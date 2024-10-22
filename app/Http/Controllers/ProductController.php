<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // show all products
    public function index()
    {
        // check products from DB
        $products = Product::all();

        return view('products.index', compact('products'));
    }
    //view single product
    // public function show($id)
    // {
    //     $product = Product::findOrFail($id);
    //     return view('products.show', compact('product'));
    // }
}
