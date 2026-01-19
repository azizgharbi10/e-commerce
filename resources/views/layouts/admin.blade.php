<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Boutique Admin</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Commun Global -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --admin-primary: #2c3e50;
            --admin-secondary: #34495e;
            --admin-accent: #3498db;
            --admin-success: #27ae60;
            --admin-warning: #f39c12;
            --admin-danger: #e74c3c;
            --admin-light: #ecf0f1;
            --admin-dark: #1a252f;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f6fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-navbar {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0;
        }

        .admin-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: white !important;
            letter-spacing: 0.5px;
        }

        .admin-navbar .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
        }

        .admin-navbar .nav-link:hover {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        .admin-navbar .nav-link.active {
            color: white !important;
            background-color: rgba(255,255,255,0.15);
            border-radius: 4px;
        }

        .btn-shop-link {
            background-color: var(--admin-accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-shop-link:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .content-wrapper {
            flex: 1;
            padding: 2rem 0;
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .page-header h1 {
            color: var(--admin-primary);
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }

        .admin-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 1.5rem;
        }

        .admin-card .card-header {
            background: var(--admin-light);
            border-bottom: 2px solid var(--admin-accent);
            font-weight: 600;
            color: var(--admin-primary);
            padding: 1rem 1.5rem;
        }

        .admin-footer {
            background: var(--admin-primary);
            color: rgba(255,255,255,0.7);
            padding: 2rem 0;
            margin-top: auto;
        }

        .admin-footer a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: color 0.3s;
        }

        .admin-footer a:hover {
            color: white;
        }

        .btn-admin-primary {
            background-color: var(--admin-accent);
            border-color: var(--admin-accent);
            color: white;
        }

        .btn-admin-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navigation Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.orders.index') }}">
                <i class="bi bi-gear-fill"></i> ADMINISTRATION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                           href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-folder"></i> Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                           href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i> Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                           href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-receipt"></i> Commandes
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('shop.products.index') }}" class="btn btn-shop-link me-3" target="_blank">
                        <i class="bi bi-shop"></i> Voir la boutique
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="content-wrapper">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Footer Admin -->
    <footer class="admin-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© {{ date('Y') }} Boutique - Panneau d'administration</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="me-3"><i class="bi bi-person-badge"></i> {{ auth()->user()->name }}</span>
                    <span><i class="bi bi-shield-check"></i> Administrateur</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
