<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($userId)
    {
        

        $user = User::findOrFail($userId);
        
        $topics = Topic::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $replies = Reply::where('user_id', $userId)
            ->with('topic')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('profile', compact('user', 'topics', 'replies'));
    }
}