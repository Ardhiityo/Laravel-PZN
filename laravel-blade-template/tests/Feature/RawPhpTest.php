<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RawPhpTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRaw()
    {
        $this->view('raw-php')
            ->assertSeeText("John Doe")
            ->assertSeeText("123 Main St");
    }
}
