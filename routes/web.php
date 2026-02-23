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
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/wakaf', [PublicController::class, 'index'])->name('wakaf.index');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/vision-mission', [PublicController::class, 'visionMission'])->name('vision-mission');
Route::get('/vision-mission-wakaf', [PublicController::class, 'visionMissionWakaf'])->name('vision-mission-wakaf');
Route::get('/about-wakaf', [PublicController::class, 'aboutWakaf'])->name('about-wakaf');
Route::get('/managers', [PublicController::class, 'managers'])->name('managers');
Route::get('/rekening', [PublicController::class, 'rekening'])->name('rekening');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/zakat', [App\Http\Controllers\ZakatController::class, 'index'])->name('zakat.index');
Route::get('/zakat/{id}', [App\Http\Controllers\ZakatController::class, 'show'])->name('zakat.show');
Route::post('/zakat/{id}', [App\Http\Controllers\ZakatController::class, 'store'])->name('zakat.store');
Route::get('/zakat/sukses/{invoice}', [App\Http\Controllers\ZakatController::class, 'success'])->name('zakat.success')->where('invoice', '.*');
Route::post('/zakat/sukses/{invoice}', [App\Http\Controllers\ZakatController::class, 'confirm'])->name('zakat.confirm')->where('invoice', '.*');
Route::get('/infaq', [App\Http\Controllers\InfaqController::class, 'index'])->name('infaq.index');
Route::get('/infaq/{id}', [App\Http\Controllers\InfaqController::class, 'show'])->name('infaq.show');
Route::post('/infaq/{id}', [App\Http\Controllers\InfaqController::class, 'store'])->name('infaq.store');
Route::get('/infaq/sukses/{invoice}', [App\Http\Controllers\InfaqController::class, 'success'])->name('infaq.success')->where('invoice', '.*');
Route::post('/infaq/sukses/{invoice}', [App\Http\Controllers\InfaqController::class, 'confirm'])->name('infaq.confirm')->where('invoice', '.*');
Route::get('/programs', [PublicController::class, 'programs'])->name('programs.index');
Route::get('/campaign/{campaign:slug}', [PublicController::class, 'show'])->name('campaign.show');
Route::get('/donasi/{campaign:slug}', [PublicController::class, 'donate'])->name('campaign.donate');
Route::post('/donasi/{campaign:slug}', [PublicController::class, 'storeDonation'])->name('campaign.store');
Route::get('/donasi/sukses/{invoice}', [PublicController::class, 'success'])->name('campaign.success')->where('invoice', '.*');
Route::post('/donasi/sukses/{invoice}', [PublicController::class, 'confirmDonation'])->name('campaign.confirm')->where('invoice', '.*');

// Gallery Routes
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}', [App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');

// News Routes
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Laporan Routes
Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');

// Donor Authentication Routes
Route::prefix('donor')->name('donor.')->group(function () {
    Route::get('/login', [App\Http\Controllers\DonorAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\DonorAuthController::class, 'sendOtp'])->name('login.send-otp');
    Route::get('/verify', [App\Http\Controllers\DonorAuthController::class, 'showVerifyForm'])->name('verify');
    Route::post('/verify', [App\Http\Controllers\DonorAuthController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/logout', [App\Http\Controllers\DonorAuthController::class, 'logout'])->name('logout');
    
    // Protected donor routes
    Route::middleware('donor.auth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DonorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/donations', [App\Http\Controllers\DonorDashboardController::class, 'donations'])->name('donations');
        Route::get('/zakat', [App\Http\Controllers\DonorDashboardController::class, 'zakat'])->name('zakat');
        Route::get('/receipt/{id}', [App\Http\Controllers\DonorDashboardController::class, 'downloadReceipt'])->name('receipt');
    });
});

// Consolidated Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Admin Resources
    Route::middleware(['can:admin'])->prefix('dashboard')->name('admin.')->group(function () {
        Route::post('/campaigns/upload-image', [App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('campaigns.upload_image');
    Route::resource('campaigns', App\Http\Controllers\Admin\CampaignController::class);
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        
        Route::put('/donations/{donation}/cancel', [App\Http\Controllers\Admin\DonationController::class, 'cancel'])->name('donations.cancel');
        Route::resource('donations', App\Http\Controllers\Admin\DonationController::class);
        Route::resource('distributions', App\Http\Controllers\Admin\DistributionController::class);
        Route::resource('payment-methods', App\Http\Controllers\Admin\PaymentMethodController::class);

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('donors', App\Http\Controllers\Admin\DonorController::class);
        Route::resource('campaign-updates', App\Http\Controllers\Admin\CampaignUpdateController::class);
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
        Route::resource('news-categories', App\Http\Controllers\Admin\NewsCategoryController::class);
        Route::resource('laporans', App\Http\Controllers\Admin\LaporanController::class);

        // Zakat Management
        Route::resource('zakat-types', App\Http\Controllers\Admin\ZakatTypeController::class);
        
        Route::put('/zakat-transactions/{id}/cancel', [App\Http\Controllers\Admin\ZakatTransactionController::class, 'cancel'])->name('zakat-transactions.cancel');
        Route::resource('zakat-transactions', App\Http\Controllers\Admin\ZakatTransactionController::class)->only(['index', 'show', 'update', 'destroy']);

        // Infaq Management
        Route::resource('infaq-categories', App\Http\Controllers\Admin\InfaqCategoryController::class);
        // Album / Gallery Management
        Route::post('/albums/{album}/photos', [App\Http\Controllers\Admin\AlbumController::class, 'storePhoto'])->name('albums.photos.store');
        Route::delete('/albums/photos/{photo}', [App\Http\Controllers\Admin\AlbumController::class, 'destroyPhoto'])->name('albums.photos.destroy');
        Route::resource('albums', App\Http\Controllers\Admin\AlbumController::class);

        // Mitra Management
        Route::resource('mitras', App\Http\Controllers\Admin\MitraController::class)->except(['show']);

        Route::put('/infaq-transactions/{id}/cancel', [App\Http\Controllers\Admin\InfaqTransactionController::class, 'cancel'])->name('infaq-transactions.cancel');
        Route::resource('infaq-transactions', App\Http\Controllers\Admin\InfaqTransactionController::class)->only(['index', 'show', 'update', 'destroy']);

        // Transaction Reports
        Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
        Route::get('/reports/print', [App\Http\Controllers\Admin\ReportController::class, 'printReport'])->name('reports.print');
        Route::get('/reports/zakat', [App\Http\Controllers\Admin\ReportController::class, 'zakat'])->name('reports.zakat');
        Route::get('/reports/donation', [App\Http\Controllers\Admin\ReportController::class, 'donation'])->name('reports.donation');
        Route::get('/reports/infaq', [App\Http\Controllers\Admin\ReportController::class, 'infaq'])->name('reports.infaq');
        Route::get('/reports/distribution', [App\Http\Controllers\Admin\ReportController::class, 'distribution'])->name('reports.distribution');
        Route::get('/reports/distribution/export', [App\Http\Controllers\Admin\ReportController::class, 'exportDistribution'])->name('reports.distribution.export');
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Vision & Mission
        Route::get('/vision-mission', [App\Http\Controllers\Admin\VisionMissionController::class, 'index'])->name('vision-mission.index');
        Route::put('/vision-mission', [App\Http\Controllers\Admin\VisionMissionController::class, 'update'])->name('vision-mission.update');

        // Managers
        Route::resource('managers', App\Http\Controllers\Admin\ManagerController::class);

        // About Us
        Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
        Route::put('/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
