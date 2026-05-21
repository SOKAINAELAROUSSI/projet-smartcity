@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Services & Catégories Urbains</h2>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Gérez les types de signalements disponibles pour les citoyens.</p>
    </div>
    <button onclick="document.getElementById('add-modal').style.display='flex'" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
        <i class="bi bi-plus-lg"></i> Nouveau Service
    </button>
</div>

@if(session('success'))
    <div style="padding: 12px 20px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; font-weight: 700;">
        {{ session('success') }}
    </div>
@endif

<div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @foreach($categories as $category)
            <div style="border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; display: flex; flex-direction: column; background: #f8fafc; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div style="width: 52px; height: 52px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #dbeafe;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 1.5rem;">{{ $category->icon ?? '🏙️' }}</span>
                        @endif
                    </div>
                    <div style="display: flex; gap: 4px;">
                        <button onclick='editCategory(@json($category))' style="background: none; border: none; color: #3b82f6; cursor: pointer; padding: 6px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'" title="Modifier">
                            <i class="bi bi-pencil-fill" style="font-size: 0.95rem;"></i>
                        </button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Supprimer ce service ?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 6px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'" title="Supprimer">
                                <i class="bi bi-trash-fill" style="font-size: 0.95rem;"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0 0 8px;">{{ $category->name }}</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin: 0; flex: 1;">{{ $category->description ?? 'Aucune description.' }}</p>
            </div>
        @endforeach
    </div>
</div>

<!-- Add Modal -->
<div id="add-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index:2000; align-items:center; justify-content:center;">
    <div style="width: 500px; padding: 32px; background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 24px;">Ajouter un Service</h2>
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Nom du service</label>
                <input type="text" name="name" required style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; outline: none; background: #f8fafc; font-size: 0.9rem;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; outline: none; background: #f8fafc; font-size: 0.9rem; resize: vertical;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Image (Icône 3D)</label>
                <input type="file" name="image" style="width:100%; font-size: 0.85rem; color: #64748b;">
            </div>
            <div style="display:flex; gap:12px; margin-top:32px;">
                <button type="button" onclick="document.getElementById('add-modal').style.display='none'" style="flex:1; padding:12px; border-radius:10px; border:1px solid #e2e8f0; background:none; cursor:pointer; font-weight: 700; font-size: 0.9rem; color: #475569;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Annuler</button>
                <button type="submit" style="flex:1; padding:12px; border-radius:10px; border: none; background:#3b82f6; color: white; cursor:pointer; font-weight: 700; font-size: 0.9rem;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index:2000; align-items:center; justify-content:center;">
    <div style="width: 500px; padding: 32px; background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 24px;">Modifier le Service</h2>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Nom du service</label>
                <input type="text" name="name" id="edit-name" required style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; outline: none; background: #f8fafc; font-size: 0.9rem;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Description</label>
                <textarea name="description" id="edit-description" rows="3" style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; outline: none; background: #f8fafc; font-size: 0.9rem; resize: vertical;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:700; font-size: 0.85rem; color: #475569;">Remplacer l'image</label>
                <input type="file" name="image" style="width:100%; font-size: 0.85rem; color: #64748b;">
            </div>
            <div style="display:flex; gap:12px; margin-top:32px;">
                <button type="button" onclick="document.getElementById('edit-modal').style.display='none'" style="flex:1; padding:12px; border-radius:10px; border:1px solid #e2e8f0; background:none; cursor:pointer; font-weight: 700; font-size: 0.9rem; color: #475569;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Annuler</button>
                <button type="submit" style="flex:1; padding:12px; border-radius:10px; border: none; background:#3b82f6; color: white; cursor:pointer; font-weight: 700; font-size: 0.9rem;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCategory(category) {
        document.getElementById('edit-name').value = category.name;
        document.getElementById('edit-description').value = category.description || '';
        document.getElementById('edit-form').action = '/categories/' + category.id;
        document.getElementById('edit-modal').style.display = 'flex';
    }
</script>
@endsection
