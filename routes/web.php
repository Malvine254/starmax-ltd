<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyAdminController;
use App\Http\Controllers\Admin\TenantAdminController;
use App\Http\Controllers\Admin\InvoiceAdminController;
use App\Http\Controllers\Admin\MaintenanceAdminController;
use App\Http\Controllers\Admin\DeploymentToolsController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\SiteController;
use App\Mail\GraceContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Grace Sellah portfolio
Route::get('/grace-sellah', function () {
    return view('grace-sellah');
});

Route::post('/grace-sellah/contact', function (Request $request) {
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'service' => 'nullable|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    Mail::to('atemograce942@gmail.com', 'Grace Sellah Atemo')
        ->send(new GraceContactNotification($validated));

    return response()->json(['success' => true]);
});

// Public site routes
Route::get('/', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/services', [SiteController::class, 'services']);
Route::get('/services/{service}', [SiteController::class, 'serviceDetail'])->name('services.show');
Route::get('/products', [SiteController::class, 'products']);
Route::get('/portfolio', [SiteController::class, 'portfolio']);
Route::get('/events', [SiteController::class, 'events']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::post('/contact', [SiteController::class, 'submitContact']);
Route::get('/deployment-tools-once', [DeploymentToolsController::class, 'once'])->name('deployment-tools.once');
Route::post('/deployment-tools-once/run', [DeploymentToolsController::class, 'runOnce'])->name('deployment-tools.once.run');

// Admin auth routes
Route::prefix('admin')->name('admin.')->group(function () {
	Route::get('/', function () {
		return auth()->check()
			? redirect()->route('admin.dashboard')
			: redirect()->route('admin.login');
	})->name('home');

	Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('login');
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
	});
});
