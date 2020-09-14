@extends('layouts.app')

@section('content')

@if(Auth::user()->user_type == 2)
@include('layouts.sidemenu-cst')
@else
@include('layouts.sidemenu')
@endif

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Order') }}</div>
        @include('layouts.flash-message')
        <div class="card-body">
            <table class="table table-bordered">
                <colgroup>
                    <col span="1" style="width: 7%;">
                    <col span="1" style="width: 13%;">
                    <col span="1" style="width: 30%;">
                    <col span="1" style="width: 25%;">
                    <col span="1" style="width: 15%;">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">Order Number</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Payment Receipt</th>
                        <th scope="col">Shipping Address</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                    <tr>
                        <td>{{$order->order_number}}</td>
                        <td>{{$order->order_status}}</td>

                        @if($order->order_evidence == 'NOT UPLOADED YET')
                        <td><span class="badge badge-danger">{{$order->order_evidence}}</span></td>
                        @else
                        <td><img src="<?php echo asset($order->order_evidence) ?>" class="img-thumbnail" style="width:140px; height:140px;" /></td>
                        @endif
                        <td>{{$order->order_address}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary btn-sm mr-1" href="{{ url('order/'.$order->order_id.'/edit') }}">
                                    {{(Auth::user()->user_type == 2)? 'Upload Receipt' : 'Update'}}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection

@section('scriptcode')
<script>

</script>
@endsection