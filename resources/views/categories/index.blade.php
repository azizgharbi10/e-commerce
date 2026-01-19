@extends('layouts.app')

@section('title', 'Liste des catégories')

@section('content')

<h1>Liste des catégories</h1>

@if ($categories->isEmpty())
    <p>Aucune catégorie trouvée.</p>
@else
    <ul>
        @foreach ($categories as $category)
            <li>
                <strong>{{ $category->name }}</strong><br>
                {{ $category->description }}
            </li>
        @endforeach
    </ul>
@endif

@endsection
