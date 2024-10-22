@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>1</td> <!-- can change the quantity -->
                    </tr>
                @endforeach
            </tbody>

        </table>

        <form action="{{ route('checkout.index') }}" method="GET">
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
    @endif
</div>
@endsection
