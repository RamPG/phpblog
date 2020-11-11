<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ]);
        Comment::create([
            'comment' => $request->input('comment'),
            'user_id' => Auth::user()->id,
            'post_id' => $request->input('post_id')
        ]);
        return redirect()->back();
    }
}
