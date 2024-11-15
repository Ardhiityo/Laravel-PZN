<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetEnv()
    {
        // Untuk mengambil value env dengan key YOUTUBE
        $yt = env("YOUTUBE");

        self::assertEquals("Programmer zaman now", $yt);

        // Untuk mengambil value env dengan key AUTHOR, dan jika tidak ada akan membuat default value ENV
        $author = env("AUTHOR", "Eko");
        self::assertEquals("Eko", $author);
    }
}
