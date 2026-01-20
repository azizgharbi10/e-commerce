@extends('layouts.shop')

@section('title', 'Tous les Produits')

@section('content')

<!-- Hero Section -->
<div class="hero-section mb-5">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="display-4 fw-bold mb-3">Tous les Produits</h1>
        <p class="lead mb-4">Découvrez notre collection complète</p>
    </div>
</div>

<!-- Section Produits -->
<div class="products-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <i class="bi bi-shop"></i> Nos Produits
            </h2>
            <p class="section-subtitle">{{ $products->total() }} produits disponibles</p>
        </div>
    </div>

    @if ($products->isEmpty())
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Aucun produit disponible pour le moment.
        </div>
    @else
        <div class="row g-4" id="productsGrid">
            @foreach ($products as $product)
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
                            
                            <!-- Quick view button -->
                            <a href="{{ route('shop.products.show', $product) }}" class="product-actions" title="Voir les détails">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>

                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name }}</div>
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="product-footer">
                                <div class="product-price">
                                    {{ number_format($product->price, 2) }} €
                                </div>
                                
                                @if($product->stock > 0)
                                    <span class="stock-status high">
                                        <i class="bi bi-check-circle"></i> En stock
                                    </span>
                                @else
                                    <span class="stock-status low">
                                        <i class="bi bi-x-circle"></i> Rupture
                                    </span>
                                @endif
                            </div>
                            
                            <div class="product-buttons">
                                <a href="{{ route('shop.products.show', $product) }}" class="btn btn-outline-brown">Détails</a>
                                <form action="{{ route('shop.cart.add', $product) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-brown w-100" @if($product->stock <= 0) disabled @endif>
                                        <i class="bi bi-cart-plus"></i> Ajouter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
    /* Hero Section avec images d'arrière-plan */
    .hero-section {
        position: relative;
        height: 450px;
        border-radius: 20px;
        overflow: hidden;
        background-image: 
            url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=80'),
            url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800&q=80');
        background-size: cover, 40%;
        background-position: center, right bottom;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(93, 78, 55, 0.85) 0%, rgba(139, 111, 71, 0.75) 100%);
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        max-width: 800px;
        padding: 0 20px;
    }
    
    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--border-light);
    }
    
    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
        letter-spacing: -0.5px;
    }
    
    .section-title i {
        font-size: 2.5rem;
        color: var(--primary-brown);
    }
    
    .section-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
        margin: 8px 0 0 0;
    }
    
    /* Product Cards */
    .product-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid transparent;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-card:hover {
        box-shadow: 0 12px 40px rgba(93, 78, 55, 0.15);
        transform: translateY(-8px);
        border-color: var(--primary-brown);
    }
    
    .product-image {
        position: relative;
        width: 100%;
        padding-bottom: 100%;
        overflow: hidden;
        background: linear-gradient(135deg, var(--cream-bg) 0%, #fffbf7 100%);
    }
    
    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.12);
    }
    
    .product-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, var(--primary-brown) 0%, var(--dark-brown) 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 25px;
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 12px rgba(93, 78, 55, 0.3);
    }
    
    .badge-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    
    .badge-warning {
        background: linear-gradient(135deg, #ff9800 0%, #e67e22 100%);
        color: white;
    }
    
    .product-actions {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: white;
        border: 2px solid var(--primary-brown);
        color: var(--primary-brown);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(10px);
        font-size: 1.3rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-decoration: none;
    }
    
    .product-image:hover .product-actions {
        opacity: 1;
        transform: translateY(0);
    }
    
    .product-actions:hover {
        background: var(--primary-brown);
        color: white;
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
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: block;
    }
    
    .product-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 8px;
        line-height: 1.3;
        min-height: 2.6em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-description {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid rgba(139, 111, 71, 0.1);
    }
    
    .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-brown);
    }
    
    .stock-status {
        font-size: 0.8rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.2px;
    }
    
    .stock-status.low {
        background: rgba(255, 193, 7, 0.2);
        color: #ff9800;
    }
    
    .stock-status.high {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
    }
    
    .product-buttons {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }
    
    .product-buttons .btn {
        flex: 1;
        padding: 10px 12px;
        font-size: 0.85rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: none;
    }
    
    .product-buttons .btn-brown {
        background: linear-gradient(135deg, var(--primary-brown) 0%, var(--dark-brown) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(93, 78, 55, 0.2);
    }
    
    .product-buttons .btn-brown:hover {
        background: linear-gradient(135deg, var(--dark-brown) 0%, #3d2817 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(93, 78, 55, 0.3);
    }
    
    .product-buttons .btn-outline-brown {
        background: white;
        border: 2px solid var(--primary-brown);
        color: var(--primary-brown);
    }
    
    .product-buttons .btn-outline-brown:hover {
        background: var(--primary-brown);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(93, 78, 55, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            height: 320px;
            border-radius: 12px;
        }
        
        .hero-content h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .section-title {
            font-size: 1.4rem;
        }
        
        .section-title i {
            font-size: 1.6rem;
        }
        
        .product-card {
            border-radius: 15px;
        }
        
        .product-body {
            padding: 15px;
        }
        
        .product-title {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }
        
        .product-description {
            font-size: 0.8rem;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-size: 1.1rem;
        }
        
        .product-buttons .btn {
            padding: 8px 10px;
            font-size: 0.8rem;
        }
    }
</style>

@endsection
