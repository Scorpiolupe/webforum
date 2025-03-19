<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
    public function index()
    {   
        // İstatistikler için veri çekme
        $activeUsers = DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(30)->timestamp)
            ->distinct('user_id')
            ->count();
        $totalQuestions = Question::where('is_approved', true)->count();
        $pendingQuestions = Question::where('is_approved', false)->count();
        $totalAnswers = Question::where('answer_count', '>', 0)
            ->where('is_approved', true)
            ->count();

        // Bekleyen sorular listesi - onaylanmamış sorular
        $pendingQuestionsList = Question::where('is_approved', false)
            ->with('user', 'category')
            ->latest()
            ->take(10)
            ->get();

        // Son aktiviteler
        $recentActivities = []; // Model oluşturulduğunda güncellenecek

        return view('panel', compact(
            'activeUsers',
            'totalQuestions', 
            'pendingQuestions',
            'totalAnswers',
            'pendingQuestionsList',
            'recentActivities'
        ));
    }

    public function approveQuestion(Request $request)
    {
        $question = Question::findOrFail($request->id);
        $question->is_approved = true;
        $question->save();

        return response()->json(['success' => true]);
    }
    
    public function rejectQuestion(Request $request)
    {
        $question = Question::findOrFail($request->id);
        $question->delete();
        
        return response()->json(['success' => true]);
    }

    public function questionDetail(Request $request)
    {
        $question = Question::with('user')->findOrFail($request->id);

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $question->title,
                'content' => $question->content,
                'author' => $question->user->username,
                'date' => $question->created_at->format('d-m-Y H:i')
            ]
        ]);
    }
}
