<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        // İstatistikler için veri çekme yarak
        $activeUsers = User::count();
        $totalQuestions = 0; // Model oluşturulduğunda güncellenecek
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
