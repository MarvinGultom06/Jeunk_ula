<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function getCart()
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($cartItems);
    }

    public function getProducts()
    {
        $user = auth()->user();
        $products = Product::all();

        $cartItems = [];
        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)
                ->get()
                ->keyBy('product_id')
                ->toArray();
        }

        return response()->json([
            'products' => $products,
            'cartItems' => $cartItems
        ]);
    }

    public function addToCart(Request $request, $productId)
    {
        $user = auth()->user();
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;  // Update to the provided quantity
            $cartItem->save();
        } else {
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $productId;
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cart_item' => $cartItem,
        ]);
    }

    public function removeFromCart($productId)
    {
        $user = auth()->user();
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true, 'message' => 'Product removed from cart successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404);
    }

    public function update(Request $request, $itemId)
    {
        $cartItem = Cart::find($itemId);
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
    }

    public function remove($itemId)
    {
        $cartItem = Cart::find($itemId);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true, 'message' => 'Item removed from cart.']);
        }
        return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
    }
}