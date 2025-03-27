<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Reply; // Reply modelini ekleyin
use Illuminate\Support\Facades\Auth;

class ProfileController
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }
        $user = Auth::user();
        
        // Kullanıcının konularını çekme
        $topics = Topic::where('user_id', $user->id)->get();
        
        // Kullanıcının yanıtlarını çekme
        $replies = Reply::where('user_id', $user->id)
            ->with('topic') // İlişkili soruyu da yükle
            ->get();
        
        // View'a hem konuları hem yanıtları gönderme
        return view('profile', compact('topics', 'replies'));
    }
}