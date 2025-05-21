<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PanelController extends Controller
{
    public function index()
    {
        if(!Auth::check() || Auth::user()->is_admin == false) {
            return redirect()->route('home')->with('error', 'Bu sayfaya erişmek için gerekli yetkiye sahip değilsin.');
        }
        
        $users = User::where('is_admin', false)->take(10)->get();
        $admins = User::where('is_admin', true)->take(10)->get();
        
        $activeUsers = DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(30)->timestamp)
            ->distinct('user_id')
            ->count();
        $totalQuestions = Topic::where('is_approved', true)->count();
        $pendingQuestions = Topic::where('is_approved', false)->count();
        $totalAnswers = Topic::where('answer_count', '>', 0)
            ->where('is_approved', true)
            ->count();

       
        $pendingQuestionsList = Topic::where('is_approved', false)
            ->with('user', 'category')
            ->latest()
            ->take(10)
            ->get();

        $questionsList = Topic::where('is_approved', true)
            ->with('user', 'category')
            ->latest()
            ->take(10)
            ->get();

        $contacts = DB::table('contacts')
            ->where('is_resolved', false)
            ->latest()
            ->take(10)
            ->get();

        $replies = Topic::with(['user', 'replies.user'])
            ->where('is_approved', true)
            ->get()
            ->flatMap->replies
            ->sortByDesc('created_at');

        $recentActivities = []; 

        return view('panel', compact(
            'users',
            'admins',
            'activeUsers',
            'totalQuestions', 
            'pendingQuestions',
            'totalAnswers',
            'pendingQuestionsList',
            'questionsList',
            'recentActivities',
            'contacts',
            'replies'
        ));
    }

    public function approveQuestion(Request $request)
    {
        try {
            $question = Topic::findOrFail($request->id);
            $question->is_approved = true;
            $question->save();
            
            Notification::create([
                'id' => Str::uuid()->toString(),
                'type' => 'App\Notifications\QuestionApproved',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $question->user_id,
                'data' => [
                    'message' => 'Sorunuz onaylandı.',
                    'question_id' => $question->id
                ]
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function rejectQuestion(Request $request)
    {
        try {
            $question = Topic::findOrFail($request->id);
            $userId = $question->user_id;
            $question->delete();

            DB::table('notifications')->insert([
                'id' => Str::uuid()->toString(),
                'type' => 'App\Notifications\QuestionRejected',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $userId,
                'data' => json_encode([
                    'message' => 'Sorunuz reddedildi.',
                    'question_id' => $request->id
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'id' => $request->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteQuestion(Request $request)
    {
        $question = Topic::findOrFail($request->id);
        $question->delete();

        DB::table('notifications')->insert([
            'id' => Str::uuid()->toString(),
            'type' => 'App\Notifications\QuestionDeleted',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $question->user_id,
            'data' => json_encode([
                'message' => 'Sorunuz silindi.',
                'question_id' => $request->id
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function lockQuestion(Request $request)
    {
        $question = Topic::findOrFail($request->id);
        $question->is_locked = true;
        $question->save();

        return response()->json(['success' => true]);
    }

    public function unlockQuestion(Request $request)
    {
        $question = Topic::findOrFail($request->id);
        $question->is_locked = false;
        $question->save();

        return response()->json(['success' => true]);
    }

    public function questionDetail(Request $request)
    {
        $question = Topic::with('user')->findOrFail($request->id);

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $question->title,
                'content' => $question->content,
                'author_id' => $question->user->id,
                'author' => $question->user->username,
                'date' => $question->created_at->format('d-m-Y H:i')
            ]
        ]);
    }

    public function userDetail(Request $request)
    {
        $user = User::findOrFail($request->id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at->format('d-m-Y H:i')
            ]
        ]);
    }

    public function banUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_banned = true; // tabloya eklenecek
        $user->save();

        return response()->json(['success' => true]);
    }

    public function unbanUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_banned = false; // tabloya eklenecek
        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function makeAdmin(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_admin = true; // tabloya eklenecek
        $user->save();

        return response()->json(['success' => true]);
    }

    public function removeAdmin(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_admin = false; // tabloya eklenecek
        $user->save();

        return response()->json(['success' => true]);
    }

    public function contactDetail(Request $request)
    {
        $contact = DB::table('contacts')->where('id', $request->id)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $contact->name,
                'email' => $contact->email,
                'message' => $contact->message,
                'date' => $contact->created_at
            ]
        ]);
    }

    public function contactDelete(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        $contact->delete();

        return response()->json(['success' => true]);
    }

    public function deleteReply(Request $request)
    {
        try {
            $topic = Topic::findOrFail($request->topic_id);
            $reply = $topic->replies()->findOrFail($request->reply_id);
            
            // Yanıtı sil
            $reply->delete();
            
            // Yanıt sayacını güncelle
            $topic->decrement('answer_count');

            // Kullanıcıya bildirim gönder
            DB::table('notifications')->insert([
                'id' => Str::uuid()->toString(),
                'type' => 'App\Notifications\ReplyDeleted',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $reply->user_id,
                'data' => json_encode([
                    'message' => 'Yanıtınız yönetici tarafından silindi.',
                    'topic_id' => $topic->id
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
