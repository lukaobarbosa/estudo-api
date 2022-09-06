<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index(User $user)
    {
       return UserResource::collection($user::paginate(15));
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json([], 204);
    }

    public function create(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        $user->create($request->all());
        return  response()->json(['created'], 201);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users'
        ]);
        $user->update($request->only(['name', 'email']));
        return response()->json(['updated', 200]);
    }

}
