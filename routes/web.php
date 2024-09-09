<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'uk'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [VerifyEmailController::class, 'login'])->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin_panel')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin_panel');

    Route::prefix('/users')->name('admin_users_')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('{id}', [UserController::class, 'show'])->name('show');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{id}', [UserController::class, 'update'])->name('update');
        Route::post('delete', [UserController::class, 'destroy'])->name('destroy');
    });
});


require __DIR__.'/auth.php';
