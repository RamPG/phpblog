<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\StringHelpers;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|unique:posts,title',
            'content' => 'required|min:50',
            'thumbnail' => 'required|image',
        ]);
        $folder = date('Y-m-d');
        $thumbnail = $request->file('thumbnail')->store("images/{$folder}");
        Post::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => StringHelpers::trimSpaceBeforeSpace($request->input('content'), 100),
            'content' => $request->input('content'),
            'thumbnail' => $thumbnail,
        ]);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $thumbnail = '';
        $request->validate([
            'title' => 'required|min:5|unique:posts,title,' . $id,
            'content' => 'required|min:50',
            'thumbnail' => 'image',
        ]);
        if ($request->hasFile('thumbnail')) {
            $folder = date('Y-m-d');
            $thumbnail = $request->file('thumbnail')->store("images/{$folder}");
        }
        $post->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => StringHelpers::trimSpaceBeforeSpace($request->input('content'), 100),
            'content' => $request->input('content'),
            'thumbnail' => $thumbnail ? $thumbnail : $post->thumbnail,
        ]);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('admin.posts.index');
    }
}
