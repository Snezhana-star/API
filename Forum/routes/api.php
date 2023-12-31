<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [\App\Http\Controllers\Api\PostController::class, 'show'])->name('posts.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/posts', [PostController::class, 'search']);
Route::middleware("auth:sanctum")->group(function () {
    //auth
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    //posts
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    //favorite
    Route::post('posts/{post}/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}',[FavoriteController::class, 'destroy'])->name('favorites.destroy');
        //comments
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //user
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{id}', [UserController::class, 'updateRole'])->name('users.update.role');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    //categories
    Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'destroy'])->name('categories.destroy');
});
