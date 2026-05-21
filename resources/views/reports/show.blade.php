@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'technician' ? 'layouts.technician' : 'layouts.app'))

@section('title', $report->title)

@section('content')
<style>
    .report-detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        align-items: flex-start;
    }
    .report-images-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .report-images-grid.two-cols {
        grid-template-columns: 1fr 1fr;
    }
    @media (max-width: 1024px) {
        .report-detail-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
    @media (max-width: 768px) {
        .report-header-section h1 {
            font-size: 2.2rem !important;
        }
        .report-images-grid.two-cols {
            grid-template-columns: 1fr;
        }
    }
</style>
@php
    $isAdminOrTech = Auth::user()->role === 'admin' || Auth::user()->role === 'technician';
    $containerClass = $isAdminOrTech ? "" : "citizen-container";
    $containerStyle = $isAdminOrTech 
        ? "max-width: 1200px; margin: 0 auto; padding: 20px 0;" 
        : "max-width: 1300px;";
@endphp
<div class="{{ $containerClass }}" style="{{ $containerStyle }}">
    <!-- Navigation Back -->
    <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary); text-decoration: none; font-weight: 700; margin-bottom: 32px; transition: var(--transition);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Retour au tableau de bord
    </a>

    <div class="report-detail-grid">
        <!-- Left: Incident Info -->
        <div class="animate-slide-up">
            <div class="glass-card" style="padding: 48px; margin-bottom: 32px; position: relative;">
                <div class="report-header-section" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                    <div>
                        <div style="display: flex; gap: 12px; margin-bottom: 16px;">
                            <span class="badge {{ $report->status === 'terminee' ? 'badge-done' : ($report->status === 'en cours' ? 'badge-progress' : 'badge-pending') }}">
                                {{ $report->status }}
                            </span>
                            @if($report->interventions->first())
                                <span style="background: var(--slate-900); color: white; padding: 6px 14px; border-radius: 100px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                                    Priorité: {{ $report->interventions->first()->priority }}
                                </span>
                            @endif
                        </div>
                        <h1 style="font-size: 3.5rem; color: var(--text-main); line-height: 1.1; letter-spacing: -1px;">{{ $report->title }}</h1>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; margin-bottom: 40px; padding: 24px; background: var(--primary-50); border-radius: 20px;">
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Rapporté par</p>
                        <p style="font-weight: 700; color: var(--text-main); font-size: 1.1rem;">{{ $report->user->name }}</p>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Date du signalement</p>
                        <p style="font-weight: 700; color: var(--text-main); font-size: 1.1rem;">{{ $report->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    @if($report->interventions->first())
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Technicien assigné</p>
                            <p style="font-weight: 700; color: var(--text-main); font-size: 1.1rem;">{{ $report->interventions->first()->technician->name }}</p>
                        </div>
                    @endif
                </div>

                <div style="margin-bottom: 40px;">
                    <h3 style="margin-bottom: 16px; font-size: 1.25rem;">Description de l'incident</h3>
                    <p style="font-size: 1.2rem; line-height: 1.7; color: var(--slate-800);">{{ $report->description }}</p>
                </div>

                @if($report->image || $report->after_image)
                    <div class="report-images-grid {{ $report->after_image ? 'two-cols' : '' }}" style="margin-bottom: 40px;">
                        @if($report->image)
                            <div style="border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-lg);">
                                <p style="padding: 10px; background: var(--slate-900); color: white; text-align: center; font-weight: 800; font-size: 0.7rem; text-transform: uppercase;">Avant</p>
                                <img src="{{ asset('storage/' . $report->image) }}" alt="Avant" style="width: 100%; height: 300px; object-fit: cover;">
                            </div>
                        @endif
                        @if($report->after_image)
                            <div style="border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-lg);">
                                <p style="padding: 10px; background: var(--primary-600); color: white; text-align: center; font-weight: 800; font-size: 0.7rem; text-transform: uppercase;">Après (Résolu)</p>
                                <img src="{{ asset('storage/' . $report->after_image) }}" alt="Après" style="width: 100%; height: 300px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Rating Form -->
                @if($report->status === 'terminee' && Auth::user()->role === 'citizen' && !$report->rating)
                    <div class="glass-card" style="padding: 32px; border: 2px solid var(--primary-200); margin-bottom: 32px; background: var(--primary-50);">
                        <h4 style="margin-bottom: 16px;">⭐ Évaluez l'intervention</h4>
                        <form action="{{ route('reports.rate', $report->id) }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 16px;">
                                <select name="score" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--primary-200);">
                                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                    <option value="4">⭐⭐⭐⭐ Très Bien</option>
                                    <option value="3">⭐⭐⭐ Moyen</option>
                                    <option value="2">⭐⭐ Médiocre</option>
                                    <option value="1">⭐ Mauvais</option>
                                </select>
                            </div>
                            <textarea name="comment" placeholder="Votre commentaire sur l'intervention..." style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--primary-200); margin-bottom: 16px;"></textarea>
                            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">Soumettre mon avis</button>
                        </form>
                    </div>
                @endif


                <div style="display: flex; gap: 12px; align-items: center; color: var(--slate-500); padding: 16px; background: white; border-radius: 12px; border: 1px solid var(--slate-100);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span style="font-weight: 600;">{{ $report->address }}</span>
                </div>
            </div>

            <!-- Enhanced Comments -->
            <div class="glass-card" style="padding: 48px;">
                <h3 style="margin-bottom: 32px; font-size: 1.5rem;">Fil d'intervention</h3>
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @forelse($report->comments as $comment)
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-100); color: var(--primary-800); display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div style="flex: 1; padding: 20px; background: white; border-radius: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--slate-100);">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <strong style="color: var(--slate-900);">{{ $comment->user->name }}</strong>
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="color: var(--slate-700); line-height: 1.5;">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px; border: 2px dashed var(--slate-200); border-radius: 20px;">
                            <p style="color: var(--text-muted);">Aucune mise à jour disponible.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Actions & Map -->
        <div style="position: sticky; top: 120px;">
            <div class="glass-card animate-slide-up" style="padding: 32px; margin-bottom: 32px; animation-delay: 0.2s;">
                <h4 style="margin-bottom: 20px; font-size: 1.1rem; display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Position Exacte
                </h4>
                <div id="detail-map" style="height: 300px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-md);"></div>
            </div>

            @if(Auth::user()->role === 'admin' && $report->status !== 'terminee')
                <div class="glass-card animate-slide-up" style="padding: 32px; border: 2px solid var(--primary-100); animation-delay: 0.3s;">
                    <h4 style="margin-bottom: 24px; color: var(--primary-800); font-size: 1.25rem;">
                    @php 
                        $suggestedPriority = 'moyenne';
                        $urgentKeywords = ['gaz', 'inondation', 'danger', 'feu', 'électrique', 'urgent', 'accidents'];
                        foreach($urgentKeywords as $key) {
                            if(stripos($report->title, $key) !== false || stripos($report->category->name ?? '', $key) !== false) {
                                $suggestedPriority = 'haute';
                                break;
                            }
                        }
                    @endphp
                    Gestion d'Intervention</h4>
                    <form action="{{ route('admin.assign', $report->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Affecter un Technicien</label>
                            <select name="technician_id" required style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none; font-weight: 600;">
                                @foreach($recommendedTechnicians as $tech)
                                    @php 
                                        $isRecommended = stripos($tech->technicianProfile->speciality ?? '', $report->category->name ?? '') !== false;
                                    @endphp
                                    <option value="{{ $tech->id }}">
                                        {{ $tech->name }} 
                                        ({{ $tech->technicianProfile->speciality ?? 'Général' }}) 
                                        - ⭐ {{ number_format($tech->technicianProfile->rating ?? 5, 1) }}
                                        {{ $isRecommended ? '👍 RECOMMANDÉ' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 32px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Niveau de Priorité (Suggéré: {{ $suggestedPriority }})</label>
                            <select name="priority" required style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none; font-weight: 600;">
                                <option value="faible" {{ $suggestedPriority === 'faible' ? 'selected' : '' }}>🟢 Basse</option>
                                <option value="moyenne" {{ $suggestedPriority === 'moyenne' ? 'selected' : '' }}>🟡 Moyenne</option>
                                <option value="haute" {{ $suggestedPriority === 'haute' ? 'selected' : '' }}>🔴 Haute</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px;">
                            Lancer l'Intervention
                        </button>
                    </form>
                </div>
            @endif

            @if(Auth::user()->role === 'technician' && $report->status !== 'terminee')
                <div class="glass-card animate-slide-up" style="padding: 32px; border: 2px solid var(--primary-100); animation-delay: 0.3s;">
                    <h4 style="margin-bottom: 24px; color: var(--primary-800); font-size: 1.25rem;">Actions du Technicien</h4>
                    
                    @php 
                        $intervention = $report->interventions()->where('technician_id', Auth::id())->first();
                    @endphp

                    @if($intervention && $intervention->status === 'en attente')
                        <div style="display: flex; gap: 12px;">
                            <form action="{{ route('technician.accept', $report->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px; background: var(--primary-600);">
                                    Accepter la Mission
                                </button>
                            </form>
                            <form action="{{ route('technician.reject', $report->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px; background: #ef4444;">
                                    Refuser
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('technician.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="margin-bottom: 24px;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Nouveau Statut</label>
                                <select name="status" required style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none; font-weight: 600;">
                                    <option value="en cours" {{ $report->status === 'en cours' ? 'selected' : '' }}>🚧 Travaux en cours</option>
                                    <option value="terminee">✅ Problème Résolu</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Photo après intervention</label>
                                <input type="file" name="after_image" style="width: 100%; padding: 10px; border: 1px solid var(--slate-200); border-radius: 10px;">
                            </div>

                            <div style="margin-bottom: 32px;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Commentaire (Facultatif)</label>
                                <textarea name="comment" placeholder="Détails sur l'intervention..." style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;"></textarea>
                            </div>

                            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px;">
                                Mettre à jour le Rapport
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lat = {{ $report->latitude }};
        var lng = {{ $report->longitude }};
        var map = L.map('detail-map').setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        
        var greenIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color: #16a34a; width: 20px; height: 20px; border-radius: 50%; border: 4px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);'></div>",
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        L.marker([lat, lng], {icon: greenIcon}).addTo(map);
    });
</script>
@endsection
