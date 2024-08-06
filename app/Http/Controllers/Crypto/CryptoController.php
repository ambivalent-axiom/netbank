<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBuyCryptoTransaction;
use App\Models\CryptoTransaction;
use App\Models\Currency;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CryptoController extends Controller
{
    public function index()
    {
        $currencies = Currency::where('type', 'crypto')
            ->orderBy('rank', 'asc')
            ->simplePaginate(20);
        $investmentAccount = Auth::user()->accounts()->where('type', 'investment')->first();
        if ($investmentAccount) {
            $portfolio = Portfolio::where('portfolio_id', $investmentAccount->portfolio_id)->get();
        }
        return view('private.crypto.index', [
            'currencies' => $currencies,
            'investmentAccount' => $investmentAccount ?? null,
            'portfolio' => $portfolio ?? null,
        ]);
    }
    public function search(Request $request)
    {
        $investmentAccount = Auth::user()->accounts()->where('type', 'investment')->first();
        if ($investmentAccount) {
            $portfolio = Portfolio::where('portfolio_id', $investmentAccount->portfolio_id)->get();
        }
        $currencies = Currency::where(function ($query) use ($request) {
            $query->where('symbol', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('name', 'LIKE', '%' . $request->get('search') . '%');
        })->simplePaginate(10);
        return view('private.crypto.index', [
            'currencies' => $currencies,
            'investmentAccount' => $investmentAccount ?? null,
            'portfolio' => $portfolio ?? null,
        ]);
    }
    public function show($currencyName)
    {
        $currency = Currency::where('name', $currencyName)->first();
        $investmentAccount = Auth::user()->accounts()->where('type', 'investment')->first();
        $portfolio = Portfolio::where('portfolio_id', $investmentAccount->portfolio_id)->get();
        return view('private.crypto.buy', [
            'investmentAccount' => $investmentAccount,
            'currency' => $currency,
            'portfolio' => $portfolio,
        ]);
    }
    public function buy(Request $request)
    {
        $investmentAccount = Auth::user()->accounts()->where('type', 'investment')->first();
        $portfolio = Portfolio::where('portfolio_id', $investmentAccount->portfolio_id)->get();
        $request->validate([
            'currency_name' => ['required', 'string', 'exists:currencies,name'],
            'currency_symbol' => ['required', 'string', 'exists:currencies,symbol'],
            'crypto_amount' => ['required', 'numeric'],
            'usd_amount' => ['required', 'numeric'],
        ]);
        $usd_amount = $request->usd_amount * 100;
        if ($investmentAccount->balance < $usd_amount) {
            return redirect('/crypto/buy/' .  $request->currency_name)
                ->with('error', 'Insufficient Balance on Investment Account for such operation!');
        }
        $cryptoTransaction = CryptoTransaction::create([
            'portfolio' => $investmentAccount->portfolio_id,
            'user_id' => Auth::id(),
            'symbol' => $request->currency_symbol,
            'type' => 'buy',
            'rate' => Currency::where([
                ['name', '=', $request->currency_name],
                ['symbol', '=', $request->currency_symbol]
            ])->first()->rate,
            'status' => 'ordered',
            'amount_USD' => $usd_amount,
            'amount_crypto' => $request->crypto_amount,
            'name' => $request->currency_name,
        ]);
        ProcessBuyCryptoTransaction::dispatch($cryptoTransaction->id);
        return redirect('/crypto')->with('success', 'Crypto purchase completed');
    }
}
