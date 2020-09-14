<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_detail = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('product.*', DB::raw('cart.id as cart_id'), 'cart.users_id', 'cart.product_id', 'cart.order_id')
            ->where('cart.users_id', '=', Auth::id())
            ->whereNull('cart.order_id')->get();

        if (count($cart_detail->toArray()) == 0) {
            return redirect()->route('cart.detail', Auth::id())
                ->with('error', 'Nothing to checkout');
        }

        // create order when checkout
        $order = new Order;
        $order->order_number = 'INV/' . date('Y') . '/' . uniqid();
        $order->order_status = 1; // 1:pending, 2:delivered

        if ($order->save()) {

            //attach cart with order id
            $order_id = $order->id;
            $update_cart = DB::table('cart')
                ->where('users_id', Auth::id())
                ->whereNull('cart.order_id')
                ->update(['order_id' => $order_id]);

            $total_price = 0;
            if (count($cart_detail)) {
                $pricelist = [];
                foreach ($cart_detail as $key => $value) {
                    $pricelist[] = $value->product_price;
                }

                $total_price = array_sum($pricelist);
                return view('order.info', compact('cart_detail', 'total_price', 'order_id'));
            }
        }

        return redirect()->route('cart.detail', Auth::id())
            ->with('error', 'Failed to checkout');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //update order if addres is set
        if ($request->address) {
            $order = Order::find($request->order_id);
            $order->order_address = $request->address;
            $order->save();
        }

        $cart_detail = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('product.*', DB::raw('cart.id as cart_id'), 'cart.users_id', 'cart.product_id', 'cart.order_id')
            ->where('cart.order_id', '=', $request->order_id)->get();

        $html_table = "";
        $pricelist = [];
        foreach ($cart_detail as $value) {
            $pricelist[] = $value->product_price;
            $html_table .= "<tr>";
            $html_table .= "<td>" . $value->product_name . "</td>";
            $html_table .= "<td> Rp. " . number_format($value->product_price, 0, ',', '.') . "</td>";
            $html_table .= "</tr>";
        }
        $html_table .= "<tr><td>Total</td><td>Rp. " . number_format(array_sum($pricelist), 0, ',', '.') . "</td></tr>";

        Mail::to(Auth::user()->email)->send(new \App\Mail\OrderResume($html_table));
        return redirect()->route('product.display')
            ->with('success', 'Product has successfully processed, please check your email to see your resume shopping');
    }

    public function index()
    {
        $get_order = DB::table('order')
            ->join('cart', 'cart.order_id', '=', 'order.id')
            ->select(
                DB::raw('order.id as order_id'),
                'order.order_number',
                'order.order_address',
                DB::raw("CASE WHEN order.order_status = 1 THEN 'PENDING'
                WHEN order.order_status = 2 THEN 'DELIVERED'
                END AS order_status"),
                DB::raw("CASE WHEN (order.order_evidence IS NULL) THEN 'NOT UPLOADED YET'
                ELSE order.order_evidence END AS order_evidence"),
                'order.created_at'
            );
        //->where('cart.users_id', '=', Auth::id())->distinct()->paginate(10);

        if (Auth::user()->user_type == 1) {
            $order = $get_order->distinct()->paginate(10);
        } else {
            $order = $get_order->where('cart.users_id', '=', Auth::id())->distinct()->paginate(10);
        }

        return view('order.index', ['orders' => $order]);
    }

    public function edit($id)
    {
        $orders = DB::table('order')
            ->join('cart', 'cart.order_id', '=', 'order.id')
            ->leftJoin('product', 'product.id', '=', 'cart.product_id')
            ->select(
                'product.product_name',
                'product.product_price',
                'product.product_image',
                DB::raw('order.id as order_id'),
                'order.order_number',
                'order.order_address',
                DB::raw("CASE WHEN order.order_status = 1 THEN 'PENDING'
                WHEN order.order_status = 2 THEN 'DELIVERED'
                END AS order_status_label"),
                'order_status',
                'order.order_evidence',
                'order.created_at'
            )
            ->where('order.id', '=', $id)->get();

        return view('order.edit', compact('orders'));
    }

    public function reupdate(Request $request, $id)
    {
        $url = null;
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {

                //second validation if image is exist
                $validator = Validator::make($request->all(), [
                    'image' => 'image|mimes:jpeg,png,jpg|max:3072',
                ]);

                if ($validator->fails()) {
                    return redirect('order/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
                }

                $imageName = time() . '.' . $request->image->extension();

                $request->image->storeAs('/public', $imageName);
                $url = Storage::url($imageName);
            }
        }

        $order = Order::find($id);
        if ($url) {
            $order->order_evidence = $url;
        }
        if ($request->order_status) {
            $order->order_status = $request->order_status;
        }
        $order->save();

        return redirect()->route('order.index')
            ->with('success', 'Order successfully updated');
    }
}
