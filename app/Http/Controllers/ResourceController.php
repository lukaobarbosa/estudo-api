<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;

class ResourceController extends Controller
{
    public function index(User $user)
    {
        return UserResource::collection($user::paginate(2));
    }

    public function show(User $user)
    {
        return UserResource::make($user::find($user)->first());
    }
}
