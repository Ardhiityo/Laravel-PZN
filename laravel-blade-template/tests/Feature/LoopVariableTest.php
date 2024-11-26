<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoopVariableTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoopVariable()
    {
        $this->view('loop-variable', ["hobbies" => ["Coding", "Gaming", "Reading"]])
            ->assertSeeText(1)
            ->assertSeeText(2)
            ->assertSeeText(3)
            ->assertSeeText("Coding")
            ->assertSeeText("Gaming")
            ->assertSeeText("Reading");
    }
}
