<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Afficher le formulaire de checkout
     */
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart.index')
                           ->with('warning', 'Votre panier est vide.');
        }

        // Valider le panier avant affichage
        $errors = $this->orderService->validateCart($cart);
        if (!empty($errors)) {
            return redirect()->route('shop.cart.index')
                           ->with('warning', implode(' ', $errors));
        }

        $total = $this->orderService->calculateTotal($cart);
        $user = auth()->user(); // Récupérer l'utilisateur connecté

        return view('shop.orders.checkout', compact('cart', 'total', 'user'));
    }

    /**
     * Traiter la commande
     */
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart.index')
                           ->with('warning', 'Votre panier est vide.');
        }

        // Validation du formulaire
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'customer_name.required' => 'Le nom est obligatoire.',
            'customer_email.required' => 'L\'email est obligatoire.',
            'customer_email.email' => 'L\'email doit être valide.',
            'address.required' => 'L\'adresse est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'postal_code.required' => 'Le code postal est obligatoire.',
        ]);

        try {
            // Préparer les données client
            $customerData = [
                'user_id' => auth()->id(), // null si guest
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => [
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                ],
                'notes' => $validated['notes'] ?? null,
            ];

            // Créer la commande (transaction atomique)
            $order = $this->orderService->createOrderFromCart($cart, $customerData);

            // Vider le panier
            session()->forget('cart');

            // Rediriger vers confirmation
            return redirect()->route('shop.orders.confirmation', $order->order_number)
                           ->with('success', 'Votre commande a été enregistrée avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('warning', 'Erreur lors de la création de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Afficher la confirmation de commande
     */
    public function confirmation($orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
        $order->load('items');

        return view('shop.orders.confirmation', compact('order'));
    }
}
