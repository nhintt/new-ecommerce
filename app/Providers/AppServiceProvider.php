<?php

namespace App\Providers;

use App\Customer;
use App\Order;
use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Video;

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
       view()->composer('*', function($view){
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');

        $min_price_range = $min_price + 500000;
        $max_price_range = $max_price + 10000000;

        $product = Product::all()->count();
        $order = Order::all()->count();
        $video = Video::all()->count();
        $customer = Customer::all()->count();

        $view->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range)->with('product',$product)->with('order',$order)->with('video',$video)->with('customer',$customer);
       });
    }
}
