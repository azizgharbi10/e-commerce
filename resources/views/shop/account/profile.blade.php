@extends('layouts.shop')

@section('title', 'Mon profil')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-8">Mon profil</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Informations profil -->
        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Mes informations</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-medium">Nom</p>
                    <p class="text-lg font-medium">{{ $user->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-medium">Email</p>
                    <p class="text-lg">{{ $user->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-medium">Téléphone</p>
                    <p class="text-lg">{{ $user->phone ?? '(Non renseigné)' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 uppercase font-medium">Membre depuis</p>
                    <p class="text-lg">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <button class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded transition">
                Modifier mes informations
            </button>
        </div>

        <!-- Statistiques -->
        <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Statistiques</h2>
            
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Nombre de commandes</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $user->orders->count() }}</p>
                </div>

                <div class="bg-green-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Montant total dépensé</p>
                    <p class="text-3xl font-bold text-green-600">
                        {{ number_format($user->orders->sum('total_amount'), 2) }} €
                    </p>
                </div>

                <div class="bg-purple-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Commandes en cours</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $user->orders->whereIn('status', ['pending', 'paid', 'shipped'])->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 space-y-3">
        <a 
            href="{{ route('shop.account.orders') }}"
            class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded transition"
        >
            Voir mes commandes
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button 
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded transition"
            >
                Se déconnecter
            </button>
        </form>
    </div>
</div>
@endsection
