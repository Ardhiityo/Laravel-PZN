<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserLogin;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRegisterReqest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    public function register(UserRegisterReqest $request)
    {
        $user = $request->validated();

        if (User::where("username", $user["username"])->count() == 1) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username already registered"
                    ]
                ]
            ], 400));
        };

        $user = new User($user);
        $user->password = Hash::make($user->password);
        $user->save();

        return (new UserResource($user))
            ->response()->setStatusCode(201);
    }

    public function login(UserLogin $request): UserResource
    {
        $data = $request->validated();

        $user = User::where("username", $data["username"])->first();

        if (!$user || !Hash::check($data["password"], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function get(): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request)
    {
        $data = $request->validated();
        Log::info($data);
        $user = Auth::user();

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return new UserResource($user);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response([
            "data" => true
        ], 200);
    }
}
