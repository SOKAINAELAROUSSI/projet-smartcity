@extends('layouts.app')

@section('title', 'Signaler un Problème')

@section('content')
<div style="padding: 60px; max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 50px; text-align: center;">
        <h1 style="font-size: 3.5rem; color: var(--slate-900); letter-spacing: -2px;">Signaler un Incident</h1>
        <p style="color: var(--slate-500); font-size: 1.2rem;">Aidez-nous à améliorer la ville en signalant les problèmes urbains.</p>
    </div>

    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="glass-card" style="padding: 48px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        @csrf
        <div>
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 10px;">Catégorie d'Incident</label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    @foreach($categories as $category)
                        <label style="cursor: pointer;">
                            <input type="radio" name="category_id" value="{{ $category->id }}" required style="display: none;" onchange="this.parentElement.parentElement.querySelectorAll('div').forEach(d => d.style.background='white'); this.nextElementSibling.style.background='var(--primary-100)';">
                            <div style="padding: 16px; border: 2px solid var(--primary-100); border-radius: 16px; text-align: center; transition: var(--transition); background: white;">
                                <span style="font-size: 1.5rem; display: block; margin-bottom: 4px;">{{ $category->icon }}</span>
                                <span style="font-size: 0.75rem; font-weight: 800; color: var(--primary-800); text-transform: uppercase;">{{ $category->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 10px;">Titre de l'incident</label>
                <input type="text" name="title" required placeholder="Ex: Panne de lampadaire..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 10px;">Description détaillée</label>
                <textarea name="description" required rows="4" placeholder="Décrivez le problème le plus précisément possible..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid var(--slate-200); outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 32px;">
                <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 10px;">Photo de l'incident</label>
                <div style="border: 2px dashed var(--slate-200); padding: 30px; border-radius: 20px; text-align: center; cursor: pointer; transition: var(--transition);" onmouseover="this.style.borderColor='var(--primary-400)'" onmouseout="this.style.borderColor='var(--slate-200)'" onclick="document.getElementById('image-input').click()">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--slate-400)" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    <p style="color: var(--slate-500); margin-top: 12px; font-weight: 600;">Cliquez pour uploader une photo</p>
                    <input type="file" id="image-input" name="image" style="display: none;" onchange="this.previousElementSibling.textContent = this.files[0].name">
                </div>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 700; color: var(--slate-700); margin-bottom: 10px;">Localisation sur la carte</label>
            <div id="map" style="height: 400px; border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-soft); margin-bottom: 16px;"></div>
            
            <input type="hidden" name="latitude" id="lat" required>
            <input type="hidden" name="longitude" id="lng" required>
            <input type="hidden" name="address" id="address">

            <div id="address-preview" style="padding: 16px; background: var(--primary-50); border-radius: 12px; color: var(--primary-800); font-weight: 600; font-size: 0.9rem; display: none;">
                📍 <span id="address-text"></span>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 40px; padding: 20px;">
                Envoyer le Signalement
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([33.5731, -7.5898], 12); // Casablanca default
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
            
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;

            // Reverse Geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    const addr = data.display_name;
                    document.getElementById('address').value = addr;
                    document.getElementById('address-text').textContent = addr;
                    document.getElementById('address-preview').style.display = 'block';
                });
        });
    });
</script>
@endsection
