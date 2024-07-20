<?php

namespace App\Http\Controllers\Addition;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AddEmailController extends Controller
{
    // View add email page
    public function index()
    {
        // return view page
        return view('addition.email');
    }

    // Update email from database
    public function update(Request $request)
    {

        // Validate form
        $validate = $request->validate([
            'email' => ['required', 'string', 'email', 'unique:users'],
        ]);

        // if validate
        if ($validate) {
            // user auth
            $user = Auth::user();
            // request email
            $user->email = $request->email;
            $user->save();
            return redirect('/user/dashboard');
        }
    }
}
