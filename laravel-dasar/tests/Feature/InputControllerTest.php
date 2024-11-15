<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testController()
    {
        $this->get('/input/hello?name=PZN')
            ->assertSeeText('PZN');

        $this->post('/input/hello', ['name' => 'PZN'])
            ->assertSeeText('PZN');
    }

    public function testControllerNested()
    {
        $this->post('/input/hello/first', [
            'name' => [
                'first' => 'PZN',
                'last' => 'Programmer Zaman Now'
            ],
        ])
            ->assertSeeText('Hello PZN');
    }

    public function testControllerInputAll()
    {
        $this->post('/input/hello/all', [
            'name' => [
                'first' => 'PZN',
                'last' => 'Programmer Zaman Now'
            ],
        ])
            ->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('PZN')
            ->assertSeeText('last')
            ->assertSeeText('Programmer Zaman Now');
    }

    public function testControllerInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30000000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 15000000
                ]
            ]
        ])
            ->assertSeeText('Apple Mac Book Pro')
            ->assertSeeText('Samsung Galaxy S10');
    }
    public function testQuery()
    {
        $this->post(
            '/input/query?name=eko'
        )
            ->assertSeeText('eko');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])
            ->assertSeeText('Budi')
            ->assertSeeText('true')
            ->assertSeeText('1990-10-10');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            'name' => [
                'first' => 'PZN',
                'middle' => 'Budi',
                'last' => 'Nugraha'
            ]
        ])
            ->assertSeeText('PZN')
            ->assertSeeText('Nugraha')
            ->assertDontSeeText('Budi');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            'name' => [
                'first' => 'PZN',
                'admin' => 'true',
                'last' => 'Nugraha'
            ]
        ])
            ->assertSeeText('PZN')
            ->assertSeeText('Nugraha')
            ->assertDontSeeText('true');
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            'admin' => 'true'
        ])
            ->assertSeeText('false');
    }

    public function testFilterMergeIfMissing()
    {
        $this->post('/input/filter/merge/ifmissing')
            ->assertSeeText('true');
    }
}
