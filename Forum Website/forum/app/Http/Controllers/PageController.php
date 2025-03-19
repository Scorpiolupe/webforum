<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PageController extends Controller
{

    
    public function index()
    {
        return view('home');
    }

    public function categories()
    {
        return view('categories');
    }

    public function topics()
    {
        return view('topics');
    }

    public function contact()
    {
        return view('contact');
    }
}
