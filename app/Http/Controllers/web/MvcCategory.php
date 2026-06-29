<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MvcCategory extends Controller
{
    public function showByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id);

        // Filter harga
        if ($request->filled('price_from')) {
            $products->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $products->where('price', '<=', $request->price_to);
        }

        // Sort
        if ($request->sort === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $products->orderBy('price', 'desc');
        } else {
            $products->latest(); // default sort
        }

        $products = $products->get();

        return view('product.by-category', compact('category', 'products'));
    }
}
