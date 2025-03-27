<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('topics')->get();
        
        $topics = Topic::with(['user', 'category'])
            ->where('is_approved', true)
            ->latest()
            ->take(10)
            ->get();

        $totalTopics = Topic::where('is_approved', true)->count();
        $totalUsers = User::count();
        $totalPosts = Topic::where('is_approved', true)->sum('answer_count');

        return view('home', compact(
            'categories',
            'topics',
            'totalTopics',
            'totalUsers',
            'totalPosts'
        ));
    }
}
