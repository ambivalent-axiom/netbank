<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function index()
    {
        $currencies = Currency::where('type', 'crypto')
            ->orderBy('rank', 'asc')
            ->simplePaginate(100);
        return view('private.crypto.index', [
            'currencies' => $currencies,
        ]);
    }
    public function search(Request $request)
    {
        $currencies = Currency::where(function ($query) use ($request) {
            $query->where('symbol', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('name', 'LIKE', '%' . $request->get('search') . '%');
        })->simplePaginate(10);
        return view('private.crypto.index', [
            'currencies' => $currencies,
        ]);
    }
    public function buy(Request $request)
    {
        return view('private.crypto.buy');
    }
}
