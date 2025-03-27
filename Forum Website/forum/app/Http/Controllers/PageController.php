<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;


class PageController extends Controller
{

    
    public function index()
    {
        $topics=Topic::with(['user', 'category'])
        ->where('is_approved', true)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        $totalTopics=Topic::where('is_approved', true)->count();
        $totalUsers=User::count();
        $totalPosts=Topic::where('is_approved', true)->sum('answer_count');

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
