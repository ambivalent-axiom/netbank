<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardContactController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts()->simplePaginate(5);
        return view('private.contacts.index', [
            'contacts' => $contacts
        ]);
    }
}
