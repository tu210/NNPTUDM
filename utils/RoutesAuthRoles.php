<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;

// Product Routes
Route::get('/products', [ProductController::class, 'index']); // Không yêu cầu đăng nhập
Route::middleware(['auth', 'role:mod'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
});
Route::middleware(['auth', 'role:admin'])->delete('/products/{id}', [ProductController::class, 'destroy']);

// Category Routes (tương tự Product)
Route::get('/categories', [CategoryController::class, 'index']);
Route::middleware(['auth', 'role:mod'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});
Route::middleware(['auth', 'role:admin'])->delete('/categories/{id}', [CategoryController::class, 'destroy']);

// User Routes
Route::middleware(['auth', 'role:mod'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show'])->where('id', '!=', auth()->id());
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'softDelete']);
});

// Role Routes
Route::get('/roles', [RoleController::class, 'index']); // Không yêu cầu quyền
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'softDelete']);
});

// Auth Routes
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::middleware('auth')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/changepassword', [AuthController::class, 'changePassword']);
});
