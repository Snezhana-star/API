<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return UserResource::collection(User::get());
    }


    public function show(string $id)
    {
        if (Gate::denies('show-user', $id)) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return new UserResource(User::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        if (Gate::denies('User', $id)) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            "name" => ["string"],
            "email" => ["email", "string", "unique:users,email"],
            "password"=> ["string"]
        ]);

        User::findOrFail($id)->update($data);
        return redirect()->route('users.show', $id);
    }

    public function updateRole(Request $request, string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $data = $request->validate([
            "role_id" => ["required", 'exists:roles,id'],
        ]);
        $user = User::findOrFail($id)->update([
            "role_id" => $data["role_id"]
        ]);
        if ($user) {
            return redirect()->route('users.show', $id);
        }
        return redirect()->route('users.show', $id);
    }

    public function destroy(string $id)
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
