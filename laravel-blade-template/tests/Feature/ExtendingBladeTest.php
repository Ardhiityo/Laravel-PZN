<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExtendingBladeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExtendingBlade()
    {
        $this->view("extending", ["name" => "Eko"])
            ->assertSeeText("Hello Eko");
    }
}
