<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])
        ->has('products', '>=', 1)
        ->whereHas('products', function ($query) {
            $query->active()->inStock();
        })
        ->ordered()
        ->get();
        
        return view('shop.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load(['products' => function ($query) {
            $query->active()->inStock()->ordered();
        }]);
        
        // Rediriger si aucun produit actif disponible
        if ($category->products->isEmpty()) {
            return redirect()->route('shop.categories.index')
                           ->with('warning', 'Cette catégorie ne contient aucun produit disponible.');
        }
        
        return view('shop.categories.show', compact('category'));
    }
}
