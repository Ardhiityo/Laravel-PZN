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
    public function testHello()
    {
        $this->get('/hello')->assertSeeText('Laravel');
    }
    public function testNested()
    {
        $this->get('hello/nested')->assertSeeText("Laravel");
    }
    public function testViewHello()
    {
        $this->view('hello', ['title' => 'Laravel'])->assertSeeText('Laravel');
    }
    public function testViewHelloNested()
    {
        $this->view('hello.world', ['title' => 'Laravel'])->assertSeeText('Laravel');
    }
}
