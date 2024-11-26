<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InheritanceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInheritance()
    {
        $this->view('child')
            ->assertSeeText('Nama Aplikasi - This is a title')
            ->assertSeeText('Header')
            ->assertSeeText('Content');
    }
    public function
    testInheritanceDefault()
    {
        $this->view('child-default')
            ->assertSeeText('Nama Aplikasi - This is a title')
            ->assertSeeText('Default Header')
            ->assertSeeText(' Header');
    }
}
