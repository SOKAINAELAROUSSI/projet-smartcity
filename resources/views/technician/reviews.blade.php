@extends('layouts.technician')

@section('title', 'Évaluations Citoyennes')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Évaluations</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Retrouvez l'historique des notes et avis réels laissés par les citoyens sur vos interventions résolues.</p>
</div>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
    
    <!-- Average Rating Card -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); text-align: center; padding: 32px 24px;">
        <div style="font-size: 0.85rem; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 12px;">Votre note globale</div>
        <div style="font-size: 3.5rem; font-weight: 900; color: #f59e0b; margin-bottom: 8px; font-family: 'Outfit', sans-serif;">
            {{ number_format($averageRating, 1) }}
        </div>
        
        <!-- Stars visualization -->
        <div style="display: flex; justify-content: center; gap: 4px; margin-bottom: 16px; color: #f59e0b;">
            @php $roundedRating = round($averageRating); @endphp
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $roundedRating)
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @else
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                @endif
            @endfor
        </div>
        
        <p style="font-size: 0.8rem; color: #94a3b8; margin: 0; line-height: 1.4;">Calculé en temps réel depuis les retours citoyens.</p>
    </div>
    
    <!-- Reviews Timeline/List -->
    <div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 20px;">Avis Récents</h3>
        
        @if($ratings->isEmpty())
            <div style="text-align: center; padding: 40px 20px;">
                <div style="width: 56px; height: 56px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #cbd5e1;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
                <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Aucune évaluation reçue</h4>
                <p style="color: #64748b; font-size: 0.85rem; max-width: 320px; margin: 0 auto;">Les avis des citoyens apparaîtront ici dès que vos interventions résolues auront été notées.</p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($ratings as $rating)
                    <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #64748b;">
                            {{ substr($rating->report->user->name ?? 'C', 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                                    {{ $rating->report->user->name ?? 'Citoyen' }}
                                </h4>
                                <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">
                                    {{ $rating->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            
                            <!-- Review Stars -->
                            <div style="display: flex; gap: 2px; color: #f59e0b; margin-bottom: 8px;">
                                @for($s = 1; $s <= 5; $s++)
                                    @if($s <= $rating->score)
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @else
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    @endif
                                @endfor
                            </div>
                            
                            @if($rating->comment)
                                <p style="font-size: 0.85rem; color: #475569; margin: 0 0 10px; line-height: 1.4;">
                                    "{{ $rating->comment }}"
                                </p>
                            @else
                                <p style="font-size: 0.85rem; color: #94a3b8; font-style: italic; margin: 0 0 10px; line-height: 1.4;">
                                    Aucun commentaire laissé.
                                </p>
                            @endif
                            
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; background: #f8fafc; padding: 6px 12px; border-radius: 6px; display: inline-block;">
                                Signalement : {{ $rating->report->title }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
