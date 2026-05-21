@extends('layouts.app')

@section('title', 'Mes Signalements')

@section('content')
<style>
    .reports-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    .report-card-grid {
        padding: 24px;
        display: grid;
        grid-template-columns: 80px 1fr 150px 120px;
        align-items: center;
        gap: 24px;
        transition: var(--transition);
    }
    @media (max-width: 768px) {
        .reports-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .reports-header h1 {
            font-size: 2.2rem !important;
        }
        .report-card-grid {
            grid-template-columns: 60px 1fr;
            gap: 16px;
            padding: 20px;
        }
        .report-card-grid > div:nth-child(3) {
            grid-column: span 2;
        }
        .report-card-grid > div:nth-child(4) {
            grid-column: span 2;
            text-align: left !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>
<div class="citizen-container" style="max-width: 1000px;">
    <div class="reports-header">
        <div>
            <h1 style="font-size: 3rem; color: var(--slate-900); letter-spacing: -2px; margin: 0;">Mes Signalements</h1>
            <p style="color: var(--slate-500); font-weight: 500; margin: 4px 0 0;">Suivez l'état de vos signalements urbains en temps réel.</p>
        </div>
        <a href="{{ route('reports.create') }}" class="btn-primary" style="padding: 14px 28px; white-space: nowrap; flex-shrink: 0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-right: 10px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouveau Signalement
        </a>
    </div>

    @if($reports->isEmpty())
        <div class="glass-card" style="padding: 80px; text-align: center; border: 2px dashed var(--slate-200);">
            <div style="width: 80px; height: 80px; background: var(--primary-50); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary-500)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <h3 style="color: var(--slate-900); margin-bottom: 12px;">Aucun signalement pour le moment</h3>
            <p style="color: var(--slate-500); margin-bottom: 32px;">Participez à l'amélioration de votre ville en signalant votre premier problème.</p>
            <a href="{{ route('reports.create') }}" class="btn-primary">Commencer maintenant</a>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($reports as $report)
                <div class="glass-card animate-slide-up report-card-grid" style="transition: var(--transition);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-soft)'">
                    <div style="width: 60px; height: 60px; background: var(--primary-100); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        {{ $report->category->icon ?? '📍' }}
                    </div>
                    <div>
                        <h4 style="font-size: 1.25rem; color: var(--slate-900); margin-bottom: 4px;">{{ $report->title }}</h4>
                        <p style="font-size: 0.85rem; color: var(--slate-500); display: flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ Str::limit($report->address, 50) }}
                        </p>
                    </div>
                    <div>
                        <span class="badge {{ $report->status === 'terminee' ? 'badge-done' : ($report->status === 'en cours' ? 'badge-progress' : 'badge-pending') }}" style="width: 100%; justify-content: center; padding: 8px;">
                            {{ $report->status }}
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <a href="{{ route('reports.show', $report->id) }}" style="color: var(--primary-600); text-decoration: none; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                            Détails
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                        <p style="font-size: 0.7rem; color: var(--slate-400); margin-top: 8px;">{{ $report->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div style="margin-top: 40px;">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
