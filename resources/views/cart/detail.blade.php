@extends('layouts.app')

@section('content')

@include('layouts.sidemenu-cst')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Cart Product') }}</div>
        <div class="card-body">
            @include('layouts.flash-message')
            <div class="row">
                <div class="col-md-8">
                    <ul class="list-group">
                        @foreach ($cart_detail as $key => $product)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4">
                                    @if($product->product_image)
                                    <img src="<?php echo asset($product->product_image) ?>" class="img-thumbnail" style="width:140px; height:140px;">
                                    @else
                                    <img src=" <?php echo asset('/storage/noimage.jpg') ?>" class="img-thumbnail" style="width:140px; height:140px;">
                                    @endif
                                </div>
                                <div class=" col-sm-8">
                                    <ul class="list-group">
                                        <li class="list-group-item text-secondary">
                                            {{$product->product_name}}
                                        </li>
                                        <li class="list-group-item text-danger font-weight-bold">
                                            Rp. {{number_format($product->product_price,0)}}
                                        </li>
                                    </ul>
                                    <form action="{{ route('cart.delete', $product->cart_id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input id="id" name="id" value="{{$product->cart_id}}" hidden />
                                        <button type="submit" class="btn btn-sm btn-outline-danger mt-1">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @if($total_price == 0)
                    <div class="justify-content-center">
                        <p>Cart is empty</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">{{ __('Shopping summary') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 pull-left">
                                    <p>Total Price</p>
                                </div>
                                <div class="col-sm-6 pull-right">
                                    <p>Rp. {{number_format($total_price,0)}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mt-2">
                                    <form action="{{ route('order.store') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-success">Checkout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection