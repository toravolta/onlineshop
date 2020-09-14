<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order = Order::where('order_status', 1)->get()->toArray();
        $order_complete = Order::where('order_status', 2)->get()->toArray();
        $incoming_order = count($order);
        $completed_order = count($order_complete);

        return view('home', compact('incoming_order', 'completed_order'));
    }
}
