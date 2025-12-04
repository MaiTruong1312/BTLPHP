<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'comment_id'];

    // Tự động cập nhật counter cache
    protected static function booted(): void
    {
        static::created(function (CommentLike $like) {
            $like->comment()->increment('likes_count');
        });

        static::deleted(function (CommentLike $like) {
            $like->comment()->decrement('likes_count');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
