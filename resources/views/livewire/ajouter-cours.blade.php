<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Créer un nouveau cours</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    
    <form wire:submit.prevent="submit" class="space-y-4">
        <!--pour le titre du cours-->
        <div>
            <label>Titre</label>
            <input type="text" wire:model="titre" class="w-full border rounded px-3 py-2">
            @error('titre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour la description du cours-->
        <div>
            <label>Description</label>
            <textarea wire:model="description" class="w-full border rounded px-3 py-2"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour le type de cours-->
        <div>
            <label>Type</label>
            <select wire:model="type" class="w-full border rounded px-3 py-2">
                <option value="video">Vidéo</option>
                <option value="image">Image</option>
            </select>
        </div>

        <!--pour les fichiers média-->
        <div>
            <label>Fichier média</label>
            <input type="file" wire:model="media" class="w-full">
            @error('media') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour le catégorie de cours-->
        <div class="mb-4">
            <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select wire:model="categorie" id="categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Choisir une catégorie --</option>
                <option value="Développement web">Développement web</option>
                <option value="Design">Design</option>
                <option value="Math">Math</option>
                <option value="Anglais">Anglais</option>
                <option value="Français">Français</option>
                <option value="Physique-Chimie">Physique-Chimie</option>
                <option value="Géométrie">Géométrie</option>
                <option value="Algorithme">Algorithme</option>
                <option value="Gestion des ressources humaines">Gestion des ressources humaines</option>
                <option value="Finances">Finances</option>
                <option value="Comptabilité">Comptabilité</option>
                <option value="Montage vidéo">Montage vidéo</option>
                <option value="Développement mobile">Développement mobile</option>
                <option value="Programmation">Programmation</option>
                <option value="Robotique">Robotique</option>
                <option value="Multimédia">Multimédia</option>
                <option value="Communication d'entreprise">Communication d'entreprise</option>
                <option value="Marketing">Marketing</option>
                <option value="Assurance">Assurance</option>
                <option value="Management">Management</option>
            </select>
            @error('categorie') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--niveau genre deb, avancee ou intermed-->
        <div>
            <label>Niveau</label>
            <select wire:model="niveau" class="w-full border rounded px-3 py-2">
                <option value="débutant">Débutant</option>
                <option value="intermédiaire">Intermédiaire</option>
                <option value="avancé">Avancé</option>
            </select>
        </div>

        <!--acces gratuit ou payant-->
        <div>
            <label>Accès</label>
            <select wire:model="payant" class="w-full border rounded px-3 py-2">
                <option value="0">Gratuit</option>
                <option value="1">Payant</option>
            </select>
            @error('payant') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <hr class="my-4">

        <h3 class="text-lg font-semibold">Modules</h3>
        @foreach ($modules as $i => $module)
            <div class="border p-4 rounded mb-4">
                <label>Titre du module</label>
                <input type="text" wire:model="modules.{{ $i }}.titre" class="w-full border rounded px-3 py-2">

                <h4 class="text-sm font-semibold mt-2">Chapitres</h4>
                @foreach ($module['chapitres'] as $j => $chapitre)
                    <input type="text" wire:model="modules.{{ $i }}.chapitres.{{ $j }}.titre" class="w-full border rounded px-3 py-2 mb-2">
                @endforeach

                <button type="button" wire:click="addChapitre({{ $i }})" class="text-blue-600 text-sm mt-2">+ Ajouter un chapitre</button>
            </div>
        @endforeach

        <!--pour le statut soit c'est publié soit c'est en brouillon-->
        <div>
            <label>Statut</label>
            <select wire:model="statut" class="w-full border rounded px-3 py-2">
                <option value="brouillon">Brouillon</option>
                <option value="publie">Publié</option>
            </select>
        </div>

        <!--barre de chargement pendant l'upload-->
        <div wire:loading wire:target="media" class="text-blue-600 text-sm">
            Chargement du fichier en cours...
        </div>

        <!--disponibilité du certificat-->
        @if ($niveau === 'avancé')
            <div>
                <label>Certificat disponible ?</label>
                <select wire:model="certificat_disponible" class="w-full border rounded px-3 py-2">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
                @error('certificat_disponible') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <button type="button" wire:click="addModule" class="text-blue-600 text-sm">+ Ajouter un module</button>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">
            Enregistrer
        </button>
    </form>
</div>
