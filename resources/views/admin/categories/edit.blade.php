@extends('layouts.admin')

@section('title', 'Admin - Modifier catégorie')

@section('content')

<h1>Modifier la catégorie</h1>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
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

    <button type="submit">Mettre à jour</button>
    <a href="{{ route('admin.categories.index') }}">Annuler</a>
</form>

@endsection
