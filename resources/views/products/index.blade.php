@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: €{{ $product->price }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" 
                            @if($product->stock == 0) disabled @endif>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection