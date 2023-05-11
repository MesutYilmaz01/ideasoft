<?php

namespace App\Providers;

use App\Http\Contracts\ICustomerService;
use App\Http\Contracts\IOrderService;
use App\Http\Contracts\IProductService;
use App\Http\Services\CustomerService;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(ICustomerService::class, CustomerService::class);
        $this->app->bind(IOrderService::class, OrderService::class);
        $this->app->bind(IProductService::class, ProductService::class);
    }
}
