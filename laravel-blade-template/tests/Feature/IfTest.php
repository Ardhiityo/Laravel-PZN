<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IfTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIf()
    {
        $this->view('if', ["hobbies" => ["Coding"]])
            ->assertSeeText("I Have One Hobbies");

        $this->view('if', ["hobbies" => ["Coding", "Gaming"]])
            ->assertSeeText("I Have Multiple Hobbies");

        $this->view('if', ["hobbies" => []])
            ->assertSeeText("I Don't Have Any Hobbies", false);
    }
}
