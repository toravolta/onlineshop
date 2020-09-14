<div class="col-md-3">
    <div class="card">
        <div class="card-header">{{ __('Menu') }}</div>
        <div class="card-body">
            <ul class="list-group">
                @if (Auth::check())
                @if (Auth::user()->user_type == 1)
                <a href="{{ route('home') }}">
                    <li class="list-group-item">Home</li>
                </a>
                @endif
                @endif

                <a href="{{ route('product.display') }}">
                    <li class="list-group-item">Catalogue</li>
                </a>

                @if (Auth::check())
                @if (Auth::user()->user_type == 2)
                <a href="{{ url('/cart/'.Auth::id())}}">
                    <li class="list-group-item">Cart
                        @if($order['cart'])
                        <span class="badge badge-danger">{{$order['cart']}}</span>
                        @endif</li>
                </a>
                @endif
                @if (Auth::user()->user_type == 1)
                <a href="{{ route('product.index') }}">
                    <li class="list-group-item">Product</li>
                </a>
                @endif
                <a href="{{ url('/order')}}">
                    <li class="list-group-item">Order
                        @if($order['order_evidence'])
                        <span class="badge badge-danger">{{$order['order_evidence']}}</span>
                        @endif</li>
                    </li>
                </a>
                @endif
            </ul>
        </div>
    </div>
</div>