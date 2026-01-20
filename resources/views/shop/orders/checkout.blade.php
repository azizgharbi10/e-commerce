@extends('layouts.shop')

@section('title', 'Finaliser ma commande')

@section('content')

<style>
    /* ======================== HERO SECTION ======================== */
    .checkout-hero {
        position: relative;
        min-height: 300px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 3rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.15);
    }

    .checkout-hero-content {
        text-align: center;
        color: white;
        z-index: 10;
        padding: 3rem 2rem;
    }

    .checkout-hero-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
    }

    .checkout-hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .checkout-hero-subtitle {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    .checkout-progress {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .progress-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
    }

    .progress-circle.active {
        background: #FFD700;
        color: #5D4E37;
    }

    .progress-label {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.85);
    }

    /* ======================== ALERTS ======================== */
    .alert-warning {
        background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
        border: 2px solid #EF5350;
        color: #C62828;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-warning-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* ======================== LAYOUT ======================== */
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2.5rem;
        margin-bottom: 3rem;
    }

    /* ======================== FORM SECTION ======================== */
    .checkout-form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
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

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #5D4E37;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-required {
        color: #DC3545;
        font-weight: 700;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #D4A574;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #FFFBF7;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #8B6F47;
        background: white;
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-error {
        color: #DC3545;
        font-size: 0.85rem;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    /* ======================== SUBMIT BUTTON ======================== */
    .btn-submit {
        width: 100%;
        padding: 1.2rem;
        background: linear-gradient(135deg, #27AE60 0%, #1E8449 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(39, 174, 96, 0.3);
    }

    /* ======================== SIDEBAR SUMMARY ======================== */
    .checkout-summary {
        position: sticky;
        top: 100px;
    }

    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 1.75rem;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        border: 1px solid #f0f0f0;
    }

    .summary-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .summary-items {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .summary-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .summary-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .item-name {
        font-weight: 600;
        color: #5D4E37;
        margin-bottom: 0.3rem;
        font-size: 0.95rem;
    }

    .item-qty {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 0.3rem;
    }

    .item-total {
        font-weight: 700;
        color: #8B6F47;
        text-align: right;
    }

    .summary-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.95rem;
    }

    .detail-label {
        color: #666;
        font-weight: 500;
    }

    .detail-value {
        color: #5D4E37;
        font-weight: 600;
    }

    .detail-row.total {
        border-top: 2px solid #f0f0f0;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
        font-size: 1.2rem;
    }

    .detail-row.total .detail-label {
        font-weight: 700;
        color: #5D4E37;
    }

    .detail-row.total .detail-value {
        background: linear-gradient(135deg, #8B6F47 0%, #FFD700 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    .payment-info {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        border: 1px solid #90CAF9;
        padding: 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        color: #1565C0;
        margin-top: 1rem;
        font-weight: 500;
    }

    .btn-back {
        display: block;
        text-align: center;
        padding: 0.75rem;
        color: #8B6F47;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-back:hover {
        color: #5D4E37;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 1024px) {
        .checkout-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .checkout-summary {
            position: relative;
            top: auto;
        }

        .checkout-progress {
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .checkout-hero {
            min-height: 280px;
            margin-bottom: 2rem;
        }

        .checkout-hero-title {
            font-size: 1.75rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .checkout-progress {
            flex-direction: column;
            gap: 1rem;
        }

        .progress-step {
            width: 100%;
            flex-direction: row;
            justify-content: flex-start;
        }

        .progress-label {
            flex: 1;
        }
    }

    @media (max-width: 576px) {
        .checkout-hero {
            min-height: 250px;
            border-radius: 15px;
        }

        .checkout-hero-content {
            padding: 1.5rem 1rem;
        }

        .checkout-hero-icon {
            font-size: 2.5rem;
        }

        .checkout-hero-title {
            font-size: 1.4rem;
        }

        .checkout-hero-subtitle {
            font-size: 0.95rem;
        }

        .form-section {
            padding: 1rem;
        }

        .section-title {
            font-size: 1.1rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-input,
        .form-textarea,
        .form-select {
            padding: 0.65rem 0.75rem;
            font-size: 0.9rem;
        }

        .btn-submit {
            padding: 1rem;
            font-size: 0.95rem;
        }

        .summary-card {
            padding: 1.25rem;
        }

        .summary-title {
            font-size: 1rem;
        }

        .detail-row.total .detail-value {
            font-size: 1.3rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="checkout-hero">
    <div class="checkout-hero-content">
        <div class="checkout-hero-icon">📦</div>
        <h1 class="checkout-hero-title">Finaliser ma commande</h1>
        <p class="checkout-hero-subtitle">Complétez vos informations de livraison</p>
        <div class="checkout-progress">
            <div class="progress-step">
                <div class="progress-circle active">1</div>
                <div class="progress-label">Panier</div>
            </div>
            <div class="progress-step">
                <div class="progress-circle active">2</div>
                <div class="progress-label">Commande</div>
            </div>
            <div class="progress-step">
                <div class="progress-circle">3</div>
                <div class="progress-label">Confirmation</div>
            </div>
        </div>
    </div>
</div>

@if(session('warning'))
    <div class="alert-warning">
        <div class="alert-warning-icon">⚠️</div>
        <div>{{ session('warning') }}</div>
    </div>
@endif

<div class="checkout-container">
    <!-- Formulaire -->
    <form action="{{ route('shop.orders.store') }}" method="POST" class="checkout-form">
        @csrf

        <!-- Section Client -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="bi bi-person"></i>
                Vos Informations
            </h2>

            <div class="form-group">
                <label for="customer_name" class="form-label">
                    Nom complet
                    <span class="form-required">*</span>
                </label>
                <input 
                    type="text" 
                    name="customer_name" 
                    id="customer_name" 
                    value="{{ old('customer_name', auth()->user()?->name ?? '') }}"
                    required
                    class="form-input"
                    placeholder="Jean Dupont"
                >
                @error('customer_name')
                    <div class="form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="customer_email" class="form-label">
                        Email
                        <span class="form-required">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="customer_email" 
                        id="customer_email" 
                        value="{{ old('customer_email', auth()->user()?->email ?? '') }}"
                        required
                        class="form-input"
                        placeholder="jean@example.com"
                    >
                    @error('customer_email')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_phone" class="form-label">
                        Téléphone
                    </label>
                    <input 
                        type="tel" 
                        name="customer_phone" 
                        id="customer_phone" 
                        value="{{ old('customer_phone', auth()->user()?->phone ?? '') }}"
                        class="form-input"
                        placeholder="+33 6 12 34 56 78"
                    >
                    @error('customer_phone')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section Livraison -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="bi bi-geo-alt"></i>
                Adresse de Livraison
            </h2>

            <div class="form-group">
                <label for="address" class="form-label">
                    Rue et numéro
                    <span class="form-required">*</span>
                </label>
                <input 
                    type="text" 
                    name="address" 
                    id="address" 
                    value="{{ old('address') }}"
                    required
                    class="form-input"
                    placeholder="123 Rue de la Paix"
                >
                @error('address')
                    <div class="form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city" class="form-label">
                        Ville
                        <span class="form-required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="city" 
                        id="city" 
                        value="{{ old('city') }}"
                        required
                        class="form-input"
                        placeholder="Paris"
                    >
                    @error('city')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">
                        Code postal
                        <span class="form-required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="postal_code" 
                        id="postal_code" 
                        value="{{ old('postal_code') }}"
                        required
                        class="form-input"
                        placeholder="75001"
                    >
                    @error('postal_code')
                        <div class="form-error">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section Remarques -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="bi bi-chat-left-text"></i>
                Remarques (Optionnel)
            </h2>

            <div class="form-group">
                <label for="notes" class="form-label">
                    Ajouter une note de livraison
                </label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    class="form-textarea"
                    placeholder="Ex: Sonner avant de livrer, laisser en bas de l'immeuble..."
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="btn-submit"
        >
            <i class="bi bi-check-circle"></i>
            Confirmer la commande
        </button>
    </form>

    <!-- Sidebar Résumé -->
    <div class="checkout-summary">
        <div class="summary-card">
            <h3 class="summary-title">
                <i class="bi bi-receipt"></i>
                Récapitulatif
            </h3>

            <!-- Items List -->
            <div class="summary-items">
                @foreach($cart as $productId => $item)
                    <div class="summary-item">
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-qty">
                            <i class="bi bi-x-circle"></i>
                            {{ $item['quantity'] }}
                        </div>
                        <div class="item-total">
                            {{ number_format($item['price'] * $item['quantity'], 2) }}€
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary Details -->
            <div class="summary-details">
                <div class="detail-row">
                    <span class="detail-label">Sous-total</span>
                    <span class="detail-value">{{ number_format($total, 2) }}€</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Livraison</span>
                    <span class="detail-value" style="color: #27AE60; font-weight: 700;">Gratuite</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">TVA</span>
                    <span class="detail-value">Incluse</span>
                </div>

                <div class="detail-row total">
                    <span class="detail-label">TOTAL</span>
                    <span class="detail-value">{{ number_format($total, 2) }}€</span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="payment-info">
                <i class="bi bi-info-circle"></i>
                Paiement à la livraison - Pas de frais supplémentaires
            </div>

            <!-- Back Link -->
            <a href="{{ route('shop.cart.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Retour au panier
            </a>
        </div>
    </div>
</div>

@endsection
