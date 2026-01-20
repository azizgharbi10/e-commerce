@extends('layouts.admin')

@section('title', 'Admin - Ajouter catégorie')

@section('content')

<h1>Nouvelle catégorie</h1>

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Nom</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>Image</label><br>
        <input type="file" name="image" accept="image/*">
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror
        <p style="font-size:0.9em; color:#666;">Formats acceptés : JPEG, PNG, JPG, GIF (max 8MB)</p>
    </div>

    <br>

    <button type="submit">Enregistrer</button>
    <a href="{{ route('admin.categories.index') }}">Annuler</a>

</form>

@endsection
