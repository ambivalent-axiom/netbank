<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\NewsArticle;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;

class DashboardIndexController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts;
        $accounts = Auth::user()->accounts;
        $investmentAccount = $accounts->filter(function ($account) {
            return $account->type == 'investment';
        })->first();
        $eurAccounts = $accounts->filter(function ($account) {
            return $account->currency == 'EUR';
        });
        $usdAccounts = $accounts->filter(function ($account) {
            return $account->currency == 'USD';
        });
        $topCurrencies = Currency::where('type', 'crypto')
            ->limit(10)
            ->get();
        $latestArticle = NewsArticle::first();
        if($investmentAccount) {
            $portfolio = Portfolio::where('portfolio_id', $investmentAccount->portfolio_id)
                ->get();
        }
        return view ('private.dashboard.index', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'eurAccounts' => $eurAccounts,
            'usdAccounts' => $usdAccounts,
            'topCurrencies' => $topCurrencies,
            'newsArticles' => $latestArticle,
            'portfolio' => $portfolio ?? null,
            'investmentAccount' => $investmentAccount ?? null,
        ]);
    }
}
