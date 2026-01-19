@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="auth-header">
    <h1>Connexion</h1>
    <p>Accédez à votre compte</p>
</div>

<!-- Bouton retour vers inscription visible en haut -->
<div class="mb-3">
    <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100" style="border-color: #667eea; color: #667eea; font-weight: 600;">
        <i class="bi bi-person-plus me-2"></i>Créer un compte
    </a>
</div>

@if(session('warning'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

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
            autofocus
        >
        @error('email')
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
            placeholder="Votre mot de passe"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-auth">
        Se connecter
    </button>
</form>

<div class="divider">
    <span>ou</span>
</div>

<div class="auth-link">
    Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
</div>
@endsection
