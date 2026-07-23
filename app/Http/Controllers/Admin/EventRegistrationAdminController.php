<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRegistrationAdminController extends Controller
{
    public function index(): View
    {
        $registrations = EventRegistration::with('event')
            ->latest()
            ->paginate(25);

        return view('admin.event-registrations.index', compact('registrations'));
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
}
