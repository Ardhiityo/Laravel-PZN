<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StackTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStack()
    {
        $this->view('stack')
            ->assertSeeInOrder(['third.js', 'first.js', 'second.js']);
    }
}
