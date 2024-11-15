<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Service\HelloService;
use App\Service\HelloServiceIndonesia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateDependency()
    {
        $bar = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame("foo and bar", $bar->bar());

        self::assertSame("foo and bar", $bar2->bar());

        // self::assertNotSame($bar, $bar2);

        // Object akan sama dikarenakan akan mereference instance object yg sama (sudah memiliki provider)
        self::assertSame($bar, $bar2);
    }

    public function testBind()
    {
        // Akan dipanggil berkali-kali
        $this->app->bind(Person::class, function () {
            return new Person("Eko", "Khannedy");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Eko", $person1->firstName);

        self::assertEquals("Eko", $person2->firstName);

        self::assertNotSame($person1, $person2);
    }
    public function testBindSingleton()
    {
        // Hanya dipanggil sekali
        $this->app->singleton(Person::class, function () {
            return new Person("Eko", "Khannedy");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Eko", $person1->firstName);

        self::assertEquals("Eko", $person2->firstName);

        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Eko", "Khannedy");

        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Eko", $person1->firstName);

        self::assertEquals("Eko", $person2->firstName);

        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        // Object akan sama dikarenakan akan mereference instance object yg sama
        self::assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionNotSame()
    {
        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        // Object tidak sama, karena memiliki instance yang berbeda
        // self::assertNotSame($foo, $bar->foo);

        // Object menjadi sama, karena memiliki instance yang sama (sudah memiliki provider)
        self::assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionWithParam()
    {
        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

        $foo = $this->app->make(Foo::class);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        // Jika sederhana pakai ini
        // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        // Atau jika kompleks maka gunakan closure
        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals("Hello Eko", $helloService->hello("Eko"));
    }
}
