<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Models\ContactMessage;
use App\Models\GraceSellahPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GraceSellahController extends Controller
{
    public function show()
    {
        $page = GraceSellahPage::query()->firstWhere('slug', 'grace-sellah');

        if (! $page) {
            $page = new GraceSellahPage([
                'slug' => 'grace-sellah',
                'content' => GraceSellahPage::defaultContent(),
            ]);
        }

        $content = $page->mergedContent();

        return view('grace-sellah-dynamic', compact('page', 'content'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contactMessage = ContactMessage::create($validated);

        Mail::to(config('app.contact_admin_email'))
            ->send(new ContactAdminNotification($contactMessage));

        Mail::to($contactMessage->email)
            ->send(new ContactUserConfirmation($contactMessage));

        return response()->json(['success' => true]);
    }
}