<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $variant = ProductVariant::findOrFail($request->variant_id);

        // ✅ stock validation
        if ($variant->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock'
            ]);
        }

        $cart = session()->get('cart', []);

        // 🔥 UNIQUE KEY (product + variant)
        $cartKey = $id . '_' . $variant->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'name'       => $product->name,
                'color'      => $variant->color,
                'size'       => $variant->size,
                'quantity'   => $request->quantity,
                'price'      => $product->price,
                'stock'      => $variant->stock,
                'image'      => $product->images->first()?->image_path,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
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
