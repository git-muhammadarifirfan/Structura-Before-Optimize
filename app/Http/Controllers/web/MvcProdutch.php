<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MvcProdutch extends Controller
{

    public function index(Request $request)
    {

        $request->validate([
            'sort' => 'nullable|in:price_asc,price_desc',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'query' => 'nullable|string|max:100'
        ]);

        $sort = $request->query('sort');
        $categoriesFilter = $request->query('categories'); // array kategori dari checkbox
        $priceFrom = $request->query('price_from');
        $priceTo = $request->query('price_to');
        $searchQuery = $request->query('query');

        $query = Product::query();

        // Filter berdasarkan kategori (misal kategori di-checkbox bisa lebih dari 1)
        if ($categoriesFilter && is_array($categoriesFilter)) {
            $query->whereIn('category_id', $categoriesFilter);
        }

        // Filter harga: from - to
        if ($priceFrom !== null && is_numeric($priceFrom)) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo !== null && is_numeric($priceTo)) {
            $query->where('price', '<=', $priceTo);
        }

        // Filter search nama produk
        if ($searchQuery) {
            $query->where('product_name', 'like', '%' . $searchQuery  . '%');
        }

        // Sorting
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        // Clone query untuk hitung total data sesuai filter, tanpa paginate
        $productCount = (clone $query)->count();

        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        // Versi baseline skripsi: sengaja menampilkan lebih banyak data produk dari database
        // agar halaman product terasa berat untuk pembanding sebelum optimasi.
        $products = $query->paginate(80);
        $products->withQueryString();

        $categories = Category::all();
        $featuredProducts = Product::orderByDesc('updated_at')->take(24)->get();
        $productSnapshots = Product::orderBy('product_name')->take(36)->get();

        return view('product.product', compact('products', 'productCount', 'categories', 'featuredProducts', 'productSnapshots'));
    }

    public function show($sku)
    {
        // Tetap memakai database, namun data pendukung dibuat lebih banyak untuk baseline berat.
        $product = Product::where('sku', $sku)->firstOrFail();

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(18)
            ->get();

        if ($relatedProducts->count() < 18) {
            $extraProducts = Product::where('id', '!=', $product->id)
                ->take(18 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->merge($extraProducts);
        }

        $browsingProducts = Product::where('id', '!=', $product->id)
            ->orderByDesc('updated_at')
            ->take(30)
            ->get();

        return view('product.detail-product', compact('product', 'relatedProducts', 'browsingProducts'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:100'
        ]);

        $query = $request->input('query');

        $products = Product::when($query, function ($q) use ($query) {
            $q->where('product_name', 'like', '%' . $query . '%');
        })->paginate(12);

        // Jika tidak ditemukan, arahkan ke view productnotfound
        if ($products->isEmpty()) {
            return view('errors.productnotfound', [
                'searchQuery' => $query
            ]);
        }

        $searchQuery = $query;
        $productCount = $products->total();
        $categories = Category::all();

        return view('product.product', compact('products', 'searchQuery', 'productCount', 'categories'));
    }
}
