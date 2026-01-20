@extends('layouts.admin')

@section('title', 'Admin - Catégories')

@section('content')

<h1>Gestion des catégories</h1>

<a href="{{ route('admin.categories.create') }}">➕ Ajouter une catégorie</a>

@if ($categories->isEmpty())
    <p>Aucune catégorie trouvée.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 80px; height: 80px; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                <span style="color: #999; font-size: 0.8em;">Pas d'image</span>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}">Modifier</a>
                        |
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
