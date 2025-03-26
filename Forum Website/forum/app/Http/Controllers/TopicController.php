<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        $topics = Question::with(['user', 'category'])
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('topics', compact('topics'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $question = Question::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'is_approved' => false // Varsayılan olarak onaysız
        ]);

        return redirect()->route('home')
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
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('topics', compact('topics'));
    }

    public function reply(Request $request, Question $question)
    {
        $validated = $request->validate([
            'content' => 'required|min:5'
        ]);

        $reply = $question->replies()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content']
        ]);

        $question->increment('answer_count');

        return redirect()->back()->with('success', 'Yanıtınız başarıyla eklendi.');
    }
    
    public function edit(Question $question){
        if (Auth::id() != $question->user_id) {
            return redirect()->route('topics.show', $question->id)->with('error', 'Bu konuyu düzenleme yetkiniz yok.');
        }

        $categories = Category::all();
        return view('topics.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question){
        if (auth::id()!=$question->user_id) {
            return redirect()->route('topics.show', $question->id)->with('error','Bu konuyu düzenleme yetkiniz yok.');

        }
        $validated=$request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required|string',
            'category_id'=>'required|exists:categories,id'
        ]);

        $question->update($validated);
        return redirect()->route('topics.show', $question->id)->with('success','Konu başarılı bir şekilde güncellendi.');
        
    }
}
