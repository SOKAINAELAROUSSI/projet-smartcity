@extends('layouts.technician')

@section('title', 'Tableau de Bord')

@section('content')
<!-- Top Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 24px;">
    @foreach($stats as $label => $stat)
        <div class="card" style="display: flex; gap: 20px; align-items: center; border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 24px;">
            <div style="width: 56px; height: 56px; border-radius: 16px; background: {{ $stat['bg'] }}; color: {{ $stat['color'] }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                {!! $stat['icon'] !!}
            </div>
            <div>
                <div style="color: #64748b; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px;">{{ $label }}</div>
                <div style="font-size: 1.75rem; font-weight: 900; color: #0f172a; line-height: 1.2;">{{ $stat['value'] }}</div>
                <div style="font-size: 0.75rem; color: {{ $stat['color'] }}; font-weight: 700; margin-top: 4px;">{!! $stat['delta'] !!}</div>
            </div>
        </div>
    @endforeach
</div>

<!-- Main Middle Grid -->
<div class="middle-grid">
    
    <!-- Carte des missions -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Carte des missions</h3>
            <select style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 12px; font-size: 0.85rem; font-weight: 600; color: #64748b; outline: none;">
                <option>Toutes les missions</option>
                <option>Urgentes</option>
            </select>
        </div>
        <div id="dashboard-map" style="flex: 1; min-height: 300px; border-radius: 12px; z-index: 1;"></div>
    </div>

    <!-- Mes missions du jour -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Mes missions du jour</h3>
            <a href="#" style="color: #3b82f6; font-size: 0.85rem; font-weight: 600; text-decoration: none;">Voir tout</a>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($missionsDuJour as $mission)
                <a href="{{ route('technician.mission.show', $mission->id) }}" style="display: flex; gap: 16px; text-decoration: none; color: inherit; align-items: center; padding: 8px; border-radius: 12px; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; background: #e2e8f0; flex-shrink: 0;">
                        @if($mission->report->image)
                            <img src="{{ asset('storage/' . $mission->report->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#94a3b8;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                            <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $mission->report->title }}</h4>
                            @if($mission->priority === 'haute')
                                <span style="background: #fee2e2; color: #ef4444; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 100px;">Urgent</span>
                            @else
                                <span style="background: #e0f2fe; color: #0284c7; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 100px;">{{ ucfirst($mission->status) }}</span>
                            @endif
                        </div>
                        <div style="display: flex; align-items: center; gap: 4px; color: #64748b; font-size: 0.8rem;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ Str::limit($mission->report->address ?? 'Lieu inconnu', 20) }}
                        </div>
                    </div>
                    <div style="color: #cbd5e1;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
            @empty
                <p style="color: #64748b; font-size: 0.9rem; text-align: center;">Aucune mission pour aujourd'hui.</p>
            @endforelse
        </div>
    </div>

    <!-- Right Column (Donut + Notifications) -->
    <div class="right-column" style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Statut des missions (Donut) -->
        <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 24px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 20px;">Statut des missions</h3>
            <div class="donut-container" style="display: flex; align-items: center; gap: 20px;">
                <div style="width: 120px; height: 120px; position: relative;">
                    <canvas id="statusChart"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 900; color: #0f172a;">{{ $donutData['total'] }}</div>
                        <div style="font-size: 0.7rem; color: #64748b; font-weight: 600;">Total</div>
                    </div>
                </div>
                <div class="donut-legend" style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                    @foreach($donutData['labels'] as $index => $label)
                        @php
                            $val = $donutData['data'][$index];
                            $percentage = $donutData['total'] > 0 ? round(($val / $donutData['total']) * 100) : 0;
                        @endphp
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 600;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #64748b;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $donutData['colors'][$index] }};"></div>
                                {{ $label }}
                            </div>
                            <div style="color: #0f172a;">{{ $val }} <span style="color: #94a3b8; font-weight: 500;">({{ $percentage }}%)</span></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Notifications récentes</h3>
                <a href="#" style="color: #3b82f6; font-size: 0.85rem; font-weight: 600; text-decoration: none;">Voir tout</a>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @forelse($notifications as $notif)
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $notif->type === 'urgent' ? '#fee2e2' : ($notif->type === 'success' ? '#dcfce7' : '#e0f2fe') }}; color: {{ $notif->type === 'urgent' ? '#ef4444' : ($notif->type === 'success' ? '#16a34a' : '#0284c7') }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                            @if($notif->type === 'urgent')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            @elseif($notif->type === 'success')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ $notif->title }}</div>
                            <div style="font-size: 0.8rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $notif->message }}</div>
                        </div>
                        <div style="font-size: 0.75rem; color: #94a3b8; white-space: nowrap;">Il y a {{ $notif->created_at->diffInMinutes() }} min</div>
                    </div>
                @empty
                    <p style="color: #64748b; font-size: 0.9rem; text-align: center;">Aucune notification.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<!-- Bottom Grid -->
<div class="bottom-grid">
    
    <!-- Interventions récentes -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Interventions récentes</h3>
            <a href="#" style="color: #3b82f6; font-size: 0.85rem; font-weight: 600; text-decoration: none;">Voir tout</a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            @forelse($recentInterventions as $intervention)
                <div style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                    <div style="height: 120px; background: #e2e8f0; position: relative;">
                        @if($intervention->report->image)
                            <img src="{{ asset('storage/' . $intervention->report->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                        <span style="position: absolute; top: 12px; left: 12px; background: #10b981; color: white; font-size: 0.7rem; font-weight: 800; padding: 4px 10px; border-radius: 100px;">Résolue</span>
                    </div>
                    <div style="padding: 16px;">
                        <h4 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0 0 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $intervention->report->title }}</h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 4px; color: #64748b;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                {{ explode(',', $intervention->report->address)[0] ?? 'Lieu inconnu' }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 4px; color: #f59e0b; font-weight: 700;">
                                ⭐ 4.5
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="color: #64748b; font-size: 0.9rem;">Aucune intervention terminée récemment.</p>
            @endforelse
        </div>
    </div>

    <!-- Performance -->
    <div class="card" style="background: linear-gradient(135deg, #059669, #10b981); color: white; border: none; padding: 32px; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; position: relative; z-index: 10;">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: white;">Votre performance</h3>
            <select style="background: rgba(255,255,255,0.2); border: none; color: white; font-weight: 600; font-size: 0.8rem; padding: 4px 12px; border-radius: 100px; outline: none; appearance: none; cursor: pointer;">
                <option style="color: black;">Ce mois</option>
            </select>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; position: relative; z-index: 10;">
            <div>
                <div style="font-size: 3rem; font-weight: 900; line-height: 1;">{{ $performance['resolved'] }}</div>
                <div style="font-size: 0.9rem; font-weight: 600; opacity: 0.9;">Missions résolues</div>
            </div>
            
            <!-- Custom Success Circle -->
            <div style="position: relative; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                <svg width="80" height="80" viewBox="0 0 100 100" style="transform: rotate(-90deg);">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="8"></circle>
                    <circle cx="50" cy="50" r="45" fill="none" stroke="white" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="{{ 283 - (283 * $performance['success_rate']) / 100 }}" stroke-linecap="round"></circle>
                </svg>
                <div style="position: absolute; text-align: center;">
                    <div style="font-size: 1.25rem; font-weight: 800;">{{ $performance['success_rate'] }}%</div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px; position: relative; z-index: 10;">
            <div>
                <div style="display: flex; align-items: center; gap: 6px; font-weight: 800; font-size: 0.95rem; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    {{ $performance['avg_time'] }}
                </div>
                <div style="font-size: 0.75rem; opacity: 0.9;">Temps moyen</div>
            </div>
            <div style="text-align: right;">
                <div style="display: flex; align-items: center; gap: 6px; font-weight: 800; font-size: 0.95rem; margin-bottom: 4px; justify-content: flex-end;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    {{ $performance['rating'] }}
                </div>
                <div style="font-size: 0.75rem; opacity: 0.9;">Note moyenne</div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Responsive Grid for Dashboard */
    .middle-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr) minmax(0, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    .bottom-grid {
        display: grid;
        grid-template-columns: minmax(0, 2.5fr) minmax(0, 1fr);
        gap: 24px;
    }
    
    @media (max-width: 1280px) {
        .middle-grid {
            grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
        }
        /* Make the 3rd column (Donut + Notifications) span full width or drop below */
        .right-column {
            grid-column: 1 / -1;
            flex-direction: row !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
    }

    @media (max-width: 1024px) {
        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .middle-grid {
            grid-template-columns: 1fr;
        }
        .right-column {
            grid-template-columns: 1fr;
        }
        /* Adjust donut layout on very small screens */
        .donut-container {
            flex-direction: column !important;
            align-items: center;
            text-align: center;
        }
        .donut-legend {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Leaflet Map ---
        var map = L.map('dashboard-map', {zoomControl: false}).setView([33.9716, -6.8498], 12); // Rabat default
        
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap © CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        @foreach($missionsDuJour as $mission)
            @if($mission->report->latitude && $mission->report->longitude)
                var color = '{{ $mission->priority === "haute" ? "#ef4444" : ($mission->status === "en cours" ? "#3b82f6" : "#f59e0b") }}';
                var icon = L.divIcon({
                    className: 'custom-pin',
                    html: `<div style='background-color:${color};width:24px;height:24px;border-radius:50%;border:3px solid white;box-shadow:0 2px 10px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;'><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9z"></path></svg></div>`,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                
                L.marker([{{ $mission->report->latitude }}, {{ $mission->report->longitude }}], {icon: icon})
                    .addTo(map)
                    .bindPopup("<b>{{ $mission->report->title }}</b><br><a href='{{ route('technician.mission.show', $mission->id) }}'>Gérer</a>");
            @endif
        @endforeach


        // --- Chart.js Donut ---
        const ctx = document.getElementById('statusChart').getContext('2d');
        const donutData = @json($donutData);
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: donutData.labels,
                datasets: [{
                    data: donutData.data,
                    backgroundColor: donutData.colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' }
                    }
                }
            }
        });
    });
</script>
@endsection
