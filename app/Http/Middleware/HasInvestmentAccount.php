<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isEmpty;

class HasInvestmentAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(count(Auth::user()->accounts()->where('type', 'investment')->get()) == 0)
        {
            return redirect('/crypto')->with('error', 'You need an investment account to operate with crypto!');
        }
        return $next($request);
    }
}
