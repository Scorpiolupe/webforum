<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Topic;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function upvote($questionId)
    {
        $user = Auth::user();
        $question = Topic::findOrFail($questionId);

        if($question->downvotes()->where('user_id', $user->id)->exists()) {
            $question->downvotes()->where('user_id', $user->id)->delete();
        }

        $vote = Vote::updateOrCreate(
            ['user_id' => $user->id, 'question_id' => $question->id],
            ['is_upvote' => true]
        );

        $upvotes = $question->upvotes()->count();
        $downvotes = $question->downvotes()->count();

        return response()->json([
            'success' => true,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);
    }

    public function downvote($questionId)
    {
        $user = Auth::user();
        $question = Topic::findOrFail($questionId);

        if ($question->upvotes()->where('user_id', $user->id)->exists()) {
            $question->upvotes()->where('user_id', $user->id)->delete();
        }

        $vote = Vote::updateOrCreate(
            ['user_id' => $user->id, 'question_id' => $question->id],
            ['is_downvote' => true]
        );

        $upvotes = $question->upvotes()->count();
        $downvotes = $question->downvotes()->count();

        return response()->json([
            'success' => true,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);
    }
}
