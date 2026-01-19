@extends('layouts.shop')

@section('title', 'Finaliser ma commande')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-8">Finaliser ma commande</h1>

    @if(session('warning'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('warning') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Formulaire de commande -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Vos informations</h2>
            
            <form action="{{ route('shop.orders.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="customer_name" class="block font-medium mb-1">Nom complet *</label>
                    <input 
                        type="text" 
                        name="customer_name" 
                        id="customer_name" 
                        value="{{ old('customer_name', auth()->user()?->name ?? '') }}"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('customer_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="customer_email" class="block font-medium mb-1">Email *</label>
                    <input 
                        type="email" 
                        name="customer_email" 
                        id="customer_email" 
                        value="{{ old('customer_email', auth()->user()?->email ?? '') }}"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('customer_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="customer_phone" class="block font-medium mb-1">Téléphone</label>
                    <input 
                        type="tel" 
                        name="customer_phone" 
                        id="customer_phone" 
                        value="{{ old('customer_phone', auth()->user()?->phone ?? '') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('customer_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6">

                <h3 class="text-lg font-semibold mb-3">Adresse de livraison</h3>

                <!-- Adresse -->
                <div>
                    <label for="address" class="block font-medium mb-1">Rue et numéro *</label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        value="{{ old('address') }}"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ville -->
                <div>
                    <label for="city" class="block font-medium mb-1">Ville *</label>
                    <input 
                        type="text" 
                        name="city" 
                        id="city" 
                        value="{{ old('city') }}"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('city')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Code postal -->
                <div>
                    <label for="postal_code" class="block font-medium mb-1">Code postal *</label>
                    <input 
                        type="text" 
                        name="postal_code" 
                        id="postal_code" 
                        value="{{ old('postal_code') }}"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >
                    @error('postal_code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block font-medium mb-1">Remarques (optionnel)</label>
                    <textarea 
                        name="notes" 
                        id="notes" 
                        rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded transition"
                >
                    Confirmer la commande
                </button>
            </form>
        </div>

        <!-- Récapitulatif panier -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Récapitulatif</h2>
            <div class="bg-gray-50 border border-gray-200 rounded p-4">
                @foreach($cart as $productId => $item)
                    <div class="flex justify-between mb-3 pb-3 border-b border-gray-300">
                        <div>
                            <p class="font-medium">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-600">Quantité : {{ $item['quantity'] }}</p>
                        </div>
                        <p class="font-semibold">{{ number_format($item['price'] * $item['quantity'], 2) }} €</p>
                    </div>
                @endforeach

                <div class="flex justify-between items-center text-lg font-bold mt-4 pt-4 border-t-2 border-gray-400">
                    <span>Total</span>
                    <span class="text-2xl text-blue-600">{{ number_format($total, 2) }} €</span>
                </div>

                <p class="text-sm text-gray-500 mt-4">
                    * Paiement à la livraison
                </p>
            </div>

            <a 
                href="{{ route('shop.cart.index') }}" 
                class="block text-center mt-4 text-blue-600 hover:text-blue-800 underline"
            >
                ← Retour au panier
            </a>
        </div>
    </div>
</div>
@endsection
