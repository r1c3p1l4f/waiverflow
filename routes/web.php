<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaiverTemplateController;
use App\Http\Controllers\SignedWaiverController;
use App\Http\Controllers\CustomerPortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (using Laravel Breeze or similar)
// This assumes you've already set up authentication
require __DIR__.'/auth.php';

// Waiver Templates (admin access)
Route::resource('waiver-templates', WaiverTemplateController::class);

// Signed Waivers
Route::get('signed-waivers', [SignedWaiverController::class, 'index'])
    ->name('signed-waivers.index');
Route::get('signed-waivers/create', [SignedWaiverController::class, 'create'])
    ->name('signed-waivers.create');
Route::post('signed-waivers', [SignedWaiverController::class, 'store'])
    ->name('signed-waivers.store');
Route::get('signed-waivers/{signedWaiver}', [SignedWaiverController::class, 'show'])
    ->name('signed-waivers.show');
Route::get('signed-waivers/{signedWaiver}/download', [SignedWaiverController::class, 'download'])
    ->name('signed-waivers.download');

// Customer Portal
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('dashboard', [CustomerPortalController::class, 'dashboard'])
        ->name('dashboard');
    Route::get('profile', [CustomerPortalController::class, 'profile'])
        ->name('profile');
    Route::put('profile', [CustomerPortalController::class, 'updateProfile'])
        ->name('profile.update');
    Route::get('waivers', [CustomerPortalController::class, 'waivers'])
        ->name('waivers');
    Route::get('available-waivers', [CustomerPortalController::class, 'availableWaivers'])
        ->name('available-waivers');
});

// Admin area
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Add more admin routes as needed
});
