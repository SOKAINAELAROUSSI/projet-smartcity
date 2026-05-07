@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="dashboard-layout" style="padding: 40px; display: grid; grid-template-columns: 280px 1fr; gap: 40px;">
    <!-- Sidebar Navigation -->
    <aside>
        <div class="glass-card" style="padding: 30px; position: sticky; top: 120px;">
            <div style="margin-bottom: 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 4px solid white; box-shadow: var(--shadow-soft);">
                    <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary-700);">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <h4 style="color: var(--slate-900);">{{ Auth::user()->name }}</h4>
                <p style="font-size: 0.75rem; color: var(--primary-700); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">{{ Auth::user()->role }}</p>
            </div>

            <nav style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('dashboard') }}" class="sidebar-item active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Tableau de Bord
                </a>
                <a href="{{ route('reports.create') }}" class="sidebar-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"></path></svg>
                    Signalements
                </a>
                <a href="#" class="sidebar-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Capteurs IoT
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('categories.index') }}" class="sidebar-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                        Gérer les Services
                    </a>
                @endif
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <div style="margin-bottom: 40px;">
            <h1 style="font-size: clamp(2rem, 5vw, 3rem); color: var(--slate-900); letter-spacing: -2px;">Centre de Contrôle</h1>
            <p style="color: var(--slate-500); font-weight: 500;">Monitorage intelligent de l'infrastructure urbaine.</p>
        </div>

        <!-- Smart City Metrics -->
        <div class="stat-card-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div class="glass-card" style="padding: 24px; border-left: 6px solid var(--primary-500);">
                <p style="font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase;">Qualité Air</p>
                <div style="font-size: 2rem; font-weight: 900; color: var(--slate-900);">{{ $smartData['air_quality'] }}%</div>
                <div style="height: 6px; background: var(--primary-100); border-radius: 3px; margin-top: 12px; overflow: hidden;">
                    <div style="width: 84%; height: 100%; background: var(--primary-500);"></div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; border-left: 6px solid #3b82f6;">
                <p style="font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase;">Parking Libre</p>
                <div style="font-size: 2rem; font-weight: 900; color: var(--slate-900);">{{ $smartData['parking_availability'] }}</div>
                <p style="font-size: 0.8rem; color: #3b82f6; font-weight: 700; margin-top: 8px;">Places disponibles</p>
            </div>
            <div class="glass-card" style="padding: 24px; border-left: 6px solid #f59e0b;">
                <p style="font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase;">Énergie</p>
                <div style="font-size: 2rem; font-weight: 900; color: var(--slate-900);">+{{ $smartData['energy_savings'] }}%</div>
                <p style="font-size: 0.8rem; color: #f59e0b; font-weight: 700; margin-top: 8px;">Économie réalisée</p>
            </div>
            <div class="glass-card" style="padding: 24px; border-left: 6px solid var(--slate-800);">
                <p style="font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase;">Capteurs</p>
                <div style="font-size: 2rem; font-weight: 900; color: var(--slate-900);">{{ $smartData['active_sensors'] }}</div>
                <p style="font-size: 0.8rem; color: var(--slate-800); font-weight: 700; margin-top: 8px;">IoT en ligne</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; margin-bottom: 40px;">
            <!-- Charts Section -->
            <div class="glass-card" style="padding: 40px; min-height: 400px;">
                <h3 style="margin-bottom: 32px;">Analyse des Signalements</h3>
                <div style="height: 300px; width: 100%;">
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>

            <!-- Stats Column -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                @foreach($stats as $label => $value)
                    <div class="glass-card" style="padding: 24px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-size: 0.8rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase;">{{ $label }}</p>
                            <div style="font-size: 2rem; font-weight: 900; color: var(--primary-700);">{{ $value }}</div>
                        </div>
                        <div style="width: 50px; height: 50px; background: var(--primary-50); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary-600)" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                        </div>
                    </div>
                @endforeach
                
                @if(Auth::user()->role === 'admin')
                    <div class="glass-card" style="padding: 24px; background: var(--slate-900); color: white;">
                        <h4 style="margin-bottom: 16px; font-size: 0.9rem;">Meilleurs Techniciens</h4>
                        @foreach(\App\Models\TechnicianProfile::orderBy('rating', 'desc')->take(3)->get() as $tp)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.85rem;">
                                <span>{{ $tp->user->name }}</span>
                                <span style="color: #f59e0b; font-weight: 800;">⭐ {{ number_format($tp->rating, 1) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="glass-card" style="padding: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 20px;">
                <h3>Dernières Interventions</h3>
                <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 12px; width: 100%; max-width: 300px;">
                    <input type="text" name="search" placeholder="Rechercher..." style="padding: 10px 16px; border-radius: 10px; border: 1px solid var(--slate-200); outline: none; flex: 1;">
                    <button type="submit" class="btn-primary" style="padding: 10px 16px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px; min-width: 600px;">
                    <tbody>
                        @foreach($reports as $report)
                            <tr style="background: white; border-radius: 16px; box-shadow: var(--shadow-soft);">
                                <td style="padding: 20px; border-radius: 16px 0 0 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 44px; height: 44px; background: var(--primary-100); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                            {{ $report->category ? $report->category->icon : '📍' }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: var(--slate-900);">{{ $report->title }}</div>
                                            <div style="font-size: 0.75rem; color: var(--primary-700); font-weight: 800; text-transform: uppercase;">{{ $report->category->name ?? 'Urbain' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td style="padding: 20px;">
                                    <span class="badge {{ $report->status === 'terminee' ? 'badge-done' : ($report->status === 'en cours' ? 'badge-progress' : 'badge-pending') }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td style="padding: 20px;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: var(--slate-500);">{{ $report->created_at->format('d M') }}</div>
                                </td>
                                <td style="padding: 20px; text-align: right; border-radius: 0 16px 16px 0;">
                                    <a href="{{ route('reports.show', $report->id) }}" style="color: var(--primary-600); text-decoration: none; font-weight: 800; font-size: 0.9rem;">Consulter</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Scripts for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('reportsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Signalements',
                    data: [12, 19, 3, 5, 2, 3, 9],
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection
