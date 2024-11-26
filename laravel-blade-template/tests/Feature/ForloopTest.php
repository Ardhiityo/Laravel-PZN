<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForloopTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFor()
    {
        $this->view('for', ["limit" => 5])
            ->assertSeeText(0)
            ->assertSeeText(1)
            ->assertSeeText(2)
            ->assertSeeText(3)
            ->assertSeeText(4);
    }
    public function testForeach()
    {
        $this->view('foreach', [
            "hobbies" => ["Coding", "Gaming"]
        ])
            ->assertSeeText('Coding')
            ->assertSeeText("Gaming");
    }

    public function testForeElse()
    {
        $this->view('forelse', [
            "hobbies" => ["Coding", "Gaming"]
        ])
            ->assertSeeText('Coding')
            ->assertSeeText("Gaming")
            ->assertDontSeeText("No hobbies");

        $this->view('forelse', ["hobbies" => []])
            ->assertSeeText("No hobbies")
            ->assertDontSeeText("Coding")
            ->assertDontSeeText("Gaming");
    }
}
