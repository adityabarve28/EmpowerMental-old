<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'categories'])->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'array'
        ]);

        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->categories) {
            $post->categories()->attach($request->categories);
        }

        return response()->json(['message' => 'Post created!', 'post' => $post->load('categories')], 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load(['user', 'categories']));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate(['title' => 'required', 'content' => 'required']);
        $post->update($request->only('title', 'content'));
        $post->categories()->sync($request->categories ?? []);
        return response()->json(['message' => 'Post updated!', 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->categories()->detach();
        $post->delete();
        return response()->json(['message' => 'Post deleted!']);
    }
}
