<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    /**
     * Valider le panier avant création de commande
     */
    public function validateCart(array $cart): array
    {
        $errors = [];

        if (empty($cart)) {
            $errors[] = 'Le panier est vide.';
            return $errors;
        }

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                $errors[] = "Le produit '{$item['name']}' n'existe plus.";
                continue;
            }

            if ($product->status !== 'active') {
                $errors[] = "Le produit '{$product->name}' n'est plus disponible.";
            }

            if ($product->stock < $item['quantity']) {
                $errors[] = "Stock insuffisant pour '{$product->name}'. Disponible: {$product->stock}, Demandé: {$item['quantity']}.";
            }
        }

        return $errors;
    }

    /**
     * Vérifier la disponibilité du stock pour tous les produits
     */
    public function checkStockAvailability(array $cart): array
    {
        $availability = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            $availability[$productId] = [
                'available' => $product && $product->status === 'active' && $product->stock >= $item['quantity'],
                'product' => $product,
                'requested' => $item['quantity'],
                'in_stock' => $product ? $product->stock : 0,
            ];
        }

        return $availability;
    }

    /**
     * Créer une commande à partir du panier (transaction atomique)
     */
    public function createOrderFromCart(array $cart, array $customerData): Order
    {
        // Validation préalable
        $errors = $this->validateCart($cart);
        if (!empty($errors)) {
            throw new Exception(implode(' ', $errors));
        }

        return DB::transaction(function () use ($cart, $customerData) {
            // 1. Générer numéro de commande unique
            $orderNumber = $this->generateOrderNumber();

            // 2. Calculer le total
            $totalAmount = $this->calculateTotal($cart);

            // 3. Créer la commande
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $customerData['user_id'] ?? null,
                'customer_name' => $customerData['customer_name'],
                'customer_email' => $customerData['customer_email'],
                'customer_phone' => $customerData['customer_phone'] ?? null,
                'shipping_address' => $customerData['shipping_address'],
                'billing_address' => $customerData['billing_address'] ?? $customerData['shipping_address'],
                'total_amount' => $totalAmount,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_PENDING,
                'payment_method' => $customerData['payment_method'] ?? null,
                'notes' => $customerData['notes'] ?? null,
            ]);

            // 4. Créer les lignes de commande (snapshots)
            foreach ($cart as $productId => $item) {
                $product = Product::lockForUpdate()->find($productId);

                if (!$product || $product->stock < $item['quantity']) {
                    throw new Exception("Stock insuffisant pour le produit '{$item['name']}'.");
                }

                // Créer l'item avec snapshot
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_slug' => $product->slug,
                    'product_price' => $product->price,
                    'quantity' => $item['quantity'],
                ]);

                // 5. Décrémenter le stock
                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }

    /**
     * Générer un numéro de commande unique
     */
    public function generateOrderNumber(): string
    {
        $year = date('Y');
        $lastOrder = Order::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastOrder ? (int) substr($lastOrder->order_number, -5) + 1 : 1;

        return sprintf('ORD-%s-%05d', $year, $nextNumber);
    }

    /**
     * Calculer le total du panier
     */
    public function calculateTotal(array $cart): float
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * Annuler une commande et restaurer le stock
     */
    public function cancelOrder(Order $order): bool
    {
        if (!$order->canBeCancelled()) {
            throw new Exception('Cette commande ne peut plus être annulée.');
        }

        return DB::transaction(function () use ($order) {
            // Restaurer le stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Mettre à jour le statut
            $order->update([
                'status' => Order::STATUS_CANCELLED,
            ]);

            return true;
        });
    }
}
