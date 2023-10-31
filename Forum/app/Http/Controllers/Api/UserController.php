<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('Admin')) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return UserResource::collection(User::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Gate::denies('show-user', $id)) {
            return response()->json([
                'message' => "Доступ запрещён"
            ], 403);
        }
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

//    public function updateRole(Request $request, string $id)
//    {
//        if(Gate::denies('Admin')){
//            return response()->json([
//                'message' => "Доступ запрещён"
//            ], 403);
//        }
//        $data = $request->validate([
//            "role_id"=> ["required",],
//        ]);
//
//
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Gate::denies('Admin')){
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
