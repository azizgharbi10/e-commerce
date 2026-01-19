<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App Vente')</title>
</head>
<body>

<header>
    <h2>App Vente en ligne</h2>
    <nav>
        <a href="{{ route('categories.index') }}">Catégories</a> |
        <a href="{{ route('categories.create') }}">Ajouter catégorie</a> |
        <a href="{{ route('products.index') }}">Produits</a> |
        <a href="{{ route('products.create') }}">Ajouter produit</a>
    </nav>
    <hr>
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <p>© {{ date('Y') }} - App Vente</p>
</footer>

</body>
</html>
