<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/programs', [PublicController::class, 'programs'])->name('programs.index');
Route::get('/campaign/{campaign:slug}', [PublicController::class, 'show'])->name('campaign.show');
Route::get('/donasi/{campaign:slug}', [PublicController::class, 'donate'])->name('campaign.donate');
Route::post('/donasi/{campaign:slug}', [PublicController::class, 'storeDonation'])->name('campaign.store');
Route::get('/donasi/sukses/{invoice}', [PublicController::class, 'success'])->name('campaign.success')->where('invoice', '.*');
Route::post('/donasi/sukses/{invoice}', [PublicController::class, 'confirmDonation'])->name('campaign.confirm')->where('invoice', '.*');

// News Routes
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Laporan Routes
Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');

// Consolidated Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Admin Resources
    Route::middleware(['can:admin'])->prefix('dashboard')->name('admin.')->group(function () {
        Route::resource('campaigns', App\Http\Controllers\Admin\CampaignController::class);
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('donations', App\Http\Controllers\Admin\DonationController::class);
        Route::resource('distributions', App\Http\Controllers\Admin\DistributionController::class);
        Route::resource('payment-methods', App\Http\Controllers\Admin\PaymentMethodController::class);

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('donors', App\Http\Controllers\Admin\DonorController::class);
        Route::resource('campaign-updates', App\Http\Controllers\Admin\CampaignUpdateController::class);
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
        Route::resource('news-categories', App\Http\Controllers\Admin\NewsCategoryController::class);
        Route::resource('laporans', App\Http\Controllers\Admin\LaporanController::class);
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
