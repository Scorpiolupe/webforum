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
        $pendingQuestions = 0; // Model oluşturulduğunda güncellenecek  
        $totalAnswers = 0; // Model oluşturulduğunda güncellenecek

        // Bekleyen sorular listesi
        $pendingQuestionsList = []; // Model oluşturulduğunda güncellenecek

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
        $questionId = $request->input('id');
        // Onaylama işlemi burada yapılacak
        return response()->json(['success' => true]);
    }

    public function rejectQuestion(Request $request) 
    {
        $questionId = $request->input('id');
        // Reddetme işlemi burada yapılacak
        return response()->json(['success' => true]);
    }
}
