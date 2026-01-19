@extends('layouts.shop')

@section('title', 'Boutique - Catégories')

@section('content')

<div class="page-header mb-4">
    <h1 class="mb-1">Catégories</h1>
    <p class="text-muted mb-0">Parcourez nos catégories de produits.</p>
    <div class="mt-3">
        <a class="btn btn-outline-brown" href="{{ route('shop.products.index') }}">Voir tous les produits</a>
    </div>
    
</div>

@if ($categories->isEmpty())
    <div class="alert alert-info">Aucune catégorie disponible pour le moment.</div>
@else
    <div class="row g-4">
        @foreach ($categories as $category)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $category->name }}</h5>
                        <p class="card-text text-muted mb-3">{{ Str::limit($category->description, 120) }}</p>
                        <div class="mt-auto">
                            <span class="badge badge-light-brown">{{ $category->products_count }} produit(s)</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('shop.categories.show', $category) }}" class="btn btn-brown w-100">Voir les produits</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
