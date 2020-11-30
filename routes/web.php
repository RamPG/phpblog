<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers;

Route::get('/', [Controllers\PostController::class, 'index'])->name('home');
Route::get('/post/{slug}', [Controllers\PostController::class, 'show'])->name('post.show');
Route::post('/post/search', [Controllers\PostController::class, 'search'])->name('post.search');

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::get('/', [Controllers\Admin\MainController::class, 'index'])->name('admin.index');
    Route::get('/posts/comments/{post}', [Controllers\Admin\CommentController::class, 'showComments'])->name('admin.post.comments');
    Route::resource('/posts', Controllers\Admin\PostController::class)->names([
        'index' => 'admin.posts.index',
        'edit' => 'admin.post.edit',
        'update' => 'admin.post.update',
        'create' => 'admin.post.create',
        'store' => 'admin.post.store',
        'destroy' => 'admin.post.destroy',
        'show' => 'admin.post.show',
    ]);
    Route::resource('/comment', Controllers\Admin\CommentController::class)->names([
        'store' => 'admin.comment.store',
        'destroy' => 'admin.comment.destroy',
        'edit' => 'admin.comment.edit',
        'update' => 'admin.comment.update',
    ])->except(['index', 'show', 'create']);
    Route::resource('/users', Controllers\Admin\UserController::class)->names([
        'index' => 'admin.users.index',
        'edit' => 'admin.user.edit',
        'update' => 'admin.user.update',
        'destroy' => 'admin.user.destroy',
        'show' => 'admin.user.show',
    ])->except(['store', 'create']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [Controllers\UserController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [Controllers\UserController::class, 'login'])->name('login');
    Route::get('/register', [Controllers\UserController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [Controllers\UserController::class, 'register'])->name('register');
    Route::get('/verify/{emailVerifyCode}', [Controllers\UserController::class, 'emailVerify'])->name('emailVerify');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('logout');
    Route::get('/user/{user}', [Controllers\UserController::class, 'show'])->name('user.show')->where(
        'user', '[0-9]+',
    );
    Route::put('/user', [Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/user/edit', [Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::resource('/comment', Controllers\CommentController::class)->names([
        'destroy' => 'comment.destroy',
        'edit' => 'comment.edit',
        'update' => 'comment.update',
        'store' => 'comment.store',
    ])->middleware('userComment')->except([
        'index', 'show', 'create',
    ]);
});
