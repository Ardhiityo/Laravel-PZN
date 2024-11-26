<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EachOnceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEachOnce()
    {
        $this->view('each', [
            "users" =>
            [
                [
                    "name" => "John",
                    "hobbies" => ["Coding", "Gaming"]
                ],
                [
                    "name" => "Eko",
                    "hobbies" => ["Coding", "Gaming"]
                ]
            ]
        ])->assertSeeInOrder([".red", "John", "Coding", "Gaming", "Eko", "Coding", "Gaming"]);
    }
}
