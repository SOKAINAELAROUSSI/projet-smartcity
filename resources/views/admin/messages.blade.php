@extends('layouts.admin')

@section('title', 'Messages - Support Techniciens')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Messages</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Communiquez en direct avec vos techniciens</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); padding: 0; display: grid; grid-template-columns: 320px 1fr; height: calc(100vh - 220px); min-height: 500px; overflow: hidden; border-radius: 16px; background: white; border: 1px solid #e2e8f0;">
    
    <!-- Sidebar: Technician Channels list -->
    <div style="border-right: 1px solid #e2e8f0; display: flex; flex-direction: column; background: #fafbfe;">
        <div style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; background: white;">
                <i class="bi bi-search" style="color: #94a3b8; font-size: 0.85rem;"></i>
                <input type="text" placeholder="Rechercher un technicien..." style="width: 100%; border: none; outline: none; font-size: 0.85rem; background: transparent;">
            </div>
        </div>
        
        <div style="flex: 1; overflow-y: auto;">
            @if($supportReports->isEmpty())
                <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 0.8rem;">
                    Aucun canal de support actif.
                </div>
            @else
                @foreach($supportReports as $report)
                    @php 
                        $isActive = $activeReport && $activeReport->id === $report->id; 
                        $lastComment = $report->comments->first();
                    @endphp
                    <a href="{{ route('admin.messages', ['chat_id' => $report->id]) }}" style="display: flex; gap: 12px; align-items: center; padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: {{ $isActive ? 'white' : 'transparent' }}; border-left: 4px solid {{ $isActive ? '#10b981' : 'transparent' }}; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='white'" onmouseout="this.style.background='{{ $isActive ? 'white' : 'transparent' }}'">
                        <div style="position: relative; flex-shrink: 0;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                {{ substr($report->user->name ?? 'T', 0, 1) }}
                            </div>
                            <span style="position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; background: #10b981; border: 2px solid white; border-radius: 50%;"></span>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                                <h4 style="font-size: 0.85rem; font-weight: 800; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $report->user->name ?? 'Technicien' }}
                                </h4>
                                @if($lastComment)
                                    <span style="font-size: 0.65rem; color: #94a3b8; font-weight: 600;">{{ $lastComment->created_at->format('d/m') }}</span>
                                @endif
                            </div>
                            <p style="font-size: 0.75rem; color: #64748b; margin: 0; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $lastComment ? Str::limit($lastComment->content, 30) : 'Aucun message' }}
                            </p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    
    <!-- Chat Workspace -->
    <div style="display: flex; flex-direction: column; background: white; justify-content: space-between;">
        
        @if(!$activeReport)
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
                <i class="bi bi-chat-square-text" style="font-size: 3rem; margin-bottom: 16px; color: #cbd5e1;"></i>
                <p>Sélectionnez un technicien pour démarrer la discussion.</p>
            </div>
        @else
            <!-- Chat Header -->
            <div style="padding: 16px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #fafbfe;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                        {{ substr($activeReport->user->name ?? 'T', 0, 1) }}
                    </div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0 0 2px;">
                            {{ $activeReport->user->name ?? 'Technicien' }}
                        </h4>
                        <span style="font-size: 0.75rem; color: #10b981; font-weight: 600;">
                            En ligne
                        </span>
                    </div>
                </div>
                
                <span style="font-size: 0.7rem; font-weight: 800; background: #ecfdf5; color: #10b981; padding: 4px 12px; border-radius: 100px; text-transform: uppercase; border: 1px solid #a7f3d0;">
                    Canal Support
                </span>
            </div>
            
            <!-- Messages Area -->
            <div style="flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; background: #f8fafc;" id="messages-container">
                
                <!-- Support System Card at top -->
                <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; max-width: 80%; font-size: 0.8rem; color: #64748b; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <strong style="color: #0f172a;">Support SmartCity</strong><br>
                        Ce canal de communication est réservé pour le support technique du technicien {{ $activeReport->user->name ?? '' }}.
                    </div>
                </div>

                @if($comments->isEmpty())
                    <div style="text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 0.85rem; font-style: italic;">
                        Aucun message échangé pour le moment.
                    </div>
                @else
                    @foreach($comments as $comment)
                        @php $isAdmin = $comment->user_id === Auth::id(); @endphp
                        
                        <div style="display: flex; gap: 12px; max-width: 75%; {{ $isAdmin ? 'align-self: flex-end; flex-direction: row-reverse;' : '' }}">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $isAdmin ? '#e2e8f0' : 'linear-gradient(135deg, #10b981, #3b82f6)' }}; display: flex; align-items: center; justify-content: center; color: {{ $isAdmin ? '#475569' : 'white' }}; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                {{ substr($comment->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div style="padding: 12px 16px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
                                        {{ $isAdmin ? 'background: #3b82f6; color: white; border-bottom-right-radius: 0;' : 'background: white; border: 1px solid #e2e8f0; color: #334155; border-bottom-left-radius: 0;' }}">
                                
                                @if(!$isAdmin)
                                    <div style="font-size: 0.7rem; font-weight: 800; margin-bottom: 4px; color: #64748b;">
                                        {{ $comment->user->name ?? 'Technicien' }}
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
                <form action="{{ route('admin.messages.send') }}" method="POST" style="display: flex; gap: 12px; align-items: center;">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $activeReport->id }}">
                    <input type="text" name="content" placeholder="Saisissez votre message..." required style="flex: 1; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 0.85rem; font-family: 'Inter', sans-serif;">
                    <button type="submit" style="padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                        Envoyer
                    </button>
                </form>
            </div>
        @endif
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
