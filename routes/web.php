<?php
use App\Http\Controllers\Account\AccountCreateController;
use App\Http\Controllers\Account\AccountDeleteController;
use App\Http\Controllers\Account\AccountEditController;
use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountShareController;
use App\Http\Controllers\Crypto\CryptoController;
use App\Http\Controllers\Crypto\CryptoPortfolioController;
use App\Http\Controllers\Dashboard\DashboardContactController;
use App\Http\Controllers\Dashboard\DashboardIndexController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Middleware\AuthorisedToTransact;
use App\Http\Controllers\User\ProfileController;
use App\Http\Middleware\HasInvestmentAccount;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.index');
});

Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/accounts', [AccountIndexController::class, 'index'])
        ->name('accounts');

    Route::get('/accounts/create', [AccountCreateController::class, 'create'])
        ->name('create');

    Route::post('/accounts/create', [AccountCreateController::class, 'store']);

    Route::get('/accounts/{account}/destroy', [AccountDeleteController::class, 'destroy'])
        ->name('destroy');

    Route::get('/accounts/{account}/default', [AccountEditController::class, 'default'])
        ->name('default');

    Route::controller(AccountShareController::class)->group(function () {
        Route::get('/accounts/share','index')
            ->name('accounts.share.index');
        Route::put('/accounts/share','store')
            ->name('accounts.share');
        Route::delete('/accounts/share','destroy')
            ->name('accounts.share.destroy');
    });

    Route::get('/dashboard', [DashboardIndexController::class, 'index'])
        ->name('dashboard');

    Route::controller(DashboardContactController::class)->group(function () {
        Route::get('/contacts', 'index')->name('contacts.index');
        Route::get('/contacts/add', 'add')->name('contacts.add');
        Route::post('/contacts/add', 'store')->name('contacts.store');
        Route::delete('/contacts/delete', 'destroy')->name('contacts.destroy');
    });

    Route::controller(CryptoController::class)->group(function () {
        Route::get('/crypto', 'index')
            ->name('crypto');
        Route::post('/crypto', 'search')
            ->name('crypto.search');
        Route::get('/crypto/buy/{currency}', 'show')
            ->name('crypto.buy')
            ->middleware(HasInvestmentAccount::class);
        Route::put('/crypto/buy/{currency}', 'buy')
            ->name('crypto.buy')
            ->middleware(HasInvestmentAccount::class);
    });



    Route::controller(CryptoPortfolioController::class)->group(function () {
        Route::get('/crypto/portfolio', 'index')
            ->name('crypto.portfolio');
        Route::post('/crypto/portfolio', 'show')
            ->name('crypto.portfolio.show');
        Route::put('/crypto/sell', 'update')
            ->name('crypto.portfolio.update');
    })->middleware(HasInvestmentAccount::class);



    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions','index')
            ->name('transactions');
        Route::get('/transactions/create','create')
            ->name('create');
        Route::put('/transactions/create','store')
            ->name('store')
            ->middleware(AuthorisedToTransact::class);
    });

    Route::get('/test', function () {

        $portfolio = Portfolio::where([
            ['user_id', '=', Auth::user()],
            ['symbol', '=', 'BTC']
        ])->get();



        return count($portfolio);
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
