@extends('layouts.shop')

@section('title', 'Mon profil')

@section('content')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .profile-header {
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 40px;
        box-shadow: 0 8px 32px rgba(93, 78, 55, 0.2);
        text-align: center;
    }

    .profile-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .profile-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 15px;
        border: 3px solid white;
    }

    .profile-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .profile-content {
            grid-template-columns: 1fr;
        }
    }

    .info-card {
        background: white;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(93, 78, 55, 0.12);
        border-color: #8B6F47;
    }

    .info-card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f5f1ed;
    }

    .info-card h2 i {
        color: #8B6F47;
        font-size: 1.8rem;
    }

    .info-item {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f5f1ed;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #8B6F47;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        word-break: break-all;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    .stat-box {
        background: linear-gradient(135deg, #f5f1ed 0%, #faf7f3 100%);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #8B6F47 0%, #D4A574 100%);
    }

    .stat-box:hover {
        border-color: #8B6F47;
        background: linear-gradient(135deg, #faf7f3 0%, #f5f1ed 100%);
    }

    .stat-label {
        font-size: 0.9rem;
        color: #8B6F47;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #5D4E37;
    }

    .stat-icon {
        font-size: 1.8rem;
        margin-top: 10px;
        opacity: 0.6;
    }

    .actions-section {
        margin-top: 40px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .btn-brown-large {
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        border: none;
        color: white !important;
        font-weight: 700;
        padding: 16px 24px;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(93, 78, 55, 0.3);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
        letter-spacing: 0.5px;
        font-size: 1rem;
    }

    .btn-brown-large:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(93, 78, 55, 0.5);
        background: linear-gradient(135deg, #5D4E37 0%, #8B6F47 100%);
        color: white !important;
    }

    .btn-brown-large i {
        font-size: 1.3rem;
    }

    .success-alert {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
        border-left: 4px solid #4caf50;
        color: #2e7d32;
        padding: 18px 24px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.15);
    }

    .success-alert i {
        font-size: 1.3rem;
    }
</style>

<div class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <h1>{{ $user->name }}</h1>
        <p>Bienvenue dans votre espace personnel</p>
    </div>

    @if(session('success'))
        <div class="success-alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Contenu principal -->
    <div class="profile-content">
        <!-- Informations personnelles -->
        <div class="info-card">
            <h2>
                <i class="bi bi-person-badge"></i>
                Mes informations
            </h2>

            <div class="info-item">
                <span class="info-label">📧 Email</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">📞 Téléphone</span>
                <span class="info-value">{{ $user->phone ?? 'Non renseigné' }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">📅 Membre depuis</span>
                <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">🔐 Rôle</span>
                <span class="info-value">
                    @if($user->role === 'admin')
                        <span style="background: #8B6F47; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">Administrateur</span>
                    @else
                        <span style="background: #D4A574; color: #333; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">Client</span>
                    @endif
                </span>
            </div>

            <button class="btn-brown-large" style="width: 100%; margin-top: 25px;">
                <i class="bi bi-pencil-square"></i> MODIFIER MES INFORMATIONS
            </button>
        </div>

        <!-- Statistiques -->
        <div class="info-card">
            <h2>
                <i class="bi bi-graph-up"></i>
                Mes statistiques
            </h2>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-label">Commandes</div>
                    <div class="stat-value">{{ $user->orders->count() }}</div>
                    <div class="stat-icon">📦</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Total dépensé</div>
                    <div class="stat-value">{{ number_format($user->orders->sum('total_amount'), 0) }}€</div>
                    <div class="stat-icon">💰</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">En cours</div>
                    <div class="stat-value">{{ $user->orders->whereIn('status', ['pending', 'paid', 'shipped'])->count() }}</div>
                    <div class="stat-icon">⏳</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions principales -->
    <div class="actions-section">
        <a href="{{ route('shop.account.orders') }}" class="btn-brown-large">
            <i class="bi bi-box-seam"></i> MES COMMANDES
        </a>

        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
            @csrf
            <button type="submit" class="btn-brown-large" style="width: 100%;">
                <i class="bi bi-box-arrow-right"></i> SE DÉCONNECTER
            </button>
        </form>
    </div>
</div>

@endsection
