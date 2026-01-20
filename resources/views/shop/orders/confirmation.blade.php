@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')

<style>
    /* ======================== SUCCESS ANIMATION ======================== */
    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* ======================== HERO SUCCESS SECTION ======================== */
    .success-hero {
        position: relative;
        min-height: 450px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 4rem;
        background: linear-gradient(135deg, #27AE60 0%, #1E8449 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 50px rgba(39, 174, 96, 0.2);
    }

    .success-checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        animation: scaleIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .success-icon {
        font-size: 4rem;
        color: white;
    }

    .success-hero-title {
        font-size: clamp(2rem, 6vw, 3.5rem);
        font-weight: 800;
        color: white;
        margin: 0 0 0.75rem 0;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: slideInUp 0.8s ease 0.2s both;
    }

    .success-hero-subtitle {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.95);
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        animation: slideInUp 0.8s ease 0.3s both;
    }

    .order-reference {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
        padding: 1.5rem 2rem;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideInUp 0.8s ease 0.4s both;
    }

    .order-ref-label {
        color: rgba(255, 255, 255, 0.85);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    .order-ref-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: #FFD700;
        letter-spacing: 2px;
    }

    /* ======================== ALERTS ======================== */
    .success-alert {
        background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        border: 2px solid #4CAF50;
        color: #2E7D32;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInUp 0.8s ease;
    }

    .success-alert-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* ======================== INFO GRID ======================== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        border-left: 5px solid #8B6F47;
        transition: all 0.3s ease;
        animation: slideInUp 0.8s ease both;
    }

    .info-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .info-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    .info-card:nth-child(4) {
        animation-delay: 0.3s;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(93, 78, 55, 0.15);
    }

    .info-card-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .info-label {
        font-size: 0.85rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #5D4E37;
    }

    .status-badge {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.5rem;
    }

    .status-pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .status-confirmed {
        background: #E3F2FD;
        color: #1565C0;
    }

    .status-shipped {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .status-delivered {
        background: #E8F5E9;
        color: #2E7D32;
    }

    /* ======================== DELIVERY INFO ======================== */
    .delivery-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        margin-bottom: 3rem;
        animation: slideInUp 0.8s ease 0.4s both;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .delivery-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .delivery-person {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .delivery-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #5D4E37;
    }

    .delivery-email,
    .delivery-phone {
        font-size: 0.95rem;
        color: #666;
    }

    .delivery-address {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .address-line {
        font-size: 0.95rem;
        color: #666;
    }

    .address-street {
        font-weight: 600;
        color: #5D4E37;
    }

    .delivery-notes {
        grid-column: 1 / -1;
        padding-top: 1.5rem;
        border-top: 1px solid #f0f0f0;
    }

    .notes-label {
        font-size: 0.85rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .notes-text {
        color: #666;
        line-height: 1.6;
        padding: 1rem;
        background: #F5F1ED;
        border-radius: 10px;
        font-style: italic;
    }

    /* ======================== ORDER ITEMS ======================== */
    .items-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        margin-bottom: 3rem;
        animation: slideInUp 0.8s ease 0.5s both;
    }

    .items-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .order-item {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #F5F1ED;
        border-radius: 12px;
        align-items: center;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: #FFFBF7;
    }

    .item-image {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        background: white;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #5D4E37;
    }

    .item-details {
        display: flex;
        gap: 2rem;
        font-size: 0.9rem;
        color: #666;
    }

    .item-price-block {
        text-align: right;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .item-unit-price {
        font-size: 0.9rem;
        color: #999;
    }

    .item-subtotal {
        font-size: 1.4rem;
        font-weight: 800;
        color: #8B6F47;
    }

    /* ======================== ORDER SUMMARY ======================== */
    .order-summary {
        background: linear-gradient(135deg, #F5F1ED 0%, #FFFBF7 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        border: 2px solid #D4A574;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        font-size: 0.95rem;
    }

    .summary-row.total {
        border-top: 3px solid #8B6F47;
        padding-top: 1rem;
        margin-top: 1rem;
        font-size: 1.3rem;
        font-weight: 800;
    }

    .summary-label {
        color: #666;
        font-weight: 600;
    }

    .summary-value {
        color: #5D4E37;
        font-weight: 700;
    }

    .summary-total-value {
        background: linear-gradient(135deg, #8B6F47 0%, #FFD700 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ======================== ACTION BUTTONS ======================== */
    .actions-section {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin: 3rem 0;
        animation: slideInUp 0.8s ease 0.6s both;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-continue {
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
    }

    .btn-continue:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(139, 111, 71, 0.3);
    }

    .btn-print {
        background: white;
        color: #8B6F47;
        border: 2px solid #8B6F47;
    }

    .btn-print:hover {
        background: #8B6F47;
        color: white;
    }

    /* ======================== EMAIL CONFIRMATION ======================== */
    .email-confirmation {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border-radius: 15px;
        border: 2px solid #90CAF9;
        color: #1565C0;
        font-weight: 600;
        margin-top: 2rem;
        animation: slideInUp 0.8s ease 0.7s both;
    }

    .email-confirmation strong {
        font-weight: 800;
        color: #0D47A1;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 1024px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .delivery-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .success-hero {
            min-height: 350px;
            margin-bottom: 2.5rem;
        }

        .success-hero-title {
            font-size: 1.75rem;
        }

        .order-reference {
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .delivery-section,
        .items-section {
            padding: 1.5rem;
        }

        .order-item {
            grid-template-columns: 80px 1fr auto;
            gap: 1rem;
        }

        .item-image {
            width: 80px;
            height: 80px;
        }

        .item-details {
            gap: 1rem;
        }

        .actions-section {
            flex-direction: column;
            gap: 1rem;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .success-hero {
            min-height: 300px;
            border-radius: 15px;
        }

        .success-checkmark {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .success-icon {
            font-size: 3rem;
        }

        .success-hero-title {
            font-size: 1.4rem;
        }

        .order-ref-number {
            font-size: 1.5rem;
        }

        .info-card {
            padding: 1.5rem;
        }

        .info-value {
            font-size: 1.2rem;
        }

        .delivery-section,
        .items-section {
            padding: 1rem;
        }

        .section-title {
            font-size: 1.1rem;
        }

        .order-item {
            grid-template-columns: 70px 1fr;
            gap: 0.75rem;
        }

        .item-image {
            width: 70px;
            height: 70px;
        }

        .item-price-block {
            grid-column: 1 / -1;
            text-align: left;
            padding-top: 0.75rem;
            border-top: 1px solid #D4A574;
        }

        .item-name {
            font-size: 1rem;
        }

        .item-details {
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.9rem 1.5rem;
            font-size: 0.85rem;
        }

        .email-confirmation {
            padding: 1.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Hero Success Section -->
<div class="success-hero">
    <div class="success-checkmark">
        <div class="success-icon">✓</div>
    </div>
    <h1 class="success-hero-title">Commande Confirmée !</h1>
    <p class="success-hero-subtitle">Merci pour votre confiance</p>
    <div class="order-reference">
        <span class="order-ref-label">Numéro de commande :</span>
        <span class="order-ref-number">#{{ $order->order_number }}</span>
    </div>
</div>

@if(session('success'))
    <div class="success-alert">
        <div class="success-alert-icon">✓</div>
        <div>{{ session('success') }}</div>
    </div>
@endif

<!-- Info Cards Grid -->
<div class="info-grid">
    <!-- Statut Card -->
    <div class="info-card">
        <div class="info-card-icon">📊</div>
        <div class="info-label">Statut</div>
        <div class="info-value">
            <span class="status-badge status-{{ $order->status }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <!-- Montant Total Card -->
    <div class="info-card">
        <div class="info-card-icon">💰</div>
        <div class="info-label">Montant Total</div>
        <div class="info-value">{{ number_format($order->total_amount, 2) }}€</div>
    </div>

    <!-- Date Card -->
    <div class="info-card">
        <div class="info-card-icon">📅</div>
        <div class="info-label">Date de Commande</div>
        <div class="info-value">{{ $order->created_at->format('d/m/Y') }}</div>
        <div style="font-size: 0.85rem; color: #999; margin-top: 0.5rem;">
            {{ $order->created_at->format('H:i') }}
        </div>
    </div>

    <!-- Items Count Card -->
    <div class="info-card">
        <div class="info-card-icon">🛍️</div>
        <div class="info-label">Articles</div>
        <div class="info-value">{{ $order->items->count() }}</div>
    </div>
</div>

<!-- Delivery Information Section -->
<div class="delivery-section">
    <h2 class="section-title">
        <i class="bi bi-truck"></i>
        Informations de Livraison
    </h2>

    <div class="delivery-content">
        <!-- Client Info -->
        <div class="delivery-person">
            <div class="delivery-name">{{ $order->customer_name }}</div>
            <div class="delivery-email">
                <i class="bi bi-envelope"></i> {{ $order->customer_email }}
            </div>
            @if($order->customer_phone)
                <div class="delivery-phone">
                    <i class="bi bi-telephone"></i> {{ $order->customer_phone }}
                </div>
            @endif
        </div>

        <!-- Address Info -->
        <div class="delivery-address">
            <div class="address-street">{{ $order->shipping_address['address'] ?? '' }}</div>
            <div class="address-line">
                {{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}
            </div>
        </div>

        @if($order->notes)
            <div class="delivery-notes">
                <div class="notes-label">
                    <i class="bi bi-chat-left-text"></i> Remarques de livraison
                </div>
                <div class="notes-text">{{ $order->notes }}</div>
            </div>
        @endif
    </div>
</div>

<!-- Order Items Section -->
<div class="items-section">
    <h2 class="section-title">
        <i class="bi bi-bag-check"></i>
        Articles Commandés
    </h2>

    <div class="items-list">
        @foreach($order->items as $item)
            <div class="order-item">
                <!-- Item Image -->
                <div class="item-image">
                    @php
                        $product = \App\Models\Product::find($item->product_id);
                    @endphp
                    @if($product && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $item->product_name }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);">
                            <i class="bi bi-image" style="font-size: 1.5rem; color: #ccc;"></i>
                        </div>
                    @endif
                </div>

                <!-- Item Info -->
                <div class="item-info">
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-details">
                        <span><strong>Prix unit :</strong> {{ number_format($item->product_price, 2) }}€</span>
                        <span><strong>Quantité :</strong> {{ $item->quantity }}</span>
                    </div>
                </div>

                <!-- Item Price -->
                <div class="item-price-block">
                    <div class="item-unit-price">Sous-total</div>
                    <div class="item-subtotal">{{ number_format($item->subtotal, 2) }}€</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Order Summary -->
    <div class="order-summary">
        <div class="summary-row">
            <span class="summary-label">Sous-total</span>
            <span class="summary-value">{{ number_format($order->total_amount, 2) }}€</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Livraison</span>
            <span class="summary-value" style="color: #27AE60; font-weight: 800;">Gratuite</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">TVA</span>
            <span class="summary-value">Incluse</span>
        </div>
        <div class="summary-row total">
            <span class="summary-label">TOTAL</span>
            <span class="summary-total-value">{{ number_format($order->total_amount, 2) }}€</span>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="actions-section">
    <a 
        href="{{ route('shop.products.index') }}" 
        class="btn-action btn-continue"
    >
        <i class="bi bi-shop"></i>
        Continuer mes achats
    </a>
    <button 
        onclick="window.print()" 
        class="btn-action btn-print"
    >
        <i class="bi bi-printer"></i>
        Imprimer la commande
    </button>
</div>

<!-- Email Confirmation -->
<div class="email-confirmation">
    <i class="bi bi-check-circle"></i>
    Un email de confirmation a été envoyé à <strong>{{ $order->customer_email }}</strong>
</div>

@endsection
