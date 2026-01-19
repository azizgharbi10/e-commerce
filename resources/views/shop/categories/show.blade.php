@extends('layouts.shop')

@section('title', $category->name)

@section('content')

<h1>{{ $category->name }}</h1>

<p>{{ $category->description }}</p>

<br>

<a href="{{ route('shop.categories.index') }}">← Toutes les catégories</a>

<h2 style="margin-top: 30px;">Produits de cette catégorie</h2>

@if ($category->products->isEmpty())
    <p>Aucun produit disponible dans cette catégorie.</p>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        @foreach ($category->products as $product)
            <div style="border: 1px solid #ccc; padding: 15px;">
                <h3>{{ $product->name }}</h3>
                <p><strong>{{ number_format($product->price, 2) }} €</strong></p>
                <p>{{ Str::limit($product->description, 80) }}</p>
                @if ($product->stock > 0)
                    <p style="color: green; font-size: 0.9em;">En stock</p>
                @else
                    <p style="color: red; font-size: 0.9em;">Rupture</p>
                @endif
                <a href="{{ route('shop.products.show', $product) }}">Voir détails</a>
            </div>
        @endforeach
    </div>
@endif

@endsection
