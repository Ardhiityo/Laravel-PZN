<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Service\HelloService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceProvider()
    {
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertSame($foo1, $foo2);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1, $bar2);

        self::assertSame($foo1, $bar1->foo);
    }

    public function testPropertySingleton()
    {
        $helloService = $this->app->make(HelloService::class);

        self::assertSame("Hello Eko", $helloService->hello("Eko"));
    }

    public function testEmpty()
    {
        self::assertTrue(true);
    }
}
