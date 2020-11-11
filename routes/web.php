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

Route::post('/comments/store', [Controllers\CommentController::class, 'store'])->name('comments.store');

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::get('/', [Controllers\Admin\MainController::class, 'index'])->name('admin.index');
    Route::resource('/posts', Controllers\Admin\PostController::class)->names([
        'index' => 'admin.posts.index',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'destroy' => 'admin.posts.destroy',
    ])->except(['show']);
});
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [Controllers\UserController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [Controllers\UserController::class, 'login'])->name('login');
    Route::get('/register', [Controllers\UserController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [Controllers\UserController::class, 'register'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('logout');
});

