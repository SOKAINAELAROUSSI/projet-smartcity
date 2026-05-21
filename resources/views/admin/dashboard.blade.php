@extends('layouts.admin')

@section('title', 'Tableau de Bord Admin')

@section('content')
<style>
    .dashboard-stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .dashboard-charts-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }
    .dashboard-tables-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }
    .dashboard-overview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* Media query for medium/tablet screen size */
    @media (max-width: 1280px) {
        .dashboard-stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .dashboard-charts-grid {
            grid-template-columns: 1fr 1fr;
        }
        .dashboard-charts-grid > div:last-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 1024px) {
        .dashboard-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .dashboard-charts-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-charts-grid > div:last-child {
            grid-column: span 1;
        }
        .dashboard-tables-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-overview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .dashboard-stats-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-overview-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Date Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div></div>
    <div style="display: flex; align-items: center; gap: 8px; background: white; padding: 8px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.85rem; font-weight: 600; color: #0f172a;">
        <i class="bi bi-calendar3"></i>
        {{ now()->translatedFormat('d M Y') }}
    </div>
</div>

{{-- Stat Cards Row --}}
<div class="dashboard-stats-grid">
    <div style="background: white; border-radius: 16px; padding: 22px; border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-flag-fill" style="font-size: 1.2rem; color: #3b82f6;"></i>
            </div>
            <div>
                <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0;">Total signalements</p>
                <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin: 0;">{{ number_format($adminStats['total']) }}</h3>
            </div>
        </div>
        <p style="font-size: 0.75rem; color: #10b981; font-weight: 700; margin: 10px 0 0;"><i class="bi bi-arrow-up-short"></i> 12.5% ce mois</p>
    </div>

    <div style="background: white; border-radius: 16px; padding: 22px; border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: #f0fdf4; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.2rem; color: #10b981;"></i>
            </div>
            <div>
                <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0;">Résolus</p>
                <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin: 0;">{{ number_format($adminStats['resolved']) }}</h3>
            </div>
        </div>
        <p style="font-size: 0.75rem; color: #10b981; font-weight: 700; margin: 10px 0 0;">{{ $adminStats['resolution_rate'] }}% taux de résolution</p>
    </div>

    <div style="background: white; border-radius: 16px; padding: 22px; border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: #fef3c7; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-clock-fill" style="font-size: 1.2rem; color: #f59e0b;"></i>
            </div>
            <div>
                <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0;">En cours</p>
                <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $adminStats['en_cours'] }}</h3>
            </div>
        </div>
        <p style="font-size: 0.75rem; color: #f59e0b; font-weight: 700; margin: 10px 0 0;"><i class="bi bi-arrow-up-short"></i> 5.2% depuis hier</p>
    </div>

    <div style="background: white; border-radius: 16px; padding: 22px; border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: #f5f3ff; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-check-fill" style="font-size: 1.2rem; color: #8b5cf6;"></i>
            </div>
            <div>
                <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0;">Techniciens actifs</p>
                <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $adminStats['technicians'] }}</h3>
            </div>
        </div>
        <p style="font-size: 0.75rem; color: #8b5cf6; font-weight: 700; margin: 10px 0 0;">{{ $adminStats['new_today'] }} nouveaux aujourd'hui</p>
    </div>

    <div style="background: white; border-radius: 16px; padding: 22px; border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: #fef2f2; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-star-fill" style="font-size: 1.2rem; color: #f59e0b;"></i>
            </div>
            <div>
                <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0;">Satisfaction moyenne</p>
                <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $adminStats['avg_rating'] }}/5</h3>
            </div>
        </div>
        <p style="font-size: 0.75rem; color: #64748b; font-weight: 700; margin: 10px 0 0;">Basé sur {{ $adminStats['total_ratings'] }} avis</p>
    </div>
</div>

{{-- Charts Row: Evolution + Pie + Map --}}
<div class="dashboard-charts-grid">
    {{-- Evolution Chart --}}
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0;">Évolution des signalements</h4>
        </div>
        <div style="display: flex; gap: 16px; margin-bottom: 16px;">
            <span style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #64748b; font-weight: 600;">
                <span style="width: 10px; height: 3px; background: #3b82f6; border-radius: 2px;"></span> Signalements
            </span>
            <span style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #64748b; font-weight: 600;">
                <span style="width: 10px; height: 3px; background: #10b981; border-radius: 2px;"></span> Résolus
            </span>
        </div>
        <div style="height: 200px;"><canvas id="evolutionChart"></canvas></div>
    </div>

    {{-- Pie Chart --}}
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
        <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0 0 20px;">Répartition par catégorie</h4>
        <div style="height: 180px; display: flex; justify-content: center;"><canvas id="categoryPie"></canvas></div>
        <div style="margin-top: 16px; display: flex; flex-direction: column; gap: 6px;">
            @foreach($categoryStats as $cat)
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem;">
                <span style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #334155;">
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $cat['color'] }};"></span>
                    {{ $cat['name'] }}
                </span>
                <span style="font-weight: 700; color: #64748b;">{{ $cat['pct'] }}% ({{ $cat['count'] }})</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Map --}}
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0;">Carte des signalements</h4>
        </div>
        <div id="admin-map" style="height: 280px; border-radius: 12px; overflow: hidden; position: relative; z-index: 1;"></div>
        <div style="display: flex; gap: 16px; margin-top: 12px; justify-content: center;">
            <span style="display: flex; align-items: center; gap: 6px; font-size: 0.7rem; font-weight: 600; color: #64748b;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b;"></span> En attente
            </span>
            <span style="display: flex; align-items: center; gap: 6px; font-size: 0.7rem; font-weight: 600; color: #64748b;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;"></span> En cours
            </span>
            <span style="display: flex; align-items: center; gap: 6px; font-size: 0.7rem; font-weight: 600; color: #64748b;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span> Résolu
            </span>
        </div>
    </div>
</div>

{{-- Reports Table + Activity Feed --}}
<div class="dashboard-tables-grid">
    {{-- Recent Reports --}}
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0;">Signalements récents</h4>
            <a href="{{ route('reports.index') }}" style="font-size: 0.8rem; font-weight: 700; color: #3b82f6; text-decoration: none;">Voir tout</a>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 10px 8px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">ID</th>
                    <th style="padding: 10px 8px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Titre</th>
                    <th style="padding: 10px 8px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Catégorie</th>
                    <th style="padding: 10px 8px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Statut</th>
                    <th style="padding: 10px 8px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Date</th>
                    <th style="padding: 10px 8px; text-align: right; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentReports as $report)
                @php
                    $statusColors = ['en attente' => ['#fef3c7','#92400e'], 'en cours' => ['#dbeafe','#1e40af'], 'terminee' => ['#d1fae5','#065f46']];
                    $sc = $statusColors[$report->status] ?? ['#f1f5f9','#334155'];
                @endphp
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px 8px; font-size: 0.8rem; font-weight: 700; color: #64748b;">#SGL-{{ $report->id }}</td>
                    <td style="padding: 14px 8px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                {{ $report->category->icon ?? '📍' }}
                            </div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">{{ Str::limit($report->title, 25) }}</span>
                        </div>
                    </td>
                    <td style="padding: 14px 8px;">
                        <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: #f0fdf4; color: #166534;">{{ $report->category->name ?? 'Général' }}</span>
                    </td>
                    <td style="padding: 14px 8px;">
                        <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: {{ $sc[0] }}; color: {{ $sc[1] }};">{{ ucfirst($report->status) }}</span>
                    </td>
                    <td style="padding: 14px 8px; font-size: 0.8rem; color: #64748b;">{{ $report->created_at->format('d M Y H:i') }}</td>
                    <td style="padding: 14px 8px; text-align: right;">
                        <a href="{{ route('reports.show', $report->id) }}" style="color: #3b82f6; font-size: 0.8rem; font-weight: 700; text-decoration: none;"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Activity Feed --}}
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0;">Activité récente</h4>
        </div>
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($recentActivities as $act)
            <div style="display: flex; align-items: flex-start; gap: 12px;">
                <div style="width: 32px; height: 32px; min-width: 32px; border-radius: 50%; background: {{ $act['bg'] }}; display: flex; align-items: center; justify-content: center;">
                    <i class="bi {{ $act['icon'] }}" style="font-size: 0.85rem; color: {{ $act['color'] }};"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 0.82rem; font-weight: 600; color: #0f172a; margin: 0;">{{ $act['text'] }}</p>
                    <p style="font-size: 0.7rem; color: #94a3b8; margin: 4px 0 0;">{{ $act['time'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Top Technicians --}}
        <div style="margin-top: 28px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h4 style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin: 0;">Techniciens les plus performants</h4>
            </div>
            @foreach($topTechnicians as $i => $tech)
            <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; {{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
                <span style="width: 24px; height: 24px; border-radius: 50%; background: {{ $i === 0 ? '#fef3c7' : ($i === 1 ? '#f1f5f9' : '#fff7ed') }}; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 900; color: {{ $i === 0 ? '#92400e' : '#64748b' }};">{{ $i + 1 }}</span>
                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem;">{{ substr($tech['name'], 0, 1) }}</div>
                <span style="flex: 1; font-size: 0.85rem; font-weight: 700; color: #0f172a;">{{ $tech['name'] }}</span>
                <span style="font-size: 0.75rem; font-weight: 700; color: #10b981;">{{ $tech['rate'] }}%</span>
                <span style="font-size: 0.75rem; font-weight: 800; color: #f59e0b;"><i class="bi bi-star-fill"></i> {{ $tech['rating'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Overview Stats Row --}}
<div class="dashboard-overview-grid">
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
            <i class="bi bi-hourglass-split" style="font-size: 1.3rem; color: #3b82f6;"></i>
        </div>
        <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px;">Temps moyen de résolution</p>
        <h3 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $overviewStats['avg_time'] }}</h3>
        <p style="font-size: 0.7rem; color: #10b981; font-weight: 700; margin: 6px 0 0;">▼ 8% ce mois</p>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
            <i class="bi bi-graph-up-arrow" style="font-size: 1.3rem; color: #f59e0b;"></i>
        </div>
        <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px;">Signalements du mois</p>
        <h3 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $overviewStats['month_total'] }}</h3>
        <p style="font-size: 0.7rem; color: #10b981; font-weight: 700; margin: 6px 0 0;">▲ 15% ce mois</p>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0fdf4; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
            <i class="bi bi-pie-chart-fill" style="font-size: 1.3rem; color: #10b981;"></i>
        </div>
        <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px;">Taux de résolution global</p>
        <h3 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $overviewStats['resolution_rate'] }}%</h3>
        <p style="font-size: 0.7rem; color: #10b981; font-weight: 700; margin: 6px 0 0;">▲ 5.3% ce mois</p>
    </div>
    <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef2f2; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
            <i class="bi bi-emoji-smile-fill" style="font-size: 1.3rem; color: #ef4444;"></i>
        </div>
        <p style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px;">Satisfaction citoyenne</p>
        <h3 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $overviewStats['satisfaction'] }}/5</h3>
        <p style="font-size: 0.7rem; color: #64748b; font-weight: 700; margin: 6px 0 0;">▲ 0.2 ce mois</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Evolution Chart
    const evoCtx = document.getElementById('evolutionChart');
    if (evoCtx) {
        new Chart(evoCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Signalements',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.08)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0
                },{
                    label: 'Résolus',
                    data: {!! json_encode($chartResolved) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.06)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }

    // Category Pie
    const pieCtx = document.getElementById('categoryPie');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(collect($categoryStats)->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode(collect($categoryStats)->pluck('count')) !!},
                    backgroundColor: {!! json_encode(collect($categoryStats)->pluck('color')) !!},
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });
    }

    // Admin Map
    const mapEl = document.getElementById('admin-map');
    if (mapEl) {
        const map = L.map('admin-map').setView([33.97, -6.85], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
        const reports = {!! json_encode($mapReports) !!};
        const colors = {'en attente':'#f59e0b','en cours':'#3b82f6','terminee':'#10b981'};
        reports.forEach(r => {
            if (r.latitude && r.longitude) {
                L.circleMarker([r.latitude, r.longitude], {
                    radius: 6, fillColor: colors[r.status] || '#94a3b8', color: '#fff', weight: 2, fillOpacity: 0.9
                }).addTo(map).bindPopup('<b>'+r.title+'</b><br>'+r.status);
            }
        });
        setTimeout(() => map.invalidateSize(), 300);
    }
});
</script>
@endsection
