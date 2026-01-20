@extends('layouts.admin')

@section('title', 'Admin - Ajouter produit')

@section('content')

<h1>Nouveau produit</h1>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Catégorie *</label><br>
        <select name="category_id" required>
            <option value="">-- Sélectionner --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Image du produit</label><br>
        <input type="file" name="image" accept="image/*">
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror
        <small style="color: #666;">Format: JPG, PNG, GIF (max 2MB)</small>
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Prix (€) *</label><br>
        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
        @error('price')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Stock *</label><br>
        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required>
        @error('stock')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Statut *</label><br>
        <select name="status" required>
            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Actif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
        </select>
        @error('status')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <button type="submit">Enregistrer</button>
    <a href="{{ route('admin.products.index') }}">Annuler</a>

</form>

@endsection
