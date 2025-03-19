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
        $totalQuestions = Question::count();
        $pendingQuestions = Question::where('is_approved', false)->count();
        $totalAnswers = Question::where('answer_count', '>', 0)->count();

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
        $question->status = 'approved';
        $question->save();

        return response()->json(['success' => true]);
    }
    
    public function rejectQuestion(Request $request)
    {
        $question = Question::findOrFail($request->id);
        $question->delete();
        
        return response()->json(['success' => true]);
    }
}
