@extends('layouts.multishop')

@section('title', 'Boutique - Produits')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Notre Boutique</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('shop.products.index') }}">Accueil</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Boutique</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Shop Start -->
<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Categories Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrer par catégorie</span></h5>
            <div class="bg-light p-4 mb-30">
                <form method="GET" action="{{ route('shop.products.index') }}">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="category" id="category-all" value="" {{ request('category') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="category-all">Tous les produits</label>
                        <span class="badge border font-weight-normal">{{ $products->total() }}</span>
                    </div>
                    @if (!empty($categories))
                        @foreach ($categories as $category)
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="radio" class="custom-control-input" name="category" id="category-{{ $category->id }}" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                <span class="badge border font-weight-normal">{{ $category->products_count ?? 0 }}</span>
                            </div>
                        @endforeach
                    @endif
                </form>
            </div>
            <!-- Categories End -->

            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrer par prix</span></h5>
            <div class="bg-light p-4 mb-30">
                <form method="GET" action="{{ route('shop.products.index') }}">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" id="price-all" value="" {{ request('price') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="price-all">Tous les prix</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" id="price-1" value="0-50" {{ request('price') == '0-50' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="price-1">0€ - 50€</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" id="price-2" value="50-100" {{ request('price') == '50-100' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="price-2">50€ - 100€</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" name="price" id="price-3" value="100-200" {{ request('price') == '100-200' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="price-3">100€ - 200€</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="radio" class="custom-control-input" name="price" id="price-4" value="200-500" {{ request('price') == '200-500' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="custom-control-label" for="price-4">200€ - 500€</label>
                    </div>
                </form>
            </div>
            <!-- Price End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <form method="GET" action="{{ route('shop.products.index') }}" class="d-inline">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('price'))
                                    <input type="hidden" name="price" value="{{ request('price') }}">
                                @endif
                                <div class="btn-group">
                                    <select name="sort" class="form-control" onchange="this.form.submit()">
                                        <option value="">Trier par</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Aucun produit disponible pour le moment.
                        </div>
                    </div>
                @else
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    @if($product->image)
                                        <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 300px; object-fit: cover;">
                                    @else
                                        <img class="img-fluid w-100" src="https://via.placeholder.com/400x300?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" style="height: 300px; object-fit: cover;">
                                    @endif
                                    <div class="product-action">
                                        <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-outline-dark btn-square" 
                                                    @if($product->stock <= 0) disabled title="Rupture de stock" @else title="Ajouter au panier" @endif>
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </form>
                                        <a class="btn btn-outline-dark btn-square" href="{{ route('shop.products.show', $product) }}" title="Voir les détails">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square" href="#" title="Ajouter aux favoris"><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate d-block" href="{{ route('shop.products.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                    <p class="text-muted small mb-2">{{ $product->category->name }}</p>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ number_format($product->price, 2) }} €</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        @if($product->stock > 10)
                                            <small class="text-success"><i class="fa fa-check-circle mr-1"></i>En stock ({{ $product->stock }})</small>
                                        @elseif($product->stock > 0)
                                            <small class="text-warning"><i class="fa fa-exclamation-circle mr-1"></i>Stock limité ({{ $product->stock }})</small>
                                        @else
                                            <small class="text-danger"><i class="fa fa-times-circle mr-1"></i>Rupture de stock</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="col-12">
                        <nav>
                            {{ $products->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
@endsection
