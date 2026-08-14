<?php

namespace Tests\Feature;

use App\Models\EventRegistration;
use App\Models\SiteEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Mail\CertificateIssued;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\EventRegistrationAdminController;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_issued_certificate_can_be_viewed_and_verified(): void
    {
        $event = SiteEvent::create([
            'title'=>'Practical AI Lab','slug'=>'practical-ai-lab','category'=>'Workshop','location'=>'Online',
            'starts_at'=>now(),'excerpt'=>'Lab','description'=>'Lab','cta_label'=>'Join','cta_url'=>'/contact','status'=>'past',
        ]);
        $registration = EventRegistration::create([
            'site_event_id'=>$event->id,'name'=>'Ada Lovelace','email'=>'ada@example.com','status'=>'attended',
            'certificate_code'=>'SMX-ABCD-1234','certificate_issued_at'=>now(),
        ]);

        $this->get(route('certificates.show', $registration->certificate_code))
            ->assertOk()->assertSee('Ada Lovelace')->assertSee('Practical AI Lab')->assertSee('SMX-ABCD-1234');
        $this->get(route('certificates.verify', ['code'=>$registration->certificate_code]))
            ->assertOk()->assertSee('Verified certificate');
        $this->get(route('certificates.download', $registration->certificate_code))
            ->assertOk()->assertHeader('content-type', 'application/pdf');
    }

    public function test_unknown_certificates_do_not_verify(): void
    {
        $this->get(route('certificates.verify', ['code'=>'SMX-NOPE-NOPE']))
            ->assertOk()->assertSee('Certificate not found');
    }

    public function test_restore_and_resend_preserve_the_original_certificate_identity(): void
    {
        Mail::fake();
        $event = SiteEvent::create([
            'title'=>'Practical AI Lab','slug'=>'certificate-lifecycle','category'=>'Workshop','location'=>'Online',
            'starts_at'=>now(),'excerpt'=>'Lab','description'=>'Lab','cta_label'=>'Join','cta_url'=>'/contact','status'=>'past',
        ]);
        $issuedAt = now()->subDay()->startOfSecond();
        $registration = EventRegistration::create([
            'site_event_id'=>$event->id,'name'=>'Grace Hopper','email'=>'grace@example.com','status'=>'attended',
            'certificate_code'=>'SMX-SAME-1001','certificate_issued_at'=>$issuedAt,'certificate_revoked_at'=>now(),
        ]);

        app(EventRegistrationAdminController::class)->restoreCertificate($registration);
        $registration->refresh();
        $this->assertSame('SMX-SAME-1001', $registration->certificate_code);
        $this->assertTrue($registration->certificate_issued_at->equalTo($issuedAt));
        $this->assertNull($registration->certificate_revoked_at);

        app(EventRegistrationAdminController::class)->resendCertificate($registration);
        $registration->refresh();
        $this->assertSame('SMX-SAME-1001', $registration->certificate_code);
        $this->assertTrue($registration->certificate_issued_at->equalTo($issuedAt));
        $this->assertNotNull($registration->certificate_emailed_at);
        Mail::assertSent(CertificateIssued::class, fn ($mail) => $mail->registration->certificate_code === 'SMX-SAME-1001');
    }

    public function test_custom_certificate_message_is_shared_by_web_and_pdf(): void
    {
        $event = SiteEvent::create([
            'title'=>'AI Operations','slug'=>'custom-certificate-message','category'=>'Workshop','location'=>'Online',
            'starts_at'=>now(),'excerpt'=>'Lab','description'=>'Lab','cta_label'=>'Join','cta_url'=>'/contact','status'=>'past',
            'certificate_message'=>'Completed :event:company with distinction and exceptional commitment.',
        ]);
        $registration = EventRegistration::create([
            'site_event_id'=>$event->id,'name'=>'Melo','email'=>'melo@example.com','company'=>'Armely','status'=>'attended',
            'certificate_code'=>'SMX-MSG-1001','certificate_issued_at'=>now(),
        ]);

        $this->get(route('certificates.show', $registration->certificate_code))
            ->assertOk()
            ->assertSee('Completed')
            ->assertSee('AI Operations')
            ->assertSee('representing Armely');
        $this->get(route('certificates.download', $registration->certificate_code))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
