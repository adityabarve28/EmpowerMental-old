<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Display list of posts
    public function index()
    {
        $posts = Post::with(['user', 'categories'])->get();
        return view('posts.index', compact('posts'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // Store new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'array',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        $post->categories()->attach($request->categories);

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    // Show single post
    public function show(Post $post)
    {
        $post->load(['user', 'categories']);
        return view('posts.show', compact('post'));
    }

    // Edit form
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($request->only('title', 'content'));
        $post->categories()->sync($request->categories ?? []);

        return redirect()->route('posts.index')->with('success', 'Post updated!');
    }

    // Delete post
    public function destroy(Post $post)
    {
        $post->categories()->detach();
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}
