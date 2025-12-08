<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Lưu một bình luận mới.
     */
    public function store(Request $request, Job $job)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['job_id'] = $job->id;

        Comment::create($validatedData);

        return back()->with('success', 'Bình luận của bạn đã được đăng.');
    }

    /**
     * Cập nhật một bình luận đã có.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Bình luận của bạn đã được cập nhật.');
    }

    /**
     * Xóa một bình luận.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Bình luận của bạn đã được xóa.');
    }
}
