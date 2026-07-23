<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;

class EventRegistrationAdminController extends Controller
{
    public function index()
    {
        $registrations = EventRegistration::with('event')
            ->latest()
            ->paginate(25);

        return view('admin.event-registrations.index', compact('registrations'));
    }
}
