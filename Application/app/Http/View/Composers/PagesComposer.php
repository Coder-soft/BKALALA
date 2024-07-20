<?php

namespace App\Http\View\Composers;

use App\Models\Page;
use Illuminate\View\View;

class PagesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */

    // Get pages from database
    public function compose(View $view)
    {
        // Get all pages
        $composerPages = Page::orderbyDesc('id')->get();
        $view->with('composerPages', $composerPages);
    }
}
