<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\RentalController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Test route
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Barang routes
    Route::prefix('barangs')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
        Route::get('/available/list', [BarangController::class, 'available']);
        Route::get('/categories/list', [BarangController::class, 'categories']);
    });
    
    // Rental routes
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index']);
        Route::post('/', [RentalController::class, 'store']);
        Route::get('/{id}', [RentalController::class, 'show']);
        Route::put('/{id}', [RentalController::class, 'update']);
        Route::patch('/{id}/status', [RentalController::class, 'updateStatus']);
        Route::get('/user/mine', [RentalController::class, 'myRentals']);
        Route::get('/pending/list', [RentalController::class, 'pending']);
        Route::get('/ongoing/list', [RentalController::class, 'ongoing']);
        Route::get('/completed/list', [RentalController::class, 'completed']);
    });
    
    // Stock routes
    Route::prefix('stocks')->group(function () {
        Route::get('/', [StockController::class, 'index']);
        Route::post('/adjust', [StockController::class, 'adjust']);
        Route::get('/logs', [StockController::class, 'logs']);
        Route::get('/low-stock', [StockController::class, 'lowStock']);
    });
    
    // User management (Manager & Gudang only)
    Route::middleware('role:manager,gudang')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });
    
    // Dashboard stats (Manager only)
    Route::middleware('role:manager')->group(function () {
        Route::get('/dashboard/stats', [UserController::class, 'dashboardStats']);
        Route::get('/reports/summary', [UserController::class, 'reportsSummary']);
    });
});
