<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Manager\UserController as ManagerUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // Check if user wants to logout
        if (request()->has('logout')) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Force logout route for testing
Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('status', 'You have been logged out successfully.');
});

// Debug route untuk test manager dashboard
Route::get('/debug-manager', function () {
    return view('manager.dashboard', [
        'totalUsers' => 0,
        'activeRentals' => 0,
        'totalBarang' => 0,
        'pendingApprovals' => 0,
        'barangKeluar' => 0,
        'barangMasuk' => 0,
        'sedangRental' => 0,
        'totalRental' => 0,
        'kategoriSummary' => collect([]),
        'recentActivities' => []
    ]);
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
        
        // User Management Routes
        Route::resource('manager/users', ManagerUserController::class)->except(['show']);
        Route::patch('/manager/users/{user}/toggle-status', [ManagerUserController::class, 'toggleStatus'])->name('manager.users.toggle-status');
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
        
        // Stock adjustment - Gudang bisa adjust stok manual
        Route::patch('/barang/{barang}/adjust-stock', [BarangController::class, 'adjustStock'])->name('barang.adjust-stock');
        
        // Rental approval dan operasional - Gudang yang handle semua operasional rental
        Route::get('/rental/pending/approval', [RentalController::class, 'pending'])->name('rental.pending.gudang');
        Route::post('/rental/{rental}/approve', [RentalController::class, 'approve'])->name('rental.approve');
        Route::post('/rental/{rental}/reject', [RentalController::class, 'reject'])->name('rental.reject');
        Route::post('/rental/{rental}/start', [RentalController::class, 'start'])->name('rental.start');
        Route::post('/rental/{rental}/take', [RentalController::class, 'take'])->name('rental.take');
        Route::post('/rental/{rental}/return', [RentalController::class, 'return'])->name('rental.return');
        
        // Maintenance management - Kelola barang maintenance
        Route::get('/maintenance/barang', [RoleController::class, 'maintenanceBarang'])->name('maintenance.barang');
        Route::patch('/maintenance/barang/{barang}', [RoleController::class, 'updateMaintenanceStatus'])->name('maintenance.update');
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
        
        // Manager User Management - Complete CRUD
        Route::resource('manager/users', \App\Http\Controllers\Manager\UserController::class, [
            'names' => [
                'index' => 'manager.users.index',
                'create' => 'manager.users.create',
                'store' => 'manager.users.store',
                'show' => 'manager.users.show',
                'edit' => 'manager.users.edit',
                'update' => 'manager.users.update',
                'destroy' => 'manager.users.destroy',
            ]
        ]);
        Route::patch('/manager/users/{user}/toggle-status', [\App\Http\Controllers\Manager\UserController::class, 'toggleStatus'])->name('manager.users.toggle-status');
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
