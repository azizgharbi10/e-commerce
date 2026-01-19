<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->active()
            ->inStock()
            ->ordered()
            ->get();
            
        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])
        ->whereHas('products', function ($query) {
            $query->active()->inStock();
        })
        ->ordered()
        ->get();
        
        return view('shop.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Bloquer accès si produit inactif ou sans stock
        if ($product->status !== 'active' || $product->stock <= 0) {
            abort(404, 'Produit non disponible');
        }
        
        $product->load('category');
        
        return view('shop.products.show', compact('product'));
    }
}
