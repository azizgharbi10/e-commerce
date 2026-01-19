@extends('layouts.shop')

@section('title', 'Détail commande ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">{{ $order->order_number }}</h1>
        <a href="{{ route('shop.account.orders') }}" class="text-blue-600 hover:text-blue-800">← Mes commandes</a>
    </div>

    <!-- Informations commande -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-500 uppercase font-medium">Statut</p>
            <p class="text-xl font-bold mt-2">
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-500 uppercase font-medium">Total</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($order->total_amount, 2) }} €</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-500 uppercase font-medium">Date</p>
            <p class="text-lg mt-2">{{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Informations client -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Informations de livraison</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-2">Contact</p>
                <p class="font-medium">{{ $order->customer_name }}</p>
                <p class="text-gray-600">{{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-2">Adresse</p>
                <p class="text-gray-700">{{ $order->shipping_address['address'] ?? '' }}</p>
                <p class="text-gray-700">{{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}</p>
            </div>
        </div>

        @if($order->notes)
            <div class="mt-4 pt-4 border-t">
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Remarques :</p>
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
        @endif
    </div>

    <!-- Articles commandés -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Articles commandés</h2>
        
        @if($order->items->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-2 font-semibold text-gray-700">Produit</th>
                            <th class="px-4 py-2 text-center font-semibold text-gray-700">Quantité</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-700">Prix unitaire</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-700">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-3">
                                    <p class="font-medium">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->product_slug }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($item->product_price, 2) }} €</td>
                                <td class="px-4 py-3 text-right font-bold">{{ number_format($item->subtotal, 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-4 pt-4 border-t-2 border-gray-300">
                <p class="text-xl font-bold">
                    Total : <span class="text-blue-600">{{ number_format($order->total_amount, 2) }} €</span>
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
