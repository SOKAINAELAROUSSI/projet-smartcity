@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px;">
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 450px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="font-size: 2rem; color: var(--text-main); margin-bottom: 8px;">Bon retour !</h2>
            <p style="color: var(--text-muted);">Connectez-vous pour gérer vos signalements.</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none; transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e5e7eb'">
                @error('email') <span style="color: #ef4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Mot de passe</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none; transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e5e7eb'">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">Se connecter</button>
        </form>

        <div style="text-align: center; margin-top: 24px;">
            <p style="color: var(--text-muted);">Pas encore de compte ? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Inscrivez-vous</a></p>
        </div>
    </div>
</div>
@endsection
