<?php

use App\Http\Controllers\Account\AccountCreateController;
use App\Http\Controllers\Account\AccountDeleteController;
use App\Http\Controllers\Account\AccountEditController;
use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Dashboard\DashboardContactController;
use App\Http\Controllers\Dashboard\DashboardIndexController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('public.index');
});








Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardIndexController::class, 'index'])
        ->name('dashboard');
    Route::get('/accounts', [AccountIndexController::class, 'index'])
        ->name('accounts');
    Route::get('/accounts/create', [AccountCreateController::class, 'create'])
        ->name('create');
    Route::post('/accounts/create', [AccountCreateController::class, 'store']);
    Route::get('/accounts/{account}/destroy', [AccountDeleteController::class, 'destroy'])
        ->name('destroy');
    Route::get('/accounts/{account}/default', [AccountEditController::class, 'default'])
        ->name('default');

    Route::get('/contacts', [DashboardContactController::class, 'index'])->name('contacts.index');



    Route::get('/crypto', function () {return view('private.crypto.index');})
        ->name('crypto');
    Route::get('/transactions', function () {return view('private.transactions.index');})
        ->name('transactions');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
