<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $requestData = $request->all();
        Comment::createComment($requestData, Auth::user()->id);
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

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->updateComment($request->input('content'));
        return redirect()->route('post.show', ['slug' => $comment->post->slug]);
    }

}
