<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name'     => $product->name,
                'quantity' => 1,
                'price'    => $product->price,
                'image'    => $product->images->first()?->image_path,
            ];
        }

        session()->put('cart', $cart);

        // Instead of redirect → return JSON
        return response()->json([
            'success'   => true,
            'message'   => 'Added to cart!',
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public static function getCartCount()
    {
        $cart = session('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;
        $quantity = (int) $request->quantity;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $quantity);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
}
