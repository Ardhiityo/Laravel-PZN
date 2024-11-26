<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testForm()
    {
        $this->view('form', [
            'user' => [
                'name' => 'Eko',
                'admin' => true,
                'premium' => true
            ]
        ])->assertSeeInOrder(['checked', 'Eko'])
            ->assertDontSee('readonly');
    }
}
