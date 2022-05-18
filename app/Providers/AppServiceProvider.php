<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Response::macro('success', function ($data) {
            $responseData = json_decode($data);
        return response()->json(['success' => true, 'data'=> $responseData]);
        });
        Response::macro('error', function ($error, $statuscode) {
        return response()->json(['success' => false, 'error' => $error], $statuscode);
        });
    }
}
