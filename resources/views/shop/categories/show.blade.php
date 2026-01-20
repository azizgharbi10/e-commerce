@extends('layouts.shop')

@section('title', $category->name)

@section('content')

<!-- En-tête de la catégorie -->
<div class="category-header mb-5">
    <div class="row align-items-center">
        @if($category->image)
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-header-image">
            </div>
        @endif
        <div class="{{ $category->image ? 'col-md-8' : 'col-12' }}">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('shop.products.index') }}" class="btn btn-outline-brown me-3">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <a href="{{ route('shop.categories.index') }}" class="btn btn-outline-brown">
                    <i class="bi bi-grid"></i> Toutes les catégories
                </a>
            </div>
            <h1 class="category-title mb-3">{{ $category->name }}</h1>
            @if($category->description)
                <p class="category-description">{{ $category->description }}</p>
            @endif
            <div class="category-stats mt-3">
                <span class="badge bg-brown">{{ $category->products->count() }} produits</span>
            </div>
        </div>
    </div>
</div>

<!-- Produits de la catégorie -->
<div class="products-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Produits disponibles</h2>
    </div>

    @if ($category->products->isEmpty())
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Aucun produit disponible dans cette catégorie pour le moment.
        </div>
    @else
        <div class="row g-4">
            @foreach ($category->products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card h-100">
                        <!-- Image du produit -->
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80" alt="{{ $product->name }}">
                            @endif
                            
                            <!-- Badges -->
                            @if($product->stock <= 0)
                                <span class="product-badge badge-danger">Rupture</span>
                            @elseif($product->stock <= 3)
                                <span class="product-badge badge-warning">Stock limité</span>
                            @endif
                            
                            <!-- Quick view -->
                            <div class="product-actions">
                                <a href="{{ route('shop.products.show', $product) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>

                        <div class="product-body">
                            <div class="product-category">{{ $category->name }}</div>
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="product-footer">
                                <div class="product-price">
                                    <span class="price">{{ number_format($product->price, 2) }} €</span>
                                    @if($product->stock > 0)
                                        <small class="text-success">✓ En stock</small>
                                    @else
                                        <small class="text-danger">✗ Rupture</small>
                                    @endif
                                </div>
                                
                                <div class="product-buttons">
                                    <a href="{{ route('shop.products.show', $product) }}" class="btn btn-outline-brown btn-sm">Détails</a>
                                    <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-brown btn-sm" @if($product->stock <= 0) disabled @endif>
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* En-tête de catégorie */
    .category-header {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-header-image {
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-brown);
    }
    
    .category-description {
        font-size: 1.1rem;
        color: var(--text-muted);
        line-height: 1.6;
    }
    
    .category-stats .badge {
        font-size: 1rem;
        padding: 8px 16px;
    }
    
    /* Product Cards (réutilisation du style de index) */
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid var(--border-light);
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(93, 78, 55, 0.15);
    }
    
    .product-image {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: var(--cream);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
    }
    
    .badge-danger {
        background: #dc3545;
    }
    
    .badge-warning {
        background: #ffc107;
        color: #000;
    }
    
    .product-actions {
        position: absolute;
        top: 15px;
        left: 15px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .product-card:hover .product-actions {
        opacity: 1;
    }
    
    .product-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-category {
        color: var(--primary-brown);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 10px;
        line-height: 1.3;
    }
    
    .product-description {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 15px;
        flex: 1;
    }
    
    .product-footer {
        margin-top: auto;
    }
    
    .product-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .price {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--dark-brown);
    }
    
    .product-buttons {
        display: flex;
        gap: 10px;
    }
    
    .product-buttons .btn {
        flex: 1;
    }
    
    .product-buttons form {
        flex: 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .category-header {
            padding: 20px;
        }
        
        .category-title {
            font-size: 2rem;
        }
        
        .product-image {
            height: 200px;
        }
    }
</style>

@endsection
