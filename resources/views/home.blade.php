@extends('layouts.app')

@section('content')

@include('layouts.sidemenu')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Notification') }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Incoming Order') }}</div>
                        <div class="card-body">
                            <a href="{{ route('order.index') }}">
                                <h3 class="text-danger">{{$incoming_order}}</h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Completed Order') }}</div>
                        <div class="card-body">
                            <h3 class="text-success">{{$completed_order}}</h3>
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
</script>
@endsection