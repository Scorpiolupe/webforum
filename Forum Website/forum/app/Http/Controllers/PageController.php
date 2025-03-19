<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;


class PageController extends Controller
{

    
    public function index()
    {
        $topics=Question::with(['user', 'category'])
        ->where('is_approved', true)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        $totalTopics=Question::where('is_approved', true)->count();
        $totalUsers=User::count();
        $totalPosts=Question::where('is_approved', true)->sum('answer_count');

        return view('home', compact(
            'topics',
            'totalTopics',
            'totalUsers',
            'totalPosts'
        ));
    }
    
    public function topics()
    {
        return view('topics');
    }

    public function contact()
    {
        return view('contact');
    }

    public function auth()
    {
        return view('auth');
    }

    public function panel()
    {
        return view('panel');
    }
}
