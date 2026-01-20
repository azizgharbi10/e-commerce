@extends('layouts.shop')

@section('title', 'Mon panier')

@section('content')

<style>
    /* ======================== HERO SECTION ======================== */
    .cart-hero {
        position: relative;
        min-height: 350px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 4rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.15);
    }

    .cart-hero-content {
        text-align: center;
        color: white;
        z-index: 10;
        padding: 3rem;
    }

    .cart-hero-icon {
        font-size: 4.5rem;
        margin-bottom: 1rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .cart-hero-title {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: -1px;
    }

    .cart-hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.95);
        margin: 0;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    /* ======================== EMPTY STATE ======================== */
    .empty-cart-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 500px;
    }

    .empty-cart-state {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, #F5F1ED 0%, #FFFBF7 100%);
        border-radius: 20px;
        border: 2px dashed #D4A574;
        max-width: 500px;
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #D4A574;
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }

    .empty-cart-title {
        font-size: 2rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 0.75rem;
    }

    .empty-cart-text {
        font-size: 1rem;
        color: #888;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .btn-empty-cart {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-empty-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 111, 71, 0.3);
    }

    /* ======================== CART LAYOUT ======================== */
    .cart-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2.5rem;
        margin-bottom: 3rem;
    }

    /* ======================== CART ITEMS TABLE ======================== */
    .cart-items-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-items-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .cart-items-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #5D4E37;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .cart-items-count {
        background: #8B6F47;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .cart-items-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* ======================== CART ITEM CARD ======================== */
    .cart-item {
        background: white;
        border-radius: 15px;
        padding: 1.75rem;
        box-shadow: 0 4px 15px rgba(93, 78, 55, 0.08);
        transition: all 0.3s ease;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1.5rem;
        align-items: center;
    }

    .cart-item:hover {
        box-shadow: 0 8px 25px rgba(93, 78, 55, 0.12);
        transform: translateY(-2px);
    }

    .cart-item-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
        flex-shrink: 0;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .cart-item-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #5D4E37;
        margin: 0;
    }

    .cart-item-category {
        font-size: 0.85rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin: 0;
    }

    .cart-item-description {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
    }

    .cart-item-price {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
    }

    .cart-item-price-unit {
        font-size: 0.9rem;
        color: #999;
    }

    .cart-item-price-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #8B6F47;
    }

    .cart-item-stock {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .stock-available {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .stock-limited {
        background: #FFF3E0;
        color: #E65100;
    }

    .stock-rupture {
        background: #FFEBEE;
        color: #C62828;
    }

    .cart-item-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-end;
    }

    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #F5F1ED;
        border-radius: 10px;
        padding: 0.5rem;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: white;
        color: #8B6F47;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: #8B6F47;
        color: white;
    }

    .quantity-input {
        width: 45px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        color: #5D4E37;
        font-size: 1rem;
    }

    .quantity-input:focus {
        outline: none;
    }

    .cart-item-total {
        font-size: 1.4rem;
        font-weight: 700;
        color: #8B6F47;
        text-align: right;
        white-space: nowrap;
    }

    .cart-item-remove {
        width: 40px;
        height: 40px;
        border: 2px solid #DC3545;
        background: white;
        color: #DC3545;
        border-radius: 10px;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item-remove:hover {
        background: #DC3545;
        color: white;
        transform: rotate(20deg);
    }

    /* ======================== CART ACTIONS ======================== */
    .cart-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn-clear-cart {
        flex: 1;
        padding: 0.9rem 1.5rem;
        background: white;
        color: #999;
        border: 2px solid #ddd;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-clear-cart:hover {
        border-color: #DC3545;
        color: #DC3545;
        background: #FEE;
    }

    /* ======================== SIDEBAR SUMMARY ======================== */
    .cart-summary {
        position: sticky;
        top: 100px;
    }

    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        border: 1px solid #f0f0f0;
    }

    .summary-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #5D4E37;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .summary-label {
        color: #666;
        font-weight: 500;
    }

    .summary-value {
        color: #5D4E37;
        font-weight: 600;
    }

    .summary-divider {
        height: 2px;
        background: #f0f0f0;
        margin: 1.5rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }

    .summary-total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: #5D4E37;
    }

    .summary-total-value {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8B6F47 0%, #FFD700 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .summary-promo {
        background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
        border: 1px solid #FFB74D;
        border-radius: 10px;
        padding: 1rem;
        margin: 1.5rem 0;
        text-align: center;
        color: #E65100;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .btn-checkout {
        width: 100%;
        padding: 1.1rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(139, 111, 71, 0.3);
    }

    .btn-continue-shopping {
        width: 100%;
        padding: 0.9rem;
        background: white;
        color: #8B6F47;
        border: 2px solid #8B6F47;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.75rem;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-continue-shopping:hover {
        background: #8B6F47;
        color: white;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 1024px) {
        .cart-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .cart-summary {
            position: relative;
            top: auto;
        }

        .cart-item {
            grid-template-columns: 100px 1fr;
            gap: 1rem;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
        }

        .cart-item-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0;
            padding-top: 1rem;
            margin-top: 1rem;
        }
    }

    @media (max-width: 768px) {
        .cart-hero {
            min-height: 280px;
            margin-bottom: 2.5rem;
        }

        .cart-hero-icon {
            font-size: 3rem;
            margin-bottom: 0.75rem;
        }

        .cart-hero-title {
            font-size: 1.75rem;
        }

        .cart-hero-subtitle {
            font-size: 1rem;
        }

        .cart-item {
            grid-template-columns: 80px 1fr;
            padding: 1rem;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
        }

        .cart-item-name {
            font-size: 1rem;
        }

        .cart-item-total {
            font-size: 1.1rem;
        }

        .summary-card {
            padding: 1.5rem;
        }

        .summary-total-value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .cart-hero {
            min-height: 250px;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .cart-hero-content {
            padding: 1.5rem 1rem;
        }

        .cart-hero-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .cart-hero-title {
            font-size: 1.4rem;
        }

        .cart-hero-subtitle {
            font-size: 0.9rem;
        }

        .cart-item {
            grid-template-columns: 70px 1fr;
            gap: 0.75rem;
            padding: 0.75rem;
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
        }

        .cart-item-name {
            font-size: 0.95rem;
        }

        .cart-item-category {
            font-size: 0.75rem;
        }

        .cart-item-price-value {
            font-size: 1.1rem;
        }

        .cart-item-total {
            font-size: 1rem;
        }

        .cart-item-actions {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            width: 100%;
        }

        .cart-item-quantity {
            width: 100%;
            justify-content: space-between;
        }

        .summary-card {
            padding: 1rem;
        }

        .summary-total-value {
            font-size: 1.3rem;
        }

        .btn-checkout,
        .btn-continue-shopping {
            font-size: 0.9rem;
            padding: 0.85rem;
        }

        .empty-cart-state {
            padding: 2rem 1rem;
        }

        .empty-cart-icon {
            font-size: 3.5rem;
        }

        .empty-cart-title {
            font-size: 1.5rem;
        }
    }
</style>

<!-- Cart Hero Section -->
<div class="cart-hero">
    <div class="cart-hero-content">
        <div class="cart-hero-icon">🛒</div>
        <h1 class="cart-hero-title">Mon Panier</h1>
        <p class="cart-hero-subtitle">Récapitulatif de vos articles sélectionnés</p>
    </div>
</div>

@if (empty($cart))
    <!-- Empty Cart State -->
    <div class="empty-cart-container">
        <div class="empty-cart-state">
            <div class="empty-cart-icon">📭</div>
            <h2 class="empty-cart-title">Votre panier est vide</h2>
            <p class="empty-cart-text">Commencez vos achats dès maintenant et découvrez notre sélection de produits de qualité.</p>
            <a href="{{ route('shop.products.index') }}" class="btn-empty-cart">
                <i class="bi bi-shop"></i>
                Découvrir la boutique
            </a>
        </div>
    </div>
@else
    <!-- Cart Content -->
    <div class="cart-container">
        <!-- Cart Items -->
        <div class="cart-items-section">
            <div class="cart-items-header">
                <h2 class="cart-items-title">
                    <i class="bi bi-bag"></i>
                    Articles
                    <span class="cart-items-count">{{ count($cart) }}</span>
                </h2>
            </div>

            <div class="cart-items-list">
                @foreach ($cart as $productId => $item)
                    @php
                        $product = \App\Models\Product::find($productId);
                    @endphp
                    <div class="cart-item">
                        <!-- Product Image -->
                        <div class="cart-item-image">
                            @if($product && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $item['name'] }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);">
                                    <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="cart-item-info">
                            <h3 class="cart-item-name">{{ $item['name'] }}</h3>
                            <p class="cart-item-category">{{ $item['category'] }}</p>
                            @if($product && $product->description)
                                <p class="cart-item-description">{{ Str::limit($product->description, 60) }}</p>
                            @endif
                            <div class="cart-item-price">
                                <span class="cart-item-price-unit">€</span>
                                <span class="cart-item-price-value">{{ number_format($item['price'], 2) }}</span>
                            </div>
                            @if($product)
                                @if($product->stock > 5)
                                    <span class="cart-item-stock stock-available">
                                        <i class="bi bi-check-circle"></i> {{ $product->stock }} en stock
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="cart-item-stock stock-limited">
                                        <i class="bi bi-exclamation-triangle"></i> Stock limité ({{ $product->stock }})
                                    </span>
                                @else
                                    <span class="cart-item-stock stock-rupture">
                                        <i class="bi bi-x-circle"></i> Rupture de stock
                                    </span>
                                @endif
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="cart-item-actions">
                            <!-- Quantity Controls -->
                            <form action="{{ route('shop.cart.update', $productId) }}" method="POST" class="cart-item-quantity">
                                @csrf
                                @method('PUT')
                                <button type="button" class="quantity-btn" onclick="decrementQty(this)">−</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input" onchange="this.form.submit()">
                                <button type="button" class="quantity-btn" onclick="incrementQty(this)">+</button>
                            </form>

                            <!-- Item Total -->
                            <div class="cart-item-total">
                                {{ number_format($item['price'] * $item['quantity'], 2) }}€
                            </div>

                            <!-- Remove Button -->
                            <form action="{{ route('shop.cart.remove', $productId) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cart-item-remove" onclick="return confirm('Retirer ce produit ?')" title="Retirer">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <form action="{{ route('shop.cart.clear') }}" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-clear-cart" onclick="return confirm('Vider le panier ?')">
                        <i class="bi bi-trash"></i> Vider le panier
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="cart-summary">
            <div class="summary-card">
                <h3 class="summary-title">
                    <i class="bi bi-receipt"></i>
                    Résumé
                </h3>

                <div class="summary-item">
                    <span class="summary-label">Sous-total</span>
                    <span class="summary-value">{{ number_format($total, 2) }}€</span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Livraison</span>
                    <span class="summary-value" style="color: #27AE60; font-weight: 700;">Gratuite</span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Articles</span>
                    <span class="summary-value">{{ count($cart) }}</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total">
                    <span class="summary-total-label">Total</span>
                    <span class="summary-total-value">{{ number_format($total, 2) }}€</span>
                </div>

                <!-- Promo Banner -->
                <div class="summary-promo">
                    ✨ Livraison gratuite pour toute commande !
                </div>

                <!-- Checkout Button -->
                <a href="{{ route('shop.checkout') }}" class="btn-checkout">
                    <i class="bi bi-credit-card"></i>
                    Passer la commande
                </a>

                <!-- Continue Shopping Button -->
                <a href="{{ route('shop.products.index') }}" class="btn-continue-shopping">
                    <i class="bi bi-arrow-left"></i>
                    Continuer mes achats
                </a>
            </div>
        </div>
    </div>
@endif

<script>
    function incrementQty(btn) {
        const input = btn.parentElement.querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
    }

    function decrementQty(btn) {
        const input = btn.parentElement.querySelector('.quantity-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Animation du héros
        const heroIcon = document.querySelector('.cart-hero-icon');
        if (heroIcon) {
            heroIcon.style.animation = 'bounce 2s infinite';
        }

        // Animation des items au chargement
        const items = document.querySelectorAll('.cart-item');
        items.forEach((item, index) => {
            item.style.animation = `cardFadeIn 0.6s ease forwards`;
            item.style.animationDelay = `${index * 0.1}s`;
            item.style.opacity = '0';
        });

        // Animation des items au survol
        items.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });

    @keyframes cardFadeIn {
        to {
            opacity: 1;
        }
    }
</script>

@endsection
