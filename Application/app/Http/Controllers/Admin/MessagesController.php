<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessagesController extends Controller
{
    // View messages page
    public function index()
    {
        // Get all messages
        $messages = Message::with('user')->orderbyDesc('id')->paginate(10);
        return view('admin.messages', ['messages' => $messages]);
    }

    // View message
    public function viewMsg($id)
    {
        // Get message data
        $message = Message::with('user')->where('id', $id)->first();
        // If data not null
        if ($message != null) {
            // if message status = 1 update it to 2
            if ($message->status == 1) {
                $update = Message::where('id', $id)->update(['status' => 2]);
            }
            return view('admin.view.message', ['message' => $message]);
        } else {
            // if data null back to messages
            return redirect('admin/messages');
        }
    }

    // Delete message
    public function deleteMsg($id)
    {
        // Get message data
        $message = Message::where('id', $id)->first();
        // if data not null
        if ($message != null) {
            // delete message
            $delete = Message::where('id', $id)->delete();
            // if message deleted
            if ($delete) {
                // Success response
                return response()->json([
                    'success' => 'Message deleted successfully',
                ]);
            } else {
                // Error response
                return response()->json(['error' => 'Delete error please refresh page and try again']);
            }
        } else {
            // Error response
            return response()->json(['error' => 'Delete error please refresh page and try again']);
        }
    }
}
