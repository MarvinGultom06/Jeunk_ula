<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index()
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
}