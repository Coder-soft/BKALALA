<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    // users page
    public function index()
    {
        // get all users data
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    // View user
    public function viewUser($id)
    {
        // get user using id
        $user = User::find($id);
        // if not data null
        if ($user != null) {
            // get user uploads
            $uploads = Upload::where('user_id', $user->id)->with('user')->orderbyDesc('id')->get();
            return view('admin.view.user', ['uploads' => $uploads, 'user' => $user]);
        } else {
            // back to users f data null
            return redirect('admin/users');
        }
    }

    // Add new admin
    public function addAdmin(Request $request)
    {
        // validate form
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $permission = 1; // permission 1 is admin
        $avatar = "default.png"; // default avatar

        // create the new user
        $register = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'avatar' => $avatar,
            'password' => Hash::make($request['password']),
            'permission' => $permission,
        ]);

        // if registered
        if ($register) {
            // success response
            return response()->json([
                'success' => 'New admin added successfully',
            ]);
        }
    }

    // ban user
    public function banUser($id)
    {
        // find user using id
        $user = User::find($id);
        // if data not null
        if ($user != null) {
            // check user status
            if ($user->status != 2) {
                // check if user is not the currant auth user
                if (Auth::user()->id != $user->id) {
                    // ban user update status to 2 mains its banned
                    $ban = User::where('id', $id)->update(['status' => 2]);
                    if ($ban) {
                        // success response
                        return response()->json([
                            'success' => 'User has been banned successfully',
                        ]);
                    } else {
                        // error response
                        return response()->json([
                            'error' => 'Error please refresh page and try again',
                        ]);
                    }
                } else {
                    // error response
                    return response()->json([
                        'error' => 'You cannot ban yourself',
                    ]);
                }
            } else {
                // error response
                return response()->json([
                    'error' => 'Illegal request ! please refresh page and try again',
                ]);
            }
        } else {
            // error response
            return response()->json([
                'error' => 'Error please refresh page and try again',
            ]);
        }
    }

    // unban user
    public function unbanUser($id)
    {
        // find user using id
        $user = User::find($id);
        // if data not null
        if ($user != null) {
            // check user status
            if ($user->status != 1) {
                // unban user change status to 1 mains unban user
                $unban = User::where('id', $id)->update(['status' => 1]);
                //
                if ($unban) {
                    // success response
                    return response()->json([
                        'success' => 'User has been banned successfully',
                    ]);
                } else {
                    // error response
                    return response()->json([
                        'error' => 'Error please refresh page and try again',
                    ]);
                }
            } else {
                // error response
                return response()->json([
                    'error' => 'Illegal request ! please refresh page and try again',
                ]);
            }
        } else {
            // error response
            return response()->json([
                'error' => 'Error please refresh page and try again',
            ]);
        }
    }
}
