<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testwhile()
    {
        $this->view('while', ["i" => 0])
            ->assertSeeText(0)
            ->assertSeeText(1)
            ->assertSeeText(2)
            ->assertSeeText(3)
            ->assertSeeText(4);
    }
}
