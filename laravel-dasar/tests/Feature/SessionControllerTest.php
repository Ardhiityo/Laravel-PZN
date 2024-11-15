<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSesion()
    {
        $this->get('/session')
            ->assertSeeText('OK')
            ->assertSessionHas('name', 'John')
            ->assertSessionHas('member', 'true');
    }

    public function testGetSesion()
    {
        $this->withSession([
            'name' => 'John',
            'member' => 'true'
        ])
            ->get('/session/get')
            ->assertSeeText('UserId: John, Member: true');
    }

    public function testGetSesionFailed()
    {
        $this->withSession([
            'name' => 'Guest',
            'member' => 'false'
        ])
            ->get('/session/get')
            ->assertSeeText('UserId: Guest, Member: false');
    }
}
