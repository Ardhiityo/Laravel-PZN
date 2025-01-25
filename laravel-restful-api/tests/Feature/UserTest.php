<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;

class UserTest extends TestCase
{
    public function test_success_register()
    {
        $this->post("/api/users", [
            "username" => "eko",
            "password" => "rahasia",
            "name" => "Eko Kurniawan Khannedy"
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "username" => "eko",
                    "name" => "Eko Kurniawan Khannedy"
                ]
            ]);
    }

    public function test_failed_register()
    {
        $this->post("/api/users", [
            "username" => "",
            "password" => "",
            "name" => ""
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => [
                        "The username field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ],
                    "name" => [
                        "The name field is required."
                    ]
                ]
            ]);
    }

    public function test_failed_username_already_exist_register()
    {
        $this->test_success_register();

        $this->post("/api/users", [
            "username" => "eko",
            "password" => "rahasia",
            "name" => "Eko Kurniawan Khannedy"
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "username already registered"
                    ]
                ]
            ]);
    }

    public function test_Login_success()
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/users/login", [
            "username" => "test",
            "password" => "test"
        ])->assertStatus(200)
            ->assertJson(
                [
                    "data" => [
                        "username" => "test",
                    ]
                ]
            );

        $user = User::where("username", "test")->first();

        self::assertNotNull($user->token);
    }

    public function test_Login_wrong_password()
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/users/login", [
            "username" => "test",
            "password" => "testing"
        ])->assertStatus(401)
            ->assertJson(
                [
                    "errors" => [
                        "message" => ["username or password wrong"]
                    ]
                ]
            );
    }

    public function test_Login_wrong_username()
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/users/login", [
            "username" => "testing",
            "password" => "test"
        ])->assertStatus(401)
            ->assertJson(
                [
                    "errors" => [
                        "message" => ["username or password wrong"]
                    ]
                ]
            );
    }

    public function test_Login_validation_exception()
    {
        $this->post("/api/users/login", [
            "username" => "",
            "password" => ""
        ])->assertStatus(400)
            ->assertJson(
                [
                    "errors" => [
                        "username" => [
                            "The username field is required."
                        ],
                        "password" => [
                            "The password field is required."
                        ]
                    ]
                ]
            );
    }

    public function test_current_success()
    {
        $this->seed(UserSeeder::class);

        $this->get("/api/users/current", ["Authorization" => "test"])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);
    }

    public function test_current_invalid_token()
    {
        $this->seed(UserSeeder::class);

        $this->get("/api/users/current", ["Authorization" => "testing"])
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Unauthorized"
                    ]
                ]
            ]);
    }

    public function test_current_failed()
    {
        $this->seed(UserSeeder::class);

        $this->get("/api/users/current")
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Unauthorized"
                    ]
                ]
            ]);
    }

    public function test_update_name_success()
    {
        $this->seed(UserSeeder::class);

        $oldUser = User::where("name", "test")->first();

        $this->patch("/api/users/current", [
            "name" => "Namaku baru"
        ], ["Authorization" => "test"])
            ->assertStatus(200);

        $newUser = User::where("name", "Namaku baru")->first();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    public function test_update_name_failed()
    {
        $this->seed(UserSeeder::class);

        $oldUser = User::where("name", "test")->first();

        $this->patch("/api/users/current", [
            "name" => "Namaku"
        ], ["Authorization" => "test"])
            ->assertStatus(status: 400)->assertJson(
                [
                    "errors" => [
                        "name" => ["The name field must be at least 10 characters."]
                    ]
                ]
            );
    }

    public function test_update_password_success()
    {
        $this->seed(UserSeeder::class);

        $oldUser = User::where("name", "test")->first();

        $this->patch("/api/users/current", [
            "password" => "Password baru"
        ], ["Authorization" => "test"])
            ->assertStatus(200);

        $newUser = User::where("name", "test")->first();

        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    public function test_update_password_and_name_success()
    {
        $this->seed(UserSeeder::class);

        $oldUser = User::where("name", "test")->first();

        $this->patch("/api/users/current", [
            "name" => "Namaku baru",
            "password" => "Password baru"
        ], ["Authorization" => "test"])
            ->assertStatus(200);

        $newUser = User::where("name", "Namaku baru")->first();

        self::assertNotEquals($oldUser->name, $newUser->name);
        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    public function test_update_password_and_name_failed()
    {
        $this->seed(UserSeeder::class);

        $this->patch("/api/users/current", [
            "name" => "baru",
            "password" => "baru"
        ], ["Authorization" => "test"])
            ->assertStatus(400);
    }

    public function test_logout_success()
    {
        $this->seed([UserSeeder::class]);

        $this->delete("/api/users/logout", headers: [
            "Authorization" => "test"
        ])->assertStatus(200);

        $user = User::where("username", "test")->first();
        self::assertNull($user->token);
    }

    public function test_logout_failed()
    {
        $this->seed([UserSeeder::class]);

        $this->delete("/api/users/logout")->assertStatus(401);
    }
}
