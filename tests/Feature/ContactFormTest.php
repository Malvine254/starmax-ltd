<?php

namespace Tests\Feature;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_saves_message_and_sends_emails(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Android Prospect',
            'email' => 'prospect@example.com',
            'service' => 'android',
            'message' => 'We need a modern Android app.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Android Prospect',
            'email' => 'prospect@example.com',
            'service' => 'android',
            'message' => 'We need a modern Android app.',
        ]);

        $contactMessage = ContactMessage::where('email', 'prospect@example.com')->firstOrFail();

        Mail::assertSent(ContactAdminNotification::class, function (ContactAdminNotification $mail) use ($contactMessage) {
            return $mail->contactMessage->is($contactMessage)
                && $mail->hasTo(config('app.contact_admin_email'));
        });

        Mail::assertSent(ContactUserConfirmation::class, function (ContactUserConfirmation $mail) use ($contactMessage) {
            return $mail->contactMessage->is($contactMessage)
                && $mail->hasTo('prospect@example.com');
        });
    }

    public function test_contact_message_is_not_lost_when_mail_delivery_fails(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Mailer unavailable'));

        $response = $this->post('/contact', [
            'name' => 'Saved Prospect',
            'email' => 'saved@example.com',
            'service' => 'web',
            'message' => 'Please keep this message even if email is down.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('warning');
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'saved@example.com',
            'message' => 'Please keep this message even if email is down.',
        ]);
    }
}
