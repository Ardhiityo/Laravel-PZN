<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyTest extends TestCase
{
    public function testPolicy()
    {

        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::first();
        Auth::login($user);

        $todo = Todo::first();

        self::assertTrue(Gate::allows("viewAny", Todo::class));
        self::assertTrue(Gate::allows("view", $todo));
        self::assertTrue(Gate::allows("create", Todo::class));
        self::assertTrue(Gate::allows("update", $todo));
        self::assertTrue(Gate::allows("delete", $todo));
        self::assertTrue(Gate::allows("restore", $todo));
        self::assertTrue(Gate::allows("forceDelete", $todo));
    }

    public function testAuthorizable()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::first();
        $todo = Todo::first();

        self::assertTrue($user->can("view", $todo));
        self::assertTrue($user->can("create", Todo::class));
        self::assertTrue($user->can("update", $todo));
        self::assertTrue($user->can("delete", $todo));
    }
}
