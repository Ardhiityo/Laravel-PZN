<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConfig()
    {
        // Mengambil value dari config
        $firstName = config("contoh.author.firstName");
        $lastName = config("contoh.author.lastName");

        self::assertEquals("Eko", $firstName);

        self::assertEquals("Khannedy", $lastName);
    }
}
