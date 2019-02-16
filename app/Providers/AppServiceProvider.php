<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Item;
use App\ItemCategory as Category;
use App\Brand;
use Illuminate\Support\Facades\View;
use App\Observers\OrderObserver;
use App\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories = Category::get();
        $brands = Brand::get();
        View::share('categories',$categories);
        View::share('brands',$brands);
        Order::observe(OrderObserver::class);
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
