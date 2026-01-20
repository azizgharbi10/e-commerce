<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boutique en ligne')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Commun Global -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-brown: #8B6F47;
            --dark-brown: #5D4E37;
            --light-brown: #D4A574;
            --cream: #F5F1ED;
            --cream-bg: #FFFBF7;
            --accent: #C19A6B;
            --text-dark: #3E2723;
            --text-muted: #6D6D6D;
            --border-light: #E8DED2;
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            color: var(--text-dark);
            background-color: #2C2416;
            background-image: 
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80'),
                url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&q=80'),
                url('https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=600&q=80'),
                url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&q=80'),
                url('https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&q=80');
            background-size: 
                50% auto,
                30% auto,
                25% auto,
                30% auto,
                25% auto;
            background-position: 
                left top,
                right 5% top 15%,
                left 10% bottom 20%,
                right 10% bottom 10%,
                center bottom;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        /* Overlay marron pour cohérence */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(93, 78, 55, 0.75) 0%, rgba(139, 111, 71, 0.70) 50%, rgba(212, 165, 116, 0.65) 100%);
            z-index: 0;
            pointer-events: none;
        }
        
        /* Pattern de points animé */
        body::after {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: movePattern 25s linear infinite;
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }
        
        @keyframes movePattern {
            0% { transform: translate(0, 0); }
            100% { transform: translate(40px, 40px); }
        }
        
        /* Container avec z-index pour passer au-dessus de l'overlay */
        .navbar,
        main,
        .footer {
            position: relative;
            z-index: 1;
        }
        
        main {
            flex: 1;
            padding-top: 2rem;
            padding-bottom: 4rem;
        }
        
        /* Container interne avec fond blanc pour le contenu */
        main .container {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background: var(--dark-brown) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 12px rgba(93, 78, 55, 0.08);
            border-bottom: 1px solid var(--border-light);
            position: relative;
            z-index: 1050;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--light-brown) !important;
            transform: translateY(-1px);
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--light-brown);
            color: var(--dark-brown);
            border-radius: 50%;
            padding: 3px 7px;
            font-size: 0.7rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background: var(--primary-brown);
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--dark-brown);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(93, 78, 55, 0.3);
        }
        
        .btn-outline-light {
            border-color: var(--light-brown);
            color: var(--light-brown);
        }
        
        .btn-outline-light:hover {
            background: var(--light-brown);
            border-color: var(--light-brown);
            color: var(--dark-brown);
        }
        
        .dropdown-menu {
            border: 1px solid var(--border-light);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            border-radius: 12px;
            min-width: 220px;
            padding: 8px 0;
            margin-top: 8px;
            z-index: 1060;
            overflow: visible !important;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            font-weight: 500;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .dropdown-item:hover {
            background: var(--cream);
            color: var(--primary-brown);
        }
        
        .dropdown-item.text-danger {
            color: #dc3545 !important;
            font-weight: 600;
        }
        
        .dropdown-item.text-danger:hover {
            background: #fff5f5;
            color: #c62828 !important;
        }
        
        /* Style pour les boutons dans dropdown */
        .dropdown-item[type="submit"] {
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
        }
        
        /* Séparateur plus visible */
        .dropdown-divider {
            margin: 8px 0;
            border-top: 1px solid var(--border-light);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
        }
        
        .alert-warning {
            background: #FFF3E0;
            color: #E65100;
        }
        
        .alert-danger {
            background: #FFEBEE;
            color: #C62828;
        }
        
        .footer {
            background: var(--cream);
            border-top: 2px solid var(--border-light);
            margin-top: 4rem;
            padding: 3rem 0 1.5rem;
        }
        
        .footer h5, .footer h6 {
            color: var(--dark-brown);
            font-weight: 700;
        }
        
        .footer a {
            color: var(--text-muted);
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-brown);
        }
        
        /* Card Styles */
        .card {
            border: 1px solid var(--border-light);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(93, 78, 55, 0.12);
        }
        
        /* Container spacing */
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('shop.products.index') }}">
                <i class="bi bi-shop-window"></i> BOUTIQUE
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products.index') }}">
                            <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.categories.index') }}">
                            <i class="bi bi-grid"></i> Catégories
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('shop.cart.index') }}">
                            <i class="bi bi-cart3"></i> Panier
                            @if (session('cart') && count(session('cart')) > 0)
                                <span class="cart-badge">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}" style="background: linear-gradient(135deg, var(--light-brown) 0%, var(--accent) 100%); border-radius: 8px; padding: 8px 16px !important; color: var(--dark-brown) !important; font-weight: 600; margin: 0 10px;">
                                    <i class="bi bi-gear-fill"></i> Administration
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.account.profile') }}">
                                        <i class="bi bi-person"></i> Mon profil
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Se déconnecter
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.account.orders') }}">
                                        <i class="bi bi-box-seam"></i> Mes commandes
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Succès !</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Attention !</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>Erreur !</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-shop-window text-primary"></i> BOUTIQUE
                    </h5>
                    <p class="text-muted small" style="line-height: 1.6;">
                        Découvrez notre sélection de produits soigneusement choisis. 
                        Qualité premium et service client d'excellence.
                    </p>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="mb-3">Navigation rapide</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('shop.categories.index') }}" class="text-decoration-none">Catégories</a></li>
                        <li class="mb-2"><a href="{{ route('shop.cart.index') }}" class="text-decoration-none">Mon panier</a></li>
                        @auth
                            <li class="mb-2"><a href="{{ route('shop.account.profile') }}" class="text-decoration-none">Mon compte</a></li>
                            <li class="mb-2"><a href="{{ route('shop.account.orders') }}" class="text-decoration-none">Mes commandes</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="mb-3">Contact</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> contact@boutique.com</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> +33 1 23 45 67 89</li>
                        <li class="mb-2"><i class="bi bi-clock me-2"></i> Lun-Ven 9h-18h</li>
                    </ul>
                </div>
            </div>
            
            <hr style="border-color: var(--border-light); margin: 2rem 0 1.5rem;">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-muted small mb-0">
                        © {{ date('Y') }} Boutique. Tous droits réservés.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted text-decoration-none me-3 fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted text-decoration-none me-3 fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-muted text-decoration-none fs-5"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
