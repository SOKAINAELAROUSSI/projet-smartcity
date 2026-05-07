@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
<div style="min-height: 95vh; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; background: radial-gradient(circle at 80% 20%, var(--primary-100) 0%, transparent 40%), radial-gradient(circle at 10% 80%, var(--primary-50) 0%, transparent 40%);">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: 10%; left: 5%; width: 300px; height: 300px; background: var(--primary-200); filter: blur(100px); opacity: 0.3; z-index: 0;"></div>
    <div style="position: absolute; bottom: 10%; right: 5%; width: 400px; height: 400px; background: var(--primary-300); filter: blur(120px); opacity: 0.2; z-index: 0;"></div>

    <div class="hero-grid">
        <div class="hero-content animate-slide-up">
            <div style="display: inline-flex; align-items: center; gap: 10px; background: var(--primary-100); color: var(--primary-800); padding: 8px 16px; border-radius: 100px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 32px;">

                <span class="pulse" style="width: 8px; height: 8px; background: var(--primary-600); border-radius: 50%;"></span>
                Plateforme Smart City Connectée
            </div>
            <h1 class="hero-title" style="font-size: 6rem; font-weight: 900; color: var(--slate-900); line-height: 0.9; letter-spacing: -4px; margin-bottom: 32px;">
                Construisons la <br> <span style="color: var(--primary-600);">Ville de Demain.</span>
            </h1>

            <p style="font-size: 1.5rem; color: var(--slate-500); line-height: 1.6; margin-bottom: 48px; max-width: 600px;">
                Une infrastructure numérique intelligente pour optimiser le trafic, l'énergie et la qualité de vie de chaque citoyen.
            </p>
            <div style="display: flex; gap: 24px;">
                <a href="{{ route('register') }}" class="btn-primary">
                    Rejoindre l'aventure
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="#map-section" class="btn-secondary" style="padding: 16px 32px; font-size: 1.1rem; color: var(--slate-800); text-decoration: none; font-weight: 800; border-radius: var(--radius-md); background: white; border: 1px solid var(--slate-200); display: flex; align-items: center; gap: 12px; transition: var(--transition);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Explorer la carte
                </a>
            </div>
        </div>

        <div class="animate-slide-up" style="animation-delay: 0.3s;">
            <div class="glass-card" style="padding: 16px; transform: perspective(1000px) rotateY(-8deg) rotateX(4deg); box-shadow: 0 60px 120px rgba(22, 163, 74, 0.15);">
                <div style="background: var(--slate-900); border-radius: calc(var(--radius-lg) - 10px); padding: 40px; height: 500px; position: relative; overflow: hidden;">
                    <!-- Simulating a city dashboard mockup inside -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 16px;">
                            <p style="color: var(--primary-400); font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Qualité de l'Air</p>
                            <div style="font-size: 2rem; color: white; font-weight: 900;">Bonne</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 16px;">
                            <p style="color: var(--primary-400); font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Énergie Économisée</p>
                            <div style="font-size: 2rem; color: white; font-weight: 900;">24%</div>
                        </div>
                    </div>
                    <div style="margin-top: 20px; height: 200px; background: linear-gradient(0deg, var(--primary-900), transparent); border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: flex-end; padding: 20px; gap: 10px;">
                        <div style="flex: 1; height: 40%; background: var(--primary-500); border-radius: 4px;"></div>
                        <div style="flex: 1; height: 80%; background: var(--primary-600); border-radius: 4px;"></div>
                        <div style="flex: 1; height: 60%; background: var(--primary-400); border-radius: 4px;"></div>
                        <div style="flex: 1; height: 90%; background: var(--primary-500); border-radius: 4px;"></div>
                        <div style="flex: 1; height: 70%; background: var(--primary-600); border-radius: 4px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section style="padding: 120px 60px; background: white;">
    <div style="max-width: 1300px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 80px;">
            <h2 style="font-size: 4rem; color: var(--slate-900); letter-spacing: -2px;">Services Urbains Intelligents</h2>
            <p style="font-size: 1.25rem; color: var(--slate-500); max-width: 600px; margin: 20px auto;">Une gestion centralisée pour chaque aspect de la vie citadine.</p>
        </div>

        <div class="smart-grid">
            @foreach($categories as $category)
                <div class="glass-card" style="padding: 48px;">
                    <div class="smart-icon" style="overflow: hidden;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 2rem;">{{ $category->icon ?? '🏙️' }}</span>
                        @endif
                    </div>
                    <h3>{{ $category->name }}</h3>
                    <p style="color: var(--slate-500); line-height: 1.6; margin-top: 16px;">{{ $category->description ?? 'Service urbain intelligent.' }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Interactive Map Section -->
<section id="map-section" style="padding: 100px 20px; background: var(--slate-50);">
    <div class="glass-card map-grid" style="padding: 40px;">

        <div>
            <h2 style="font-size: 3rem; letter-spacing: -2px; margin-bottom: 24px;">Carte Connectée</h2>
            <p style="color: var(--slate-500); line-height: 1.7; margin-bottom: 32px;">
                Visualisez l'état de la ville en temps réel. Notre carte interactive affiche les capteurs IoT, les zones de pollution, et les signalements citoyens.
            </p>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 15px; padding: 16px; background: white; border-radius: 16px; border: 1px solid var(--slate-200);">
                    <div style="width: 12px; height: 12px; background: #ef4444; border-radius: 50%;" class="pulse"></div>
                    <span style="font-weight: 700;">Alertes Actives</span>
                </div>
                <div style="display: flex; align-items: center; gap: 15px; padding: 16px; background: white; border-radius: 16px; border: 1px solid var(--slate-200);">
                    <div style="width: 12px; height: 12px; background: #3b82f6; border-radius: 50%;"></div>
                    <span style="font-weight: 700;">Parkings Disponibles</span>
                </div>
                <div style="display: flex; align-items: center; gap: 15px; padding: 16px; background: white; border-radius: 16px; border: 1px solid var(--slate-200);">
                    <div style="width: 12px; height: 12px; background: #22c55e; border-radius: 50%;"></div>
                    <span style="font-weight: 700;">Zones de Qualité Air</span>
                </div>
            </div>
            <a href="{{ route('reports.create') }}" class="btn-primary" style="margin-top: 40px; width: 100%; justify-content: center;">
                Signaler un problème
            </a>
        </div>
        <div style="border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-premium);">
            <div id="smart-map" style="height: 600px; width: 100%;"></div>
        </div>
    </div>
</section>

<!-- Floating Chatbot -->
<div class="chatbot-trigger" id="chatbot-btn">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('smart-map').setView([48.8566, 2.3522], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Smart City Markers
        var smartMarkers = [
            {lat: 48.8584, lng: 2.2945, type: 'alert', text: '🚧 Travaux : Avenue Eiffel'},
            {lat: 48.8606, lng: 2.3376, type: 'parking', text: '🅿️ Parking Louvre : 12 places'},
            {lat: 48.8529, lng: 2.3501, type: 'sensor', text: '🍃 Qualité Air : Excellente'},
            {lat: 48.8644, lng: 2.3245, type: 'camera', text: '📹 Caméra active : Place Concorde'}
        ];

        smartMarkers.forEach(function(m) {
            var color = m.type === 'alert' ? '#ef4444' : (m.type === 'parking' ? '#3b82f6' : '#22c55e');
            var icon = L.divIcon({
                className: 'custom-icon',
                html: `<div style="background: ${color}; width: 24px; height: 24px; border-radius: 50%; border: 4px solid white; box-shadow: 0 0 15px ${color}"></div>`,
                iconSize: [24, 24]
            });
            L.marker([m.lat, m.lng], {icon: icon}).addTo(map).bindPopup(m.text);
        });

        // Chatbot Simulation
        document.getElementById('chatbot-btn').addEventListener('click', function() {
            alert("Bonjour ! Je suis l'IA SmartCity. Comment puis-je vous aider aujourd'hui ?");
        });
    });
</script>
@endsection
