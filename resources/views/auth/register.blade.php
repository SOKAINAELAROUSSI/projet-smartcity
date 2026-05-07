@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px;">
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 500px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="font-size: 2rem; color: var(--text-main); margin-bottom: 8px;">Rejoignez-nous</h2>
            <p style="color: var(--text-muted);">Créez votre compte SmartCity aujourd'hui.</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Nom complet</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none;">
                @error('email') <span style="color: #ef4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Rôle</label>
                <select name="role" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px;">
                    <option value="citizen">Citoyen</option>
                    <option value="admin">Administrateur</option>
                    <option value="technician">Technicien</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Mot de passe</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none;">
            </div>

            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #e5e7eb; background: white; outline: none;">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">S'inscrire</button>
        </form>

        <div style="text-align: center; margin-top: 24px;">
            <p style="color: var(--text-muted);">Déjà un compte ? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Connectez-vous</a></p>
        </div>
    </div>
</div>
@endsection
