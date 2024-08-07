<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\NewsArticle;
use App\Models\Portfolio;
use App\Models\UserMessage;
use Illuminate\Http\Request;
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
        $userMessages = Auth::user()->userMessages;
        return view ('private.dashboard.index', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'eurAccounts' => $eurAccounts,
            'usdAccounts' => $usdAccounts,
            'topCurrencies' => $topCurrencies,
            'newsArticles' => $latestArticle,
            'portfolio' => $portfolio ?? null,
            'investmentAccount' => $investmentAccount ?? null,
            'userMessages' => $userMessages ?? null,
        ]);
    }
    public function update(Request $request){
        $userMessage = UserMessage::where('id', $request->message_id)->first();
        $userMessage->status = 'confirmed';
        $userMessage->save();
        return redirect('/dashboard')->with('message', 'Message has been confirmed as viewed');
    }
}
