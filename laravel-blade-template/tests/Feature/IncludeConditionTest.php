<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeConditionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIncludeCondition()
    {
        $this->view(
            'include-condition',
            [
                "owner" =>
                [
                    'name' => 'PZN',
                    'status' => true
                ]
            ]
        )
            ->assertSeeText('Selamat datang owner')
            ->assertSeeText('Hello PZN');

        $this->view(
            'include-condition',
            [
                "owner" =>
                [
                    'name' => 'PZN',
                    'status' => false
                ]
            ]
        )
            ->assertDontSeeText('Selamat datang owner')
            ->assertSeeText('Hello PZN');
    }
}
