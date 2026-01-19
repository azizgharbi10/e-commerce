<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('shop.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        // Vérifier disponibilité
        if ($product->status !== 'active' || $product->stock <= 0) {
            return redirect()->back()->with('warning', 'Ce produit n\'est pas disponible.');
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = $request->input('quantity', 1);

        // Vérifier stock suffisant
        if ($quantity > $product->stock) {
            return redirect()->back()->with('warning', 'Stock insuffisant pour ce produit.');
        }

        $cart = session('cart', []);

        // Si produit déjà dans le panier, augmenter la quantité
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // Vérifier que la nouvelle quantité ne dépasse pas le stock
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('warning', 'Stock insuffisant pour ajouter cette quantité.');
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Ajouter nouveau produit au panier
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'category' => $product->category->name,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->route('shop.cart.index')->with('warning', 'Produit non trouvé dans le panier.');
        }

        // Vérifier stock disponible
        $product = Product::find($productId);
        if (!$product || $request->quantity > $product->stock) {
            return redirect()->route('shop.cart.index')->with('warning', 'Stock insuffisant.');
        }

        $cart[$productId]['quantity'] = $request->quantity;
        session(['cart' => $cart]);

        return redirect()->route('shop.cart.index')->with('success', 'Quantité mise à jour.');
    }

    public function remove($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
            return redirect()->route('shop.cart.index')->with('success', 'Produit retiré du panier.');
        }

        return redirect()->route('shop.cart.index')->with('warning', 'Produit non trouvé.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('shop.cart.index')->with('success', 'Panier vidé.');
    }

    private function calculateTotal(array $cart): float
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
}
