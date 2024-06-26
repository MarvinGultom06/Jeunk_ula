<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        $userId = auth()->id();

        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout', compact('cartItems', 'subtotal'));
    }


    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->payment_method = $request->payment_method;
        $order->total = $request->subtotal;
        $order->save();

        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product->price;
            $orderItem->save();
        }

        Cart::where('user_id', Auth::id())->delete();

        return view('order-success', compact('order'));
    }
}
