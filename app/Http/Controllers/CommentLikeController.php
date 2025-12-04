<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function toggle(Request $request, Comment $comment)
    {
        $user = $request->user();
        $like = $comment->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Nếu đã thích -> bỏ thích
            $like->delete();
            $liked = false;
        } else {
            // Nếu chưa thích -> thích
            $comment->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        // Trả về dữ liệu JSON để cập nhật giao diện
        return response()->json([
            'liked' => $liked,
            'likes_count' => $comment->likes()->count(),
        ]);
    }
}
