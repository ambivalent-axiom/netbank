<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountIndexController extends Controller
{
    public function index()
    {
        $accounts = Auth::user()->accounts()->simplePaginate(6);
        $accounts->transform(function ($account) {
            $account->type = ucwords($account->type);
            $account->balance = number_format($account->balance/100, 2, ',', ' ');
            return $account;
        });

        $sharedAccounts = Auth::user()->sharedWithAccounts()->with('owner')->get();
        $sharedAccounts->transform(function ($account) {
            $account->type = ucwords($account->type);
            $account->balance = number_format($account->balance/100, 2, ',', ' ');
            return $account;
        });

        return view('private.accounts.index', [
            'accounts' => $accounts,
            'sharedAccounts' => $sharedAccounts
        ]);
    }
}
