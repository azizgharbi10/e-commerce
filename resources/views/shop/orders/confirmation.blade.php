@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="text-center mb-8">
        <div class="inline-block bg-green-100 rounded-full p-4 mb-4">
            <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Commande confirmée !</h1>
        <p class="text-lg text-gray-600">Merci pour votre achat</p>
    </div>

    <!-- Informations commande -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Numéro de commande -->
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Numéro de commande</p>
                <p class="text-2xl font-bold text-blue-600">{{ $order->order_number }}</p>
            </div>

            <!-- Statut -->
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Statut</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <!-- Total -->
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Montant total</p>
                <p class="text-2xl font-bold">{{ number_format($order->total_amount, 2) }} €</p>
            </div>

            <!-- Date -->
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Date de commande</p>
                <p class="text-lg">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Informations client -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Informations de livraison</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <p class="font-medium">{{ $order->customer_name }}</p>
                <p class="text-gray-600">{{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                @endif
            </div>
            <div>
                <p class="text-gray-700">{{ $order->shipping_address['address'] ?? '' }}</p>
                <p class="text-gray-700">{{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}</p>
            </div>
        </div>

        @if($order->notes)
            <div class="mt-4 pt-4 border-t">
                <p class="text-sm text-gray-500 font-medium mb-1">Remarques :</p>
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
        @endif
    </div>

    <!-- Détails articles -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Articles commandés</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex justify-between items-center pb-3 border-b border-gray-200 last:border-0">
                    <div class="flex-1">
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-600">Prix unitaire : {{ number_format($item->product_price, 2) }} €</p>
                        <p class="text-sm text-gray-600">Quantité : {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-lg">{{ number_format($item->subtotal, 2) }} €</p>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center text-xl font-bold mt-6 pt-4 border-t-2 border-gray-300">
            <span>Total</span>
            <span class="text-blue-600">{{ number_format($order->total_amount, 2) }} €</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-center space-x-4">
        <a 
            href="{{ route('shop.products.index') }}" 
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded transition"
        >
            Continuer mes achats
        </a>
        <button 
            onclick="window.print()" 
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded transition"
        >
            Imprimer
        </button>
    </div>

    <p class="text-center text-sm text-gray-500 mt-8">
        Un email de confirmation a été envoyé à <strong>{{ $order->customer_email }}</strong>
    </p>
</div>
@endsection
