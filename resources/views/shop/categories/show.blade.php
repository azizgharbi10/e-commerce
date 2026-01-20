@extends('layouts.shop')

@section('title', $category->name)

@section('content')

<style>
    /* ======================== HERO SECTION ======================== */
    .category-hero {
        position: relative;
        min-height: 500px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 4rem;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.15);
    }

    .category-hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.95);
    }

    .category-hero-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
    }

    .category-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(93, 78, 55, 0.7) 0%, rgba(91, 68, 34, 0.8) 100%);
        backdrop-filter: blur(2px);
    }

    .category-hero-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 3rem;
        z-index: 10;
        color: white;
    }

    /* Breadcrumb */
    .category-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .breadcrumb-link {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .breadcrumb-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .breadcrumb-separator {
        opacity: 0.6;
    }

    .breadcrumb-current {
        opacity: 0.8;
        font-weight: 500;
    }

    /* Hero Titles */
    .category-hero-title {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 700;
        margin: 0.5rem 0;
        color: white;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        letter-spacing: -1px;
    }

    .category-hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.95);
        max-width: 600px;
        margin: 1rem 0 2rem;
        line-height: 1.6;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        font-weight: 400;
    }

    /* Statistics */
    .category-hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        width: 100%;
        max-width: 500px;
    }

    .stat {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stat:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-3px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #FFD700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.85);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }

    /* ======================== NAVIGATION BUTTONS ======================== */
    .category-nav {
        display: flex;
        gap: 1rem;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
    }

    .btn-back {
        background: #8B6F47;
        color: white;
    }

    .btn-back:hover {
        background: #5D4E37;
        transform: translateX(-3px);
        box-shadow: 0 5px 15px rgba(93, 78, 55, 0.3);
    }

    .btn-all-categories {
        background: transparent;
        color: #8B6F47;
        border: 2px solid #8B6F47;
    }

    .btn-all-categories:hover {
        background: #8B6F47;
        color: white;
        box-shadow: 0 5px 15px rgba(139, 111, 71, 0.3);
    }

    /* ======================== PRODUCTS SHOWCASE ======================== */
    .products-showcase {
        margin: 4rem 0;
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .products-header-left {
        flex: 1;
    }

    .section-title-large {
        font-size: 2rem;
        font-weight: 700;
        color: #5D4E37;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .section-title-large i {
        color: #8B6F47;
        font-size: 2.2rem;
    }

    .section-subtitle {
        color: #888;
        font-size: 1rem;
        margin: 0;
    }

    .products-header-right {
        display: flex;
        align-items: center;
    }

    .sort-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sort-label {
        font-weight: 600;
        color: #5D4E37;
        margin: 0;
    }

    .sort-select {
        padding: 0.75rem 1rem;
        border: 2px solid #D4A574;
        border-radius: 12px;
        background: white;
        color: #5D4E37;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sort-select:hover,
    .sort-select:focus {
        border-color: #8B6F47;
        background: #FFFBF7;
        outline: none;
    }

    /* ======================== EMPTY STATE ======================== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #F5F1ED 0%, #FFFBF7 100%);
        border-radius: 20px;
        border: 2px dashed #D4A574;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #D4A574;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #5D4E37;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #888;
        margin-bottom: 2rem;
    }

    /* ======================== PRODUCTS GRID ======================== */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .product-showcase-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        transition: all 0.3s ease;
        animation: cardFadeIn 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes cardFadeIn {
        to {
            opacity: 1;
        }
    }

    .product-showcase-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(93, 78, 55, 0.15);
    }

    /* Product Image */
    .product-showcase-image {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: #f5f5f5;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-showcase-card:hover .product-img {
        transform: scale(1.08);
    }

    /* Product Overlay */
    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(93, 78, 55, 0.85);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 5;
    }

    .product-showcase-card:hover .product-overlay {
        opacity: 1;
    }

    .overlay-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #8B6F47;
    }

    .btn-view:hover {
        background: #FFD700;
        color: #5D4E37;
        transform: scale(1.05);
    }

    .btn-add {
        background: #FFD700;
        color: #5D4E37;
    }

    .btn-add:hover:not(:disabled) {
        background: #8B6F47;
        color: white;
        transform: scale(1.05);
    }

    .btn-add:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .overlay-form {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    /* Product Badges */
    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .badge-rupture {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    .badge-limited {
        background: rgba(255, 193, 7, 0.9);
        color: #5D4E37;
    }

    .badge-available {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }

    /* Price Badge */
    .price-badge {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: #5D4E37;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        z-index: 10;
    }

    /* Product Info */
    .product-showcase-info {
        padding: 1.5rem;
    }

    .product-meta {
        margin-bottom: 0.75rem;
    }

    .category-tag {
        display: inline-block;
        background: #F5F1ED;
        color: #8B6F47;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-showcase-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        min-height: 2.8em;
    }

    .product-showcase-description {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1.25rem;
        line-height: 1.5;
        min-height: 1.8em;
    }

    /* Product Footer */
    .product-showcase-footer {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .stock-indicator {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .stock-bar {
        height: 6px;
        background: #E8E8E8;
        border-radius: 3px;
        overflow: hidden;
    }

    .stock-fill {
        height: 100%;
        background: linear-gradient(90deg, #8B6F47 0%, #FFD700 100%);
        transition: width 0.3s ease;
    }

    .stock-indicator small {
        font-size: 0.8rem;
        color: #999;
        font-weight: 500;
    }

    .view-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #8B6F47;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .view-link:hover {
        color: #5D4E37;
        gap: 0.75rem;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 992px) {
        .category-hero {
            min-height: 400px;
        }

        .category-hero-content {
            padding: 2rem;
        }

        .category-hero-title {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
        }

        .category-hero-subtitle {
            font-size: 1rem;
        }

        .category-hero-stats {
            gap: 1.5rem;
            max-width: 100%;
        }

        .stat {
            flex: 1;
            padding: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .products-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .products-header-right {
            width: 100%;
            justify-content: flex-start;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .category-hero {
            min-height: 350px;
            margin-bottom: 2rem;
        }

        .category-hero-content {
            padding: 1.5rem;
        }

        .category-hero-title {
            font-size: 1.75rem;
        }

        .category-hero-subtitle {
            font-size: 0.95rem;
            max-width: 100%;
        }

        .category-hero-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .stat {
            padding: 0.75rem;
        }

        .stat-number {
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        .category-breadcrumb {
            font-size: 0.85rem;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .product-showcase-image {
            height: 200px;
        }

        .overlay-btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .section-title-large {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .category-hero {
            min-height: 280px;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .category-hero-content {
            padding: 1rem;
            justify-content: flex-end;
            padding-bottom: 2rem;
        }

        .category-hero-title {
            font-size: 1.35rem;
            margin-bottom: 0.25rem;
        }

        .category-hero-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .category-breadcrumb {
            font-size: 0.75rem;
            gap: 0.5rem;
            margin-bottom: 1rem !important;
        }

        .category-hero-stats {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .stat {
            flex-direction: row;
            align-items: center;
            padding: 0.75rem 1rem;
            gap: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .stat-label {
            font-size: 0.65rem;
        }

        .category-nav {
            flex-direction: column;
        }

        .nav-btn {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1rem;
        }

        .products-header {
            flex-direction: column;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .sort-container {
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
        }

        .sort-select {
            width: 100%;
        }

        .products-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .product-showcase-image {
            height: 180px;
        }

        .section-title-large {
            font-size: 1.25rem;
        }

        .section-subtitle {
            font-size: 0.9rem;
        }

        .product-showcase-title {
            font-size: 1rem;
            min-height: auto;
        }

        .price-badge {
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state-icon {
            font-size: 3rem;
        }
    }
</style>

<!-- Header Hero Spectaculaire -->
<div class="category-hero mb-5">
    @if($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-hero-image">
    @else
        <div class="category-hero-placeholder"></div>
    @endif
    
    <div class="category-hero-overlay"></div>
    
    <div class="category-hero-content">
        <div class="category-breadcrumb mb-3">
            <a href="{{ route('shop.products.index') }}" class="breadcrumb-link">
                <i class="bi bi-house"></i> Accueil
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $category->name }}</span>
        </div>
        
        <h1 class="category-hero-title">{{ $category->name }}</h1>
        
        @if($category->description)
            <p class="category-hero-subtitle">{{ $category->description }}</p>
        @endif
        
        <div class="category-hero-stats">
            <div class="stat">
                <div class="stat-number">{{ $category->products->count() }}</div>
                <div class="stat-label">Produits</div>
            </div>
            <div class="stat">
                <div class="stat-number">{{ number_format($category->products->avg('price'), 0) }}€</div>
                <div class="stat-label">Prix moyen</div>
            </div>
            <div class="stat">
                <div class="stat-number">{{ $category->products->where('stock', '>', 0)->count() }}</div>
                <div class="stat-label">En stock</div>
            </div>
        </div>
    </div>
</div>

<!-- Boutons de navigation -->
<div class="category-nav mb-5">
    <a href="{{ route('shop.products.index') }}" class="nav-btn btn-back">
        <i class="bi bi-arrow-left"></i> Retour à la boutique
    </a>
    <a href="{{ route('shop.categories.index') }}" class="nav-btn btn-all-categories">
        <i class="bi bi-grid-3x3-gap"></i> Toutes les catégories
    </a>
</div>

<!-- Section Produits Professionnelle -->
<div class="products-showcase">
    <!-- En-tête section produits -->
    <div class="products-header mb-5">
        <div class="products-header-left">
            <h2 class="section-title-large">
                <i class="bi bi-shop"></i> Nos Produits
            </h2>
            <p class="section-subtitle">Découvrez notre sélection complète de {{ $category->products->count() }} article(s)</p>
        </div>
        
        <div class="products-header-right">
            <div class="sort-container">
                <label for="sortBy" class="sort-label">Trier par:</label>
                <select id="sortBy" class="sort-select">
                    <option value="newest">Les plus récents</option>
                    <option value="price-asc">Prix: croissant</option>
                    <option value="price-desc">Prix: décroissant</option>
                    <option value="name">Alphabétique</option>
                </select>
            </div>
        </div>
    </div>

    @if ($category->products->isEmpty())
        <!-- État vide innovant -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3>Aucun produit pour le moment</h3>
            <p>Revenez bientôt ! De nouveaux produits arrivent régulièrement.</p>
            <a href="{{ route('shop.products.index') }}" class="btn btn-brown-large">
                <i class="bi bi-arrow-left"></i> Retour à la boutique
            </a>
        </div>
    @else
        <!-- Grille de produits innovante -->
        <div class="products-grid">
            @foreach ($category->products as $index => $product)
                <div class="product-showcase-card" style="animation-delay: {{ $index * 0.1 }}s">
                    <!-- Image avec overlay interactif -->
                    <div class="product-showcase-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                        @else
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80" alt="{{ $product->name }}" class="product-img">
                        @endif
                        
                        <!-- Overlay avec action buttons -->
                        <div class="product-overlay">
                            <a href="{{ route('shop.products.show', $product) }}" class="overlay-btn btn-view">
                                <i class="bi bi-eye"></i>
                                <span>Vue détaillée</span>
                            </a>
                            <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="overlay-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="overlay-btn btn-add" @if($product->stock <= 0) disabled @endif>
                                    <i class="bi bi-cart-plus"></i>
                                    <span>@if($product->stock > 0) Ajouter @else Rupture @endif</span>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Badges -->
                        <div class="product-badges">
                            @if($product->stock <= 0)
                                <span class="badge badge-rupture">
                                    <i class="bi bi-exclamation-circle"></i> Rupture
                                </span>
                            @elseif($product->stock <= 3)
                                <span class="badge badge-limited">
                                    <i class="bi bi-exclamation-triangle"></i> Stock limité
                                </span>
                            @else
                                <span class="badge badge-available">
                                    <i class="bi bi-check-circle"></i> Disponible
                                </span>
                            @endif
                        </div>
                        
                        <!-- Prix sur image -->
                        <div class="price-badge">
                            {{ number_format($product->price, 2) }}€
                        </div>
                    </div>
                    
                    <!-- Informations produit -->
                    <div class="product-showcase-info">
                        <div class="product-meta">
                            <span class="category-tag">{{ $category->name }}</span>
                        </div>
                        
                        <h3 class="product-showcase-title">{{ $product->name }}</h3>
                        
                        <p class="product-showcase-description">
                            {{ Str::limit($product->description, 75) }}
                        </p>
                        
                        <div class="product-showcase-footer">
                            <div class="stock-indicator">
                                <div class="stock-bar">
                                    <div class="stock-fill" style="width: {{ min(($product->stock / 10) * 100, 100) }}%"></div>
                                </div>
                                <small>{{ $product->stock }} en stock</small>
                            </div>
                            
                            <a href="{{ route('shop.products.show', $product) }}" class="view-link">
                                Voir plus <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du tri des produits
        const sortSelect = document.getElementById('sortBy');
        const productsGrid = document.querySelector('.products-grid');
        const productCards = Array.from(document.querySelectorAll('.product-showcase-card'));

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortValue = this.value;
                let sortedCards = [...productCards];

                switch(sortValue) {
                    case 'price-asc':
                        sortedCards.sort((a, b) => {
                            const priceA = parseFloat(a.querySelector('.price-badge').textContent);
                            const priceB = parseFloat(b.querySelector('.price-badge').textContent);
                            return priceA - priceB;
                        });
                        break;
                    case 'price-desc':
                        sortedCards.sort((a, b) => {
                            const priceA = parseFloat(a.querySelector('.price-badge').textContent);
                            const priceB = parseFloat(b.querySelector('.price-badge').textContent);
                            return priceB - priceA;
                        });
                        break;
                    case 'name':
                        sortedCards.sort((a, b) => {
                            const nameA = a.querySelector('.product-showcase-title').textContent;
                            const nameB = b.querySelector('.product-showcase-title').textContent;
                            return nameA.localeCompare(nameB);
                        });
                        break;
                    case 'newest':
                    default:
                        sortedCards = [...productCards];
                }

                // Réinitialiser les délais d'animation
                productsGrid.innerHTML = '';
                sortedCards.forEach((card, index) => {
                    card.style.animationDelay = (index * 0.1) + 's';
                    card.style.animation = 'none';
                    card.style.opacity = '0';
                    productsGrid.appendChild(card);
                    // Déclencher la répainting
                    setTimeout(() => {
                        card.style.animation = 'cardFadeIn 0.6s ease forwards';
                    }, 10);
                });
            });
        }

        // Animation au défilement
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'cardFadeIn 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        productCards.forEach(card => {
            observer.observe(card);
        });

        // Animation des statistiques
        const stats = document.querySelectorAll('.stat-number');
        stats.forEach(stat => {
            const finalValue = parseInt(stat.textContent);
            let currentValue = 0;
            const increment = Math.ceil(finalValue / 50);
            const interval = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    stat.textContent = finalValue;
                    clearInterval(interval);
                } else {
                    stat.textContent = currentValue;
                }
            }, 20);
        });
    });
</script>

@endsection
