@extends('layouts.app')

@section('title', 'Modifier une catégorie')

@section('content')

<h1>Modifier la catégorie</h1>

<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nom</label><br>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description">{{ old('description', $category->description) }}</textarea>
    </div>

    <br>

    <button type="submit">Mettre à jour</button>
</form>

@endsection
