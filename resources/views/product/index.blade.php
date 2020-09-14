@extends('layouts.app')

@section('content')

@include('layouts.sidemenu')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">{{ __('Product') }}</div>
        @include('layouts.flash-message')
        <div class="card-body">
            <div class="pull-right mb-2"><a href="{{ route('product.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Product</a></div>
            <table class="table table-bordered">
                <colgroup>
                    <col span="1" style="width: 5%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 35%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                    <tr>
                        <td>{{$products->firstItem() + $key }}</td>
                        <td>
                            @if($product->product_image)
                            <img src="<?php echo asset($product->product_image) ?>" class="img-thumbnail" style="width:140px; height:140px;" />
                            @else
                            <img src="<?php echo asset('/storage/noimage.jpg') ?>" class="img-thumbnail" style="width:140px; height:140px;" />
                            @endif
                        </td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->product_price}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary btn-sm mr-1" href="{{ url('product/'.$product->id.'/edit') }}">Edit</a>
                                <a class="btn btn-secondary btn-sm mr-1" href="{{ url('product/'.$product->id) }}">Show</a>
                                <button type="button" onClick="handleDelete({{$product->id}})" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="{{ route('product.destroy', 'id') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input id="id" name="id" hidden />
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptcode')
<script>
    function handleDelete(id) {
        document.getElementById("id").value = id;
    }
</script>
@endsection