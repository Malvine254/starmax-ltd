<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Models\ContactMessage;
use App\Models\SiteEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    public function home()
    {
        return view('site.home');
    }

    public function about()
    {
        return view('site.about');
    }

    public function services()
    {
        return view('site.services');
    }

    public function products()
    {
        return view('site.products');
    }

    public function portfolio()
    {
        return view('site.portfolio');
    }

    public function events()
    {
        $events = SiteEvent::where('status', 'upcoming')
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        $featuredEvents = $events->where('is_featured', true)->take(2);

        $eventStats = [
            'upcoming' => $events->count(),
            'formats' => $events->pluck('format')->filter()->unique()->count(),
            'next_month' => optional($events->first()?->starts_at)->format('M Y') ?? 'Soon',
        ];

        return view('site.events', compact('events', 'featuredEvents', 'eventStats'));
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string|in:web,android,ai,consulting,tenant,custom,other',
            'message' => 'required|string|max:3000',
        ]);

        $contactMessage = ContactMessage::create($request->only([
            'name',
            'email',
            'service',
            'message',
        ]));

        Mail::to(config('app.contact_admin_email'))
            ->send(new ContactAdminNotification($contactMessage));

        Mail::to($contactMessage->email)
            ->send(new ContactUserConfirmation($contactMessage));

        return back()->with('success', 'Thank you! Your message has been received.');
    }

    public function dashboard()
    {
        return redirect()->route('admin.login');
    }
}
