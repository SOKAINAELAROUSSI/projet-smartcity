@extends('layouts.technician')

@section('title', 'Carte des Missions')

@section('content')
<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Carte des Missions</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Visualisez géographiquement toutes vos interventions en cours sur la carte.</p>
</div>

<!-- Map Container -->
<div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 0; overflow: hidden; height: calc(100vh - 220px); min-height: 450px;">
    <div id="tech-map" style="width: 100%; height: 100%;"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser la carte sur le centre du Maroc (ou une ville spécifique comme Fès/Rabat)
        // Coordonnées par défaut : Rabat
        const map = L.map('tech-map').setView([34.01325, -6.83255], 13);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
        }).addTo(map);

        const markers = [];
        
        @foreach($interventions as $intervention)
            @if($intervention->report->latitude && $intervention->report->longitude)
                (function() {
                    const lat = {{ $intervention->report->latitude }};
                    const lng = {{ $intervention->report->longitude }};
                    const title = "{{ $intervention->report->title }}";
                    const status = "{{ $intervention->status }}";
                    const url = "{{ route('technician.mission.show', $intervention->id) }}";
                    const description = "{{ Str::limit($intervention->report->description, 60) }}";
                    
                    // Couleur du marqueur en fonction du statut
                    const markerColor = status === 'en cours' || status === 'acceptée' ? '#3b82f6' : '#f59e0b';
                    
                    const markerIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: ${markerColor}; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 8px rgba(0,0,0,0.3);"></div>`,
                        iconSize: [14, 14],
                        iconAnchor: [7, 7]
                    });

                    const marker = L.marker([lat, lng], { icon: markerIcon }).addTo(map);
                    
                    marker.bindPopup(`
                        <div style="font-family: 'Inter', sans-serif; padding: 4px;">
                            <h4 style="margin: 0 0 6px; font-weight: 800; font-size: 0.9rem; color: #0f172a;">${title}</h4>
                            <p style="margin: 0 0 10px; font-size: 0.75rem; color: #64748b;">${description}</p>
                            <a href="${url}" style="display: block; text-align: center; text-decoration: none; background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; transition: background 0.2s;">
                                Gérer l'intervention
                            </a>
                        </div>
                    `);
                    
                    markers.push([lat, lng]);
                })();
            @endif
        @endforeach

        // Ajuster le zoom pour inclure tous les marqueurs si présents
        if (markers.length > 0) {
            const bounds = L.latLngBounds(markers);
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    });
</script>
@endsection
