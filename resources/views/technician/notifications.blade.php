@extends('layouts.technician')

@section('title', 'Centre de Notifications Réel')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Notifications</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Restez informé en temps réel de vos assignations et alertes municipales.</p>
</div>

<div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 24px; max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Flux d'actualités</h3>
        @if(!$notifications->isEmpty())
            <button style="background: none; border: none; font-size: 0.8rem; font-weight: 700; color: #10b981; cursor: pointer;">Tout marquer comme lu</button>
        @endif
    </div>
    
    <!-- Timeline notifications -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        @if($notifications->isEmpty())
            <div style="text-align: center; padding: 40px 20px;">
                <div style="width: 56px; height: 56px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #cbd5e1;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </div>
                <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Aucune notification</h4>
                <p style="color: #64748b; font-size: 0.85rem; max-width: 320px; margin: 0 auto;">Votre boîte de réception est complètement propre pour le moment.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                @php
                    // Dynamic styling depending on notification type
                    $bgColor = '#f8fafc';
                    $borderColor = '#e2e8f0';
                    $iconColor = '#64748b';
                    $iconBg = '#f1f5f9';
                    
                    if ($notification->type === 'success') {
                        $borderColor = '#10b981';
                        $iconColor = '#10b981';
                        $iconBg = '#ecfdf5';
                    } elseif ($notification->type === 'danger' || $notification->type === 'error') {
                        $borderColor = '#ef4444';
                        $iconColor = '#ef4444';
                        $iconBg = '#fee2e2';
                    } elseif ($notification->type === 'warning') {
                        $borderColor = '#f59e0b';
                        $iconColor = '#f59e0b';
                        $iconBg = '#fffbeb';
                    } elseif ($notification->type === 'info') {
                        $borderColor = '#3b82f6';
                        $iconColor = '#3b82f6';
                        $iconBg = '#eff6ff';
                    }
                @endphp
                <div style="display: flex; gap: 16px; align-items: flex-start; padding: 16px; border-radius: 12px; background: #f8fafc; border-left: 4px solid {{ $borderColor }}; border-top: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;
                            {{ !$notification->is_read ? 'box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); background: white;' : '' }}">
                    
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $iconBg }}; display: flex; align-items: center; justify-content: center; color: {{ $iconColor }}; flex-shrink: 0;">
                        @if($notification->type === 'danger' || $notification->type === 'error')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        @elseif($notification->type === 'success')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        @elseif($notification->type === 'warning')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                        @endif
                    </div>
                    
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                            <h4 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0;">
                                {{ $notification->title }}
                            </h4>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p style="font-size: 0.85rem; color: #475569; margin: 0 0 8px; line-height: 1.4;">
                            {{ $notification->message }}
                        </p>
                        @if($notification->link)
                            <a href="{{ $notification->link }}" style="font-size: 0.8rem; font-weight: 700; color: #10b981; text-decoration: none;">Voir les détails →</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        
    </div>
</div>
@endsection
