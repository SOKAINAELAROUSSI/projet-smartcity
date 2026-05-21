@extends('layouts.technician')

@section('title', 'Support Administration')

@section('content')
<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.75rem; font-weight: 900; color: #0f172a; margin: 0 0 4px; font-family: 'Outfit', sans-serif;">Messagerie administrative</h1>
    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Discutez en direct et de manière sécurisée avec l'administration municipale SmartCity.</p>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 0; display: grid; grid-template-columns: 320px 1fr; height: calc(100vh - 220px); min-height: 500px; overflow: hidden; border-radius: 16px;">
    
    <!-- Sidebar: Admin Channel list -->
    <div style="border-right: 1px solid #e2e8f0; display: flex; flex-direction: column; background: #fafbfe;">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
            <input type="text" placeholder="Rechercher..." disabled style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 0.85rem; background: #f1f5f9; cursor: not-allowed; color: #94a3b8;">
        </div>
        
        <div style="flex: 1; overflow-y: auto;">
            <!-- Single direct channel link -->
            <div style="display: flex; gap: 12px; align-items: center; padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: white; border-left: 4px solid #10b981;">
                <div style="position: relative; flex-shrink: 0;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #0f172a; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                        ADM
                    </div>
                    <!-- Active green dot -->
                    <span style="position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; background: #10b981; border: 2px solid white; border-radius: 50%;"></span>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                        <h4 style="font-size: 0.85rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Administration Municipale
                        </h4>
                    </div>
                    <p style="font-size: 0.75rem; color: #10b981; margin: 0; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                        <span style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                        En ligne
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chat Workspace -->
    <div style="display: flex; flex-direction: column; background: white; justify-content: space-between;">
        
        <!-- Chat Header -->
        <div style="padding: 16px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #fafbfe;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #0f172a; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                    A
                </div>
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0 0 2px;">
                        Administration Municipale
                    </h4>
                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 600;">
                        Support technique & Affectation des incidents
                    </span>
                </div>
            </div>
            
            <span style="font-size: 0.7rem; font-weight: 800; background: #ecfdf5; color: #10b981; padding: 4px 12px; border-radius: 100px; text-transform: uppercase; border: 1px solid #a7f3d0;">
                Canal officiel
            </span>
        </div>
        
        <!-- Messages Area -->
        <div style="flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; background: #f8fafc;" id="messages-container">
            
            <!-- Support System Card at top -->
            <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; max-width: 80%; font-size: 0.8rem; color: #64748b; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <strong style="color: #0f172a;">Support SmartCity</strong><br>
                    Ce canal de communication est strictement réservé pour vos échanges directs avec les administrateurs concernant vos interventions ou requêtes techniques.
                </div>
            </div>

            @if($comments->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 0.85rem; font-style: italic;">
                    Aucun message échangé pour le moment. Rédigez le premier message ci-dessous pour contacter l'administration !
                </div>
            @else
                @foreach($comments as $comment)
                    @php $isMe = $comment->user_id === Auth::id(); @endphp
                    
                    <div style="display: flex; gap: 12px; max-width: 75%; {{ $isMe ? 'align-self: flex-end; flex-direction: row-reverse;' : '' }}">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $isMe ? '#e2e8f0' : '#0f172a' }}; display: flex; align-items: center; justify-content: center; color: {{ $isMe ? '#475569' : 'white' }}; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            {{ substr($comment->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div style="padding: 12px 16px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
                                    {{ $isMe ? 'background: #10b981; color: white; border-bottom-right-radius: 0;' : 'background: white; border: 1px solid #e2e8f0; color: #334155; border-bottom-left-radius: 0;' }}">
                            
                            @if(!$isMe)
                                <div style="font-size: 0.7rem; font-weight: 800; margin-bottom: 4px; color: #64748b;">
                                    {{ $comment->user->name ?? 'Administrateur' }}
                                </div>
                            @endif
                            
                            <p style="font-size: 0.85rem; margin: 0; line-height: 1.4; white-space: pre-line;">{{ $comment->content }}</p>
                            <span style="font-size: 0.65rem; display: block; text-align: right; margin-top: 4px; opacity: 0.8;">
                                {{ $comment->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <!-- Input Area -->
        <div style="padding: 20px 24px; border-top: 1px solid #e2e8f0; background: white;">
            <form action="{{ route('technician.messages.send') }}" method="POST" style="display: flex; gap: 12px; align-items: center;">
                @csrf
                <input type="hidden" name="report_id" value="{{ $supportReport->id }}">
                <input type="text" name="content" placeholder="Saisissez votre message pour l'administration municipale..." required style="flex: 1; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 0.85rem; font-family: 'Inter', sans-serif;">
                <button type="submit" style="padding: 12px 24px; background: #10b981; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#0d9488'" onmouseout="this.style.background='#10b981'">
                    Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
@endsection
