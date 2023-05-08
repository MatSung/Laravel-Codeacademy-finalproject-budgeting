<?php

namespace App\Providers;

use App\Services\ExchangerateService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExchangerateService::class, function ($app){
            $client = new Client();
            return new ExchangerateService($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function(QueryExecuted $query) {
            File::append(
                storage_path('/logs/query.log'),
                $query->sql . ' [' . implode(', ', $query->bindings) . ']' . '[' . $query->time . ']' . PHP_EOL
           );
        });
    }
}
