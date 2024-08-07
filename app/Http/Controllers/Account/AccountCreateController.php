<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class AccountCreateController extends Controller
{
    public function create()
    {
        $currencies = Currency::where('type', 'fiat')->get();
        $symbols = $currencies->map(function ($currency) {
            return $currency->symbol;
        });
        return view('private.accounts.create', [
            'mainCurrencies' => $symbols,
            'accountTypes' => Account::TYPES,
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $currencies = Currency::where('type', 'fiat')->get();
        $symbols = $currencies->map(function ($currency) {
            return $currency->symbol;
        });
        $validCurrencies = $symbols->implode(',');
        $request->validate([
            'currency' => ['required', 'string', 'in:' . $validCurrencies],
            'type' => ['required', 'string', 'in:Shared,Investment,Private,Business'],
        ]);
        if ($request->type == 'Investment' && $request->currency != 'USD')
        {
            return redirect(route('accounts'))->with('error', 'Error. Investment account can be USD account only!');
        }
        if ($request->type == 'Investment' && Auth::user()->accounts()->where('type', 'investment')->count() > 0)
        {
            return redirect(route('accounts'))->with('error', 'Error. You are allowed to have only one Investment account!');
        }

        $account = Account::create([
            'id' => Uuid::uuid4(),
            'type' => strtolower($request->type),
            'portfolio_id' => Uuid::uuid4(),
            'currency' => $request->currency,
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);
        return redirect(route('accounts'))->with('success', 'Account created.');
    }
}
