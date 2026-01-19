<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Afficher le profil utilisateur
     */
    public function profile()
    {
        $user = Auth::user();
        return view('shop.account.profile', compact('user'));
    }

    /**
     * Afficher les commandes de l'utilisateur
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->latest('created_at')
            ->paginate(10);

        return view('shop.account.orders', compact('orders'));
    }

    /**
     * Afficher le détail d'une commande
     */
    public function orderDetail($orderNumber)
    {
        $user = Auth::user();
        $order = $user->orders()
            ->where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('shop.account.order-detail', compact('order'));
    }
}
