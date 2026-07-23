<?php

namespace Tests\Feature;

use App\Models\EventRegistration;
use App\Models\Role;
use App\Models\SiteEvent;
use App\Models\User;
use App\Mail\EventRegistrationConfirmation;
use App\Mail\EventReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_is_saved_when_confirmation_email_fails(): void
    {
        $event = SiteEvent::create([
            'title' => 'Portfolio Workshop',
            'slug' => 'portfolio-workshop',
            'category' => 'Workshop',
            'format' => 'Online',
            'location' => 'Online',
            'starts_at' => now()->addWeek(),
            'excerpt' => 'A practical portfolio workshop.',
            'description' => 'Build a clear and useful professional portfolio.',
            'cta_label' => 'Register',
            'cta_url' => '',
            'status' => 'upcoming',
        ]);

        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Sendmail unavailable'));

        $response = $this->post(route('events.register', $event), [
            'name' => 'Melo',
            'email' => 'melo@example.com',
            'message' => 'I would like to attend.',
        ]);

        $response->assertRedirect(route('events.index', ['event' => $event->slug]));
        $response->assertSessionHas('warning');
        $this->assertDatabaseHas('event_registrations', [
            'site_event_id' => $event->id,
            'email' => 'melo@example.com',
        ]);
    }

    public function test_admin_can_view_and_manage_complete_registration_details(): void
    {
        $role = Role::create(['name' => 'ADMIN']);
        $admin = User::factory()->create([
            'role_id' => $role->id,
            'is_active' => true,
            'password' => Hash::make('admin-password'),
        ]);
        $event = SiteEvent::create([
            'title' => 'Admin Managed Workshop',
            'slug' => 'admin-managed-workshop',
            'category' => 'Workshop',
            'location' => 'Nairobi',
            'starts_at' => now()->addWeek(),
            'excerpt' => 'A managed workshop.',
            'description' => 'Workshop details.',
            'status' => 'upcoming',
        ]);
        $registration = EventRegistration::create([
            'site_event_id' => $event->id,
            'name' => 'Full Detail Attendee',
            'email' => 'attendee@example.com',
            'phone' => '+254700000000',
            'company' => 'Example Ltd',
            'message' => 'Dietary requirement noted.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.event-registrations.show', $registration))
            ->assertOk()
            ->assertSee('Full Detail Attendee')
            ->assertSee('Dietary requirement noted.');

        $this->assertNotNull($registration->fresh()->read_at);

        $this->actingAs($admin)
            ->patch(route('admin.event-registrations.update', $registration), [
                'status' => 'confirmed',
                'admin_notes' => 'Confirmation completed by phone.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'confirmed',
            'admin_notes' => 'Confirmation completed by phone.',
        ]);
    }

    public function test_confirmation_email_uses_the_dedicated_event_link(): void
    {
        Mail::fake();
        $event = SiteEvent::create([
            'title' => 'Online Portfolio Session',
            'slug' => 'online-portfolio-session',
            'category' => 'Webinar',
            'location' => 'Online',
            'starts_at' => now()->addWeek(),
            'excerpt' => 'An online portfolio session.',
            'description' => 'A practical online portfolio session.',
            'cta_url' => '/contact',
            'event_url' => 'https://meet.example.com/private-session',
            'status' => 'upcoming',
        ]);

        $this->post(route('events.register', $event), [
            'name' => 'Email Recipient',
            'email' => 'recipient@example.com',
        ])->assertSessionHas('success');

        Mail::assertSent(EventRegistrationConfirmation::class, function (EventRegistrationConfirmation $mail) {
            return $mail->eventUrl === 'https://meet.example.com/private-session'
                && $mail->hasTo('recipient@example.com');
        });
    }

    public function test_admin_can_send_individual_bulk_reminders_and_print_attendance(): void
    {
        Mail::fake();
        $role = Role::create(['name' => 'ADMIN']);
        $admin = User::factory()->create(['role_id' => $role->id, 'is_active' => true]);
        $event = SiteEvent::create([
            'title' => 'Reminder Workshop',
            'slug' => 'reminder-workshop',
            'category' => 'Workshop',
            'location' => 'Nairobi',
            'starts_at' => now()->addWeek(),
            'excerpt' => 'Reminder test.',
            'description' => 'Reminder test event.',
            'event_url' => 'https://meet.example.com/reminder',
            'status' => 'upcoming',
        ]);
        foreach (['first@example.com', 'second@example.com'] as $index => $email) {
            EventRegistration::create([
                'site_event_id' => $event->id,
                'name' => 'Attendee '.($index + 1),
                'email' => $email,
            ]);
        }

        $this->actingAs($admin)->post(route('admin.event-registrations.reminders.send'), [
            'site_event_id' => $event->id,
            'subject' => 'Event reminder',
            'message' => 'Please remember to attend.',
        ])->assertSessionHas('success', 'Reminder completed: 2 sent, 0 failed.');

        Mail::assertSent(EventReminder::class, 2);
        Mail::assertSent(EventReminder::class, fn (EventReminder $mail) =>
            $mail->eventUrl === 'https://meet.example.com/reminder'
            && $mail->registration->name === 'Attendee 1'
            && $mail->hasTo('first@example.com')
        );

        $this->actingAs($admin)->post(route('admin.event-registrations.reminders.send'), [
            'site_event_id' => $event->id,
            'subject' => 'Reminder for {{name}}',
            'message' => 'Hello {{name}}. Your event is {{event}} at {{location}}. {{event_url}}',
        ])->assertSessionHas('success');

        Mail::assertSent(EventReminder::class, fn (EventReminder $mail) =>
            $mail->reminderSubject === 'Reminder for Attendee 1'
            && str_contains($mail->reminderMessage, 'Hello Attendee 1.')
            && str_contains($mail->reminderMessage, 'Reminder Workshop at Nairobi')
            && str_contains($mail->reminderMessage, 'https://meet.example.com/reminder')
            && $mail->hasTo('first@example.com')
        );

        $this->actingAs($admin)
            ->get(route('admin.events.attendance', $event))
            ->assertOk()
            ->assertSee('Attendee 1')
            ->assertSee('Attendee 2')
            ->assertSee('Print attendance register');
    }
}
