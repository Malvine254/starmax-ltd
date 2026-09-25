<?php

namespace Tests\Feature;

use App\Mail\EventInvitation;
use App\Models\EventRegistration;
use App\Models\Role;
use App\Models\SiteEvent;
use App\Models\User;
use App\Support\InvitationRecipients;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Tests\TestCase;

class EventInvitationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $role = Role::firstOrCreate(['name' => 'ADMIN']);

        return User::factory()->create(['role_id' => $role->id, 'is_active' => true]);
    }

    private function event(): SiteEvent
    {
        return SiteEvent::create([
            'title' => 'Invitation Workshop', 'slug' => 'invitation-workshop',
            'category' => 'Workshop', 'location' => 'Nairobi', 'starts_at' => now()->addWeek(),
            'excerpt' => 'Workshop', 'description' => 'Workshop details', 'status' => 'upcoming',
        ]);
    }

    public function test_csv_preview_deduplicates_flags_bad_rows_and_queues_individual_personalized_invites_once(): void
    {
        Mail::fake();
        $event = $this->event();
        $this->actingAs($this->admin())->get(route('admin.event-registrations.index'))->assertOk()->assertSee('Upload and preview invitations');
        $response = $this->post(route('admin.event-invitations.preview'), [
            'site_event_id' => $event->id, 'subject' => 'Join {{event}}, {{name}}',
            'message' => 'Welcome {{company}}: {{event_url}}',
            'recipients_file' => UploadedFile::fake()->createWithContent('people.csv', "Full Name,Email Address,Phone,Company\nJane,JANE@example.com,+254700000000,Example Ltd\nDuplicate,jane@example.com,,\nBad,not-an-email,,\nOther,other@example.com,,\n"),
        ]);
        $response->assertOk()->assertSee('2 recipients ready. 1 duplicate addresses removed. 1 row issues.');
        Mail::assertNothingOutgoing();
        $draft = session('event_invitation_draft');
        $this->assertCount(2, $draft['recipients']);
        $this->post(route('admin.event-invitations.send'), ['token' => $draft['token']])->assertSessionHas('success');
        Mail::assertQueued(EventInvitation::class, 2);
        Mail::assertQueued(EventInvitation::class, function ($mail) {
            return $mail->hasTo('jane@example.com') && count($mail->to) === 1
                && $mail->invitationSubject === 'Join Invitation Workshop, Jane'
                && str_contains($mail->invitationMessage, 'Example Ltd')
                && $mail->eventUrl === null
                && ! str_contains($mail->render(), 'Open event link');
        });
        $this->assertDatabaseCount('event_registrations', 2);
        $this->assertDatabaseHas('event_registrations', ['site_event_id' => $event->id, 'email' => 'jane@example.com', 'name' => 'Jane', 'company' => 'Example Ltd']);
        $this->assertTrue(EventRegistration::where('email', 'jane@example.com')->firstOrFail()->event->is($event));
        $this->post(route('admin.event-invitations.send'), ['token' => $draft['token']])->assertSessionHas('error');
        Mail::assertQueued(EventInvitation::class, 2);
    }

    public function test_xlsx_extracts_first_sheet_and_preserves_text_phone_numbers(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'invite');
        try {
            $writer = new Writer;
            $writer->openToFile($path);
            $writer->addRow(Row::fromValues(['Name', 'Email', 'Phone', 'Company']));
            $writer->addRow(Row::fromValues(['Jane', 'jane@example.com', '00700123456', 'Example Ltd']));
            $writer->addNewSheetAndMakeItCurrent();
            $writer->addRow(Row::fromValues(['Ignored']));
            $writer->close();
            $this->actingAs($this->admin())->post(route('admin.event-invitations.preview'), [
                'site_event_id' => $this->event()->id, 'subject' => 'Invitation', 'message' => 'Hello {{name}}',
                'recipients_file' => new UploadedFile($path, 'people.xlsx', null, null, true),
            ])->assertOk()->assertSee('00700123456')->assertSee('Hello Jane');
            $this->assertCount(1, session('event_invitation_draft.recipients'));
        } finally {
            @unlink($path);
        }
    }

    public function test_online_invitation_includes_the_configured_event_link(): void
    {
        $event = $this->event();
        $event->update(['format' => 'Online', 'event_url' => 'https://meet.example.com/invitation']);
        $recipient = ['name' => 'Jane', 'email' => 'jane@example.com', 'phone' => '', 'company' => ''];
        $mail = new EventInvitation($event, $recipient, 'Invitation', 'Join here: {{event_url}}');

        $this->assertSame('https://meet.example.com/invitation', $mail->eventUrl);
        $this->assertStringContainsString('https://meet.example.com/invitation', $mail->invitationMessage);
        $this->assertStringContainsString('Open event link', $mail->render());
    }

    public function test_selected_event_program_is_auto_filled_and_available_for_personalization(): void
    {
        $event = $this->event();
        $event->update(['program' => "9:00 AM - 10:00 AM: Arrival\n10:00 AM - 11:00 AM: Opening session"]);

        $this->actingAs($this->admin())
            ->get(route('admin.event-registrations.index', ['event' => $event->id]).'#invite')
            ->assertOk()
            ->assertSee('Program:')
            ->assertSee('9:00 AM - 10:00 AM: Arrival')
            ->assertSee('{{program}}');

        $recipient = ['name' => 'Jane', 'email' => 'jane@example.com', 'phone' => '', 'company' => ''];
        $mail = new EventInvitation($event, $recipient, 'Invitation', "Event program:\n{{program}}");

        $this->assertStringContainsString('9:00 AM - 10:00 AM: Arrival', $mail->invitationMessage);
        $this->assertStringNotContainsString('{{program}}', $mail->invitationMessage);
    }

    public function test_admin_can_save_an_event_program(): void
    {
        $this->actingAs($this->admin())->post(route('admin.events.store'), [
            'title' => 'Programmed Workshop',
            'category' => 'Workshop',
            'format' => 'In-Person',
            'location' => 'Thika, Kenya',
            'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addWeek()->addHours(3)->format('Y-m-d H:i:s'),
            'excerpt' => 'A workshop with a detailed program.',
            'description' => 'Workshop details.',
            'program' => "9:00 AM - 10:00 AM: Arrival\n10:00 AM - 11:00 AM: Opening session",
            'cta_label' => 'Request Invite',
            'cta_url' => '/contact',
            'status' => 'upcoming',
            'sort_order' => 0,
        ])->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('site_events', [
            'title' => 'Programmed Workshop',
            'program' => "9:00 AM - 10:00 AM: Arrival\n10:00 AM - 11:00 AM: Opening session",
        ]);
    }

    public function test_missing_email_header_is_rejected(): void
    {
        $this->actingAs($this->admin())->post(route('admin.event-invitations.preview'), [
            'site_event_id' => $this->event()->id, 'subject' => 'Invitation', 'message' => 'Hello',
            'recipients_file' => UploadedFile::fake()->createWithContent('people.csv', "Name,Phone\nJane,123\n"),
        ])->assertSessionHasErrors('recipients_file');
    }

    public function test_large_import_is_rejected_before_any_delivery(): void
    {
        $file = UploadedFile::fake()->createWithContent('people.csv', "email\n".str_repeat("jane@example.com\n", 1001));
        $this->expectException(ValidationException::class);
        (new InvitationRecipients)->read($file);
    }

    public function test_guest_and_non_admin_cannot_import_or_send(): void
    {
        foreach (['preview', 'send'] as $action) {
            $this->post(route('admin.event-invitations.'.$action))->assertRedirect(route('login'));
        }
        $this->actingAs(User::factory()->create());
        foreach (['preview', 'send'] as $action) {
            $this->actingAs(User::factory()->create())
                ->post(route('admin.event-invitations.'.$action))->assertRedirect(route('login'));
        }
    }

    public function test_expired_draft_cannot_send(): void
    {
        Mail::fake();
        $token = (string) Str::uuid();
        $this->actingAs($this->admin())->withSession(['event_invitation_draft' => [
            'token' => $token, 'expires_at' => now()->subMinute()->timestamp,
        ]])->post(route('admin.event-invitations.send'), ['token' => $token])->assertSessionHas('error');
        Mail::assertNothingOutgoing();
    }

    public function test_failed_queue_attempt_keeps_only_failed_recipients_for_retry(): void
    {
        $event = $this->event();
        $token = (string) Str::uuid();
        $recipient = ['name' => 'Jane', 'email' => 'jane@example.com', 'phone' => '', 'company' => ''];
        Mail::shouldReceive('to')->once()->with('jane@example.com')->andThrow(new \RuntimeException('Queue unavailable'));
        Mail::shouldReceive('to')->once()->with('other@example.com')->andReturnSelf();
        Mail::shouldReceive('queue')->once();
        $this->actingAs($this->admin())->withSession(['event_invitation_draft' => [
            'token' => $token, 'expires_at' => now()->addHour()->timestamp,
            'site_event_id' => $event->id, 'subject' => 'Invitation', 'message' => 'Hello',
            'recipients' => [$recipient, array_merge($recipient, ['email' => 'other@example.com'])],
            'issues' => [], 'duplicates' => 0,
        ]])->post(route('admin.event-invitations.send'), ['token' => $token])
            ->assertOk()->assertSee('Only these recipients remain');
        $this->assertSame([$recipient], session('event_invitation_draft.recipients'));
        $this->assertDatabaseCount('event_registrations', 2);
        $this->assertNotSame($token, session('event_invitation_draft.token'));
    }

    public function test_corrupt_workbook_is_reported_as_validation_error(): void
    {
        $this->expectException(ValidationException::class);
        (new InvitationRecipients)->read(UploadedFile::fake()->createWithContent('people.xlsx', 'not a workbook'));
    }

    public function test_existing_attendee_is_not_duplicated_or_overwritten(): void
    {
        Mail::fake();
        $event = $this->event();
        $otherEvent = $event->replicate()->fill(['title' => 'Other Workshop', 'slug' => 'other-workshop']);
        $otherEvent->save();
        $otherEvent->registrations()->create(['name' => 'Other Jane', 'email' => 'jane@example.com', 'status' => 'new']);
        $registration = $event->registrations()->create(['name' => 'Original', 'email' => 'JANE@example.com', 'status' => 'attended']);
        $token = (string) Str::uuid();
        $this->actingAs($this->admin())->withSession(['event_invitation_draft' => [
            'token' => $token, 'expires_at' => now()->addHour()->timestamp,
            'site_event_id' => $event->id, 'subject' => 'Invitation', 'message' => 'Hello',
            'recipients' => [['name' => 'Jane', 'email' => 'jane@example.com', 'phone' => '', 'company' => '']],
            'issues' => [], 'duplicates' => 0,
        ]])->post(route('admin.event-invitations.send'), ['token' => $token])->assertSessionHas('success');
        $this->assertDatabaseCount('event_registrations', 2);
        $this->assertCount(1, $event->registrations()->whereRaw('LOWER(email) = ?', ['jane@example.com'])->get());
        $this->assertCount(1, $otherEvent->registrations()->whereRaw('LOWER(email) = ?', ['jane@example.com'])->get());
        $this->assertSame('attended', $registration->fresh()->status);
        $this->assertSame('Original', $registration->fresh()->name);
    }
}
