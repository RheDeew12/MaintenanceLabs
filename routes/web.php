<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Kaprodi\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Integrated for Politeknik ATK Yogyakarta
|--------------------------------------------------------------------------
*/

// --- AREA PENGUNJUNG (Login) ---
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// --- AREA TERAUTENTIKASI (Sudah Login) ---
Route::middleware(['auth'])->group(function() {
    
    Route::get('/home', function() {
        return redirect()->route('dashboard');
    });
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    /**
     * DASHBOARD UTAMA & MONITORING GLOBAL
     */
    Route::get('/dashboard', [MaintenanceController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [DashboardController::class, 'inventory'])->name('kaprodi.inventory');
    Route::get('/equipment/{id}/history', [DashboardController::class, 'equipmentHistory'])->name('kaprodi.equipment.history');

    /**
     * MANAJEMEN MASTER DATA
     */
    // 1. Master Barang (Akses: Super Admin & Kepala Lab)
    Route::middleware('UserAkses:Super Admin,Kepala Lab')->prefix('barangs')->name('barangs.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::put('/{id}/update', [BarangController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [BarangController::class, 'destroy'])->name('destroy');
    });

    // 2. Unit Management (EKSKLUSIF: Hanya Super Admin)
    Route::middleware('UserAkses:Super Admin')->prefix('units')->name('units.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::put('/{id}/update', [UnitController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [UnitController::class, 'destroy'])->name('destroy');
    });

    /**
     * DASHBOARD KAPRODI (TPK, TPPK, TPKP)
     */
    Route::middleware('UserAkses:Kaprodi')->prefix('kaprodi')->name('kaprodi.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/unit-monitoring/{lab_id}', [DashboardController::class, 'index'])->name('unit.monitoring');
        Route::get('/cost-report', [DashboardController::class, 'costReport'])->name('cost_report');
        Route::get('/calibration', [DashboardController::class, 'calibration'])->name('calibration');
    });

    /**
     * DASHBOARD PEMBANTU DIREKTUR 1 (AKADEMIK)
     */
    Route::middleware('UserAkses:Pembantu Direktur 1')->prefix('admin/pudir1')->name('pudir1.')->group(function () {
        Route::get('/', [AdminController::class, 'PembantuDirektur1'])->name('index');
        Route::get('/readiness', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'readiness')->name('readiness');
        Route::get('/high-impact', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'high_impact')->name('high_impact');
        Route::get('/calibration', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'calibration')->name('calibration');
        Route::get('/downtime', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'downtime')->name('downtime');
        Route::get('/total-assets', [AdminController::class, 'PembantuDirektur1'])->defaults('menu', 'total_assets')->name('total_assets');
    });

    /**
     * DASHBOARD PEMBANTU DIREKTUR 2 (KEUANGAN & ASET)
     */
    Route::middleware('UserAkses:Pembantu Direktur 2')->prefix('admin/pudir2')->name('pudir2.')->group(function () {
        Route::get('/', [AdminController::class, 'PembantuDirektur2'])->name('index');
        Route::get('/approval', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'approval')->name('approval');
        Route::get('/budget', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'budget')->name('budget');
        Route::get('/assets', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'assets')->name('assets');
        Route::get('/vendor', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'vendor')->name('vendor');
        Route::get('/total-assets', [AdminController::class, 'PembantuDirektur2'])->defaults('menu', 'total_assets')->name('total_assets');
    });

    /**
     * MANAJEMEN PENGGUNA (EKSKLUSIF: Hanya Super Admin)
     */
    Route::middleware('UserAkses:Super Admin')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('destroy');
    });

    /**
     * WORKFLOW PERBAIKAN (Maintenance Lifecycle)
     */
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::post('/store', [MaintenanceController::class, 'store'])->name('store');
        Route::get('/{id}/show', [MaintenanceController::class, 'show'])->name('show');
        
        // UPDATE: Route Hapus Tiket diarahkan ke AdminController untuk logic Hard Delete & Reset Status Aset
        Route::delete('/{id}/delete', [AdminController::class, 'destroy'])->name('destroy');
        
        // Persetujuan Bertingkat (Logic Branching ada di dalam Controller)
        Route::post('/approve/{id}', [MaintenanceController::class, 'approveKaprodi'])->name('approve'); 
        Route::post('/approve-pudir1/{id}', [MaintenanceController::class, 'approvePudir1'])->name('approve.pudir1');
        Route::post('/approve-pudir2/{id}', [MaintenanceController::class, 'approvePudir2'])->name('approve.pudir2');
        
        // Eksekusi & Konfirmasi
        Route::post('/update-technical/{id}', [MaintenanceController::class, 'updateTechnical'])->name('update.technical');
        Route::post('/finish/{id}', [MaintenanceController::class, 'finishWork'])->name('finish');
        Route::post('/verify/{id}', [MaintenanceController::class, 'verifyWork'])->name('verify');
        Route::post('/complain/{id}', [MaintenanceController::class, 'complainWork'])->name('complain'); 
        Route::post('/close/{id}', [MaintenanceController::class, 'closeTicket'])->name('close');
        Route::post('/reject/{id}', [MaintenanceController::class, 'reject'])->name('reject');

        Route::get('/print/{id}', [MaintenanceController::class, 'print'])->name('print');
    });
});