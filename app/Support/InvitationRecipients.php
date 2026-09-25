<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;
use Throwable;

class InvitationRecipients
{
    public function read(UploadedFile $file): array
    {
        $reader = strtolower($file->getClientOriginalExtension()) === 'xlsx' ? new XlsxReader : new CsvReader;
        $recipients = $issues = $seen = [];
        $headers = null;
        $duplicates = $number = 0;

        try {
            if ($reader instanceof XlsxReader) {
                $archive = new \ZipArchive;
                if ($archive->open($file->getRealPath()) !== true) {
                    throw ValidationException::withMessages(['recipients_file' => 'Upload a valid XLSX workbook.']);
                }
                try {
                    $expandedSize = 0;
                    for ($index = 0; $index < $archive->numFiles; $index++) {
                        $expandedSize += $archive->statIndex($index)['size'];
                        if ($expandedSize > 50 * 1024 * 1024 || $archive->numFiles > 2000) {
                            throw ValidationException::withMessages(['recipients_file' => 'This workbook is too large when expanded. Export the recipient sheet as CSV.']);
                        }
                    }
                } finally {
                    $archive->close();
                }
            }
            $reader->open($file->getRealPath());
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    $number++;
                    if ($number > 1001) {
                        throw ValidationException::withMessages(['recipients_file' => 'Upload at most 1,000 rows per file.']);
                    }
                    $values = array_map(fn ($value) => is_scalar($value) ? trim((string) $value) : '', $row->toArray());
                    if (! array_filter($values, fn ($value) => $value !== '')) {
                        continue;
                    }
                    if ($headers === null) {
                        $headers = array_map(function ($value) {
                            $key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $value));

                            return match ($key) {
                                'fullname', 'name' => 'name',
                                'emailaddress', 'email' => 'email',
                                'phonenumber', 'phone', 'mobile' => 'phone',
                                'organization', 'organisation', 'company' => 'company',
                                default => $key,
                            };
                        }, $values);
                        if (! in_array('email', $headers) || count($headers) !== count(array_unique($headers))) {
                            throw ValidationException::withMessages(['recipients_file' => 'Use unique column headings including email. Optional columns: name, phone, company.']);
                        }

                        continue;
                    }
                    $recipient = [];
                    foreach (['name', 'email', 'phone', 'company'] as $field) {
                        $index = array_search($field, $headers, true);
                        $recipient[$field] = $index === false ? '' : ($values[$index] ?? '');
                    }
                    $recipient['email'] = strtolower($recipient['email']);
                    $recipient['name'] = $recipient['name'] ?: 'there';
                    $validator = Validator::make($recipient, [
                        'email' => 'required|email|max:255', 'name' => 'required|string|max:255',
                        'phone' => 'nullable|string|max:40', 'company' => 'nullable|string|max:255',
                    ]);
                    if ($validator->fails()) {
                        $issues[] = 'Row '.$number.': '.implode(' ', $validator->errors()->all());
                    } elseif (isset($seen[$recipient['email']])) {
                        $duplicates++;
                    } else {
                        $seen[$recipient['email']] = true;
                        $recipients[] = $recipient;
                    }
                }
                break; // Only the first worksheet is imported.
            }
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);
            throw ValidationException::withMessages(['recipients_file' => 'Unable to read this file. Upload a valid UTF-8 CSV or XLSX workbook.']);
        } finally {
            $reader->close();
        }

        if (! $recipients) {
            throw ValidationException::withMessages(['recipients_file' => 'No valid email recipients found. '.implode(' ', array_slice($issues, 0, 5))]);
        }

        return compact('recipients', 'issues', 'duplicates');
    }
}
