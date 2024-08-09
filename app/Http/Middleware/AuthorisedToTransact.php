<?php
namespace App\Http\Middleware;

use App\Models\Account;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorisedToTransact
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $accountId = $request->all()['from_account'];
        if ( ! $this->isUserAuthorizedForAccount($user, $accountId)) {
            return redirect('/transactions/create')->with('error', 'Unauthorized Transaction');
        }
        return $next($request);
    }
    protected function isUserAuthorizedForAccount(User $user, string $accountId): bool
    {
        $transactTypes = Account::TRANSACT_TYPES;
        $ownAccounts = Auth::user()->accounts()->whereIn('type', $transactTypes)->get();
        $sharedAccounts = Auth::user()->sharedWithAccounts;
        $accounts = $ownAccounts->merge($sharedAccounts);
        return $accounts->contains($accountId);
    }
}
