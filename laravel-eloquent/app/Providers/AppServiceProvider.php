<?php

namespace App\Providers;

use App\Models\Customers;
use App\Models\Products;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $queryExecuted) {
            Log::info($queryExecuted->sql);
        });

        Relation::enforceMorphMap([
            "product" => Products::class,
            "voucher" => Voucher::class,
            "customer" => Customers::class
        ]);
    }
}
