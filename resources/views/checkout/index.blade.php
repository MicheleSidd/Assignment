@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>

    @if ($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="text" name="discount_code" placeholder="Have a discount code?">
            <button type="submit">Apply Discount</button>
            <button type="submit" class="btn btn-primary">Complete Checkout</button>
        </form>
    @endif

    @if(Auth::guest())
        <!-- Register form during checkout -->
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    @else
        <!-- Already logged in user -->
        <p>Welcome back, {{ Auth::user()->name }}</p>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <!-- Show and update user info -->
            <input type="text" name="address" value="{{ Auth::user()->address }}" placeholder="Address" required>
            <input type="text" name="contact" value="{{ Auth::user()->contact }}" placeholder="Contact" required>
            <button type="submit">Proceed to Checkout</button>
        </form>
    @endif
</div>
@endsection
