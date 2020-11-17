<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Pagination\Paginator;

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
        $comments = Comment::where('post_id', '=', $post->id)->paginate(5);
        return view('post.index', compact('post', 'comments'));
    }

    public function search(Request $request)
    {
        $posts = Post::all();
        $matchPosts = [];
        $keyPhrase = strtolower($request->input('text'));
        foreach ($posts as $post) {
            if (strpos(strtolower($post->content . ' ' . $post->title), $keyPhrase)) {
                array_push($matchPosts, $post);
            }
        }
        $matchPosts = new Paginator($matchPosts, 5);
        return view('post.found', compact('matchPosts'));
    }
}
