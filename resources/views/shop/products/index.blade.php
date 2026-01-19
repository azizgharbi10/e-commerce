@extends('layouts.shop')

@section('title', 'Boutique - Produits')

@section('content')

<div class="page-header mb-4">
    <h1 class="mb-1">Catalogue produits</h1>
    <p class="text-muted mb-0">Découvrez nos articles, design clair et moderne.</p>
    @if (!empty($categories) && $categories->count() > 0)
        <div class="mt-3">
            <span class="me-2 fw-semibold">Catégories:</span>
            <a class="badge badge-light-brown text-decoration-none me-1" href="{{ route('shop.products.index') }}">Tous</a>
            @foreach ($categories as $category)
                <a class="badge badge-light-brown text-decoration-none me-1" href="{{ route('shop.categories.show', $category) }}">{{ $category->name }} ({{ $category->products_count }})</a>
            @endforeach
        </div>
    @endif
</div>

@if ($products->isEmpty())
    <div class="alert alert-warning">Aucun produit disponible pour le moment.</div>
@else
    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 position-relative">
                    @if($product->stock <= 0)
                        <span class="badge bg-danger position-absolute" style="top:12px; right:12px;">Rupture</span>
                    @elseif($product->stock <= 3)
                        <span class="badge bg-warning text-dark position-absolute" style="top:12px; right:12px;">Stock limité</span>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $product->name }}</h5>
                        <p class="text-muted mb-2">Catégorie: {{ $product->category->name }}</p>
                        <p class="fw-bold mb-2">{{ number_format($product->price, 2) }} €</p>
                        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 80) }}</p>

                        <div class="mt-auto">
                            @if($product->stock > 10)
                                <span class="text-success fw-semibold">{{ $product->stock }} en stock</span>
                            @elseif($product->stock > 0)
                                <span class="text-warning fw-semibold">{{ $product->stock }} restant(s)</span>
                            @else
                                <span class="text-danger fw-semibold">Rupture de stock</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex gap-2">
                        <a href="{{ route('shop.products.show', $product) }}" class="btn btn-outline-brown flex-grow-1">Détails</a>
                        <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-brown" @if($product->stock <= 0) disabled @endif>
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
