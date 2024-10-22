<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
use App\Models\DiscountCode;
use App\Jobs\SendDiscountCode;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
       //check if user has a cart
        if ($user->cart) {
            $cartItems = $user->cart->products;
        } else {
            $cartItems = collect(); 
        }

        return view('checkout.index', compact('cartItems'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // cart total
        $total = $user->cart->products->sum('price');

        // check discount code
        if ($request->filled('discount_code')) {
            $discountCode = DiscountCode::where('code', $request->discount_code)->first();

            if ($discountCode) {
                //apply discount
                $total -= $discountCode->discount_amount; // subtraction discount code
                $user->usedDiscountCodes()->attach($discountCode->id);
            } else {
                return redirect()->back()->with('error', 'Invalid discount code.');
            }
            //send delayed discount code
            SendDiscountCode::dispatch(Auth::user())->delay(now()->addMinutes(15));

            return redirect()->route('order.confirmation');
        }

        

        // make a new order
        Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
        ]);

        $user->cart->products()->detach(); // clean up cart after check out

        // notify order success

        return redirect()->route('order.confirmation')->with('success', 'Checkout completed successfully!');
    }
}