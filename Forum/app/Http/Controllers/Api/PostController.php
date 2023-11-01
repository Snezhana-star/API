<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::get());
    }

    public function store(Request $request)
    {
        if (Gate::denies('Editor')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            'title' => ['required', 'string'],
            'preview' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'thumbnail' => ['required', 'image'],
        ]);

        $post = Post::create([
            'title' => $data["title"],
            'preview' => $data["preview"],
            'description' => $data["description"],
            'category_id' => $data["category_id"],
            'thumbnail' => $request->file('thumbnail')->store('public/posts'),
            'user_id' => auth()->user()->id,
        ]);
        if ($post) {
            return $post;
        }
    }


    public function show(string $id)
    {
        return new PostResource(Post::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        if (Gate::denies('Editor')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            'title' => ['string'],
            'preview' => ['string'],
            'description' => ['string'],
            'category_id' => ['exists:categories,id'],
            'thumbnail' => ['image'],
        ]);

        if ($request->hasFile('thumbnail')) {
            Post::findOrFail($id)->update([
                'thumbnail' => $request->file('thumbnail')->store('public/posts'),
            ]);
            array_pop($data);
            Post::findOrFail($id)->update($data);
        } else {
            Post::findOrFail($id)->update($request->validate([
                'title' => ['string'],
                'preview' => ['string'],
                'description' => ['string'],
                'category_id' => ['exists:categories,id'],
                'thumbnail' => ['image'],
            ]));
        }
        return redirect()->route('posts.show', $id);
    }

    public function destroy(string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $post = Post::findOrFail($id);
        if ($post) {
            $post->delete();
        }
        return redirect()->route('posts.index');
    }
}
