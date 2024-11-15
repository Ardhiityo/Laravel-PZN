<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateCookie()
    {
        $this->get('/cookie')
            ->assertSeeText('Hello World')
            ->assertCookie('name', 'pzn');
    }

    public function testGetCookie()
    {
        $this->withCookie('name', 'pzn')
            ->get('/cookie/get')
            ->assertJson([
                'name' => 'pzn'
            ]);
    }

    public function testClearCookie()
    {
        $this->withCookie('name', 'pzn')
            ->get('/cookie/clear')
            ->assertCookieExpired('name');
    }
}
