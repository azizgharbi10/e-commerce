@extends('layouts.admin')

@section('title', 'Admin - Modifier catégorie')

@section('content')

<h1>Modifier la catégorie</h1>

<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Nom</label><br>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        @error('name')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Image</label><br>
        @if($category->image)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                <p style="font-size:0.9em; color:#666;">Image actuelle</p>
            </div>
        @endif
        <input type="file" name="image" accept="image/*">
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror
        <p style="font-size:0.9em; color:#666;">Formats acceptés : JPEG, PNG, JPG, GIF (max 8MB)</p>
    </div>

    <br>

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('admin.categories.index') }}">Annuler</a>
</form>

@endsection
