@extends('layouts.shop')

@section('title', 'Mon panier')

@section('content')

<h1>🛒 Mon panier</h1>

@if (empty($cart))
    <div style="text-align: center; padding: 60px 20px;">
        <p style="font-size: 4em; margin: 0;">🛒</p>
        <h2 style="color: #6c757d;">Votre panier est vide</h2>
        <p style="color: #6c757d;">Ajoutez des produits pour commencer vos achats.</p>
        <br>
        <a href="{{ route('shop.products.index') }}" style="
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        ">
            Voir le catalogue
        </a>
    </div>
@else
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
        
        <!-- Liste des produits -->
        <div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 15px; text-align: left;">Produit</th>
                        <th style="padding: 15px; text-align: center;">Prix unitaire</th>
                        <th style="padding: 15px; text-align: center;">Quantité</th>
                        <th style="padding: 15px; text-align: center;">Disponible</th>
                        <th style="padding: 15px; text-align: right;">Total</th>
                        <th style="padding: 15px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $productId => $item)
                        @php
                            $product = \App\Models\Product::find($productId);
                        @endphp
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 20px;">
                                <div>
                                    <strong style="font-size: 1.1em;">{{ $item['name'] }}</strong><br>
                                    <small style="color: #6c757d;">{{ $item['category'] }}</small>
                                </div>
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                {{ number_format($item['price'], 2) }} €
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                <form action="{{ route('shop.cart.update', $productId) }}" method="POST" style="display: inline-flex; align-items: center; gap: 5px;">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                           style="width: 60px; padding: 5px; text-align: center; border: 1px solid #ddd;">
                                    <button type="submit" style="padding: 5px 10px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 3px;">
                                        ✓
                                    </button>
                                </form>
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                @if($product && $product->stock > 0)
                                    <span style="font-weight: bold; color: #28a745;">{{ $product->stock }} en stock</span>
                                @else
                                    <span style="font-weight: bold; color: #dc3545;">❌ Rupture</span>
                                @endif
                            </td>
                            <td style="padding: 20px; text-align: right;">
                                <strong>{{ number_format($item['price'] * $item['quantity'], 2) }} €</strong>
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                <form action="{{ route('shop.cart.remove', $productId) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Retirer ce produit du panier ?')"
                                            style="padding: 8px 12px; background: #dc3545; color: white; border: none; cursor: pointer; border-radius: 3px;">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                <form action="{{ route('shop.cart.clear') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Vider tout le panier ?')"
                            style="padding: 10px 20px; background: #6c757d; color: white; border: none; cursor: pointer; border-radius: 5px;">
                        Vider le panier
                    </button>
                </form>
            </div>
        </div>

        <!-- Résumé commande -->
        <div>
            <div style="background: #f8f9fa; padding: 25px; border-radius: 5px; border: 1px solid #dee2e6;">
                <h3 style="margin-top: 0; border-bottom: 2px solid #dee2e6; padding-bottom: 15px;">Résumé de la commande</h3>
                
                <div style="margin: 20px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Sous-total :</span>
                        <span>{{ number_format($total, 2) }} €</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #6c757d; font-size: 0.9em;">
                        <span>Livraison :</span>
                        <span>Gratuite</span>
                    </div>
                    <hr style="margin: 15px 0; border: none; border-top: 1px solid #dee2e6;">
                    <div style="display: flex; justify-content: space-between; font-size: 1.3em; font-weight: bold;">
                        <span>Total :</span>
                        <span style="color: #007bff;">{{ number_format($total, 2) }} €</span>
                    </div>
                </div>

                <a href="{{ route('shop.checkout') }}" style="
                    display: block;
                    width: 100%;
                    padding: 15px;
                    background: #28a745;
                    color: white;
                    border: none;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 1.1em;
                    font-weight: bold;
                    margin-top: 20px;
                    text-align: center;
                    text-decoration: none;
                ">
                    Passer la commande
                </a>

                <a href="{{ route('shop.products.index') }}" style="
                    display: block;
                    text-align: center;
                    margin-top: 15px;
                    color: #007bff;
                    text-decoration: none;
                ">
                    ← Continuer mes achats
                </a>
            </div>
        </div>
    </div>
@endif

@endsection
