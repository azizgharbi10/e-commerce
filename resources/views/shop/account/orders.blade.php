@extends('layouts.shop')

@section('title', 'Mes commandes')

@section('content')
@php
    $totalOrders = $orders->total() ?? $orders->count();
    $totalItems = $orders->sum('items_count') ?? $orders->sum(fn($o) => $o->items->count());
    $totalAmount = $orders->sum('total_amount');
@endphp

<style>
    /* ======================== HERO SECTION ======================== */
    .orders-hero {
        position: relative;
        min-height: 320px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 3.5rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.18);
    }

    .orders-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.15), transparent 40%),
                    radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.08), transparent 40%),
                    radial-gradient(circle at 40% 80%, rgba(0, 0, 0, 0.08), transparent 35%);
        pointer-events: none;
        z-index: 1;
    }

    .orders-hero-content {
        text-align: center;
        color: white;
        padding: 3rem 2rem;
        z-index: 5;
    }

    .orders-hero-icon {
        font-size: 3.5rem;
        margin-bottom: 0.75rem;
    }

    .orders-hero-title {
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .orders-hero-subtitle {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.92);
        margin: 0;
    }

    .orders-hero-stats {
        display: flex;
        gap: 2rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.75rem;
    }

    .orders-stat {
        background: rgba(255, 255, 255, 0.14);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        min-width: 160px;
    }

    .orders-stat-number {
        font-size: 1.6rem;
        font-weight: 800;
        color: #FFD700;
        line-height: 1;
    }

    .orders-stat-label {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
        margin-top: 0.35rem;
    }

    /* ======================== ACTION BAR ======================== */
    .orders-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .orders-back-link {
        color: #8B6F47;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .orders-back-link:hover {
        color: #5D4E37;
    }

    /* ======================== ORDERS GRID ======================== */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 6px 20px rgba(93, 78, 55, 0.1);
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(93, 78, 55, 0.16);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .order-number {
        font-size: 1.2rem;
        font-weight: 800;
        color: #5D4E37;
        margin: 0;
    }

    .order-date {
        color: #999;
        font-size: 0.9rem;
        margin: 0;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #FFF3E0; color: #E65100; }
    .status-paid { background: #E3F2FD; color: #1565C0; }
    .status-shipped { background: #F3E5F5; color: #6A1B9A; }
    .status-delivered { background: #E8F5E9; color: #2E7D32; }
    .status-cancelled { background: #FFEBEE; color: #C62828; }

    .order-body {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .order-info {
        background: #F5F1ED;
        border-radius: 10px;
        padding: 0.85rem 1rem;
    }

    .order-info-label {
        font-size: 0.85rem;
        color: #888;
        margin: 0;
    }

    .order-info-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: #5D4E37;
        margin: 0.2rem 0 0 0;
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn-details {
        flex: 1;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }

    .btn-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(93, 78, 55, 0.25);
    }

    /* ======================== EMPTY STATE ======================== */
    .orders-empty {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, #F5F1ED 0%, #FFFBF7 100%);
        border-radius: 18px;
        border: 2px dashed #D4A574;
        max-width: 520px;
        margin: 0 auto;
    }

    .orders-empty-icon {
        font-size: 4rem;
        color: #D4A574;
        margin-bottom: 1rem;
    }

    .orders-empty-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #5D4E37;
        margin-bottom: 0.5rem;
    }

    .orders-empty-text {
        color: #777;
        margin-bottom: 1.5rem;
    }

    .btn-start-shopping {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.9rem 1.5rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-start-shopping:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 111, 71, 0.3);
    }

    /* ======================== PAGINATION ======================== */
    .orders-pagination {
        margin-top: 2rem;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 900px) {
        .orders-hero { min-height: 280px; }
        .orders-hero-title { font-size: 2rem; }
        .order-body { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .orders-hero {
            min-height: 240px;
            border-radius: 15px;
        }
        .orders-hero-content { padding: 2rem 1.2rem; }
        .orders-hero-title { font-size: 1.6rem; }
        .orders-hero-subtitle { font-size: 0.95rem; }
        .orders-stat { min-width: 140px; }
        .orders-actions { flex-direction: column; align-items: flex-start; }
        .orders-grid { grid-template-columns: 1fr; }
        .order-body { grid-template-columns: 1fr; }
        .order-actions { flex-direction: column; }
        .btn-details { width: 100%; }
    }
</style>

<!-- Hero Section -->
<div class="orders-hero">
    <div class="orders-hero-content">
        <div class="orders-hero-icon">📦</div>
        <h1 class="orders-hero-title">Mes commandes</h1>
        <p class="orders-hero-subtitle">Suivez vos commandes et leur statut en un coup d'œil</p>
        <div class="orders-hero-stats">
            <div class="orders-stat">
                <div class="orders-stat-number">{{ $totalOrders }}</div>
                <div class="orders-stat-label">Commandes</div>
            </div>
            <div class="orders-stat">
                <div class="orders-stat-number">{{ $totalItems }}</div>
                <div class="orders-stat-label">Articles</div>
            </div>
            <div class="orders-stat">
                <div class="orders-stat-number">{{ number_format($totalAmount, 2) }}€</div>
                <div class="orders-stat-label">Total cumulé (page)</div>
            </div>
        </div>
    </div>
</div>

<div class="orders-actions">
    <a href="{{ route('shop.account.profile') }}" class="orders-back-link">
        <i class="bi bi-arrow-left"></i>
        Retour au profil
    </a>
</div>

@if($orders->count() > 0)
    <div class="orders-grid">
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <p class="order-number">{{ $order->order_number }}</p>
                        <p class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>

                <div class="order-body">
                    <div class="order-info">
                        <p class="order-info-label">Articles</p>
                        <p class="order-info-value">{{ $order->items->count() }}</p>
                    </div>
                    <div class="order-info">
                        <p class="order-info-label">Total</p>
                        <p class="order-info-value">{{ number_format($order->total_amount, 2) }}€</p>
                    </div>
                    <div class="order-info">
                        <p class="order-info-label">Statut</p>
                        <p class="order-info-value" style="font-size: 1rem;">{{ ucfirst($order->status) }}</p>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('shop.account.orderDetail', $order->order_number) }}" class="btn-details">
                        Voir le détail
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="orders-pagination">
        {{ $orders->links() }}
    </div>
@else
    <div class="orders-empty">
        <div class="orders-empty-icon">🧾</div>
        <div class="orders-empty-title">Aucune commande pour le moment</div>
        <div class="orders-empty-text">Parcourez la boutique et lancez votre première commande.</div>
        <a href="{{ route('shop.products.index') }}" class="btn-start-shopping">
            <i class="bi bi-shop"></i>
            Commencer vos achats
        </a>
    </div>
@endif
@endsection
