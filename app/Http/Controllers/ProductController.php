<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::paginate(10);

        return view('product.index', ['products' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return redirect('product/create')
                ->withErrors($validator)
                ->withInput();
        }

        $url = null;
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {

                //second validation if image is exist
                $validator = Validator::make($request->all(), [
                    'image' => 'image|mimes:jpeg,png,jpg|max:3072',
                ]);

                if ($validator->fails()) {
                    return redirect('product/create')
                        ->withErrors($validator)
                        ->withInput();
                }

                $imageName = time() . '.' . $request->image->extension();

                $request->image->storeAs('/public', $imageName);
                $url = Storage::url($imageName);
            }
        }

        Product::create([
            'product_name' => $request->name,
            'product_image' => $url,
            'product_price' => $request->price,
            'product_desc' => $request->desc,
        ]);

        return redirect()->route('product.index')
            ->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return view('product.edit', compact('product'));
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return redirect('product/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);
        $url = $product->product_image;
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {

                //second validation if image is exist
                $validator = Validator::make($request->all(), [
                    'image' => 'image|mimes:jpeg,png,jpg|max:3072',
                ]);

                if ($validator->fails()) {
                    return redirect('product/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
                }

                $imageName = time() . '.' . $request->image->extension();

                $request->image->storeAs('/public', $imageName);
                $url = Storage::url($imageName);

                //delete previous image if exist
                if ($product->product_image) {
                    $getName = explode("/", $product->product_image);
                    Storage::disk('public')->delete($getName[2]);
                }
            }
        }

        $product->product_name = $request->name;
        $product->product_image = $url;
        $product->product_price = $request->price;
        $product->product_desc = $request->desc;
        $product->save();

        return redirect()->route('product.index')
            ->with('success', 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::find($request->id);

        //delete previous image if exist
        if ($product->product_image) {
            $getName = explode("/", $product->product_image);
            Storage::disk('public')->delete($getName[2]);
        }

        $product = Product::destroy($request->id);

        if ($product) {
            return redirect()->route('product.index')
                ->with('success', 'Product successfully deleted');
        }

        return redirect()->route('product.index')
            ->with('error', 'Failed to delete product');
    }

    public function display()
    {
        $product = Product::paginate(10);

        return view('product.display', ['products' => $product]);
    }

    public function detailProduct($id)
    {
        $product = Product::find($id);

        return view('product.detail', compact('product'));
    }
}
