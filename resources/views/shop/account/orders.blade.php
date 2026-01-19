@extends('layouts.shop')

@section('title', 'Mes commandes')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Mes commandes</h1>
        <a href="{{ route('shop.account.profile') }}" class="text-blue-600 hover:text-blue-800">← Mon profil</a>
    </div>

    @if($orders->count() > 0)
        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Numéro</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Articles</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-700">Total</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Statut</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Date</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono font-bold text-blue-600">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-center">{{ $order->items->count() }}</td>
                            <td class="px-4 py-3 text-right font-bold">{{ number_format($order->total_amount, 2) }} €</td>
                            <td class="px-4 py-3 text-center">
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
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-600">
                                {{ $order->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a 
                                    href="{{ route('shop.account.orderDetail', $order->order_number) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold"
                                >
                                    Détail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-gray-100 border border-gray-300 rounded-lg p-8 text-center">
            <p class="text-gray-600 text-lg mb-4">Vous n'avez pas encore de commande.</p>
            <a 
                href="{{ route('shop.products.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded transition"
            >
                Commencer vos achats
            </a>
        </div>
    @endif
</div>
@endsection
