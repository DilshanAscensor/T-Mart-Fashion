<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\WishlistItem;
use Exception;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $wishlistItems = Auth::user()
                ->wishlistItems()
                ->with('product.images')
                ->get();

            return view('frontend.wishlist.index', compact('wishlistItems'));
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function store($productId)
    {

        WishlistItem::firstOrCreate([
            'user_id' => 1,
            'product_id' => 1
        ]);

        return back()->with('success', 'Added to wishlist');
    }

    public function destroy($productId)
    {
        WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'Removed from wishlist');
    }
}
