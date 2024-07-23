<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountEditController extends Controller
{
    public function default(Account $account)
    {
        $user = Auth::user();
        $user->default_account = $account->id;
        $user->save();


        return redirect(route('accounts'))->with('message', $account->id . ' is set as primary.');
    }
}
