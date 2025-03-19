<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'category_id', 
        'title',
        'content',
        'is_approved',
        'is_locked',
        'is_pinned',
        'upvotes',
        'downvotes',
        'answer_count',
        'best_answer_id',
        'view_count',
        'is_resolved'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->votes()->where('is_upvote', true);
    }

    public function downvotes()
    {
        return $this->votes()->where('is_downvote', true);
    }
}
