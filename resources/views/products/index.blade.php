@extends('layouts.app')

@section('title', 'Liste des produits')

@section('content')

<h1>Liste des produits</h1>

<a href="{{ route('products.create') }}">➕ Ajouter un produit</a>

@if ($products->isEmpty())
    <p>Aucun produit trouvé.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ number_format($product->price, 2) }} €</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->status === 'active' ? 'Actif' : 'Inactif' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}">Modifier</a>
                        |
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
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
