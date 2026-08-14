<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function show(string $code): View
    {
        $registration = EventRegistration::with('event')
            ->where('certificate_code', strtoupper($code))
            ->whereNotNull('certificate_issued_at')
            ->firstOrFail();

        $qrCode = $this->qrCode($registration);
        return view('certificates.show', compact('registration', 'qrCode'));
    }

    public function download(string $code): Response
    {
        $registration = $this->issuedCertificate($code);
        $qrCode = $this->qrCode($registration);
        $filename = 'Starmax-Certificate-'.str($registration->name)->slug().'.pdf';
        return Pdf::loadView('certificates.pdf-v3', compact('registration', 'qrCode'))
            ->setPaper('a4', 'landscape')->download($filename);
    }

    public function verify(): View
    {
        $code = strtoupper(trim((string) request('code')));
        $registration = $code === '' ? null : EventRegistration::with('event')
            ->where('certificate_code', $code)->whereNotNull('certificate_issued_at')->first();

        return view('certificates.verify', compact('registration', 'code'));
    }

    private function issuedCertificate(string $code): EventRegistration
    {
        return EventRegistration::with('event')->where('certificate_code', strtoupper($code))
            ->whereNotNull('certificate_issued_at')->firstOrFail();
    }

    private function qrCode(EventRegistration $registration): string
    {
        $qr = new QrCode(data: route('certificates.verify', ['code' => $registration->certificate_code]), encoding: new Encoding('UTF-8'), errorCorrectionLevel: ErrorCorrectionLevel::High, size: 220, margin: 8);
        return (new SvgWriter())->write($qr)->getDataUri();
    }
}
