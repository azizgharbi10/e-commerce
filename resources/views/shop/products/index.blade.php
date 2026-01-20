@extends('layouts.shop')

@section('title', 'Boutique - Produits')

@section('content')

<!-- Hero Section avec barre de recherche -->
<div class="hero-section mb-5">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="display-4 fw-bold mb-3">Découvrez Notre Collection</h1>
        <p class="lead mb-4">Des produits de qualité sélectionnés avec soin pour vous</p>
        
        <!-- Barre de recherche dynamique -->
        <div class="search-container">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des produits ou catégories...">
                <div id="searchResults" class="search-results"></div>
            </div>
        </div>
    </div>
</div>

<!-- Section Catégories avec images - REDESIGNÉE -->
<div class="categories-section mb-5">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <i class="bi bi-grid-3x3-gap"></i> Nos Catégories
            </h2>
            <p class="section-subtitle">Explorez nos collections triées sur le volet</p>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('shop.products.all') }}" class="category-card-modern">
                <div class="category-image-modern" style="background-image: url({{ asset('img/vetements_mx.png') }});"></div>
                <div class="category-content-modern">
                    <h5>Tous les produits</h5>
                    <div class="category-count">{{ $products->total() }} articles</div>
                </div>
                <div class="category-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>
        
        @foreach ($categories as $category)
            <div class="col-6 col-md-3">
                <a href="{{ route('shop.categories.show', $category) }}" class="category-card-modern">
                    <div class="category-image-modern" style="background-image: url('{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=400&q=80' }}');"></div>
                    <div class="category-content-modern">
                        <h5>{{ $category->name }}</h5>
                        <div class="category-count">{{ $category->products_count }} articles</div>
                    </div>
                    <div class="category-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<!-- Section Produits -->
<div class="products-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <i class="bi bi-shop"></i> Nos Produits
            </h2>
            <p class="section-subtitle">{{ $products->total() }} produits sélectionnés pour vous</p>
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

<!-- Section Nos Services -->
<div class="services-section mb-5">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <i class="bi bi-star"></i> Nos Services
            </h2>
            <p class="section-subtitle">Découvrez nos avantages et garanties</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-3 col-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h6>Livraison Rapide</h6>
                <p>Expédition sous 24h</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6>Paiement Sécurisé</h6>
                <p>100% sécurisé</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
                <h6>Retour Gratuit</h6>
                <p>30 jours pour changer d'avis</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <h6>Support 24/7</h6>
                <p>Service client à votre écoute</p>
            </div>
        </div>
    </div>
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
    
    /* Barre de recherche */
    .search-container {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.2rem;
    }
    
    .search-box input {
        padding: 15px 20px 15px 55px;
        border-radius: 50px;
        border: none;
        font-size: 1rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }
    
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 15px;
        margin-top: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        max-height: 400px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
    }
    
    .search-results.show {
        display: block;
    }
    
    .search-result-item {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-light);
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .search-result-item:hover {
        background: var(--cream);
    }
    
    .search-result-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .search-result-info {
        flex: 1;
        color: var(--text-dark);
    }
    
    .search-result-info strong {
        display: block;
        margin-bottom: 3px;
    }
    
    .search-result-info small {
        color: var(--text-muted);
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
    
    /* Catégories redesignées */
    .category-card-modern {
        display: block;
        position: relative;
        height: 220px;
        border-radius: 18px;
        overflow: hidden;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid transparent;
        group: "category";
    }
    
    .category-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(93, 78, 55, 0.15);
        border-color: var(--primary-brown);
    }
    
    .category-card-modern.active {
        border-color: var(--primary-brown);
        box-shadow: 0 8px 30px rgba(93, 78, 55, 0.2);
    }
    
    .category-image-modern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease;
    }
    
    .category-card-modern:hover .category-image-modern {
        transform: scale(1.08);
    }
    
    .category-content-modern {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.9) 100%);
        color: white;
        padding: 20px 18px;
        text-align: center;
    }
    
    .category-content-modern h5 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: -0.3px;
    }
    
    .category-count {
        font-size: 0.85rem;
        opacity: 0.9;
        font-weight: 500;
    }
    
    .category-arrow {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-brown);
        font-size: 1.3rem;
        opacity: 0;
        transition: all 0.3s ease;
        transform: translateX(-10px);
    }
    
    .category-card-modern:hover .category-arrow {
        opacity: 1;
        transform: translateX(0);
    }
    
    /* Catégories avec images - ancien style */
    .category-card {
        display: block;
        position: relative;
        height: 200px;
        border-radius: 15px;
        overflow: hidden;
        text-decoration: none;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .category-card.active {
        border: 3px solid var(--primary-brown);
    }
    
    .category-image {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
    }
    
    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .category-overlay h5 {
        font-weight: 700;
        margin-bottom: 3px;
    }
    
    /* Services Section - Professionnel */
    .services-section {
        background: linear-gradient(135deg, rgba(139, 111, 71, 0.05) 0%, rgba(212, 165, 116, 0.05) 100%);
        border-radius: 20px;
        padding: 40px 30px;
        margin: 60px 0;
    }
    
    .service-card {
        background: white;
        border-radius: 15px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }
    
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(93, 78, 55, 0.12);
        border-color: var(--primary-brown);
    }
    
    .service-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.2rem;
        box-shadow: 0 8px 20px rgba(93, 78, 55, 0.2);
        transition: all 0.3s ease;
    }
    
    .service-card:hover .service-icon {
        transform: scale(1.1);
        box-shadow: 0 12px 30px rgba(93, 78, 55, 0.3);
    }
    
    .service-card h6 {
        color: var(--dark-brown);
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.05rem;
        letter-spacing: -0.3px;
    }
    
    .service-card p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    /* Product Cards - Redesign Professionnel */
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
    
    .product-price .price-old {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-right: 5px;
        font-weight: 500;
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
    @media (max-width: 992px) {
        .hero-section {
            height: 400px;
            border-radius: 15px;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .section-header {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .section-title i {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            height: 320px;
            border-radius: 12px;
        }
        
        .hero-content {
            padding: 0 20px;
        }
        
        .hero-content h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .hero-content p.lead {
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        
        .section-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
        }
        
        .section-title {
            font-size: 1.4rem;
        }
        
        .section-title i {
            font-size: 1.6rem;
        }
        
        .section-subtitle {
            font-size: 0.9rem;
        }
        
        .category-card-modern {
            height: 180px;
        }
        
        .category-content-modern {
            padding: 15px 12px;
        }
        
        .category-content-modern h5 {
            font-size: 1rem;
        }
        
        .category-count {
            font-size: 0.75rem;
        }
        
        .services-section {
            padding: 25px 20px;
            margin: 40px 0;
        }
        
        .service-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .service-card h6 {
            font-size: 0.95rem;
        }
        
        .service-card p {
            font-size: 0.85rem;
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
        
        .product-actions {
            width: 38px;
            height: 38px;
            font-size: 1.1rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-section {
            height: 280px;
        }
        
        .hero-content h1 {
            font-size: 1.5rem;
        }
        
        .search-box {
            margin: 0 -10px;
        }
        
        .section-title {
            font-size: 1.2rem;
            gap: 10px;
        }
        
        .section-title i {
            font-size: 1.4rem;
        }
        
        .category-card-modern {
            height: 160px;
        }
        
        .product-badge {
            top: 8px;
            right: 8px;
            padding: 4px 10px;
            font-size: 0.7rem;
        }
        
        .product-category {
            font-size: 0.75rem;
            margin-bottom: 8px;
        }
        
        .product-title {
            font-size: 0.9rem;
        }
        
        .product-footer {
            padding-top: 8px;
            gap: 5px;
        }
    }
</style>

<script>
    // Recherche dynamique
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.remove('show');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`/shop/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => console.error('Erreur de recherche:', error));
        }, 300);
    });
    
    function displaySearchResults(data) {
        if (data.products.length === 0 && data.categories.length === 0) {
            searchResults.innerHTML = '<div class="search-result-item">Aucun résultat trouvé</div>';
            searchResults.classList.add('show');
            return;
        }
        
        let html = '';
        
        // Catégories
        if (data.categories.length > 0) {
            html += '<div class="p-3 fw-bold text-muted" style="font-size: 0.85rem;">CATÉGORIES</div>';
            data.categories.forEach(category => {
                html += `
                    <a href="/shop/categories/${category.slug}" class="search-result-item text-decoration-none">
                        <img src="${category.image || 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=100&q=80'}" alt="${category.name}">
                        <div class="search-result-info">
                            <strong>${category.name}</strong>
                            <small>${category.products_count} produits</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                `;
            });
        }
        
        // Produits
        if (data.products.length > 0) {
            html += '<div class="p-3 fw-bold text-muted" style="font-size: 0.85rem;">PRODUITS</div>';
            data.products.forEach(product => {
                html += `
                    <a href="/shop/products/${product.id}" class="search-result-item text-decoration-none">
                        <img src="${product.image || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&q=80'}" alt="${product.name}">
                        <div class="search-result-info">
                            <strong>${product.name}</strong>
                            <small>${product.category} • ${product.price} €</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                `;
            });
        }
        
        searchResults.innerHTML = html;
        searchResults.classList.add('show');
    }
    
    // Fermer les résultats en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });
    
    // Toggle vue grille/liste
    document.querySelectorAll('[data-view]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('[data-view]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            const grid = document.getElementById('productsGrid');
            
            if (view === 'list') {
                grid.classList.remove('row');
                grid.classList.add('d-flex', 'flex-column', 'gap-3');
            } else {
                grid.classList.add('row');
                grid.classList.remove('d-flex', 'flex-column', 'gap-3');
            }
        });
    });
</script>

@endsection


