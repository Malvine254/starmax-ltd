<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EventInvitation;
use App\Models\EventRegistration;
use App\Models\SiteEvent;
use App\Support\InvitationRecipients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EventInvitationController extends Controller
{
    public function preview(Request $request, InvitationRecipients $importer)
    {
        $data = $request->validate([
            'site_event_id' => 'required|exists:site_events,id',
            'subject' => 'required|string|max:180|not_regex:/[\r\n]/',
            'message' => 'required|string|max:20000',
            'recipients_file' => 'required|file|extensions:csv,xlsx|mimes:csv,txt,xlsx|max:5120',
        ]);
        $event = SiteEvent::findOrFail($data['site_event_id']);
        $draft = array_merge($importer->read($request->file('recipients_file')), [
            'site_event_id' => $event->id, 'subject' => $data['subject'], 'message' => $data['message'],
            'token' => (string) Str::uuid(), 'expires_at' => now()->addHour()->timestamp,
        ]);
        $request->session()->put('event_invitation_draft', $draft);

        return view('admin.event-registrations.invitation-preview', compact('draft', 'event'));
    }

    public function send(Request $request)
    {
        $request->validate(['token' => 'required|uuid']);
        $draft = $request->session()->get('event_invitation_draft');
        if (! $draft || ! hash_equals($draft['token'], $request->string('token')->toString()) || $draft['expires_at'] < now()->timestamp) {
            return redirect()->route('admin.event-registrations.index')->with('error', 'This preview has expired or was already sent. Upload the file again.');
        }
        $event = SiteEvent::findOrFail($draft['site_event_id']);
        // Save the entire import before queuing mail; a mail failure must not lose attendees.
        DB::transaction(function () use ($event, $draft) {
            SiteEvent::whereKey($event->id)->lockForUpdate()->firstOrFail();
            foreach ($draft['recipients'] as $recipient) {
                $existing = EventRegistration::where('site_event_id', $event->id)
                    ->whereRaw('LOWER(email) = ?', [strtolower($recipient['email'])])->first();
                if (! $existing) {
                    EventRegistration::create([
                        ...$recipient,
                        'site_event_id' => $event->id,
                        'status' => 'new',
                    ]);
                }
            }
        });
        $request->session()->forget('event_invitation_draft');
        $queued = 0;
        $failed = [];
        foreach ($draft['recipients'] as $recipient) {
            try {
                Mail::to($recipient['email'])->queue(new EventInvitation($event, $recipient, $draft['subject'], $draft['message']));
                $queued++;
            } catch (\Throwable $exception) {
                report($exception);
                $failed[] = $recipient;
            }
        }
        if ($failed) {
            $draft['recipients'] = $failed;
            $draft['issues'] = ["Attendees saved. {$queued} invitations queued. Some invitations could not be queued. Only these recipients remain; retry sending below."];
            $draft['duplicates'] = 0;
            $draft['token'] = (string) Str::uuid();
            $request->session()->put('event_invitation_draft', $draft);

            return view('admin.event-registrations.invitation-preview', compact('draft', 'event'));
        }

        return redirect()->route('admin.event-registrations.index', ['event' => $event->id])
            ->with('success', "Attendees saved. {$queued} invitations queued for delivery. Email delivery runs in the background.");
    }
}
