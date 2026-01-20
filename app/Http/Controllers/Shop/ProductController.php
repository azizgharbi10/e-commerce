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
            ->paginate(12);
            
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

    public function search()
    {
        $query = request('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'categories' => []
            ]);
        }
        
        // Recherche de catégories
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->withCount('products')
            ->limit(3)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ? asset('storage/' . $category->image) : null,
                    'products_count' => $category->products_count
                ];
            });
        
        // Recherche de produits
        $products = Product::with('category')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->active()
            ->inStock()
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'category' => $product->category->name,
                    'image' => $product->image ? asset('storage/' . $product->image) : null
                ];
            });
        
        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]);
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
