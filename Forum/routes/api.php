<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
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

Route::get('/posts', [\App\Http\Controllers\Api\PostController::class,'index'])->name('posts.index');
Route::get('/posts/{id}', [\App\Http\Controllers\Api\PostController::class,'show'])->name('posts.show');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register', [AuthController::class,'register'])->name('register');

Route::middleware("auth:sanctum")->group(function (){
    Route::delete('/logout',[AuthController::class,'logout'])->name('logout');
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class,'index'])->name('user.index');
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class,'show'])->name('user.show');
    Route::get('/comments', [\App\Http\Controllers\Api\CommentController::class,'index'])->name('comment.index');
    Route::delete('/posts/{id}',[PostController::class,'destroy'])->name('post.destroy');

});
