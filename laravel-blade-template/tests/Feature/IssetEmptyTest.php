<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IssetEmptyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIssetEmpty()
    {
        $this->view('isset-empty')
            ->assertDontSeeText("Hello");

        $this->view('isset-empty', ['name' => 'Eko'])
            ->assertSeeText("Hello, Eko")
            ->assertSeeText("I don't have any hobbies", false);

        $this->view('isset-empty', ['name' => 'Eko', "hobbies" => ["Coding"]])
            ->assertSeeText("Hello, Eko")
            ->assertDontSeeText("I don't have any hobbies", false);
    }
}
