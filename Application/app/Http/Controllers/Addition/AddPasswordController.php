<?php

namespace App\Http\Controllers\Addition;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AddPasswordController extends Controller
{

    // View add password page
    public function index()
    {
        // return view page
        return view('addition.password');
    }

    // Update password from database
    public function update(Request $request)
    {
        // validate inputs
        $validate = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // if validate update it
        if ($validate) {
            // User auth
            $user = Auth::user();
            // request password
            $user->password = bcrypt($request->get('password'));
            $user->save();
            return redirect('/user/dashboard');
        }
    }
}
