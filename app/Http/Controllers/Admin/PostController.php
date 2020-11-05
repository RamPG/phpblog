<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
        $folder = date('Y-m-d');
        $thumbnail = $request->file('thumbnail')->store("images/{$folder}");
        Post::create([
            'title' => $request->input('title'),
            'description' => substr($request->input('content'), 0, strpos($request->input('content'), ' ', 100)),
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
    public function show($id)
    {
        //
    }

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
        if ($request->hasFile('thumbnail')) {
            $folder = date('Y-m-d');
            $thumbnail = $request->file('thumbnail')->store("images/{$folder}");
            $post->update([
                'title' => $request->input('title'),
                'description' => substr($request->input('content'), 0, strpos($request->input('content'), ' ', 50)),
                'content' => $request->input('content'),
                'thumbnail' => $thumbnail,
            ]);
        } else {
            $post->update([
                'title' => $request->input('title'),
                'description' => substr($request->input('content'), 0, strpos($request->input('content'), ' ', 50)),
                'content' => $request->input('content'),
            ]);
        }
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
