<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Kaprodi\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GUEST AREA (Login) ---
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// --- AUTH AREA (User sudah login) ---
Route::middleware(['auth'])->group(function() {
    
    /**
     * Redirect Utama & Logout
     */
    Route::get('/home', function() {
        return redirect()->route('dashboard');
    });
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    /**
     * DASHBOARD UTAMA (Maintenance Request)
     */
    Route::get('/dashboard', [MaintenanceController::class, 'index'])->name('dashboard');

    /**
     * AKSES GLOBAL (Dapat diakses semua Role yang sudah Login)
     * Dipindahkan ke luar middleware 'UserAkses:Kaprodi' untuk mencegah 404/403 bagi role lain.
     */
    Route::get('/inventory', [DashboardController::class, 'inventory'])->name('kaprodi.inventory');
    Route::get('/equipment/{id}/history', [DashboardController::class, 'equipmentHistory'])->name('kaprodi.equipment.history');

    /**
     * KHUSUS DASHBOARD KAPRODI
     */
    Route::middleware('UserAkses:Kaprodi')->prefix('kaprodi')->name('kaprodi.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/cost-report', [DashboardController::class, 'costReport'])->name('cost_report');
        Route::get('/calibration', [DashboardController::class, 'calibration'])->name('calibration');
    });

    /**
     * KHUSUS MENU ANALITIK PEMBANTU DIREKTUR 1
     */
    Route::middleware('UserAkses:Pembantu Direktur 1')->prefix('admin/pudir1')->name('pudir1.')->group(function () {
        Route::get('/', [AdminController::class, 'PembantuDirektur1'])->name('index');
        
        // Pastikan parameter 'menu' di sini sinkron dengan logika switch di Controller
        Route::get('/readiness', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'readiness')->name('readiness');
        Route::get('/high-impact', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'high_impact')->name('high_impact');
        Route::get('/downtime', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'downtime')->name('downtime');
        Route::get('/calibration', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'calibration')->name('calibration');
    });

    /**
     * KHUSUS DASHBOARD PEMBANTU DIREKTUR 2
     */
    Route::middleware('UserAkses:Pembantu Direktur 2')->prefix('admin/pudir2')->name('pudir2.')->group(function () {
        Route::get('/', [AdminController::class, 'PembantuDirektur2'])->name('index');
        Route::get('/approval', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'approval')->name('approval');
        Route::get('/budget', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'budget')->name('budget');
        Route::get('/assets', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'assets')->name('assets');
        Route::get('/vendor', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'vendor')->name('vendor');
    });

    /**
     * ROLE-BASED REDIRECTS (Halaman Admin Spesifik)
     */
    Route::middleware('UserAkses:Super Admin')->get('/admin/SuperAdmin', [AdminController::class, 'SuperAdmin'])->name('admin.super');
    Route::middleware('UserAkses:Kepala Lab')->get('/admin/KaLab', [AdminController::class, 'KaLab'])->name('admin.kalab');
    Route::middleware('UserAkses:Tim Pemelihara')->get('/admin/TimPemelihara', [AdminController::class, 'TimPemelihara'])->name('admin.teknisi');

    /**
     * MANAJEMEN USER (Hanya Super Admin)
     */
    Route::middleware('UserAkses:Super Admin')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('destroy');
    });

    /**
     * WORKFLOW MAINTENANCE LAB
     */
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/create', [MaintenanceController::class, 'create'])->name('create'); 
        Route::post('/store', [MaintenanceController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [MaintenanceController::class, 'destroy'])->name('destroy');
        
        Route::post('/approve/{id}', [MaintenanceController::class, 'approveKaprodi'])->name('approve'); 
        Route::post('/approve-pudir1/{id}', [MaintenanceController::class, 'approvePudir1'])->name('approve.pudir1');
        Route::post('/approve-pudir2/{id}', [MaintenanceController::class, 'approvePudir2'])->name('approve.pudir2');
        
        Route::post('/update-technical/{id}', [MaintenanceController::class, 'updateTechnical'])->name('update.technical');
        Route::post('/finish/{id}', [MaintenanceController::class, 'finishWork'])->name('finish');
        Route::post('/verify/{id}', [MaintenanceController::class, 'verifyWork'])->name('verify');
        Route::post('/complain/{id}', [MaintenanceController::class, 'complainWork'])->name('complain');
        Route::post('/close/{id}', [MaintenanceController::class, 'closeTicket'])->name('close');
        Route::post('/reject/{id}', [MaintenanceController::class, 'reject'])->name('reject');

        Route::get('/print/{id}', [MaintenanceController::class, 'print'])->name('print');
    });
});