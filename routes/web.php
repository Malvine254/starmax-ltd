<?php

use App\Http\Controllers\Admin\GraceSellahPageController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyAdminController;
use App\Http\Controllers\Admin\TenantAdminController;
use App\Http\Controllers\Admin\InvoiceAdminController;
use App\Http\Controllers\Admin\MaintenanceAdminController;
use App\Http\Controllers\Admin\DeploymentToolsController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\EventRegistrationAdminController;
use App\Http\Controllers\GraceSellahController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

// Grace Sellah portfolio
Route::get('/grace-sellah', [GraceSellahController::class, 'show']);
Route::post('/grace-sellah/contact', [GraceSellahController::class, 'submitContact']);
Route::get('/admin/login', [AuthAdminController::class, 'showLogin'])->name('login');
Route::redirect('/admin/grace-sellah/admin', '/grace-sellah/admin');
Route::redirect('/admin/grace-sellah/admin/login', '/admin/login');

Route::redirect('/grace-sellah/admin/login', '/admin/login');

Route::prefix('grace-sellah/admin')->name('grace-sellah.admin.')->group(function () {
	Route::post('/login', [AuthAdminController::class, 'login'])->name('login.post');
	Route::post('/logout', [AuthAdminController::class, 'logout'])->name('logout');

	Route::middleware(['auth', 'admin'])->group(function () {
		Route::get('/', [GraceSellahPageController::class, 'edit'])->name('home');
		Route::get('/page', [GraceSellahPageController::class, 'edit'])->name('page.edit');
		Route::put('/page', [GraceSellahPageController::class, 'update'])->name('page.update');
	});
});

// Public site routes
Route::get('/', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/services', [SiteController::class, 'services']);
Route::get('/services/{service}', [SiteController::class, 'serviceDetail'])->name('services.show');
Route::get('/products', [SiteController::class, 'products']);
Route::get('/portfolio', [SiteController::class, 'portfolio']);
Route::get('/events', [SiteController::class, 'events'])->name('events.index');
Route::post('/events/{event:slug}/register', [SiteController::class, 'registerEvent'])->name('events.register');
Route::get('/certificates/verify', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::get('/certificates/{code}/download', [CertificateController::class, 'download'])->name('certificates.download');
Route::get('/certificates/{code}', [CertificateController::class, 'show'])->name('certificates.show');
Route::get('/contact', [SiteController::class, 'contact']);
Route::post('/contact', [SiteController::class, 'submitContact']);

// Publicly reachable maintenance page. Production command execution still
// requires DEPLOYMENT_TOOL_TOKEN and all actions are strictly allowlisted.
Route::middleware('throttle:10,1')->group(function () {
	Route::get('/server-tools', [DeploymentToolsController::class, 'index'])->name('server-tools.public.index');
	Route::post('/server-tools/run', [DeploymentToolsController::class, 'run'])->name('server-tools.public.run');
});

// Admin auth routes
Route::prefix('admin')->name('admin.')->group(function () {
	Route::get('/', function () {
		return auth()->check()
			? redirect()->route('admin.dashboard')
			: redirect()->route('login');
	})->name('home');
	Route::post('/login', [AuthAdminController::class, 'login'])->name('login.post');
	Route::post('/logout', [AuthAdminController::class, 'logout'])->name('logout');

	// Protected admin routes
	Route::middleware(['auth', 'admin'])->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
		Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
		Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
		Route::resource('/events', EventAdminController::class)->parameters(['events' => 'event'])->names([
			'index'   => 'events.index',
			'create'  => 'events.create',
			'store'   => 'events.store',
			'edit'    => 'events.edit',
			'update'  => 'events.update',
			'destroy' => 'events.destroy',
		]);
		Route::get('/event-registrations', [EventRegistrationAdminController::class, 'index'])->name('event-registrations.index');
		Route::get('/event-registrations/{eventRegistration}', [EventRegistrationAdminController::class, 'show'])->name('event-registrations.show');
		Route::patch('/event-registrations/{eventRegistration}', [EventRegistrationAdminController::class, 'update'])->name('event-registrations.update');
		Route::post('/event-registrations/{eventRegistration}/certificate', [EventRegistrationAdminController::class, 'issueCertificate'])->name('event-registrations.certificate.issue');
		Route::post('/event-registrations/{eventRegistration}/certificate/resend', [EventRegistrationAdminController::class, 'resendCertificate'])->name('event-registrations.certificate.resend');
		Route::post('/event-registrations/{eventRegistration}/certificate/restore', [EventRegistrationAdminController::class, 'restoreCertificate'])->name('event-registrations.certificate.restore');
		Route::delete('/event-registrations/{eventRegistration}/certificate', [EventRegistrationAdminController::class, 'revokeCertificate'])->name('event-registrations.certificate.revoke');
		Route::post('/events/{event}/certificates', [EventRegistrationAdminController::class, 'issueCertificates'])->name('events.certificates.issue');
		Route::post('/event-registrations/reminders/send', [EventRegistrationAdminController::class, 'sendReminder'])->name('event-registrations.reminders.send');
		Route::get('/events/{event}/attendance', [EventRegistrationAdminController::class, 'attendance'])->name('events.attendance');
		Route::middleware('throttle:10,1')->group(function () {
			Route::get('/server-tools', [DeploymentToolsController::class, 'index'])->name('server-tools.index');
			Route::post('/server-tools/run', [DeploymentToolsController::class, 'run'])->name('server-tools.run');
		});
	});
});
