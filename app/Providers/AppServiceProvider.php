<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema; //Import Schema




class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

     public function boot()
 {
     Schema::defaultStringLength(191); //this is going to solve the length related isseus
 }



    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
