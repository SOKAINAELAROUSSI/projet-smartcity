@extends('layouts.admin')

@section('title', $pageTitle ?? 'Utilisateurs')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">{{ $pageTitle ?? 'Utilisateurs' }}</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">{{ $pageDesc ?? 'Gérez les utilisateurs de la plateforme.' }}</p>
    </div>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0;">
    @if($users->isEmpty())
        <div style="text-align: center; padding: 60px 0;">
            <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="bi bi-people" style="font-size: 2rem; color: #cbd5e1;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Aucun utilisateur trouvé</h4>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Utilisateur</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Email</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Rôle</th>
                        <th style="padding: 14px 12px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Date d'inscription</th>
                        <th style="padding: 14px 12px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 16px 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $user->role === 'technician' ? 'linear-gradient(135deg, #10b981, #3b82f6)' : '#e2e8f0' }}; color: {{ $user->role === 'technician' ? 'white' : '#475569' }}; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td style="padding: 16px 12px; font-size: 0.85rem; color: #64748b;">
                            {{ $user->email }}
                        </td>
                        <td style="padding: 16px 12px;">
                            <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: {{ $user->role === 'technician' ? '#dbeafe' : '#f1f5f9' }}; color: {{ $user->role === 'technician' ? '#1e40af' : '#475569' }};">
                                {{ $user->role === 'technician' ? 'Technicien' : 'Citoyen' }}
                            </span>
                        </td>
                        <td style="padding: 16px 12px; font-size: 0.85rem; color: #64748b;">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 16px 12px; text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
                            @if($user->role === 'technician')
                                <a href="{{ route('admin.messages.initiate', $user->id) }}" style="color: #3b82f6; padding: 6px; border-radius: 8px; transition: background 0.2s; text-decoration: none;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'" title="Discuter avec le technicien">
                                    <i class="bi bi-chat-dots-fill"></i>
                                </a>
                            @endif
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 6px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'" title="Supprimer l'utilisateur">
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
