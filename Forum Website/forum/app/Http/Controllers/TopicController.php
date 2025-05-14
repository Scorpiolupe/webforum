<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Soru sormak için giriş yapmalısınız.');
        }

        $topics = Topic::with(['user', 'category'])
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

        $question = Topic::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'is_approved' => false // Varsayılan olarak onaysız
        ]);

        return redirect()->route('home')
            ->with('success', 'Sorunuz başarıyla oluşturuldu ve onay için gönderildi.');
    }

    public function show(Topic $question)
    {
        $question->increment('view_count');
        
        $topic = $question->load(['user', 'category', 'replies.user']);
        
        return view('topics.detail', compact('topic'));
    }

    public function index()
    {
        $topics = Topic::with(['user', 'category'])
            ->where('is_approved', true)
            ->when(request('sort') == 'oldest', function($query) {
                return $query->orderBy('created_at', 'asc');
            })
            ->when(request('sort') == 'most_upvoted', function($query) {
                // Doğrudan upvotes sütununa göre sırala
                return $query->orderBy('upvotes', 'desc');
            })
            ->when(request('sort') == 'most_viewed', function($query) {
                return $query->orderBy('view_count', 'desc');
            })
            ->when(!request('sort') || request('sort') == 'latest', function($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->paginate(15);
            
        $categories = Category::all();
        return view('topics', compact('topics', 'categories'));
    }

    public function reply(Request $request, Topic $question)
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
    
    public function edit(Topic $question){
        if (Auth::id() != $question->user_id && !Auth::user()->is_admin) {
            return redirect()->route('topics.show', $question->id)->with('error', 'Bu konuyu düzenleme yetkiniz yok.');
        }

        $categories = Category::all();
        return view('topics.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Topic $question){
        if (auth::id()!=$question->user_id && !Auth::user()->is_admin) {
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

    public function lock(Topic $question)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('topics.show', $question->id)->with('error', 'Bu konuyu kilitleme yetkiniz yok.');
        }
        elseif ($question->is_locked) {
            $question->update(['is_locked' => false]);

            return redirect()->route('topics.show', $question->id)->with('success', 'Konunun kilidi başarıyla açıldı.');
        }
        elseif(!$question->is_locked){
            $question->update(['is_locked' => true]);

            return redirect()->route('topics.show', $question->id)->with('success', 'Konu başarıyla kilitlendi.');
        }
        else{
            return redirect()->route('topics.show', $question->id)->with('error', 'Bir hata oluştu.');
        }
        
    }

    public function editReply(Request $request, Topic $question, $replyId) 
    {
        $reply = $question->replies()->findOrFail($replyId);
        
        if (Auth::id() != $reply->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Bu yanıtı düzenleme yetkiniz yok.');
        }

        return view('topics.edit-reply', compact('question', 'reply'));
    }

    public function updateReply(Request $request, Topic $question, $replyId)
    {
        $reply = $question->replies()->findOrFail($replyId);

        if (Auth::id() != $reply->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Bu yanıtı düzenleme yetkiniz yok.');
        }

        $validated = $request->validate([
            'content' => 'required|min:5'
        ]);

        $reply->update($validated);

        return redirect()->route('topics.show', $question->id)
            ->with('success', 'Yanıtınız başarıyla güncellendi.');
    }

    public function destroy(Topic $question)
    {
        if (Auth::id() != $question->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Bu konuyu silme yetkiniz yok.');
        }

        $question->delete();
        return redirect()->route('topics')->with('success', 'Konu başarıyla silindi.');
    }

    public function destroyReply(Topic $question, $replyId)
    {
        $reply = $question->replies()->findOrFail($replyId);

        if (Auth::id() != $reply->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Bu yanıtı silme yetkiniz yok.');
        }

        $reply->delete();
        return redirect()->back()->with('success', 'Yanıt başarıyla silindi.');
    }
}
