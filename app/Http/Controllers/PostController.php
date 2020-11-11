<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        return view('home', compact('posts'));
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $comments = Post::where('slug', $slug)->firstOrFail()->comments;
        return view('post', compact('post', 'comments'));
    }
}
