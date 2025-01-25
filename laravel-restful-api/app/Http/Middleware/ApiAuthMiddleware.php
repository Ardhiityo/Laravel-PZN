<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header("Authorization");

        $authenticate = false;

        if ($key) {
            $authenticate = true;
        }

        if ($authenticate) {
            $user = User::where("token", $key)->first();

            if ($user) {
                Auth::login($user);
            } else {
                $authenticate = false;
            }
        }

        if ($authenticate) {
            return $next($request);
        } else {
            return response([
                "errors" => [
                    "message" => [
                        "Unauthorized"
                    ]
                ]
            ], status: 401);
        }
    }
}
