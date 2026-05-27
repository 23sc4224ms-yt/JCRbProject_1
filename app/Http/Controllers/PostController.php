<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('posts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Post::create($validated);

        return redirect('/posts')->with('success', 'Post created successfully!');
    }

    public function show(string $id)
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return redirect('/posts')->with('error', 'Post not found!');
        }

        return view('posts.show', compact('post'));
    }

    public function edit(string $id)
    {
        $post = Post::find($id);
        $users = User::orderBy('name')->get();

        if (!$post) {
            return redirect('/posts')->with('error', 'Post not found!');
        }

        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect('/posts')->with('error', 'Post not found!');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->update($validated);

        return redirect('/posts')->with('success', 'Post updated successfully!');
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect('/posts')->with('error', 'Post not found!');
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Post deleted successfully!');
    }
}