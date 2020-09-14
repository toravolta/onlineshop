@extends('layouts.app')

@section('content')

@if(Auth::user()->user_type == 2)
@include('layouts.sidemenu-cst')
@else
@include('layouts.sidemenu')
@endif

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Order Product') }}</div>
        <div class="card-body">
            @include('layouts.flash-message')
            <div class="row">
                <div class="col-md-8">
                    <ul class="list-group">
                        @foreach ($orders as $key => $order)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4">
                                    @if($order->product_image)
                                    <img src="<?php echo asset($order->product_image) ?>" class="img-thumbnail" style="width:140px; height:140px;">
                                    @else
                                    <img src=" <?php echo asset('/images/noimage.jpg') ?>" class="img-thumbnail" style="width:140px; height:140px;">
                                    @endif
                                </div>
                                <div class=" col-sm-8">
                                    <ul class="list-group">
                                        <li class="list-group-item text-secondary">
                                            {{$order->product_name}}
                                        </li>
                                        <li class="list-group-item text-danger font-weight-bold">
                                            Rp. {{number_format($order->product_price,0)}}
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
                        <div class="card-header">{{ __('Update Order') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('order.reupdate', $order->order_id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        @if(Auth::user()->user_type == 2)
                                        <div class="form-group">
                                            <label for="paymentReceipt">Upload Receipt</label>
                                            <input type="file" class="form-control-file" id="paymentReceipt" name="image">
                                            @error('image')
                                            <span class="text-danger"><i>{{ $message }}</i></span>
                                            @enderror
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="order_status">Status</label>
                                            <select name="order_status" class="form-control" {{Auth::user()->user_type == 2 ? 'disabled' : ''}}>
                                                <option value="1" {{ $order->order_status == 1 ? 'selected="selected"' : '' }}>PENDING</option>
                                                <option value="2" {{ $order->order_status == 2 ? 'selected="selected"' : ''}}>DELIVERED</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
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