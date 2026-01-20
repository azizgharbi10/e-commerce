@extends('layouts.shop')

@section('title', $product->name)

@section('content')

<div style="max-width: 900px; margin: 0 auto;">
    
    <!-- Navigation -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('shop.products.index') }}">← Retour au catalogue</a> |
        <a href="{{ route('shop.categories.show', $product->category) }}">{{ $product->category->name }}</a>
    </div>

    <!-- Produit -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px;">
        
        <!-- Image du produit -->
        <div style="background: #f0f0f0; height: 400px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; border-radius: 10px; overflow: hidden;">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <span style="color: #999; font-size: 3em;">📦</span>
            @endif
        </div>

        <!-- Informations produit -->
        <div>
            <h1 style="margin-top: 0; font-size: 2em;">{{ $product->name }}</h1>
            
            <!-- Prix mis en avant -->
            <div style="background: #f8f9fa; padding: 20px; border-left: 4px solid #007bff; margin: 20px 0;">
                <div style="font-size: 2.5em; font-weight: bold; color: #007bff;">
                    {{ number_format($product->price, 2) }} €
                </div>
                @if($product->stock > 10)
                    <p style="margin: 10px 0 0 0; color: #28a745; font-weight: bold;">✓ {{ $product->stock }} articles en stock</p>
                @elseif($product->stock > 0)
                    <p style="margin: 10px 0 0 0; color: #ff9800; font-weight: bold;">⚠️ Seulement {{ $product->stock }} article(s) disponible(s)</p>
                @else
                    <p style="margin: 10px 0 0 0; color: #dc3545; font-weight: bold;">❌ Rupture de stock</p>
                @endif
            </div>

            <!-- Appel à l'action -->
            <form action="{{ route('shop.cart.add', $product) }}" method="POST" style="margin: 30px 0;">
                @csrf
                
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <label style="display: flex; flex-direction: column; flex: 1;">
                        <span style="margin-bottom: 5px; font-weight: bold;">Quantité :</span>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required
                               style="padding: 10px; font-size: 1em; border: 1px solid #ddd; border-radius: 5px;">
                    </label>
                </div>
                
                <button type="submit" style="
                    width: 100%;
                    padding: 15px 30px;
                    font-size: 1.2em;
                    background: #28a745;
                    color: white;
                    border: none;
                    cursor: pointer;
                    border-radius: 5px;
                    font-weight: bold;
                ">
                    🛒 Ajouter au panier
                </button>
                <p style="text-align: center; margin-top: 10px; font-size: 0.9em; color: #666;">
                    Livraison rapide • Paiement sécurisé
                </p>
            </form>

            <!-- Description -->
            <div style="margin-top: 40px;">
                <h3 style="border-bottom: 2px solid #ddd; padding-bottom: 10px;">Description</h3>
                <p style="line-height: 1.6; color: #333;">
                    {{ $product->description ?? 'Aucune description disponible pour ce produit.' }}
                </p>
            </div>

            <!-- Catégorie -->
            <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                <strong>Catégorie :</strong>
                <a href="{{ route('shop.categories.show', $product->category) }}" style="color: #007bff; text-decoration: none;">
                    {{ $product->category->name }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
