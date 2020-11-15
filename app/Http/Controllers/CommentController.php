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
            'content' => 'required|max:255',
        ]);
        Comment::create([
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'post_id' => $request->input('post_id')
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Comment::destroy($id);
        return redirect()->back();
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('post.commentEdit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);
        $comment = Comment::find($id);
        $comment->update([
            'content' => $request->input('content'),
        ]);
        return redirect()->route('post.show', ['slug' => $comment->post->slug]);
    }

}
