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

use \App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('posts.post');
})->name('home');
Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::resource('/posts', PostController::class)->names([
        'index' => 'admin.posts.index',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'destroy' => 'admin.posts.destroy',
    ])->except(['show']);
});
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [UserController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [UserController::class, 'register'])->name('register');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});

