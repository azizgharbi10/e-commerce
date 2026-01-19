@extends('layouts.app')

@section('title', $product->name)

@section('content')

<h1>{{ $product->name }}</h1>

<p><strong>Catégorie :</strong> {{ $product->category->name }}</p>
<p><strong>Prix :</strong> {{ number_format($product->price, 2) }} €</p>
<p><strong>Stock :</strong> {{ $product->stock }}</p>
<p><strong>Statut :</strong> {{ $product->status === 'active' ? 'Actif' : 'Inactif' }}</p>
<p><strong>Description :</strong></p>
<p>{{ $product->description ?? 'Aucune description' }}</p>

<br>

<a href="{{ route('products.edit', $product) }}">Modifier</a> |
<a href="{{ route('products.index') }}">Retour à la liste</a>

@endsection
