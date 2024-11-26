<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testError()
    {
        $this
            ->withViewErrors([
                'name' => ['The name field is required.'],
                'password' => ['The password field is required.'],
            ])
            ->view('error')->assertSee('The name field is required.')
            ->assertSee('The password field is required.');
    }
}
