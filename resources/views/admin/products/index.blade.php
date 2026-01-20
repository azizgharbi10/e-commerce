@extends('layouts.admin')

@section('title', 'Admin - Produits')

@section('content')

<h1>Gestion des produits</h1>

<a href="{{ route('admin.products.create') }}">➕ Ajouter un produit</a>

@if ($products->isEmpty())
    <p>Aucun produit trouvé.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Image</th>
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
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        @else
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">
                                Pas d'image
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ number_format($product->price, 2) }} €</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->status === 'active' ? 'Actif' : 'Inactif' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}">Modifier</a>
                        |
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
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
