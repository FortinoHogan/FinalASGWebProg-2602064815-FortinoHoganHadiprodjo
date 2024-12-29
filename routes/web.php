<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('home');

Route::middleware(['CekAuth'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'login_post'])->name('login_post');
    Route::get('/register', [UserController::class, 'register'])->name('register');     
    Route::post('/register', [UserController::class, 'register_post'])->name('register_post');
    Route::get('/payment', [UserController::class, 'payment'])->name('payment');   
    Route::post('/payment', [UserController::class, 'payment_post'])->name('payment_post');
    Route::post('/overpaid', [UserController::class, 'overpaid'])->name('overpaid');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('set-locale');
