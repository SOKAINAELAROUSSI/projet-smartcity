@extends('layouts.technician')

@section('title', 'Mes Missions')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Mes Missions</h1>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Gérez et suivez toutes vos interventions assignées.</p>
    </div>
    
    <!-- Status Quick Filter -->
    <div style="display: flex; gap: 8px; background: white; padding: 6px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);">
        <a href="{{ route('technician.missions.index', ['status' => 'all']) }}" 
           class="filter-tab {{ !request('status') || request('status') === 'all' ? 'active' : '' }}">
            Tous
        </a>
        <a href="{{ route('technician.missions.index', ['status' => 'en attente']) }}" 
           class="filter-tab {{ request('status') === 'en attente' ? 'active' : '' }}">
            En attente
        </a>
        <a href="{{ route('technician.missions.index', ['status' => 'en_cours']) }}" 
           class="filter-tab {{ request('status') === 'en_cours' ? 'active' : '' }}">
            En cours
        </a>
        <a href="{{ route('technician.missions.index', ['status' => 'terminee']) }}" 
           class="filter-tab {{ request('status') === 'terminee' ? 'active' : '' }}">
            Résolues
        </a>
    </div>
</div>

<style>
    .filter-tab {
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.2s;
        color: #64748b;
    }
    .filter-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .filter-tab.active {
        background: #10b981;
        color: white;
    }
    .filter-tab.active:hover {
        background: #0d9488;
        color: white;
    }
</style>

<!-- Missions Grid/List -->
<div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 24px;">
    @if($interventions->isEmpty())
        <div style="text-align: center; padding: 40px 20px;">
            <div style="width: 64px; height: 64px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #94a3b8;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Aucune mission trouvée</h3>
            <p style="color: #64748b; font-size: 0.9rem; max-width: 400px; margin: 0 auto;">Il n'y a actuellement aucune mission correspondant à ce filtre dans votre planning d'interventions.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
            @foreach($interventions as $intervention)
                <div style="border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
                    
                    <!-- Left Section: Details & Image -->
                    <div style="display: flex; gap: 20px; align-items: center; flex: 1; min-width: 280px;">
                        <div style="width: 80px; height: 80px; border-radius: 12px; overflow: hidden; background: #f1f5f9; flex-shrink: 0;">
                            @if($intervention->report->image)
                                <img src="{{ asset('storage/' . $intervention->report->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div style="min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                                <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $intervention->report->title }}
                                </h3>
                                @if($intervention->priority === 'haute')
                                    <span style="background: #fee2e2; color: #ef4444; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 100px; text-transform: uppercase; letter-spacing: 0.5px;">Urgent</span>
                                @endif
                                
                                @if($intervention->status === 'en attente')
                                    <span style="background: #fffbeb; color: #d97706; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 100px;">En attente</span>
                                @elseif($intervention->status === 'en cours' || $intervention->status === 'acceptée')
                                    <span style="background: #eff6ff; color: #2563eb; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 100px;">En cours</span>
                                @elseif($intervention->status === 'terminee')
                                    <span style="background: #f0fdf4; color: #16a34a; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 100px;">Résolue</span>
                                @endif
                            </div>
                            
                            <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $intervention->report->description }}
                            </p>
                            
                            <div style="display: flex; gap: 16px; color: #94a3b8; font-size: 0.8rem; font-weight: 600; flex-wrap: wrap;">
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    {{ $intervention->report->address ?? 'Lieu GPS' }}
                                </span>
                                <span style="display: flex; align-items: center; gap: 4px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    Signalé le {{ $intervention->report->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Section: Action Button -->
                    <div style="flex-shrink: 0; display: flex; gap: 12px; align-items: center;">
                        <a href="{{ route('technician.mission.show', $intervention->id) }}" 
                           style="padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; background: #10b981; color: white; transition: all 0.2s;"
                           onmouseover="this.style.background='#0d9488'; this.style.transform='translateY(-1px)'" 
                           onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)'">
                            Gérer la mission
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                    
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
