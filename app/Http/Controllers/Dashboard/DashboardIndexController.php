<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardIndexController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts;
        return view ('private.dashboard.index', [
            'contacts' => $contacts
        ]);
    }
}
