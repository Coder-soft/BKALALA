<?php

namespace App\Http\View\Composers;

use App\Models\Message;
use Illuminate\View\View;

class MessagesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */

    // Get message from database
    public function compose(View $view)
    {
        // Get unread messages
        $messages = Message::where('status', 1)->count();
        $view->with('messages', $messages);
    }
}
