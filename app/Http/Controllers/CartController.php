<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $cart = new Cart;
        $cart->product_id = $request->id;
        $cart->users_id = Auth::id();

        if ($cart->save()) {
            return redirect()->route('product.display')
                ->with('success', 'Product successfully add to cart');
        }

        return redirect()->route('product.display')
            ->with('error', 'Add to cart failed');
    }

    public function detail($id)
    {
        $cart_detail = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('product.*', DB::raw('cart.id as cart_id'), 'cart.users_id', 'cart.product_id', 'cart.order_id')
            ->where('cart.users_id', '=', $id)
            ->whereNull('cart.order_id')->get();

        $total_price = 0;
        if (count($cart_detail)) {
            $pricelist = [];
            foreach ($cart_detail as $key => $value) {
                $pricelist[] = $value->product_price;
            }

            $total_price = array_sum($pricelist);
            return view('cart.detail', compact('cart_detail', 'total_price'));
        }

        return view('cart.detail', compact('cart_detail', 'total_price'));
    }

    public function delete(Request $request)
    {
        $cart = Cart::destroy($request->id);

        if ($cart) {
            return redirect()->route('cart.detail', Auth::id())
                ->with('success', 'Product successfully removed');
        }

        return redirect()->route('cart.detail', Auth::id())
            ->with('error', 'Failed to remove product');
    }
}
