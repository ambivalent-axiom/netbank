<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('private.transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactTypes = ['business', 'private', 'shared'];
        $ownAccounts = Auth::user()->accounts()->whereIn('type', $transactTypes)->get();
        $sharedAccounts = Auth::user()->sharedWithAccounts;
        $accounts = $ownAccounts->merge($sharedAccounts);
        $contacts = Auth::user()->contacts;

        return view('private.transactions.create', [
            'accounts' => $accounts,
            'contacts' => $contacts,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionController $f)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionController $f)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionController $f)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionController $f)
    {
        //
    }
}
