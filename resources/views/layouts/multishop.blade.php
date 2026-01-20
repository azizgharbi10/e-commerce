<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Boutique en ligne') - MultiShop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Boutique en ligne Laravel" name="keywords">
    <meta content="Boutique e-commerce moderne" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">À propos</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Aide</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        @auth
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('shop.account.profile') }}">Mon profil</a>
                                <a class="dropdown-item" href="{{ route('shop.account.orders') }}">Mes commandes</a>
                                @if(auth()->user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.orders.index') }}">Administration</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-dark text-decoration-none w-100 text-left pl-3">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-sign-in-alt"></i> Connexion
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-light ml-2">
                                <i class="fas fa-user-plus"></i> Inscription
                            </a>
                        @endauth
                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">FR</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">EN</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="{{ route('shop.cart.index') }}" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="{{ route('shop.products.index') }}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="{{ route('shop.products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher un produit" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Service Client</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Catégories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <a href="{{ route('shop.products.index') }}" class="nav-item nav-link">Tous les produits</a>
                        <a href="{{ route('shop.categories.index') }}" class="nav-item nav-link">Toutes les catégories</a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="{{ route('shop.products.index') }}" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('shop.products.index') }}" class="nav-item nav-link {{ request()->routeIs('shop.products.index') ? 'active' : '' }}">Accueil</a>
                            <a href="{{ route('shop.products.index') }}" class="nav-item nav-link {{ request()->routeIs('shop.products.*') ? 'active' : '' }}">Boutique</a>
                            <a href="{{ route('shop.cart.index') }}" class="nav-item nav-link {{ request()->routeIs('shop.cart.*') ? 'active' : '' }}">Panier</a>
                            @auth
                                <a href="{{ route('shop.account.orders') }}" class="nav-item nav-link {{ request()->routeIs('shop.account.*') ? 'active' : '' }}">Mon compte</a>
                            @endauth
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="{{ route('shop.cart.index') }}" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Succès !</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    @if (session('warning'))
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Attention !</strong> {{ session('warning') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times-circle mr-2"></i>
                        <strong>Erreur !</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Contactez-nous</h5>
                <p class="mb-4">Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans vos achats.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Rue Commerce, Paris, France</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>contact@multishop.fr</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+33 1 23 45 67 89</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Navigation</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="{{ route('shop.products.index') }}"><i class="fa fa-angle-right mr-2"></i>Accueil</a>
                            <a class="text-secondary mb-2" href="{{ route('shop.products.index') }}"><i class="fa fa-angle-right mr-2"></i>Boutique</a>
                            <a class="text-secondary mb-2" href="{{ route('shop.categories.index') }}"><i class="fa fa-angle-right mr-2"></i>Catégories</a>
                            <a class="text-secondary mb-2" href="{{ route('shop.cart.index') }}"><i class="fa fa-angle-right mr-2"></i>Panier</a>
                            @auth
                                <a class="text-secondary mb-2" href="{{ route('shop.checkout') }}"><i class="fa fa-angle-right mr-2"></i>Commander</a>
                            @endauth
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Mon compte</h5>
                        <div class="d-flex flex-column justify-content-start">
                            @auth
                                <a class="text-secondary mb-2" href="{{ route('shop.account.profile') }}"><i class="fa fa-angle-right mr-2"></i>Mon profil</a>
                                <a class="text-secondary mb-2" href="{{ route('shop.account.orders') }}"><i class="fa fa-angle-right mr-2"></i>Mes commandes</a>
                                <a class="text-secondary mb-2" href="{{ route('shop.cart.index') }}"><i class="fa fa-angle-right mr-2"></i>Mon panier</a>
                                @if(auth()->user()->role === 'admin')
                                    <a class="text-secondary mb-2" href="{{ route('admin.orders.index') }}"><i class="fa fa-angle-right mr-2"></i>Administration</a>
                                @endif
                            @else
                                <a class="text-secondary mb-2" href="{{ route('login') }}"><i class="fa fa-angle-right mr-2"></i>Connexion</a>
                                <a class="text-secondary mb-2" href="{{ route('register') }}"><i class="fa fa-angle-right mr-2"></i>Inscription</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Abonnez-vous pour recevoir nos dernières offres et nouveautés</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Votre Email">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">S'abonner</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Suivez-nous</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">MultiShop</a>. Tous droits réservés. Designé par
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distribué par: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="{{ asset('img/payments.png') }}" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
