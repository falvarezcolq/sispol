<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;

Route::inertia('/', 'Welcome')->name('home');
//API routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('api/card_details/save_card_detail_result', [CardController::class, 'saveCardDetailResult'])->name('card_details.save_card_detail_result');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('cards', CardController::class)->names('cards');
});

require __DIR__.'/settings.php';
