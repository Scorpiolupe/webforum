<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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

    public function upvotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('is_upvote', true);
    }

    public function downvotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('is_downvote', true);
    }
    
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
