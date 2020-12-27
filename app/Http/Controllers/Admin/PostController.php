<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\Contracts\FileServiceInterface;

class PostController extends Controller
{
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

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
    public function store(PostStoreRequest $request)
    {
        $requestData = $request->all();
        $thumbnail = $this->fileService->handleUploadedImage($requestData, 'thumbnail');
        Post::createPost($requestData, $thumbnail);
        return redirect()->route('admin.posts.index');
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
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);
        $requestData = $request->all();
        $thumbnail = $this->fileService->handleUploadedImage($requestData, 'thumbnail');
        $post->updatePost($requestData, $thumbnail);
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
        Comment::where('post_id', $id)->delete();
        return redirect()->route('admin.posts.index');
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.show', ['post' => $post]);
    }
}
