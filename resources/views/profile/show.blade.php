@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 40px;
    }
    @media (max-width: 640px) {
        .profile-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 16px;
        }
        .profile-header h1 {
            font-size: 2.2rem !important;
        }
        .profile-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
</style>
<div class="citizen-container" style="max-width: 800px;">
    <div class="profile-header" style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 3rem; color: var(--slate-900); letter-spacing: -2px; margin: 0;">Paramètres du Compte</h1>
            <p style="color: var(--slate-500); font-weight: 500; margin: 4px 0 0;">Gérez vos informations personnelles et votre sécurité.</p>
        </div>
        <a href="{{ url()->previous() }}" class="btn-primary" style="background: var(--slate-100); color: var(--slate-900); border: 1px solid var(--slate-200); white-space: nowrap;">Retour</a>
    </div>

    @if(session('success'))
        <div class="glass-card animate-fade-in" style="padding: 16px 24px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 12px; margin-bottom: 32px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-card animate-slide-up" style="padding: 40px;">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: flex; align-items: center; gap: 24px; margin-bottom: 40px; padding: 24px; background: var(--primary-50); border-radius: 20px;">
                <div style="width: 80px; height: 80px; background: var(--primary-100); color: var(--primary-700); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 900; border: 4px solid white; box-shadow: var(--shadow-sm);">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 style="margin-bottom: 4px;">{{ $user->name }}</h3>
                    <p style="color: var(--primary-700); font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Rôle : {{ $user->role }}</p>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Nom complet</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none; font-weight: 600;">
                @error('name') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 32px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none; font-weight: 600;">
                @error('email') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <hr style="margin: 40px 0; border: none; border-top: 1px solid var(--slate-100);">

            <h4 style="margin-bottom: 24px;">Changer le mot de passe</h4>
            
            <div class="profile-grid">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Nouveau mot de passe</label>
                    <input type="password" name="password" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 18px; font-size: 1rem;">Sauvegarder les modifications</button>
        </form>
    </div>
</div>
@endsection
