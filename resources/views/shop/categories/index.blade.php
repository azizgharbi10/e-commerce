@extends('layouts.shop')

@section('title', 'Boutique - Catégories')

@section('content')

<style>
    /* ======================== HERO SECTION ======================== */
    .categories-hero {
        position: relative;
        min-height: 450px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 4rem;
        box-shadow: 0 10px 40px rgba(93, 78, 55, 0.15);
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
    }

    .categories-hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 450"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="1200" height="450" fill="url(%23grid)"/></svg>'),
            linear-gradient(135deg, rgba(139, 111, 71, 0.9) 0%, rgba(93, 78, 55, 0.95) 100%);
        background-size: auto, cover;
        opacity: 0.9;
    }

    .categories-hero-content {
        position: relative;
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        padding: 3rem;
        text-align: center;
        color: white;
    }

    .categories-hero-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .categories-hero-title {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: -1px;
    }

    .categories-hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 2rem;
        max-width: 700px;
        line-height: 1.6;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .categories-hero-stats {
        display: flex;
        gap: 3rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #FFD700;
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.85);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 0.5rem;
        font-weight: 600;
    }

    /* ======================== INTRO SECTION ======================== */
    .categories-intro {
        margin-bottom: 3rem;
        text-align: center;
    }

    .intro-subtitle {
        display: inline-block;
        color: #8B6F47;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .intro-title {
        font-size: 2rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 1rem;
    }

    .intro-description {
        font-size: 1.05rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto 2rem;
        line-height: 1.7;
    }

    .intro-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 2rem;
        background: #8B6F47;
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .intro-cta:hover {
        background: #5D4E37;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 111, 71, 0.3);
        color: white;
    }

    /* ======================== EMPTY STATE ======================== */
    .empty-state-categories {
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

    .empty-state-categories h3 {
        color: #5D4E37;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state-categories p {
        color: #888;
        margin-bottom: 2rem;
    }

    /* ======================== CATEGORIES GRID ======================== */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2.5rem;
        margin-bottom: 4rem;
    }

    .category-showcase-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        transition: all 0.3s ease;
        animation: cardFadeIn 0.6s ease forwards;
        opacity: 0;
        display: flex;
        flex-direction: column;
    }

    @keyframes cardFadeIn {
        to {
            opacity: 1;
        }
    }

    .category-showcase-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 50px rgba(93, 78, 55, 0.2);
    }

    /* Category Image Container */
    .category-showcase-image {
        position: relative;
        height: 320px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .category-showcase-card:hover .category-image {
        transform: scale(1.1) rotate(2deg);
    }

    /* Image Overlay */
    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(93, 78, 55, 0.7) 0%, rgba(91, 68, 34, 0.85) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 5;
    }

    .category-showcase-card:hover .category-overlay {
        opacity: 1;
    }

    .overlay-action {
        text-align: center;
        color: white;
    }

    .overlay-action-icon {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.9;
    }

    .overlay-action-text {
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Category Badges */
    .category-badges {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .products-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: #5D4E37;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        backdrop-filter: blur(5px);
    }

    /* Category Info */
    .category-showcase-info {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .category-showcase-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #5D4E37;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .category-showcase-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    /* Category Stats */
    .category-stats-mini {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-item {
        flex: 1;
        text-align: center;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #8B6F47;
        line-height: 1;
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.5rem;
        font-weight: 600;
    }

    /* Category CTA Button */
    .category-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(93, 78, 55, 0.3);
        color: white;
    }

    .category-cta i {
        font-size: 1.1rem;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 992px) {
        .categories-hero {
            min-height: 350px;
        }

        .categories-hero-title {
            font-size: clamp(2rem, 5vw, 3rem);
        }

        .categories-hero-subtitle {
            font-size: 1.1rem;
        }

        .categories-hero-stats {
            gap: 2rem;
        }

        .hero-stat-number {
            font-size: 2rem;
        }

        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 2rem;
        }

        .category-showcase-image {
            height: 260px;
        }

        .intro-title {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 768px) {
        .categories-hero {
            min-height: 300px;
            margin-bottom: 2.5rem;
        }

        .categories-hero-content {
            padding: 2rem 1rem;
        }

        .categories-hero-title {
            font-size: 1.75rem;
        }

        .categories-hero-subtitle {
            font-size: 1rem;
        }

        .categories-hero-stats {
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .hero-stat-number {
            font-size: 1.75rem;
        }

        .hero-stat-label {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .category-showcase-image {
            height: 220px;
        }

        .category-showcase-info {
            padding: 1.5rem;
        }

        .category-showcase-title {
            font-size: 1.2rem;
        }

        .category-showcase-description {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .intro-title {
            font-size: 1.5rem;
        }

        .intro-description {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .categories-hero {
            min-height: 280px;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .categories-hero-content {
            padding: 1.5rem 1rem;
        }

        .categories-hero-title {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .categories-hero-subtitle {
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .categories-hero-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .categories-hero-stats {
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }

        .hero-stat {
            display: flex;
            gap: 1rem;
            align-items: center;
            text-align: left;
        }

        .hero-stat-number {
            font-size: 1.5rem;
            min-width: 50px;
        }

        .categories-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .category-showcase-image {
            height: 200px;
        }

        .category-showcase-info {
            padding: 1.25rem;
        }

        .category-showcase-title {
            font-size: 1.1rem;
        }

        .category-stats-mini {
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }

        .category-cta {
            padding: 0.85rem;
            font-size: 0.9rem;
        }

        .intro-title {
            font-size: 1.3rem;
        }

        .intro-subtitle {
            font-size: 0.8rem;
        }
    }
</style>

<!-- Hero Section Spectaculaire -->
<div class="categories-hero">
    <div class="categories-hero-background"></div>
    <div class="categories-hero-content">
        <div class="categories-hero-icon">
            <i class="bi bi-grid-3x3-gap"></i>
        </div>
        <h1 class="categories-hero-title">Nos Catégories</h1>
        <p class="categories-hero-subtitle">Découvrez une collection curatée de produits triés par catégorie. Chaque catégorie vous propose une sélection spécifique adaptée à vos besoins.</p>
        <div class="categories-hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-number">{{ $categories->count() }}</div>
                <div class="hero-stat-label">Catégories</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number">{{ $categories->sum('products_count') }}</div>
                <div class="hero-stat-label">Produits</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number">100%</div>
                <div class="hero-stat-label">Qualité</div>
            </div>
        </div>
    </div>
</div>

<!-- Introduction Section -->
<div class="categories-intro">
    <span class="intro-subtitle">✨ Explorez</span>
    <h2 class="intro-title">Trouvez Exactement Ce Que Vous Cherchez</h2>
    <p class="intro-description">Parcourez nos catégories soigneusement organisées pour une expérience de shopping optimale. Chaque catégorie contient des produits sélectionnés avec soin.</p>
    <a href="{{ route('shop.products.index') }}" class="intro-cta">
        <i class="bi bi-box-seam"></i> Voir tous les produits
    </a>
</div>

@if ($categories->isEmpty())
    <!-- État vide -->
    <div class="empty-state-categories">
        <div class="empty-state-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h3>Aucune catégorie disponible</h3>
        <p>Revenez bientôt ! De nouvelles catégories seront ajoutées.</p>
    </div>
@else
    <!-- Grille de catégories -->
    <div class="categories-grid">
        @foreach ($categories as $index => $category)
            <div class="category-showcase-card" style="animation-delay: {{ $index * 0.1 }}s">
                <!-- Image avec overlay -->
                <div class="category-showcase-image">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);">
                            <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                    @endif
                    
                    <div class="category-overlay">
                        <div class="overlay-action">
                            <div class="overlay-action-icon">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                            <div class="overlay-action-text">Voir les produits</div>
                        </div>
                    </div>

                    <!-- Badge produits -->
                    <div class="category-badges">
                        <span class="products-badge">
                            <i class="bi bi-bag-check"></i>
                            {{ $category->products_count }} produit{{ $category->products_count > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>

                <!-- Category Info -->
                <div class="category-showcase-info">
                    <h3 class="category-showcase-title">{{ $category->name }}</h3>
                    <p class="category-showcase-description">{{ Str::limit($category->description, 100) ?? 'Une collection de produits variés et de qualité.' }}</p>

                    <!-- Mini Stats -->
                    <div class="category-stats-mini">
                        <div class="stat-item">
                            <span class="stat-value">{{ $category->products_count }}</span>
                            <span class="stat-label">Articles</span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <a href="{{ route('shop.categories.show', $category) }}" class="category-cta">
                        <i class="bi bi-shop"></i> Parcourir
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des statistiques du hero
        const heroStats = document.querySelectorAll('.hero-stat-number');
        heroStats.forEach(stat => {
            const finalValue = parseInt(stat.textContent);
            if (finalValue && !isNaN(finalValue)) {
                let currentValue = 0;
                const increment = Math.ceil(finalValue / 40);
                const interval = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue;
                        clearInterval(interval);
                    } else {
                        stat.textContent = currentValue;
                    }
                }, 25);
            }
        });

        // Animation des cartes au scroll
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

        document.querySelectorAll('.category-showcase-card').forEach(card => {
            observer.observe(card);
        });
    });
</script>

@endsection
