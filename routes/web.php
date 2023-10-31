<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Portal\RoleController;
use App\Http\Controllers\Portal\UserController;
use App\Http\Controllers\Portal\ArticleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'index']);
Route::get('/articles/{id}', [PublicController::class, 'show'])->name('public.articles.show');

Auth::routes();


Route::group(['middleware' => ['auth'], 'as' => 'dashboard.', 'prefix' => 'dashboard'], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('articles', HomeController::class);
    Route::post('/add-comment', [CommentController::class, 'store'])->name('comments.store');
});

Route::group(['middleware' => ['auth'], 'as' => 'portal.', 'prefix' => 'portal'], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('articles', ArticleController::class);
    Route::post('/articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
});
