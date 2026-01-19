@extends('layouts.app')

@section('title', 'Ajouter une catégorie')

@section('content')

<h1>Nouvelle catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <div>
        <label>Nom</label><br>
        <input type="text" name="name" required>
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description"></textarea>
    </div>

    <br>

    <button type="submit">Enregistrer</button>

</form>

@endsection
