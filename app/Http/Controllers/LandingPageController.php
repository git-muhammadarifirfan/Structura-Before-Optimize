<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        if ($user?->role === 'admin' || $user?->role === 'super-admin') {
            return redirect('/structuradmin');
        }

        $latestProducts = Product::orderBy('id', 'desc')->take(4)->get();
        $categories = Category::all();

        return view('home.landingpage', compact('latestProducts', 'categories'));
    }
}
