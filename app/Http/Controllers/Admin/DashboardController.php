<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\EventRegistration;
use App\Models\GraceSellahPage;
use App\Models\SiteEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
            'total_messages' => ContactMessage::count(),
            'upcoming_events' => SiteEvent::where('status', 'upcoming')->count(),
            'event_registrations' => EventRegistration::count(),
            'unread_registrations' => EventRegistration::whereNull('read_at')->count(),
            'portfolio_ready' => GraceSellahPage::where('slug', 'grace-sellah')->exists(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $upcomingEvents = SiteEvent::where('status', 'upcoming')
            ->orderBy('starts_at')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'upcomingEvents'));
    }
}
