@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Centre de notifications</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Restez informé des activités importantes de la plateforme.</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
    @if($notifications->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-bell-slash" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucune notification</h4>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Vous êtes à jour sur l'ensemble de vos alertes.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($notifications as $notification)
                @php
                    $icon = 'bi-info-circle';
                    $color = '#3b82f6';
                    $bg = '#eff6ff';
                    
                    if ($notification->type === 'success') {
                        $icon = 'bi-check-circle';
                        $color = '#10b981';
                        $bg = '#ecfdf5';
                    } elseif ($notification->type === 'warning') {
                        $icon = 'bi-exclamation-triangle';
                        $color = '#f59e0b';
                        $bg = '#fffbeb';
                    } elseif ($notification->type === 'danger') {
                        $icon = 'bi-x-circle';
                        $color = '#ef4444';
                        $bg = '#fef2f2';
                    }
                @endphp
                
                <div style="display: flex; gap: 16px; padding: 20px; border-radius: 12px; border: 1px solid {{ $notification->is_read ? '#f1f5f9' : '#e2e8f0' }}; background: {{ $notification->is_read ? '#f8fafc' : 'white' }}; box-shadow: {{ $notification->is_read ? 'none' : '0 4px 6px -1px rgba(0, 0, 0, 0.05)' }}; transition: all 0.2s;">
                    
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: {{ $bg }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi {{ $icon }}" style="font-size: 1.25rem; color: {{ $color }};"></i>
                    </div>
                    
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <h4 style="font-size: 0.95rem; font-weight: 800; color: {{ $notification->is_read ? '#475569' : '#0f172a' }}; margin: 0;">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span style="display: inline-block; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; margin-left: 8px; vertical-align: middle;"></span>
                                @endif
                            </h4>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 12px; line-height: 1.5;">{{ $notification->message }}</p>
                        
                        <div style="display: flex; gap: 12px; align-items: center;">
                            @if($notification->link)
                                <a href="{{ $notification->link }}" style="font-size: 0.75rem; font-weight: 700; color: #3b82f6; text-decoration: none; padding: 6px 12px; background: #eff6ff; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                                    Voir les détails <i class="bi bi-arrow-right"></i>
                                </a>
                            @endif
                            
                            @if(!$notification->is_read)
                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; font-size: 0.75rem; font-weight: 700; color: #10b981; cursor: pointer; padding: 6px 12px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#ecfdf5'" onmouseout="this.style.background='transparent'">
                                        <i class="bi bi-check2-all"></i> Marquer comme lu
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" style="display: inline; margin-left: auto;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; font-size: 0.75rem; font-weight: 700; color: #ef4444; cursor: pointer; padding: 6px 12px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
