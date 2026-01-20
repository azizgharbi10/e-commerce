@extends('layouts.shop')

@section('title', 'Détail commande ' . $order->order_number)

@section('content')
@php
    $itemsCount = $order->items->count();
    $formattedTotal = number_format($order->total_amount, 2);
@endphp

<style>
    /* ======================== HERO ======================== */
    .order-hero {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        padding: 3rem 2.5rem;
        color: #fff;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.2);
    }

    .order-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.15), transparent 40%),
                    radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.08), transparent 40%),
                    radial-gradient(circle at 40% 80%, rgba(0, 0, 0, 0.08), transparent 35%);
        pointer-events: none;
    }

    .order-hero-content { position: relative; z-index: 2; }
    .order-hero-title { font-size: clamp(2.1rem, 4vw, 3.2rem); font-weight: 800; margin: 0; }
    .order-hero-meta { color: rgba(255, 255, 255, 0.9); margin-top: 0.5rem; }

    /* ======================== BADGES & CARDS ======================== */
    .status-chip {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.4px;
        background: rgba(255, 255, 255, 0.16);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .glass-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.2rem 1.4rem;
        border: 1px solid #f0f0f0;
        box-shadow: 0 6px 22px rgba(93, 78, 55, 0.12);
    }

    .card-label { color: #8A8A8A; font-size: 0.85rem; margin: 0; }
    .card-value { margin: 0.25rem 0 0 0; font-weight: 800; color: #5D4E37; font-size: 1.1rem; }

    /* ======================== LAYOUT ======================== */
    .section-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f1f1f1;
        box-shadow: 0 8px 26px rgba(93, 78, 55, 0.08);
        padding: 1.75rem;
        margin-bottom: 1.75rem;
    }

    .section-title { font-size: 1.4rem; font-weight: 800; color: #5D4E37; margin: 0 0 1rem 0; }
    .muted { color: #777; }

    /* ======================== TABLE ======================== */
    .order-table { width: 100%; border-collapse: collapse; }
    .order-table thead { background: #F5F1ED; }
    .order-table th, .order-table td { padding: 0.9rem 1rem; text-align: left; }
    .order-table th { font-weight: 700; color: #5D4E37; font-size: 0.95rem; }
    .order-table td { color: #4a4a4a; border-bottom: 1px solid #f0f0f0; }
    .order-table tr:last-child td { border-bottom: none; }

    .table-wrapper { overflow-x: auto; border-radius: 12px; border: 1px solid #f1e6d9; background: #fff; }

    .total-row { text-align: right; font-size: 1.2rem; font-weight: 800; color: #5D4E37; padding-top: 1rem; }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 720px) {
        .order-hero { padding: 2.25rem 1.5rem; }
        .orders-back { margin-top: 1rem; display: inline-flex; }
        .section-card { padding: 1.4rem; }
        .order-table th, .order-table td { padding: 0.75rem 0.7rem; }
    }
</style>

<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="order-hero">
        <div class="order-hero-content">
            <p class="order-hero-meta mb-1">Commande</p>
            <h1 class="order-hero-title">{{ $order->order_number }}</h1>
            <p class="order-hero-meta">Passée le {{ $order->created_at->format('d/m/Y \à H:i') }}</p>
            <div class="info-grid">
                <div class="glass-card">
                    <p class="card-label">Statut</p>
                    <p class="card-value">
                        <span class="status-chip status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </p>
                </div>
                <div class="glass-card">
                    <p class="card-label">Total</p>
                    <p class="card-value">{{ $formattedTotal }} €</p>
                </div>
                <div class="glass-card">
                    <p class="card-label">Articles</p>
                    <p class="card-value">{{ $itemsCount }}</p>
                </div>
                <div class="glass-card">
                    <p class="card-label">Retour</p>
                    <p class="card-value"><a href="{{ route('shop.account.orders') }}" class="orders-back-link" style="color:#FFD700;">← Mes commandes</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title">Informations de livraison</h2>
        <div class="info-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            <div class="glass-card">
                <p class="card-label">Contact</p>
                <p class="card-value" style="font-size:1rem;">{{ $order->customer_name }}</p>
                <p class="muted">{{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p class="muted">{{ $order->customer_phone }}</p>
                @endif
            </div>
            <div class="glass-card">
                <p class="card-label">Adresse</p>
                <p class="card-value" style="font-size:1rem;">{{ $order->shipping_address['address'] ?? '' }}</p>
                <p class="muted">{{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}</p>
            </div>
            @if($order->notes)
                <div class="glass-card" style="grid-column: span 2;">
                    <p class="card-label">Remarques</p>
                    <p class="card-value" style="font-size:1rem; font-weight:600;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title">Articles commandés</h2>
        @if($itemsCount > 0)
            <div class="table-wrapper">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th style="text-align:center;">Quantité</th>
                            <th style="text-align:right;">Prix unitaire</th>
                            <th style="text-align:right;">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#5D4E37;">{{ $item->product_name }}</div>
                                    <div class="muted" style="font-size:0.9rem;">{{ $item->product_slug }}</div>
                                </td>
                                <td style="text-align:center; font-weight:700; color:#5D4E37;">{{ $item->quantity }}</td>
                                <td style="text-align:right;">{{ number_format($item->product_price, 2) }} €</td>
                                <td style="text-align:right; font-weight:800; color:#5D4E37;">{{ number_format($item->subtotal, 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="total-row">
                Total : <span style="color:#8B6F47;">{{ $formattedTotal }} €</span>
            </div>
        @else
            <p class="muted">Aucun article associé à cette commande.</p>
        @endif
    </div>
</div>
@endsection
