<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SystemManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Unisba
|--------------------------------------------------------------------------
*/

// === ROOT: Redirect ke login atau dashboard ===
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // === DASHBOARD ===
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // === PROFILE ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:is-admin'])->group(function () {

        // === MANAJEMEN USER ===
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/import/form', [UserManagementController::class, 'importForm'])->name('import.form');
            Route::post('/import', [UserManagementController::class, 'import'])->name('import');
            Route::get('/import/template', [UserManagementController::class, 'downloadTemplate'])->name('import.template');
            Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
            Route::patch('/{user}/toggle-active', [UserManagementController::class, 'toggleActive'])->name('toggle-active');
            Route::post('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('reset-password');
            Route::get('/{user}/access', [UserManagementController::class, 'manageAccess'])->name('access');
            Route::post('/{user}/access', [UserManagementController::class, 'updateAccess'])->name('access.update');
        });

        // === MANAJEMEN SISTEM ===
        Route::prefix('systems')->name('systems.')->group(function () {
            Route::get('/', [SystemManagementController::class, 'index'])->name('index');
            Route::get('/create', [SystemManagementController::class, 'create'])->name('create');
            Route::post('/', [SystemManagementController::class, 'store'])->name('store');
            Route::get('/{system}/edit', [SystemManagementController::class, 'edit'])->name('edit');
            Route::patch('/{system}', [SystemManagementController::class, 'update'])->name('update');
            Route::delete('/{system}', [SystemManagementController::class, 'destroy'])->name('destroy');
            Route::patch('/{system}/toggle-active', [SystemManagementController::class, 'toggleActive'])->name('toggle-active');
        });

        // === ACTIVITY LOG ===
        Route::get('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])
            ->name('activity-log.index');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
