<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function upvote($topicId)
    {
        $user = Auth::user();
        $topic = Topic::findOrFail($topicId);

        // Önce mevcut downvote'u sil
        Vote::where('user_id', $user->id)
            ->where('topic_id', $topic->id)
            ->where('is_downvote', true)
            ->delete();

        // Upvote ekle veya güncelle
        Vote::updateOrCreate(
            [
                'user_id' => $user->id,
                'topic_id' => $topic->id
            ],
            [
                'is_upvote' => true,
                'is_downvote' => false
            ]
        );

        $upvotes = Vote::where('topic_id', $topic->id)->where('is_upvote', true)->count();
        $downvotes = Vote::where('topic_id', $topic->id)->where('is_downvote', true)->count();

        Topic::where('id', $topic->id)->update([
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);

        return response()->json([
            'success' => true,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);
    }

    public function downvote($topicId)
    {
        $user = Auth::user();
        $topic = Topic::findOrFail($topicId);

        // Önce mevcut upvote'u sil
        Vote::where('user_id', $user->id)
            ->where('topic_id', $topic->id)
            ->where('is_upvote', true)
            ->delete();

        // Downvote ekle veya güncelle
        Vote::updateOrCreate(
            [
                'user_id' => $user->id,
                'topic_id' => $topic->id
            ],
            [
                'is_upvote' => false,
                'is_downvote' => true
            ]
        );

        $upvotes = Vote::where('topic_id', $topic->id)->where('is_upvote', true)->count();
        $downvotes = Vote::where('topic_id', $topic->id)->where('is_downvote', true)->count();

        Topic::where('id', $topic->id)->update([
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);

        return response()->json([
            'success' => true,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);
    }
}
