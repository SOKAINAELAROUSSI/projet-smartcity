@extends('layouts.app')

@section('title', 'Carte Globale des Signalements')

@section('content')
<div style="height: calc(100vh - 80px); position: relative;">
    <div id="global-map" style="height: 100%; width: 100%;"></div>

    <!-- Map Overlay Legend -->
    <div class="glass-card animate-slide-up" style="position: absolute; top: 30px; right: 30px; z-index: 1000; padding: 24px; width: 280px;">
        <h3 style="margin-bottom: 20px; font-size: 1.25rem;">Signalements</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 14px; height: 14px; border-radius: 50%; background: #f59e0b; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.2);"></div>
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--slate-700);">En attente ({{ $reports->where('status', 'en attente')->count() }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 14px; height: 14px; border-radius: 50%; background: #3b82f6; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.2);"></div>
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--slate-700);">En cours ({{ $reports->where('status', 'en cours')->count() }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 14px; height: 14px; border-radius: 50%; background: #16a34a; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.2);"></div>
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--slate-700);">Terminé ({{ $reports->where('status', 'terminee')->count() }})</span>
            </div>
        </div>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid var(--slate-100);">
        <p style="font-size: 0.8rem; color: var(--slate-500); line-height: 1.5;">Cliquez sur un marqueur pour voir les détails et l'image du signalement.</p>
    </div>

    <!-- Back Button Overlay -->
    <a href="{{ route('dashboard') }}" class="btn-primary" style="position: absolute; top: 30px; left: 30px; z-index: 1000; background: white; color: var(--slate-900); border: 1px solid var(--slate-200); box-shadow: var(--shadow-md);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><polyline points="15 18 9 12 15 6"></polyline></svg>
        Tableau de bord
    </a>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('global-map').setView([33.5731, -7.5898], 12); // Default to Casablanca
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var reports = @json($reports);
        var markers = [];

        reports.forEach(function(report) {
            if (report.latitude && report.longitude) {
                var color = '#f59e0b'; // pending
                if (report.status === 'en cours') color = '#3b82f6';
                if (report.status === 'terminee') color = '#16a34a';

                var icon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background: ${color}; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: var(--shadow-md);"></div>`,
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });

                var popupContent = `
                    <div style="padding: 10px; min-width: 200px;">
                        <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--slate-500); margin-bottom: 4px;">${report.category ? report.category.name : 'Urbain'}</div>
                        <h4 style="margin-bottom: 8px;">${report.title}</h4>
                        <div style="font-size: 0.85rem; color: var(--slate-600); margin-bottom: 12px;">${report.address}</div>
                        ${report.image ? `<img src="/storage/${report.image}" style="width: 100%; border-radius: 8px; margin-bottom: 12px; height: 100px; object-fit: cover;">` : ''}
                        <a href="/reports/${report.id}" style="display: block; text-align: center; background: var(--primary-600); color: white; padding: 8px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700;">Voir les détails</a>
                    </div>
                `;

                var marker = L.marker([report.latitude, report.longitude], {icon: icon})
                    .bindPopup(popupContent)
                    .addTo(map);
                
                markers.push(marker);
            }
        });

        if (markers.length > 0) {
            var group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    });
</script>
@endsection
