@extends('layouts.app')

@section('title', 'Détails de la Mission')

@section('content')
<div class="container" style="padding: 100px 20px 40px; max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('dashboard') }}" style="color: var(--slate-500); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Retour au tableau de bord
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px;">
        
        <!-- Left Column: Details & Map -->
        <div>
            <!-- Mission Info -->
            <div style="background: white; border-radius: 20px; padding: 30px; border: 1px solid var(--slate-100); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 30px; position: relative;">
                @if($intervention->priority === 'haute')
                    <div style="position: absolute; top: 30px; right: 30px; background: #fee2e2; color: #ef4444; padding: 6px 16px; border-radius: 100px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Urgente
                    </div>
                @endif

                <h1 style="font-size: 2rem; font-weight: 900; color: var(--slate-900); margin-bottom: 16px; padding-right: 120px;">{{ $report->title }}</h1>
                
                <div style="display: flex; gap: 20px; margin-bottom: 24px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--slate-600); font-weight: 600;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        {{ $report->address ?? 'Coordonnées GPS' }}
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--slate-600); font-weight: 600;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Signalé le {{ $report->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div style="background: var(--slate-50); padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 12px;">Description du problème</h3>
                    <p style="color: var(--slate-700); line-height: 1.6;">{{ $report->description }}</p>
                </div>

                @if($report->image)
                    <div style="margin-bottom: 30px;">
                        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 12px;">Photo du citoyen</h3>
                        <img src="{{ asset('storage/' . $report->image) }}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 16px; border: 1px solid var(--slate-200);">
                    </div>
                @endif
            </div>

            <!-- Interactive Map -->
            <div style="background: white; border-radius: 20px; padding: 30px; border: 1px solid var(--slate-100); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-900);">Géolocalisation & Itinéraire</h2>
                    <button id="calc-route-btn" class="btn-outline" style="padding: 8px 16px; font-size: 0.9rem; cursor: pointer; border-radius: 8px; border: 1px solid #10b981; color: #10b981; font-weight: 600; background: white;">Calculer l'itinéraire</button>
                </div>
                <div id="distance-info" style="margin-bottom: 15px; padding: 12px; background: #e0f2fe; color: #0369a1; border-radius: 8px; font-weight: 600; display: none;"></div>
                <div id="mission-map" style="height: 400px; width: 100%; border-radius: 16px; z-index: 1;"></div>
            </div>

            <!-- Communication -->
            <div style="background: white; border-radius: 20px; padding: 30px; border: 1px solid var(--slate-100); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-900); margin-bottom: 20px;">Commentaires & Chat</h2>
                
                <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                    @foreach($comments->reverse() as $comment)
                        <div style="display: flex; gap: 12px; {{ $comment->user_id === Auth::id() ? 'flex-direction: row-reverse;' : '' }}">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div style="background: {{ $comment->user_id === Auth::id() ? 'var(--primary)' : 'var(--slate-50)' }}; color: {{ $comment->user_id === Auth::id() ? 'white' : 'var(--slate-800)' }}; padding: 16px; border-radius: 16px; max-width: 80%;">
                                <div style="font-weight: 700; font-size: 0.85rem; margin-bottom: 4px; opacity: 0.8;">{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</div>
                                <p style="margin: 0; line-height: 1.5;">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Status & Evidence -->
        <div style="position: sticky; top: 100px;">
            <div style="background: white; border-radius: 20px; padding: 30px; border: 1px solid var(--slate-100); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900); margin-bottom: 24px;">Mise à jour du statut</h2>

                <form method="POST" action="{{ route('technician.update', $report->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">État actuel</label>
                        <select name="status" style="width: 100%; padding: 14px 16px; border-radius: 12px; border: 2px solid var(--slate-200); font-weight: 600; color: var(--slate-800); outline: none; appearance: none; background: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E') no-repeat right 16px center; background-size: 20px; cursor: pointer;">
                            <option value="en attente" {{ $intervention->status === 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en cours" {{ $intervention->status === 'en cours' ? 'selected' : '' }}>En cours (Acceptée)</option>
                            <option value="terminee" {{ $intervention->status === 'terminee' ? 'selected' : '' }}>Résolue</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Photo Avant Intervention (Optionnel)</label>
                        <input type="file" name="photo_before" accept="image/*" style="width: 100%; padding: 12px; border: 1px dashed var(--slate-300); border-radius: 12px; background: var(--slate-50);">
                        @if($intervention->photo_before)
                            <div style="margin-top: 10px; color: #10b981; font-weight: 600; font-size: 0.85rem;">✓ Photo avant envoyée</div>
                        @endif
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Photo Après (Preuve) <span style="color: #ef4444;">*</span></label>
                        <input type="file" name="after_image" accept="image/*" style="width: 100%; padding: 12px; border: 1px dashed var(--slate-300); border-radius: 12px; background: var(--slate-50);">
                        @if($intervention->photo_after)
                            <div style="margin-top: 10px; color: #10b981; font-weight: 600; font-size: 0.85rem;">✓ Photo après envoyée</div>
                        @endif
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Notes Techniques / Commentaire</label>
                        <textarea name="technical_notes" rows="4" placeholder="Détails de l'intervention, matériel utilisé..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid var(--slate-200); font-family: inherit; resize: vertical; outline: none;">{{ $intervention->technical_notes }}</textarea>
                    </div>

                    <!-- Add chat comment as part of status update -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Nouveau message (Chat)</label>
                        <input type="text" name="comment" placeholder="Envoyer un message au citoyen..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;">
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px; font-size: 1.1rem; border-radius: 12px; cursor: pointer; border: none;">
                        Mettre à jour et Valider
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 1024px) {
        .container > div:nth-child(2) {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var missionLat = {{ $report->latitude }};
        var missionLng = {{ $report->longitude }};
        var map = L.map('mission-map').setView([missionLat, missionLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var missionIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style='background-color:#ef4444;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 0 10px rgba(0,0,0,0.2);'></div>`,
            iconSize: [20, 20]
        });

        L.marker([missionLat, missionLng], {icon: missionIcon}).addTo(map)
            .bindPopup("<b>Lieu du problème</b>");

        var routingControl = null;

        document.getElementById('calc-route-btn').addEventListener('click', function() {
            if ("geolocation" in navigator) {
                this.innerText = "Recherche de position...";
                
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;
                    
                    document.getElementById('calc-route-btn').innerText = "Itinéraire tracé";
                    
                    // Add tech marker
                    var techIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style='background-color:#10b981;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 0 10px rgba(0,0,0,0.2);'></div>`,
                        iconSize: [20, 20]
                    });
                    L.marker([userLat, userLng], {icon: techIcon}).addTo(map).bindPopup("<b>Votre position</b>");

                    if (routingControl) {
                        map.removeControl(routingControl);
                    }

                    routingControl = L.Routing.control({
                        waypoints: [
                            L.latLng(userLat, userLng),
                            L.latLng(missionLat, missionLng)
                        ],
                        routeWhileDragging: false,
                        show: false,
                        addWaypoints: false,
                        lineOptions: {
                            styles: [{color: '#3b82f6', opacity: 0.8, weight: 6}]
                        }
                    }).addTo(map);

                    routingControl.on('routesfound', function(e) {
                        var routes = e.routes;
                        var summary = routes[0].summary;
                        var distanceDiv = document.getElementById('distance-info');
                        distanceDiv.style.display = 'block';
                        distanceDiv.innerHTML = "Distance : <b>" + (summary.totalDistance / 1000).toFixed(1) + " km</b> — Temps estimé : <b>" + Math.round(summary.totalTime % 3600 / 60) + " min</b>";
                    });

                }, function(error) {
                    alert("Erreur de géolocalisation. Veuillez autoriser l'accès à votre position.");
                    document.getElementById('calc-route-btn').innerText = "Calculer l'itinéraire";
                });
            } else {
                alert("La géolocalisation n'est pas supportée par votre navigateur.");
            }
        });
    });
</script>
@endsection
