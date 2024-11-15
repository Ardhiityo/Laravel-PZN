<?php

namespace App\Providers;

use App\Data\Bar;
use App\Data\Foo;
use App\Service\HelloService;
use App\Service\HelloServiceIndonesia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    // Jika memiliki interface
    public array $singletons = [
        HelloService::class => HelloServiceIndonesia::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        // Akan selalu dijalankan jika tidak implement DeferrableProvider, jika tidak maka akan dijalankan ketika hanya digunakan saja
        // echo "FooBarServiceProvider";

        $this->app->singleton(Foo::class, function () {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [HelloService::class, Foo::class, Bar::class];
    }
}
