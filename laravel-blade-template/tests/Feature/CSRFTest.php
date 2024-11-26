<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CSRFTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCSRF()
    {
        $this->view('csrf')
            ->assertSee('_token')
            ->assertSee('hidden');
    }
}
