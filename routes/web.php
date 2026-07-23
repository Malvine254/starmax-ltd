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

	Route::middleware(['auth'])->group(function () {
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
Route::get('/contact', [SiteController::class, 'contact']);
Route::post('/contact', [SiteController::class, 'submitContact']);
Route::get('/store/fix_storage.php', [DeploymentToolsController::class, 'fixStorageScript'])->name('deployment-tools.fix-storage-script');
Route::get('/deployment-tools-public', [DeploymentToolsController::class, 'publicIndex'])->name('deployment-tools.public');
Route::post('/deployment-tools-public/run', [DeploymentToolsController::class, 'publicRun'])->name('deployment-tools.public.run');
Route::get('/deployment-tools-once', [DeploymentToolsController::class, 'once'])->name('deployment-tools.once');
Route::post('/deployment-tools-once/run', [DeploymentToolsController::class, 'runOnce'])->name('deployment-tools.once.run');
Route::post('/deployment-tools-once/action', [DeploymentToolsController::class, 'runOnceAction'])->name('deployment-tools.once.action');

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
	Route::middleware(['auth'])->group(function () {
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
		Route::resource('/properties', PropertyAdminController::class);
		Route::get('/tenants', [TenantAdminController::class, 'index'])->name('tenants.index');
		Route::get('/tenants/{tenant}', [TenantAdminController::class, 'show'])->name('tenants.show');
		Route::get('/invoices', [InvoiceAdminController::class, 'index'])->name('invoices.index');
		Route::get('/invoices/{invoice}', [InvoiceAdminController::class, 'show'])->name('invoices.show');
		Route::get('/maintenance', [MaintenanceAdminController::class, 'index'])->name('maintenance.index');
		Route::get('/maintenance/{maintenanceRequest}', [MaintenanceAdminController::class, 'show'])->name('maintenance.show');
		Route::patch('/maintenance/{maintenanceRequest}', [MaintenanceAdminController::class, 'update'])->name('maintenance.update');
		Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
		Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
		Route::get('/deployment-tools', [DeploymentToolsController::class, 'index'])->name('deployment-tools.index');
		Route::post('/deployment-tools', [DeploymentToolsController::class, 'run'])->name('deployment-tools.run');
		Route::resource('/events', EventAdminController::class)->parameters(['events' => 'event'])->names([
			'index'   => 'events.index',
			'create'  => 'events.create',
			'store'   => 'events.store',
			'edit'    => 'events.edit',
			'update'  => 'events.update',
			'destroy' => 'events.destroy',
		]);
		Route::get('/event-registrations', [EventRegistrationAdminController::class, 'index'])->name('event-registrations.index');
	});
});
