<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'user_id',
        'parent_id',
        'content',
    ];
    protected $with = ['user'];

    protected $withCount = ['likes'];

    protected $appends = ['is_liked'];
    /**
     * Lấy người dùng đã đăng bình luận.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Lấy công việc mà bình luận này thuộc về.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    /**
     * Lấy các bình luận trả lời (con).
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    /**
     * Lấy tất cả lượt thích của bình luận.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
    /**
     * Kiểm tra xem người dùng hiện tại đã thích bình luận này chưa.
     */
    public function getIsLikedAttribute(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}
