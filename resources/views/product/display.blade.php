@extends('layouts.app')

@section('content')

@include('layouts.sidemenu-cst')

<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            @include('layouts.flash-message')
            <div class="row justify-content-center">
                @foreach ($products as $key => $product)
                <div class="card mr-3 mb-4 inline-block" style="width: 12rem;">
                    @if($product->product_image)
                    <img src="<?php echo asset($product->product_image) ?>" class="card-img-top" style="height:170px;" />
                    @else
                    <img src="<?php echo asset('/storage/noimage.jpg') ?>" class="card-img-top" style="height:170px;" />
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$product->product_name}}</h5>
                        <p class="card-text">{{$product->product_desc}}</p>
                    </div>
                    <a href="{{ url('detail/'.$product->id) }}" class="btn btn-primary justify-content-center m-3">Detail Product</a>
                </div>
                @endforeach
            </div>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection