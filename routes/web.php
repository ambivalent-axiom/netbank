<?php
use App\Http\Controllers\Account\AccountCreateController;
use App\Http\Controllers\Account\AccountDeleteController;
use App\Http\Controllers\Account\AccountEditController;
use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountShareController;
use App\Http\Controllers\Dashboard\DashboardContactController;
use App\Http\Controllers\Dashboard\DashboardIndexController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Middleware\AuthorisedToTransact;
use App\Http\Controllers\User\ProfileController;
use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardIndexController::class, 'index'])
        ->name('dashboard');




    Route::get('/test', function () {

        $xml = simplexml_load_string(Cache::get('exchange_rates'));
        $currencies = collect();
        foreach ($xml->Currencies->Currency as $currency) {
            $currencies->add(new Currency((string) $currency->ID, (float) $currency->Rate));
        }

        var_dump($currencies->firstWhere('id', 'USD')->rate);
            }
    );





    Route::get('/accounts', [AccountIndexController::class, 'index'])
        ->name('accounts');
    Route::get('/accounts/create', [AccountCreateController::class, 'create'])
        ->name('create');
    Route::post('/accounts/create', [AccountCreateController::class, 'store']);
    Route::get('/accounts/{account}/destroy', [AccountDeleteController::class, 'destroy'])
        ->name('destroy');
    Route::get('/accounts/{account}/default', [AccountEditController::class, 'default'])
        ->name('default');



    Route::get('/accounts/share', [AccountShareController::class, 'index'])
        ->name('accounts.share.index');
    Route::put('/accounts/share', [AccountShareController::class, 'store'])
        ->name('accounts.share');
    Route::delete('/accounts/share', [AccountShareController::class, 'destroy'])
        ->name('accounts.share.destroy');




    Route::controller(DashboardContactController::class)->group(function () {
        Route::get('/contacts', 'index')->name('contacts.index');
        Route::get('/contacts/add', 'add')->name('contacts.add');
        Route::post('/contacts/add', 'store')->name('contacts.store');
        Route::delete('/contacts/delete', 'destroy')->name('contacts.destroy');
    });


    Route::get('/crypto', function () {return view('private.crypto.index');})
        ->name('crypto');



    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions');
    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('create');
    Route::put('/transactions/create', [TransactionController::class, 'store'])
        ->name('store')->middleware(AuthorisedToTransact::class);



});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
