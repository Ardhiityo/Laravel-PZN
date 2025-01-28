<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Todo;
use App\Models\User;
use App\Models\Contact;
use App\Policies\TodoPolicy;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Providers\Guard\TokenGuard;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Application;
use App\Providers\User\SimpleUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Todo::class => TodoPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend("token", function (Application $app, string $name, array $config) {
            $guard = new TokenGuard(
                userProvider: Auth::createUserProvider($config["provider"]),
                request: $app->make(Request::class)
            );
            $app->refresh(abstract: "request", target: $guard, method: "setRequest");
            return $guard;
        });

        Auth::provider("simple", function () {
            return new SimpleUserProvider();
        });

        Gate::define("get-contact", function (User $user, Contact $contact) {
            return $user->id === $contact->user_id;
        });

        Gate::define("create-contact", function (User $user) {
            if ($user->name == "admin") {
                return Response::allow();
            } else {
                return Response::deny("You're not admin");
            }
        });
    }
}
