@extends('layouts.admin')

@section('title', 'Détail commande ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">← Retour</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            ⚠ {{ session('warning') }}
        </div>
    @endif

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

    <!-- Modifier le statut -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Modifier le statut</h2>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-3">
            @csrf
            @method('PUT')

            <select name="status" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                <option value="">-- Sélectionner un statut --</option>
                @if($order->status === 'pending')
                    <option value="paid">Marquer comme payée</option>
                    <option value="cancelled">Annuler</option>
                @elseif($order->status === 'paid')
                    <option value="shipped">Marquer comme expédiée</option>
                    <option value="cancelled">Annuler</option>
                @elseif($order->status === 'shipped')
                    <option value="delivered">Marquer comme livrée</option>
                @endif
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded transition">
                Mettre à jour
            </button>
        </form>

        @error('status')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Informations client -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Informations client</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Nom</p>
                <p class="text-lg">{{ $order->customer_name }}</p>

                <p class="text-sm text-gray-500 uppercase font-medium mt-3 mb-1">Email</p>
                <p class="text-lg"><a href="mailto:{{ $order->customer_email }}" class="text-blue-600 hover:text-blue-800">{{ $order->customer_email }}</a></p>

                @if($order->customer_phone)
                    <p class="text-sm text-gray-500 uppercase font-medium mt-3 mb-1">Téléphone</p>
                    <p class="text-lg">{{ $order->customer_phone }}</p>
                @endif

                @if($order->user_id)
                    <p class="text-sm text-gray-500 uppercase font-medium mt-3 mb-1">Client</p>
                    <p class="text-lg">Utilisateur inscrit (ID: {{ $order->user_id }})</p>
                @else
                    <p class="text-sm text-gray-500 uppercase font-medium mt-3 mb-1">Type</p>
                    <p class="text-lg bg-gray-100 px-2 py-1 rounded inline-block">Client invité</p>
                @endif
            </div>

            <div>
                <p class="text-sm text-gray-500 uppercase font-medium mb-1">Adresse de livraison</p>
                <div class="bg-gray-50 p-3 rounded border border-gray-200">
                    <p class="text-lg font-medium">{{ $order->shipping_address['address'] ?? '-' }}</p>
                    <p class="text-lg">{{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}</p>
                </div>

                @if($order->notes)
                    <p class="text-sm text-gray-500 uppercase font-medium mt-4 mb-1">Remarques</p>
                    <div class="bg-yellow-50 p-3 rounded border border-yellow-200">
                        <p>{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Articles commandés -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Articles commandés ({{ $order->items->count() }})</h2>
        
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
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
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
        @else
            <p class="text-gray-600">Aucun article dans cette commande.</p>
        @endif
    </div>
</div>
@endsection
