<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category = null)
    {
        $query = Product::query();

        // ✅ Category filter
        if ($category) {
            $query->where('category_id', $category->id);
        }

        // ✅ Search filter
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->with('images')->latest()->paginate(12);

        return view('frontend.pages.products.index', compact('products', 'category'));
    }

    public function categoryProducts(Request $request, Category $category)
    {
        $query = Product::where('category_id', $category->id);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->with('images')->latest()->paginate(12);

        return view('frontend.pages.products.index', compact('products', 'category'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('frontend.pages.products.show', compact('product'));
    }


}
