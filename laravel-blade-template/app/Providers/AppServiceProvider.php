<?php

namespace App\Providers;

use App\Service\SayHello;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\Person;
use Stringable;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        SayHello::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('hello', function ($expression): string {
            return "<?php echo 'Hello ' . $expression; ?>";
        });

        Blade::stringable(Person::class, function (Person $person) {
            return "$person->name : $person->address";
        });
    }
}
