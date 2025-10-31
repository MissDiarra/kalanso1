<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Modifier le cours</h2>

    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label>Titre</label>
            <input type="text" wire:model="titre" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label>Description</label>
            <textarea wire:model="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
            <label>Niveau</label>
            <select wire:model="niveau" class="w-full border rounded px-3 py-2">
                <option value="débutant">Débutant</option>
                <option value="intermédiaire">Intermédiaire</option>
                <option value="avancé">Avancé</option>
            </select>
        </div>

        <div>
            <label>Catégorie</label>
            <input type="text" wire:model="categorie" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label>Statut</label>
            <select wire:model="statut" class="w-full border rounded px-3 py-2">
                <option value="brouillon">Brouillon</option>
                <option value="publie">Publié</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enregistrer les modifications
        </button>
    </form>
</div>

