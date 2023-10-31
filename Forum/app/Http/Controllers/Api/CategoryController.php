<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{

    public function index()
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return CategoryResource::collection(Category::get());
    }


    public function store(Request $request)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            "name" => ["required", "string"],
        ]);
        $category = Category::create([
            "name" => $data["name"]
        ]);
        if ($category) {
            return redirect()->route('categories.index');
        }
        return redirect()->route('categories.index');

    }


    public function update(Request $request, string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            "name" => ["required", "string"],
        ]);
        $category = Category::findOrFail($id)->update([
            "name" => $data["name"]
        ]);
        if ($category) {
            return redirect()->route('categories.index');
        }
        return redirect()->route('categories.index');
    }


    public function destroy(string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $category = Category::findOrFail($id);
        if ($category) {
            $category->delete();
        }
        return redirect()->route('categories.index');
    }
}
