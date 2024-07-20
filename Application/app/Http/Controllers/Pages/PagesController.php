<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PagesController extends Controller
{
    // View page
    public function index($slug)
    {
        // Get page data
        $page = Page::where('slug', $slug)->first();
        // if data not null
        if ($page != null) {
            return view('pages.page', ['page' => $page]);
        } else {
            // Abort 404
            return abort(404);
        }
    }

}
