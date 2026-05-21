@extends('layouts.technician')

@section('title', 'Mon Profil Technicien')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Mon Profil</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Gérez vos informations professionnelles, vos spécialités et votre disponibilité.</p>
</div>

@if(session('success'))
    <div style="padding: 16px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
    
    <!-- Profile Sidebar Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); text-align: center; padding: 32px 24px;">
        <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 20px;">
            <div style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                @if($profile->photo)
                    <img src="{{ asset('storage/' . $profile->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span style="font-size: 3rem; color: #cbd5e1; font-weight: 900;">{{ substr($user->name, 0, 1) }}</span>
                @endif
            </div>
            <div style="position: absolute; bottom: 4px; right: 4px; width: 24px; height: 24px; background: {{ $profile->is_available ? '#10b981' : '#ef4444' }}; border: 3px solid white; border-radius: 50%;" title="{{ $profile->is_available ? 'Disponible' : 'Indisponible' }}"></div>
        </div>
        
        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">{{ $user->name }}</h3>
        <p style="color: #10b981; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 24px;">
            {{ $profile->speciality ?? 'Technicien Généraliste' }}
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;">
            <div style="padding: 12px; background: #fafbfe; border-radius: 12px; border: 1px solid #f1f5f9;">
                <p style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 800; margin: 0 0 4px;">Note</p>
                <div style="font-size: 1.1rem; font-weight: 900; color: #f59e0b;">⭐ {{ number_format($profile->rating ?? 4.8, 1) }}</div>
            </div>
            <div style="padding: 12px; background: #fafbfe; border-radius: 12px; border: 1px solid #f1f5f9;">
                <p style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 800; margin: 0 0 4px;">Missions</p>
                <div style="font-size: 1.1rem; font-weight: 900; color: #10b981;">{{ $user->interventions()->where('status', 'terminee')->count() }}</div>
            </div>
        </div>

        <div style="text-align: left; padding: 16px; background: #fafbfe; border-radius: 12px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 0.85rem; font-weight: 600;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>{{ $profile->city ?? 'Non spécifié' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 0.85rem; font-weight: 600;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <span>{{ $profile->phone ?? 'Non spécifié' }}</span>
            </div>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 32px;">
        <form action="{{ route('technician.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Nom complet</label>
                    <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Spécialité</label>
                    <input type="text" name="speciality" value="{{ $profile->speciality }}" placeholder="Ex: Électricien, Plombier..." style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Ville</label>
                    <input type="text" name="city" value="{{ $profile->city }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Téléphone</label>
                    <input type="text" name="phone" value="{{ $profile->phone }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Photo de profil</label>
                <input type="file" name="photo" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 0.85rem;">
            </div>

            <div style="margin-bottom: 30px; padding: 20px; background: #ecfdf5; border-radius: 16px; border: 1px solid #a7f3d0; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-weight: 800; color: #065f46; margin: 0 0 4px; font-size: 0.95rem;">Disponibilité pour interventions</p>
                    <p style="font-size: 0.8rem; color: #047857; margin: 0;">Activez cette option pour recevoir de nouvelles notifications de missions en temps réel.</p>
                </div>
                <label class="switch">
                    <input type="checkbox" name="is_available" {{ $profile->is_available ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #10b981; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#0d9488'" onmouseout="this.style.background='#10b981'">
                Mettre à jour mon profil
            </button>
        </form>
    </div>
</div>

<style>
/* Toggle Switch Styles */
.switch { position: relative; display: inline-block; width: 50px; height: 28px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; }
.slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 4px; bottom: 4px; background-color: white; transition: .4s; }
input:checked + .slider { background-color: #10b981; }
input:checked + .slider:before { transform: translateX(22px); }
.slider.round { border-radius: 28px; }
.slider.round:before { border-radius: 50%; }
</style>
@endsection
