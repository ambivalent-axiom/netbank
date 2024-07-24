<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SharedAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountShareController extends Controller
{
    public function index()
    {
        $accounts = Auth::user()->accounts()->where([
            'type' => 'shared'
        ])->get();
        if ($accounts->isEmpty()) {
            return redirect()->route('accounts')->with('message', 'You must have a shared account in your accounts first.');
        }
        $contacts = Auth::user()->contacts;
        $sharedAccounts = Auth::user()->sharedAccounts()->with('sharedUser')->get();
        return view('private.accounts.share', [
            'accounts' => $accounts,
            'contacts' => $contacts,
            'sharedAccounts' => $sharedAccounts
        ]);

    }
    public function store()
    {
        $request = request();
        //validate: if account and contact belongs to user and account is not already shared with this user
        if (Account::where('id', $request->account)->first()->user_id != Auth::id() //not his account
            || ! Auth::user()->contacts->contains($request->contact) //not his contact
        )
        {
            return redirect()->route('accounts.share')->with('error', 'Unauthorized operation attempted!');
        }
        if (DB::table('shared_accounts')->where([
                'user_id' => Auth::id(),
                'account_id' => $request->account,
                'shared_user_id' => $request->contact
            ])->exists()
        )
        {
            return redirect()->route('accounts.share')->with('message', 'Hey, this user already has access to this account!');
        }
        SharedAccount::create([
            'user_id' => Auth::id(),
            'shared_user_id' => User::where('id', $request->contact)->first()->id,
            'account_id' => Account::where('id', $request->account)->first()->id,
        ]);
        return redirect()->route('accounts.share')->with('success', 'Account has been shared with contact');
    }
    public function destroy()
    {
        $request = request();
        $sharedAccount = SharedAccount::where([
            'id' => $request->delete_shared_account_id,
            'user_id' => Auth::id()
        ]);
        $sharedAccount->delete();
        return redirect()->route('accounts.share')->with('success', 'Relationship has been removed');
    }
}
