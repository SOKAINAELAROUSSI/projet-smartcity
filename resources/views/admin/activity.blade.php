@extends('layouts.admin')

@section('title', 'Journal d\'Activités')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Journal d'Activités</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Tracez toutes les actions importantes effectuées sur la plateforme.</p>
    </div>
</div>

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
    @if($logs->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-clock-history" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucune activité enregistrée</h4>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Les actions importantes apparaîtront ici.</p>
        </div>
    @else
        <div style="position: relative; padding-left: 20px;">
            <!-- Ligne verticale -->
            <div style="position: absolute; left: 27px; top: 10px; bottom: 10px; width: 2px; background: #e2e8f0;"></div>
            
            @foreach($logs as $log)
                @php
                    $icon = 'bi-record-circle';
                    $color = '#64748b';
                    $bg = '#f1f5f9';
                    
                    if (str_contains(strtolower($log->action), 'suppression') || str_contains(strtolower($log->action), 'delete')) {
                        $icon = 'bi-trash-fill';
                        $color = '#ef4444';
                        $bg = '#fef2f2';
                    } elseif (str_contains(strtolower($log->action), 'connexion') || str_contains(strtolower($log->action), 'login')) {
                        $icon = 'bi-box-arrow-in-right';
                        $color = '#10b981';
                        $bg = '#ecfdf5';
                    } elseif (str_contains(strtolower($log->action), 'affectation') || str_contains(strtolower($log->action), 'assign')) {
                        $icon = 'bi-person-gear';
                        $color = '#3b82f6';
                        $bg = '#eff6ff';
                    } elseif (str_contains(strtolower($log->action), 'modification') || str_contains(strtolower($log->action), 'update')) {
                        $icon = 'bi-pencil-fill';
                        $color = '#f59e0b';
                        $bg = '#fffbeb';
                    }
                @endphp
                
                <div style="position: relative; padding: 16px 0; display: flex; gap: 20px;">
                    <!-- Point sur la ligne -->
                    <div style="width: 16px; height: 16px; border-radius: 50%; background: {{ $color }}; border: 3px solid white; box-shadow: 0 0 0 2px #e2e8f0; position: absolute; left: 0; top: 22px; z-index: 2;"></div>
                    
                    <div style="margin-left: 16px; flex: 1; background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 16px; display: flex; align-items: flex-start; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: {{ $bg }}; color: {{ $color }}; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                                <h4 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $log->action }}</h4>
                                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 8px; line-height: 1.5;">{{ $log->description }}</p>
                            
                            <div style="display: flex; gap: 12px; align-items: center; font-size: 0.75rem;">
                                @if($log->user)
                                    <span style="color: #475569; font-weight: 600; background: white; padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                        <i class="bi bi-person-fill" style="color: #94a3b8; margin-right: 4px;"></i> {{ $log->user->name }}
                                        <span style="color: #94a3b8; margin-left: 4px;">({{ $log->user->role }})</span>
                                    </span>
                                @else
                                    <span style="color: #94a3b8; font-weight: 600; background: white; padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                        Système / Anonyme
                                    </span>
                                @endif
                                
                                @if($log->ip_address)
                                    <span style="color: #94a3b8;">IP: {{ $log->ip_address }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
