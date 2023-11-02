<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class FavoriteController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $favorite = Favorite::all();
        $data = $favorite->where('post_id', '=', $post->id)->where('user_id', '=', Auth::user()->id);
        if (count($data) === 0) {
            Favorite::create([
                "user_id" => Auth::user()->id,
                "post_id" => $post->id,
            ]);
            return redirect()->route('users.show', Auth::user()->id);
        } else
            return response()->json(['message' => "Уже в избранном"], 403);
    }

    public function destroy(string $id)
    {
        $user = Favorite::findOrFail($id)->user;
        if (Gate::denies('User', $user->id)) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $favorite = Favorite::findOrFail($id);
        if ($favorite) {
            $favorite->delete();
        }
        return redirect()->route('users.show',$user->id);
    }
}
