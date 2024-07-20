<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // Send message
    public function sendMsg(Request $request)
    {
        // If setUp captcha
        if (env('NOCAPTCHA_SITEKEY') != null && env('NOCAPTCHA_SECRET') != null) {
            // Validate from with captcha
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:150'],
                'message' => ['required', 'string', 'max:1500'],
                'g-recaptcha-response' => ['required', 'captcha'],
            ]);
        } else {
            // Validate from without captcha
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:150'],
                'message' => ['required', 'string', 'max:1500'],
            ]);
        }

        // Check if user login to get user_id
        if (Auth::user()) {
            $user_id = Auth::user()->id; // if its login get user id
        } else {
            $user_id = null; // if not login make it null
        }

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new message on database
        $message = Message::create([
            'user_id' => $user_id,
            'name' => $request['name'],
            'email' => $request['email'],
            'subject' => $request['subject'],
            'message' => $request['message'],
        ]);

        // If message created
        if ($message) {
            // Back with success message
            $request->session()->flash('success', 'Your message has been sent successfully, We will reply to you as soon as possible.');
            return redirect()->back();
        } else {
            // Back if messaage not created
            return redirect()->back();
        }

    }
}
