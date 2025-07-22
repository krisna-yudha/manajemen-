<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard route with role-based redirection
Route::get('/dashboard', [RoleController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Role-specific dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Manager routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager/dashboard', [RoleController::class, 'managerDashboard'])->name('manager.dashboard');
        Route::get('/manager/users', [RoleController::class, 'userManagement'])->name('manager.users');
        Route::patch('/manager/users/{user}/role', [RoleController::class, 'updateUserRole'])->name('manager.users.update-role');
    });

    // Gudang routes
    Route::middleware(['role:gudang'])->group(function () {
        Route::get('/gudang/dashboard', [RoleController::class, 'gudangDashboard'])->name('gudang.dashboard');
    });

    // Member routes
    Route::middleware(['role:member'])->group(function () {
        Route::get('/member/dashboard', [RoleController::class, 'memberDashboard'])->name('member.dashboard');
        
        // Member barang management
        Route::get('/member/barang/available', [RoleController::class, 'memberAvailableBarang'])->name('member.barang.available');
        
        // Member rental management
        Route::get('/member/rental/create', [RoleController::class, 'memberCreateRental'])->name('member.rental.create');
        Route::post('/member/rental', [RoleController::class, 'memberStoreRental'])->name('member.rental.store');
        Route::get('/member/rental/{rental}', [RoleController::class, 'memberShowRental'])->name('member.rental.show');
        Route::get('/member/rental', [RoleController::class, 'memberRentalHistory'])->name('member.rental.history');
    });

    // Routes accessible by multiple roles
    Route::middleware(['role:gudang'])->group(function () {
        // Barang management - Hanya Gudang yang bisa kelola barang
        Route::resource('barang', BarangController::class);
        
        // Rental approval dan operasional - Gudang yang handle semua operasional rental
        Route::get('/rental/pending/approval', [RentalController::class, 'pending'])->name('rental.pending.gudang');
        Route::post('/rental/{rental}/approve', [RentalController::class, 'approve'])->name('rental.approve');
        Route::post('/rental/{rental}/reject', [RentalController::class, 'reject'])->name('rental.reject');
        Route::post('/rental/{rental}/start', [RentalController::class, 'start'])->name('rental.start');
        Route::post('/rental/{rental}/take', [RentalController::class, 'take'])->name('rental.take');
        Route::post('/rental/{rental}/return', [RentalController::class, 'return'])->name('rental.return');
    });

    // Manager specific routes - View only untuk monitoring
    Route::middleware(['role:manager'])->group(function () {
        // Manager bisa lihat semua barang tapi tidak edit
        Route::get('/manager/barang', [BarangController::class, 'index'])->name('manager.barang.index');
        Route::get('/manager/barang/{barang}', [BarangController::class, 'show'])->name('manager.barang.show');
        
        // Manager bisa lihat semua rental untuk monitoring
        Route::get('/manager/rental/pending', [RentalController::class, 'pending'])->name('manager.rental.pending');
        
        // Manager report barang dengan grafik
        Route::get('/manager/report/barang', [RoleController::class, 'reportBarang'])->name('manager.report.barang');
        
        // Manager khusus untuk user management
        Route::get('/manager/users', [RoleController::class, 'userManagement'])->name('manager.users');
        Route::get('/manager/users/create', [RoleController::class, 'createUser'])->name('manager.users.create');
        Route::post('/manager/users', [RoleController::class, 'storeUser'])->name('manager.users.store');
        Route::patch('/manager/users/{user}/role', [RoleController::class, 'updateUserRole'])->name('manager.users.update-role');
    });
    
    // Rental routes - All authenticated users
    Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');
    Route::get('/rental/create', [RentalController::class, 'create'])->name('rental.create');
    Route::post('/rental', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/rental/{rental}', [RentalController::class, 'show'])->name('rental.show');
    
    // Barang view - All authenticated users
    Route::get('/barang/available', [BarangController::class, 'available'])->name('barang.available');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
