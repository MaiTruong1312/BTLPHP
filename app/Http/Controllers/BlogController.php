<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the published blog posts.
     */
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for creating a new blog post.
     * This would typically be for employers or admins.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('blog.create');
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'image' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        $post = new Post($validated);
        $post->slug = Str::slug($validated['title']);
        $post->user_id = Auth::id();
        $post->save();
        $post->image = $imagePath;
        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'image' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->update($validated);
        $post->slug = Str::slug($validated['title']);
        $post->save();

        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('blog.index');
    }
}
