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

Route::prefix('/admin')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::resource('/posts', PostController::class)->names([
        'index' => 'admin.posts.index',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'destroy' => 'admin.posts.destroy',
    ]);
});
