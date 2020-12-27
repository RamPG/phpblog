<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\Comment;
use App\Models\User;
use App\Services\Contracts\FileServiceInterface;

class UserController extends Controller
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
        $users = User::paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $comments = Comment::where('user_id', '=', $id)->with('post')->paginate(5);
        return view('admin.users.show', ['user' => $user, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $requestData = $request->all();
        $avatar = $this->fileService->handleUploadedImage($requestData, 'avatar');
        $user->updateUser($requestData['name'], $avatar);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        Comment::where('user_id', $id)->delete();
        return redirect()->back();
    }
}
