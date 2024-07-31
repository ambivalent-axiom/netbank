<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class DashboardIndexController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts;
        $accounts = Auth::user()->accounts;
        $eurAccounts = $accounts->filter(function ($account) {
            return $account->currency == 'EUR';
        });
        $usdAccounts = $accounts->filter(function ($account) {
            return $account->currency == 'USD';
        });
        $topCurrencies = Currency::where('type', 'crypto')
            ->limit(10)
            ->get();
        return view ('private.dashboard.index', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'eurAccounts' => $eurAccounts,
            'usdAccounts' => $usdAccounts,
            'topCurrencies' => $topCurrencies,
        ]);
    }
}
