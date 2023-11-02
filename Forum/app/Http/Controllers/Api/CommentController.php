<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index()
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return CommentResource::collection(Comment::get());
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            "text" => ["required", "string"],
        ]);
        Comment::create([
            "text" => $data["text"],
            "user_id" => auth()->user()->id,
            "post_id" => $post->id

        ]);
        return redirect()->route('posts.show', ['id' => $post->id]);
    }

    public function update(Request $request, string $id)
    {
        $user = Comment::findOrFail($id)->user;
        if (Gate::denies('User', $user->id)) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }

        $data = $request->validate([
            "text" => ["required", "string"],
        ]);
        Comment::findOrFail($id)->update([
            "text" => $data["text"]
        ]);

        return redirect()->route('posts.index');

    }

    public function destroy(string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $comment = Comment::findOrFail($id);
        if ($comment) {
            $comment->delete();
        }
        return redirect()->route('comments.index');
    }

}
