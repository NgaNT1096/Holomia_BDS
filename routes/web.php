<?php

use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermisionsController;
use App\Http\Controllers\Admin\RoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('index');
            Route::post('', [UserController::class, 'store'])->name('store');
            // modal route
            Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('import/user',  [UserController::class, 'import'])->name('import');
            Route::post('addAnalyticCode/{id}', [UserController::class, 'addAnalyticCode'])->name('addAnalyticCode');
            Route::post('verifyEmail', [UserController::class, 'verifyEmail'])->name('verifyEmail');
        });
        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('index');
            Route::post('', [RoleController::class, 'store'])->name('store');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
        });
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('', [PermisionsController::class, 'index'])->name('index');
            Route::post('', [PermisionsController::class, 'store'])->name('store');
            Route::put('/update/{id}', [PermisionsController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PermisionsController::class, 'delete'])->name('delete');
        });

    });
});
