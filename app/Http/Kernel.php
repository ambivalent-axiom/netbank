<?php
namespace App\Http;

use App\Http\Middleware\AuthorisedToTransact;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        'check.transaction' => AuthorisedToTransact::class,
    ];
}
