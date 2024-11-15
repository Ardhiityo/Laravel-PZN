<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText("Hello PZN");
    }

    public function testViewNested()
    {
        $this->get('/hello-world')
            ->assertSeeText("World PZN");
    }

    // Test View tanpa routes
    public function testTemplate()
    {

        $this->view('hello', ['name' => 'PZN'])
            ->assertSeeText("Hello PZN");

        $this->view('hello.world', ['name' => 'PZN'])
            ->assertSeeText("World PZN");
    }
}
