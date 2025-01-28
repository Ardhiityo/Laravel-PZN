<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Tests\TestCase;

class GuardTest extends TestCase
{
    public function testGuard(): void
    {
        $this->seed(UserSeeder::class);

        $this->get(
            "/api/users/current",
            headers: [
                "Accept" => "application/json"
            ]
        )->assertStatus(401);

        $this->get(
            "/api/users/current",
            headers: [
                "API-Key" => "secret"
            ]
        )
            ->assertStatus(200)
            ->assertSeeText("Hello pzn");
    }

    public function testProvider()
    {
        $this->get(
            "/api/users/current",
            headers: [
                "Accept" => "application/json"
            ]
        )->assertStatus(401);

        $this->get(
            "/simple/api/users/current",
            headers: [
                "API-Key" => "secret"
            ]
        )
            ->assertStatus(200)
            ->assertSeeText("Hello eko");
    }
}
