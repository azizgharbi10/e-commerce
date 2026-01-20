@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="auth-header">
    <h1>Créer un compte</h1>
    <p>Rejoignez notre communauté</p>
</div>

<!-- Bouton retour vers connexion visible en haut -->
<div class="mb-3">
    <a href="{{ route('login') }}" class="btn btn-outline-brown w-100" style="font-weight: 600;">
        <i class="bi bi-arrow-left me-2"></i>Retour à la connexion
    </a>
</div>

<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom complet</label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            placeholder="John Doe"
            required
            autofocus
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            placeholder="vous@exemple.com"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Téléphone</label>
        <input 
            type="tel" 
            name="phone" 
            id="phone" 
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone') }}"
            placeholder="+33 6 12 34 56 78"
            required
        >
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Minimum 8 caractères"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input 
            type="password" 
            name="password_confirmation" 
            id="password_confirmation" 
            class="form-control"
            placeholder="Répétez votre mot de passe"
            required
        >
    </div>

    <button type="submit" class="btn btn-auth btn-connect">
        <i class="bi bi-person-plus me-2"></i>CRÉER MON COMPTE
    </button>
</form>

<div class="divider">
    <span>ou</span>
</div>

<div class="auth-link">
    Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
</div>
@endsection
