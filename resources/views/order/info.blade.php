@extends('layouts.app')

@section('content')

@include('layouts.sidemenu-cst')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Checkout') }}</div>
        <div class="card-body">
            @include('layouts.flash-message')
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="addressId">Shipping Address</label>
                        <textarea class="form-control" id="addressId" rows="3"></textarea>
                    </div>
                </div>
            </div>
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
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
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
                                    <form action="{{ route('order.update', $order_id) }}" method="post" id="orderForm">
                                        @csrf
                                        @method('PUT')
                                        <input id="id" name="order_id" value="{{$order_id}}" hidden />
                                        <textarea class="form-control" id="addressId2" name="address" hidden></textarea>
                                        <button type="button" onClick="handleSubmit()" class="btn btn-block btn-success">Order</button>
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

@section('scriptcode')
<script>
    function handleSubmit() {
        var text = document.getElementById("addressId").value;
        document.getElementById("addressId2").value = text;
        document.getElementById("orderForm").submit();
    }
</script>
@endsection