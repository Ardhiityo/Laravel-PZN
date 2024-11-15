<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGet()
    {
        $this->get('/pzn')
            ->assertStatus(200)
            ->assertSeeText("Hello PZN");
    }

    public function testRedirect()
    {
        $this->get('youtube')
            ->assertRedirect('/pzn');
    }

    public function testFallback()
    {
        $this->get('/404')
            ->assertSeeText("404 by PZN");

        $this->get('/Ups')
            ->assertSeeText("404 by PZN");
    }

    public function testRouteParameter()
    {
        $this->get("/products/1")
            ->assertSeeText("product 1");

        $this->get("/products/1/items/2")
            ->assertSeeText("product 1 item 2");
    }

    public function testRouteParameterRegex()
    {
        $this->get("/categories/12345")
            ->assertSeeText("category 12345");

        $this->get("/categories/eko")
            ->assertSeeText("404 by PZN");
    }

    public function testRouteParameterOptional()
    {
        $this->get("/users")
            ->assertSeeText("user 404");
    }

    public function testRouteParameterNamed()
    {
        $this->get("/produk/1")
            ->assertSeeText("Link : http://localhost/products/1");

        $this->get("/produk/redirect/1")
            ->assertSeeText("http://localhost/products/1");
    }
}
