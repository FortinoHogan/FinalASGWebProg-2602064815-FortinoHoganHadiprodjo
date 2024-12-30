<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('home');

Route::middleware(['CekAuth:guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'login_post'])->name('login_post');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'register_post'])->name('register_post');
    Route::get('/payment', [UserController::class, 'payment'])->name('payment');
    Route::post('/payment', [UserController::class, 'payment_post'])->name('payment_post');
    Route::post('/overpaid', [UserController::class, 'overpaid'])->name('overpaid');
});

Route::middleware(['CekAuth:auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/notifications/{id}/mark-as-read', [UserController::class, 'mark_as_read'])->name('notifications.mark-as-read');
    Route::post('/friends/add/{user}', [FriendController::class, 'add_friend'])->name('friends.add');
    Route::post('/friends/remove/{user}', [FriendController::class, 'remove_friend'])->name('friends.remove');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/messages/{friendId}', [ChatController::class, 'get_messages'])->name('messages.get');
    Route::post('/messages/{friendId}', [ChatController::class, 'send_message'])->name('messages.send');
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('set-locale');
