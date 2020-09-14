@extends('layouts.app')

@section('content')

@include('layouts.sidemenu')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Edit Product') }}</div>
        <div class="card-body">
            <form method="POST" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="productImage">Product Image</label>
                    <input type="file" class="form-control-file" id="productImage" name="image" value="{{ $product->product_image }}">
                </div>
                <div class="form-group">
                    <label for="produdctName">Product Name *</label>
                    <input type="text" class="form-control" id="produdctName" name="name" value="{{old('name', $product->product_name)}}">
                    @error('name')
                    <span class="text-danger"><i>{{ $message }}</i></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="productPrice">Price *</label>
                    <input type="text" class="form-control" id="productPrice" name="price" value="{{old('price', $product->product_price)}}">
                    @error('price')
                    <span class="text-danger"><i>{{ $message }}</i></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="productDesc">Desc</label>
                    <textarea class="form-control" id="productDesc" rows="3" name="desc">{{$product->product_desc}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection