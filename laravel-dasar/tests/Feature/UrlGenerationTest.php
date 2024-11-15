<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlGenerationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testURL()
    {
        $this->get('/url/current?name=PZN')
            ->assertSeeText("/url/current?name=PZN");
    }
    public function testURLNamed()
    {
        $this->get('/url/named')
            ->assertSeeText("/redirect/hello/PZN");
    }
    public function testURLAction()
    {
        $this->get('/url/action')
            ->assertSeeText("form");
    }
}
