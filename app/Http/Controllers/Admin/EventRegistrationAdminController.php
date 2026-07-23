<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EventReminder;
use App\Models\EventRegistration;
use App\Models\SiteEvent;
use App\Support\SafeMailDelivery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EventRegistrationAdminController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = EventRegistration::with('event')
            ->when($request->filled('event'), fn ($query) => $query->where('site_event_id', $request->string('event')))
            ->latest()
            ->paginate(25);

        $events = SiteEvent::withCount('registrations')->orderByDesc('starts_at')->get();
        $selectedEvent = $request->filled('event')
            ? $events->firstWhere('id', $request->string('event')->toString())
            : null;

        return view('admin.event-registrations.index', compact('registrations', 'events', 'selectedEvent'));
    }

    public function show(EventRegistration $eventRegistration): View
    {
        $eventRegistration->markAsRead();
        $eventRegistration->load('event');

        return view('admin.event-registrations.show', compact('eventRegistration'));
    }

    public function update(Request $request, EventRegistration $eventRegistration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,confirmed,attended,cancelled'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $eventRegistration->update($validated);

        return back()->with('success', 'Registration details updated.');
    }

    public function sendReminder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_event_id' => ['required', 'exists:site_events,id'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $event = SiteEvent::with('registrations')->findOrFail($validated['site_event_id']);
        if ($event->registrations->isEmpty()) {
            return back()->with('error', 'This event has no registered attendees.');
        }

        $eventUrl = filled($event->event_url)
            ? $event->event_url
            : route('events.index', ['event' => $event->slug]).'#schedule';
        $sent = 0;
        $failed = 0;

        foreach ($event->registrations as $registration) {
            $delivered = SafeMailDelivery::attempt(
                fn () => Mail::to($registration->email)->send(
                    new EventReminder($registration, $validated['subject'], $validated['message'], $eventUrl)
                ),
                [
                    'flow' => 'event-bulk-reminder',
                    'event_id' => $event->id,
                    'registration_id' => $registration->id,
                ],
            );
            $delivered ? $sent++ : $failed++;
        }

        return back()->with(
            $failed === 0 ? 'success' : 'warning',
            "Reminder completed: {$sent} sent, {$failed} failed."
        );
    }

    public function attendance(SiteEvent $event): View
    {
        $event->load(['registrations' => fn ($query) => $query->orderBy('name')]);

        return view('admin.event-registrations.attendance', compact('event'));
    }
}
