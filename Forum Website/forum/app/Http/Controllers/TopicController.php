<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Soru sormak için giriş yapmalısınız.');
        }

        return view('topics');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $validated = $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:20',
            'category_id' => 'required|exists:categories,id'
        ]);

        $question = Question::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

        return redirect()->route('topics.show', $question->id)
            ->with('success', 'Sorunuz başarıyla oluşturuldu ve onay için gönderildi.');
    }

    public function show(Question $question)
    {
        $question->increment('view_count');
        
        $topic = $question->load(['user', 'category', 'replies.user']);
        
        return view('topics.detail', compact('topic'));
    }

    public function index()
    {
        $topics = Question::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('topics', compact('topics'));
    }
}
