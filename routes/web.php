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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/api/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::middleware(['auth'])->group(function () {

    //Rotas dos Posts
    Route::post('/create/post', [App\Http\Controllers\PostController::class, 'store'])->name('create.post');
    Route::get('/api/list/posts', [App\Http\Controllers\PostController::class, 'listPost'])->name('list.post');
    Route::get('/list/posts', [App\Http\Controllers\PostController::class, 'list'])->name('list.post');
    Route::get('/create/post', [App\Http\Controllers\PostController::class, 'create'])->name('create.post.view');
    Route::post('/update/post', [App\Http\Controllers\PostController::class, 'update'])->name('update.post');
    Route::get('/api/destroy/post/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('destroy.post');

    //Rotas dos Posts
    Route::post('/create/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('create.category');
    Route::get('/api/list/categories', [App\Http\Controllers\CategoryController::class, 'listCategories'])->name('list.post');
    Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('api.list.category');
    Route::get('/list/categories', [App\Http\Controllers\CategoryController::class, 'list'])->name('list.category');
    Route::post('/create/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('create.category');
    Route::post('/update/category', [App\Http\Controllers\CategoryController::class, 'update'])->name('update.category');
    Route::get('/destory/category/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('destroy.category');
    
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});



