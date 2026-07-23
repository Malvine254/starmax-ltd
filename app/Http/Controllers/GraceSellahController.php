<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Models\ContactMessage;
use App\Models\GraceSellahPage;
use App\Support\SafeMailDelivery;
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

        $contactMessage = ContactMessage::create([
            ...$validated,
            'source' => 'grace-portfolio',
        ]);

        $emailSent = SafeMailDelivery::attempt(function () use ($contactMessage): void {
            Mail::to(config('app.contact_admin_email'))
                ->send(new ContactAdminNotification($contactMessage));
            Mail::to($contactMessage->email)
                ->send(new ContactUserConfirmation($contactMessage));
        }, [
            'flow' => 'grace-portfolio-contact',
            'contact_message_id' => $contactMessage->id,
        ]);

        return response()->json([
            'success' => true,
            'email_sent' => $emailSent,
            'message' => $emailSent
                ? 'Your enquiry has been sent.'
                : 'Your enquiry was saved. Email delivery is temporarily delayed.',
        ]);
    }
}
