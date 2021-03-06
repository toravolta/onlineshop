@extends('layouts.app')

@section('content')

@include('layouts.sidemenu')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Show Product') }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->product_image)
                    <img src="<?php echo asset($product->product_image) ?>" class="img-fluid img-thumbnail"></img>
                    @else
                    <img src="<?php echo asset('/images/noimage.jpg') ?>" class="img-fluid img-thumbnail"></img>
                    @endif
                </div>
                <div class="col-md-8">
                    <ul class="list-group">
                        <li class="list-group-item border-bottom">
                            <h3>{{$product->product_name}}</h3>
                        </li>
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item text-secondary mr-4">HARGA</li>
                                <li class="list-inline-item text-danger font-weight-bold">Rp. {{number_format($product->product_price,0)}}</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item text-secondary mr-4">DESKRIPSI</li>
                                <li class="list-inline-item">{{$product->product_desc}}</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 mt-2">
                    <a href="{{ route('product.index') }}" class="btn btn-primary pull-right">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection