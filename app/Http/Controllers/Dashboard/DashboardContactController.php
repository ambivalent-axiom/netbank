<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserContact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardContactController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts()->simplePaginate(5);
        return view('private.contacts.index', [
            'contacts' => $contacts
        ]);
    }
    public function add()
    {
        return view('private.contacts.add');
    }
    public function store()
    {
        $request = request();
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email']
        ]);
        if ($request->email == Auth::user()->email)
        {
            return redirect('/contacts/add')->with([
                'error' => 'You cannot be Your own contact...'
            ]);
        }
        if (DB::table('user_contacts')->where([
            'user_id' => Auth::id(),
            'contact_user_id' => User::where('email', $request->email)->first()->id
        ])->exists())
        {
            return redirect('/contacts/add')->with([
                'error' => 'Such contact is already in Your list.'
            ]);
        }
        UserContact::create([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'contact_user_id' => User::where('email', $request->email)->first()->id
        ]);
        return redirect('/contacts')->with([
            'success' => 'Contact found and added!'
        ]);
    }
    public function destroy()
    {
        $request = request();
        $contact = UserContact::where([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'contact_user_id' => $request->contact
        ])->first();
        $contact->delete();
        return redirect('/contacts')->with([
            'success' => 'Contact removed from Your contact list!'
        ]);
    }
}
