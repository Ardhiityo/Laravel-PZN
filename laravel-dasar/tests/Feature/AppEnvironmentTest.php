<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAppEnv()
    {
        // Untuk mengecek sekarang beada di env mana
        // $env = App::environment();



        // Untuk mengecek apakah sekarang berada di env testing
        // $env = App::environment("testing");

        // if ($env) {
        //     self::assertTrue(true);
        // }



        // Untuk mengecek apakah sekarang berada di env testing, production, dev
        $env = App::environment(["testing", "production", "dev"]);

        if ($env) {
            self::assertTrue(true);
        }
    }
}
