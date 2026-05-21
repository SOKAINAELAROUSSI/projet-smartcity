@extends('layouts.admin')

@section('title', 'Avis & Évaluations')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Avis & Évaluations</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Supervisez les retours des citoyens et évaluez vos techniciens.</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<!-- Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-star-fill" style="color: #3b82f6; font-size: 1.5rem;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px;">Note globale</p>
            <h3 style="font-size: 1.5rem; font-weight: 900; color: #0f172a; margin: 0;">{{ number_format($avgScore, 1) }} <span style="font-size: 1rem; color: #94a3b8;">/ 5</span></h3>
        </div>
    </div>
    
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-chat-left-text-fill" style="color: #64748b; font-size: 1.5rem;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px;">Total des avis</p>
            <h3 style="font-size: 1.5rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $totalReviews }}</h3>
        </div>
    </div>
    
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-emoji-smile-fill" style="color: #10b981; font-size: 1.5rem;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px;">Excellents (4-5)</p>
            <h3 style="font-size: 1.5rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $excellent }}</h3>
        </div>
    </div>
    
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-emoji-frown-fill" style="color: #ef4444; font-size: 1.5rem;"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px;">Critiques (1-2)</p>
            <h3 style="font-size: 1.5rem; font-weight: 900; color: #0f172a; margin: 0;">{{ $poor }}</h3>
        </div>
    </div>
</div>

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
    @if($reviews->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-star-half" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucun avis reçu</h4>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Les avis des citoyens apparaîtront ici.</p>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Note</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Commentaire</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Signalement</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Technicien évalué</th>
                        <th style="padding: 14px 12px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 16px 12px; width: 120px;">
                            <div style="display: flex; gap: 2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star-fill" style="color: {{ $i <= $review->score ? '#f59e0b' : '#e2e8f0' }}; font-size: 1rem;"></i>
                                @endfor
                            </div>
                            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 4px; font-weight: 600;">
                                {{ $review->created_at->format('d/m/Y') }}
                            </div>
                        </td>
                        <td style="padding: 16px 12px; max-width: 300px;">
                            <p style="font-size: 0.85rem; color: #0f172a; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="{{ $review->comment }}">
                                {{ $review->comment ?: 'Aucun commentaire.' }}
                            </p>
                        </td>
                        <td style="padding: 16px 12px;">
                            @if($review->report)
                                <a href="{{ route('reports.show', $review->report->id) }}" style="font-size: 0.85rem; color: #3b82f6; text-decoration: none; font-weight: 600;">
                                    {{ Str::limit($review->report->title, 25) }}
                                </a>
                            @else
                                <span style="font-size: 0.85rem; color: #94a3b8;">Signalement supprimé</span>
                            @endif
                        </td>
                        <td style="padding: 16px 12px;">
                            @if($review->technician)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800;">
                                        {{ substr($review->technician->name, 0, 1) }}
                                    </div>
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #0f172a;">{{ $review->technician->name }}</span>
                                </div>
                            @else
                                <span style="font-size: 0.85rem; color: #94a3b8;">Technicien introuvable</span>
                            @endif
                        </td>
                        <td style="padding: 16px 12px; text-align: right;">
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ? Cette action est irréversible.');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 6px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'" title="Supprimer cet avis">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
