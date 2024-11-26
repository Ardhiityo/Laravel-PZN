<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInclude()
    {
        $this->view('include')
            ->assertSeeText('PZN')
            ->assertSeeText('Homepage')
            ->assertSeeText('dari halaman home');

        $this->view('include', ['title' => 'Include'])
            ->assertSeeText('Include')
            ->assertDontSeeText('PZN')
            ->assertSeeText('Homepage');

        $this->view('include', ['title' => 'Include'])
            ->assertSeeText('Include')
            ->assertDontSeeText('PZN')
            ->assertSeeText('Homepage')
            ->assertSeeText('dari halaman home');
    }
}
