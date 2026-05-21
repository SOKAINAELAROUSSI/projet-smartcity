@extends('layouts.admin')

@section('title', 'Messages Citoyens')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Messages Citoyens</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Consultez les messages envoyés depuis le formulaire de contact public.</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
    @if($messages->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-envelope-open" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucun message</h4>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Aucun citoyen n'a envoyé de message pour le moment.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($messages as $message)
                <div style="display: flex; gap: 16px; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: all 0.2s;">
                    
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-envelope-fill" style="font-size: 1.25rem; color: #3b82f6;"></i>
                    </div>
                    
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
                                    {{ $message->subject }}
                                </h4>
                                <div style="display: flex; gap: 12px; align-items: center; font-size: 0.8rem; color: #64748b;">
                                    <span style="font-weight: 600; color: #475569;">{{ $message->name }}</span>
                                    <span>&bull;</span>
                                    <a href="mailto:{{ $message->email }}" style="color: #3b82f6; text-decoration: none;">{{ $message->email }}</a>
                                </div>
                            </div>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: #475569; margin: 12px 0 16px; line-height: 1.6; white-space: pre-line; background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px solid #f1f5f9;">{{ $message->message }}</p>
                        
                        <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                            <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}&body={{ rawurlencode("Bonjour " . $message->name . ",\n\nConcernant votre message : \"" . $message->message . "\"\n\nCordialement,\nL'administration SmartCity Connect") }}" style="text-decoration: none; font-size: 0.75rem; font-weight: 700; color: #3b82f6; padding: 6px 12px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'">
                                <i class="bi bi-reply-fill"></i> Répondre par email
                            </a>

                            <form action="{{ route('admin.contacts.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; font-size: 0.75rem; font-weight: 700; color: #ef4444; cursor: pointer; padding: 6px 12px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                    <i class="bi bi-trash"></i> Supprimer le message
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
