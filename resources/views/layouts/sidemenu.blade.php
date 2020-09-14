<div class="col-md-3">
    <div class="card">
        <div class="card-header">{{ __('Menu') }}</div>
        <div class="card-body">
            <ul class="list-group">
                <a href="{{ route('home') }}">
                    <li class="list-group-item">Home</li>
                </a>
                <a href="{{ route('product.display') }}">
                    <li class="list-group-item">Catalogue</li>
                </a>
                <a href="{{ route('product.index') }}">
                    <li class="list-group-item">Product</li>
                </a>
                <a href="{{ url('/order')}}">
                    <li class="list-group-item">Order
                        @if($order['incoming_order'])
                        <span class="badge badge-danger">{{$order['incoming_order']}}</span>
                        @endif
                </a>
            </ul>
        </div>
    </div>
</div>