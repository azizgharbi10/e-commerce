<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::ordered()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.',
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], $messages);

        $slug = Str::slug($validated['name']);

        validator(
            ['slug' => $slug],
            ['slug' => ['required', 'string', Rule::unique('categories', 'slug')]],
            ['slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.']
        )->validate();

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie créée avec succès');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.',
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], $messages);

        $slug = Str::slug($validated['name']);

        validator(
            ['slug' => $slug],
            ['slug' => ['required', 'string', Rule::unique('categories', 'slug')->ignore($category->id)]],
            ['slug.unique' => 'Ce slug existe déjà, choisissez un autre nom.']
        )->validate();

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie supprimée avec succès');
    }
}
