<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnlessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUnless()
    {
        $this->view('/unless', ["isAdmin" => true])
            ->assertDontSeeText('You are not admin');

        $this->view('/unless', ["isAdmin" => false])
            ->assertSeeText('You are not admin');
    }
}
