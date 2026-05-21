@extends('layouts.admin')

@section('title', 'Gestion des Signalements')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Signalements</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Gérez tous les signalements des citoyens</p>
    </div>
    
    <div style="display: flex; gap: 12px;">
        <form action="{{ route('reports.index') }}" method="GET" style="display: flex; gap: 12px;">
            <select name="status" onchange="this.form.submit()" style="padding: 8px 16px; border-radius: 10px; border: 1px solid #e2e8f0; background: white; font-size: 0.85rem; font-weight: 600; color: #0f172a; outline: none;">
                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Tous les statuts</option>
                <option value="en attente" {{ request('status') === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours" {{ request('status') === 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ request('status') === 'terminee' ? 'selected' : '' }}>Terminés</option>
            </select>
        </form>
    </div>
</div>

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
    @if($reports->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-inbox" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucun signalement trouvé</h4>
            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Il n'y a pas de signalements correspondant à vos critères.</p>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">ID</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Signalement</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Catégorie</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Statut</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Citoyen</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Date</th>
                        <th style="padding: 14px 12px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    @php
                        $statusColors = [
                            'en attente' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'en cours' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                            'terminee' => ['bg' => '#d1fae5', 'text' => '#065f46']
                        ];
                        $sc = $statusColors[$report->status] ?? ['bg' => '#f1f5f9', 'text' => '#334155'];
                    @endphp
                    <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 16px 12px; font-size: 0.85rem; font-weight: 700; color: #64748b;">#{{ $report->id }}</td>
                        <td style="padding: 16px 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($report->image)
                                    <img src="{{ Storage::url($report->image) }}" alt="Signalement" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                        {{ $report->category->icon ?? '📍' }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-size: 0.9rem; font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ Str::limit($report->title, 40) }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 4px;">
                                        <i class="bi bi-geo-alt-fill"></i> {{ Str::limit($report->address, 30) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px 12px;">
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: #f1f5f9; color: #475569;">
                                {{ $report->category->name ?? 'Non classé' }}
                            </span>
                        </td>
                        <td style="padding: 16px 12px;">
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td style="padding: 16px 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 24px; height: 24px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 800; color: #475569;">
                                    {{ substr($report->user->name ?? '?', 0, 1) }}
                                </div>
                                <span style="font-size: 0.85rem; font-weight: 600; color: #334155;">{{ $report->user->name ?? 'Anonyme' }}</span>
                            </div>
                        </td>
                        <td style="padding: 16px 12px; font-size: 0.85rem; color: #64748b;">
                            {{ $report->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 16px 12px; text-align: right;">
                            <a href="{{ route('reports.show', $report->id) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; background: #eff6ff; color: #3b82f6; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                                <i class="bi bi-eye-fill"></i> Consulter
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 24px;">
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
