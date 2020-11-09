<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(5);
        return view('home', compact('posts'));
    }
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.post', compact('post'));
    }
}
