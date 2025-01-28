<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HashTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testHash()
    {
        $password = "rahasia";
        $hash = Hash::make($password);

        //return dari hash check adalah boolean
        self::assertTrue(Hash::check($password, $hash));

        //hasil dari tiap hash adlaah berbeda
        $hash2 = Hash::make($password);
        self::assertNotEquals($hash, $hash2);
    }
}
