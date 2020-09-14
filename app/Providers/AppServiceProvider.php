<?php

namespace App\Providers;

use App\Order;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        view()->composer('*', function ($view) {
            $get_cart = Cart::where('users_id', '=', Auth::id())->whereNull('order_id')->get()->toArray();
            $cart_count = count($get_cart);

            $order = Order::where('order_status', 1)->get()->toArray();
            $incoming_order = count($order);

            $get_cust_order = DB::table('order')
                ->leftJoin('cart', 'cart.order_id', '=', 'order.id')
                ->select('order.id')
                ->where('cart.users_id', '=', Auth::id())
                ->whereNull('order.order_evidence')->get()->toArray();

            $get_id = [];
            foreach ($get_cust_order as $key => $value) {
                $get_id[] = $value->id;
            }
            $cust_order = count(array_unique($get_id));

            $view->with('order', ['cart' => $cart_count, 'incoming_order' => $incoming_order, 'order_evidence' => $cust_order]);
        });
    }
}
