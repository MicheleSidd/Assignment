<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    // show items in the cart
    public function index()
    {$user = Auth::user();

        // check if user have a cart
        if ($user->cart) {
            // if got a cart, take products
            $cartItems = $user->cart->products;
        } else {
            // if don't have cart-> empty collection
            $cartItems = collect(); // una collection vuota per evitare errori
        }
    
        return view('cart.index', compact('cartItems'));
    }
    // add items 
    public function addToCart(Product $product)
    {
    
        $user = Auth::user();
        //if user doesen't have a cart
        if (!$user->cart) {
            $cart = $user->cart()->create();
        } else {
            $cart = $user->cart;
        }
        //if product in stock
        if ($product->stock > 0) {
            // check if product alrady in cart
            if ($cart->products->contains($product->id)) {
                // increase amount
                $cart->products()->updateExistingPivot($product->id, [
                    'quantity' => $cart->products->find($product->id)->pivot->quantity + 1
                ]);
            } else {
                // add +1 to the cartr
                $cart->products()->attach($product->id, ['quantity' => 1]);
            }
    
            // reduce the stock
            $product->decrement('stock');
    
            return redirect()->back()->with('success', 'Product added to cart!');
        }
    
        return redirect()->back()->with('error', 'Product out of stock');
    }

    // Remove from cart
    public function removeFromCart(Product $product)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart && $cart->products->contains($product->id)) {
            // check quantity of the product
            $quantity = $cart->products->find($product->id)->pivot->quantity;
    
            // remove from the cart
            $cart->products()->detach($product->id);
    
            // readjust stock amount
            $product->increment('stock', $quantity);
    
            return redirect()->back()->with('success', 'Product removed from cart!');
        }
    
        return redirect()->back()->with('error', 'Product not found in cart');
    }
}



