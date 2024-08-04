<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBuyCryptoTransaction;
use App\Models\CryptoTransaction;
use App\Models\Currency;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CryptoPortfolioController extends Controller
{
    public function index()
    {
        $investmentAccount = Auth::user()
            ->accounts()
            ->where('type', 'investment')
            ->first();
        if ($investmentAccount) {
            $portfolio = Portfolio::where('id', $investmentAccount->portfolio_id)->get();
            $cryptoTransactions = CryptoTransaction::where('user_id', Auth::id())->simplePaginate(10);
        }
        return view('private.crypto.portfolio', [
            'investmentAccount' => $investmentAccount,
            'portfolio' => $portfolio,
            'cryptoTransactions' => $cryptoTransactions,
        ]);
    }
    public function show(Request $request)
    {
        $request->validate([
            'symbol' => ['required', 'string', 'exists:currencies,symbol'],
            'name' => ['required', 'string', 'exists:currencies,name']
        ]);
        $investmentAccount = Auth::user()
            ->accounts()
            ->where('type', 'investment')
            ->first();
        $portfolio = Portfolio::where([
            'id' => $investmentAccount->portfolio_id,
            'symbol' => $request->symbol,
            'currency_name' => $request->name
        ])->first();
        $currency = Currency::firstWhere([
            'type' => 'crypto',
            'name' => $portfolio->currency_name,
            'symbol' => $portfolio->symbol
        ]);

        return view('private.crypto.sell', [
            'investmentAccount' => $investmentAccount,
            'portfolio' => $portfolio,
            'currency' => $currency,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'symbol' => ['required', 'string', 'exists:currencies,symbol'],
            'name' => ['required', 'string', 'exists:currencies,name'],
            'crypto_amount' => ['required', 'numeric'],
            'usd_amount' => ['required', 'numeric'],
        ]);
        $usd_amount = $request->usd_amount * 100;
        $investmentAccount = Auth::user()
            ->accounts()
            ->where('type', 'investment')
            ->first();

        $portfolio = Portfolio::where([
            'id' => $investmentAccount->portfolio_id,
            'symbol' => $request->symbol,
            'currency_name' => $request->name
        ])->first();

        if ($portfolio->amount < $request->crypto_amount) {
            return redirect()
                ->back()
                ->with('error', 'Sell amount is over the amount in Your possession!');
        }

        $cryptoTransaction = CryptoTransaction::create([
            'portfolio' => $investmentAccount->portfolio_id,
            'user_id' => Auth::id(),
            'symbol' => $request->symbol,
            'type' => 'sell',
            'rate' => Currency::where([
                ['name', '=', $request->name],
                ['symbol', '=', $request->symbol]
            ])->first()->rate,
            'status' => 'ordered',
            'amount_USD' => $usd_amount,
            'amount_crypto' => $request->crypto_amount,
            'name' => $request->name,
        ]);
        ProcessSellCryptoTransaction::dispatch($cryptoTransaction->id);
        return redirect('/crypto')->with('success', 'Crypto sell operation completed');
    }
}
