<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    // view home page
    public function index()
    {
        return view('pages.home');
    }
}
