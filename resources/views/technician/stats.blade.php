@extends('layouts.technician')

@section('title', 'Statistiques de Performance')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Statistiques</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Analysez vos indicateurs clés de performance et vos résolutions mensuelles.</p>
</div>

<!-- Performance Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 30px;">
    
    <!-- Total Missions Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">Total Missions</div>
            <div style="font-size: 2rem; font-weight: 900; color: #0f172a;">{{ $total }}</div>
        </div>
        <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
    </div>
    
    <!-- Resolved Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">Résolues</div>
            <div style="font-size: 2rem; font-weight: 900; color: #10b981;">{{ $resolved }}</div>
        </div>
        <div style="width: 48px; height: 48px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #10b981;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
    </div>
    
    <!-- Success Rate Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">Taux de Réussite</div>
            <div style="font-size: 2rem; font-weight: 900; color: #3b82f6;">{{ $success_rate }}%</div>
        </div>
        <div style="width: 48px; height: 48px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        </div>
    </div>
    
</div>

<!-- Analytics Charts -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; flex-wrap: wrap;">
    
    <!-- Bar Chart -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 20px;">Missions Résolues par Mois</h3>
        <div style="height: 300px; width: 100%;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    
    <!-- Mini Stats Breakdown -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 20px;">Répartition</h3>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">
                        <span style="color: #64748b;">En cours</span>
                        <span style="color: #0f172a;">{{ $in_progress }}</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $total > 0 ? ($in_progress / $total) * 100 : 0 }}%; height: 100%; background: #3b82f6; border-radius: 10px;"></div>
                    </div>
                </div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">
                        <span style="color: #64748b;">En attente</span>
                        <span style="color: #0f172a;">{{ $pending }}</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $total > 0 ? ($pending / $total) * 100 : 0 }}%; height: 100%; background: #f59e0b; border-radius: 10px;"></div>
                    </div>
                </div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">
                        <span style="color: #64748b;">Résolues</span>
                        <span style="color: #0f172a;">{{ $resolved }}</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $total > 0 ? ($resolved / $total) * 100 : 0 }}%; height: 100%; background: #10b981; border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 16px; text-align: center; margin-top: 24px;">
            <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 4px;">Temps moyen de résolution</div>
            <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">{{ $avg_time }}</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthly_stats['labels']) !!},
                datasets: [{
                    label: 'Missions Résolues',
                    data: {!! json_encode($monthly_stats['resolved']) !!},
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderColor: '#10b981',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                weight: 600
                            },
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                weight: 600
                            },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
