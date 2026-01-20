@extends('layouts.admin')

@section('title', 'Admin - Modifier produit')

@section('content')

<h1>Modifier le produit</h1>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Catégorie *</label><br>
        <select name="category_id" required>
            <option value="">-- Sélectionner --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Nom *</label><br>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        @error('name')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Image du produit</label><br>
        @if($product->image)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 8px;">
                <br>
                <label style="margin-top: 5px;">
                    <input type="checkbox" name="remove_image" value="1">
                    Supprimer l'image actuelle
                </label>
            </div>
        @endif
        <input type="file" name="image" accept="image/*">
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror
        <small style="color: #666;">Format: JPG, PNG, GIF (max 15MB)</small>
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Prix (€) *</label><br>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
        @error('price')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Stock *</label><br>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
        @error('stock')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Statut *</label><br>
        <select name="status" required>
            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Actif</option>
            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
        </select>
        @error('status')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('admin.products.index') }}">Annuler</a>

</form>

@endsection
