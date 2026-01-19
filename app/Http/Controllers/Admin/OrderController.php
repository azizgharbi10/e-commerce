<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Lister toutes les commandes
     */
    public function index()
    {
        $orders = Order::latest('created_at')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show(Order $order)
    {
        $order->load('items', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:pending,paid,shipped,delivered,cancelled',
            ],
        ], [
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
        ]);

        // Valider que la transition de statut est autorisée
        $currentStatus = $order->status;
        $newStatus = $validated['status'];

        // Règles de transition
        $allowedTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
        ];

        if (!isset($allowedTransitions[$currentStatus]) || !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return redirect()->back()
                ->with('warning', "Impossible de passer de '{$currentStatus}' à '{$newStatus}'.");
        }

        // Restaurer le stock si la commande est annulée
        if ($newStatus === 'cancelled' && $currentStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $item->product?->increment('stock', $item->quantity);
            }
        }

        // Mettre à jour le statut
        $order->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "Le statut de la commande a été mis à jour à '{$newStatus}'.");
    }
}
