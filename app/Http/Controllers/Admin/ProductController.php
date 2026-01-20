<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->ordered()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne dépasse pas 255 caractères.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix doit être supérieur ou égal à 0.',
            'stock.required' => 'Le stock est obligatoire.',
            'stock.integer' => 'Le stock doit être un nombre entier.',
            'stock.min' => 'Le stock doit être supérieur ou égal à 0.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être "active" ou "inactive".',
            'slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif.',
            'image.max' => 'L\'image ne doit pas dépasser 15MB.',
        ];

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            // Autorise jusqu'à 15 Mo pour les images produit
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:15360'],
        ], $messages);

        $slug = Str::slug($validated['name']);

        validator(
            ['slug' => $slug],
            ['slug' => ['required', 'string', Rule::unique('products', 'slug')]],
            ['slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.']
        )->validate();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produit créé avec succès');
    }

    public function edit(Product $product)
    {
        $categories = Category::ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.max' => 'Le nom ne dépasse pas 255 caractères.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix doit être supérieur ou égal à 0.',
            'stock.required' => 'Le stock est obligatoire.',
            'stock.integer' => 'Le stock doit être un nombre entier.',
            'stock.min' => 'Le stock doit être supérieur ou égal à 0.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être "active" ou "inactive".',
            'slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif.',
            'image.max' => 'L\'image ne doit pas dépasser 15MB.',
        ];

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            // Autorise jusqu'à 15 Mo pour les images produit
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:15360'],
        ], $messages);

        $slug = Str::slug($validated['name']);

        validator(
            ['slug' => $slug],
            ['slug' => ['required', 'string', Rule::unique('products', 'slug')->ignore($product->id)]],
            ['slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.']
        )->validate();

        $imagePath = $product->image;
        
        // Supprimer l'image si demandé
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = null;
        }
        
        // Upload nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produit supprimé avec succès');
    }
}
