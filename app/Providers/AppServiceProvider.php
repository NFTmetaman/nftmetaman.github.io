<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
    public function boot()
{
    $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q=durban&appid=" . env('OPENWEATHERMAP_API_KEY'));
    $weather = $response->json();

    view()->share('weather', $weather);
}
}
