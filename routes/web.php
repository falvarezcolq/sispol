<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::inertia('/', 'Welcome')->name('home');
// API routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('api/card_details/save_card_detail_result', [CardController::class, 'saveCardDetailResult'])->name('card_details.save_card_detail_result');
});


Route::middleware(['auth', 'verified'])->group(function () {
       
    Route::resource('dashboard', DashboardController::class)->only(['index'])->names('dashboard');
});

Route::middleware(['auth', 'verified','is_admin'])->group(function () {
    
    // Route::resource('dashboard', DashboardController::class)->only(['index'])->names('dashboard');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('cards', CardController::class)->names('cards');
    Route::resource('fixtures', FixtureController::class)->names('fixtures');
});

require __DIR__.'/settings.php';
