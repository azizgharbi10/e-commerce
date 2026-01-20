@extends('layouts.shop')

@section('title', $product->name)

@section('content')

<div style="max-width: 900px; margin: 0 auto;">
    
    <!-- Navigation -->
    <div style="margin-bottom: 30px; display: flex; gap: 12px; align-items: center;">
        <a href="{{ route('shop.products.index') }}" style="
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(139, 111, 71, 0.2);
        " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 111, 71, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(139, 111, 71, 0.2)'">
            <span>←</span> Retour au catalogue
        </a>
        <span style="color: #ddd; font-size: 1.5em;">|</span>
        <a href="{{ route('shop.categories.show', $product->category) }}" style="
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: #8B6F47;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            border: 2px solid #8B6F47;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(139, 111, 71, 0.1);
        " onmouseover="this.style.background='#8B6F47'; this.style.color='white'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 111, 71, 0.3)'" onmouseout="this.style.background='white'; this.style.color='#8B6F47'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(139, 111, 71, 0.1)'">
            📁 {{ $product->category->name }}
        </a>
    </div>

    <!-- Produit -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px;">
        
        <!-- Galerie d'images -->
        <div>
            <!-- Image principale -->
            <div style="background: #f0f0f0; height: 400px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; margin-bottom: 15px;">
                @if($product->image)
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span style="color: #999; font-size: 3em;">📦</span>
                @endif
            </div>

            <!-- Miniatures -->
            @if($product->images->count() > 0 || $product->image)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                    <!-- Miniature de l'image principale -->
                    @if($product->image)
                        <div 
                            class="thumbnail-main" 
                            onclick="changeImage('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')"
                            style="
                                cursor: pointer;
                                border: 2px solid #8B6F47;
                                border-radius: 8px;
                                overflow: hidden;
                                height: 80px;
                                transition: border-color 0.3s;
                            "
                            onmouseover="this.style.borderColor='#5D4E37'"
                            onmouseout="this.style.borderColor='#8B6F47'"
                        >
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Miniatures des images supplémentaires -->
                    @foreach($product->images as $image)
                        <div 
                            class="thumbnail" 
                            onclick="changeImage('{{ asset('storage/' . $image->image) }}', '{{ $image->alt_text ?? $product->name }}')"
                            style="
                                cursor: pointer;
                                border: 2px solid #ddd;
                                border-radius: 8px;
                                overflow: hidden;
                                height: 80px;
                                transition: border-color 0.3s;
                            "
                            onmouseover="this.style.borderColor='#8B6F47'"
                            onmouseout="this.style.borderColor='#ddd'"
                        >
                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->alt_text ?? $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Informations produit -->
        <div>
            <h1 style="margin-top: 0; font-size: 2em;">{{ $product->name }}</h1>
            
            <!-- Prix mis en avant -->
            <div style="background: #f8f9fa; padding: 20px; border-left: 4px solid #8B6F47; margin: 20px 0;">
                <div style="font-size: 2.5em; font-weight: bold; color: #8B6F47;">
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
                    background: #8B6F47;
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
                <a href="{{ route('shop.categories.show', $product->category) }}" style="color: #8B6F47; text-decoration: none;">
                    {{ $product->category->name }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(src, alt) {
        document.getElementById('mainImage').src = src;
        document.getElementById('mainImage').alt = alt;
    }
</script>

@endsection
