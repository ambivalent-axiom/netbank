<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountDeleteController extends Controller
{
    public function destroy(Account $account)
    {
        if ($account->id == Auth::user()->default_account) {
            return redirect(route('accounts'))->with('error', 'Account is primary therefore cannot be deleted');
        }
        if($account->balance > 0) {
            return redirect(route('accounts'))->with('error', 'Account is not empty therefore cannot be deleted');
        }
        $account->type = 'deleted';
        $account->save();
        return redirect(route('accounts'))->with('message', 'Account deleted');
    }
}
