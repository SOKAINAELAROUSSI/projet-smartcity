@extends('layouts.app')

@section('title', 'Gestion des Services Urbains')

@section('content')
<div style="padding: 40px 60px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
        <div>
            <h1 style="font-size: 3rem; color: var(--text-main);">Services Urbains Intelligents</h1>
            <p style="color: var(--text-muted);">Gérez les services affichés sur la page d'accueil et les catégories de signalements.</p>
        </div>
        <button onclick="document.getElementById('add-modal').style.display='flex'" class="btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nouveau Service
        </button>
    </div>

    <div class="smart-grid">
        @foreach($categories as $category)
            <div class="glass-card" style="padding: 32px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
                    <div style="width: 64px; height: 64px; background: var(--primary-100); border-radius: 18px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 1.5rem;">{{ $category->icon ?? '🏙️' }}</span>
                        @endif
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="editCategory({{ $category }})" style="background: var(--slate-100); border: none; padding: 8px; border-radius: 8px; cursor: pointer;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--slate-600)" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Supprimer ce service ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fee2e2; border: none; padding: 8px; border-radius: 8px; cursor: pointer;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 style="margin-bottom: 8px;">{{ $category->name }}</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.5;">{{ $category->description ?? 'Aucune description.' }}</p>
            </div>
        @endforeach
    </div>
</div>

<!-- Add Modal -->
<div id="add-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
    <div class="glass-card" style="width: 500px; padding: 40px; background: white;">
        <h2 style="margin-bottom: 24px;">Ajouter un Service</h2>
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Nom</label>
                <input type="text" name="name" required style="width:100%; padding:12px; border-radius:10px; border:1px solid var(--slate-200);">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:12px; border-radius:10px; border:1px solid var(--slate-200);"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Image (Icône 3D)</label>
                <input type="file" name="image" style="width:100%;">
            </div>
            <div style="display:flex; gap:12px; margin-top:32px;">
                <button type="button" onclick="document.getElementById('add-modal').style.display='none'" style="flex:1; padding:12px; border-radius:10px; border:1px solid var(--slate-200); background:none; cursor:pointer;">Annuler</button>
                <button type="submit" class="btn-primary" style="flex:1; justify-content:center;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCategory(category) {
        // Simple alert for demo, ideally another modal
        alert("Modification de " + category.name + " (Logique de modal d'édition à venir)");
    }
</script>
@endsection
