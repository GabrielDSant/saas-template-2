<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }
    public function settings()
    {
        return view('pages.auth.settings'); // Retorna a view settings
    }
}
