<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class AccountCreateController extends Controller
{
    public function create()
    {
        return view('private.accounts.create', [
            'mainCurrencies' => ['USD', 'EUR'],
            'accountTypes' => ['private', 'business', 'shared', 'investment'],
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'currency' => ['required', 'string', 'in:USD,EUR'],
            'type' => ['required', 'string', 'in:Shared,Investment,Private,Business'],
        ]);
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
