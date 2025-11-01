<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Mes cours enregistrés</h2>

    <!-- formulaire de filtre -->
    <div class="mb-6 flex flex-wrap gap-4">
        <select wire:model="filtreCategorie" class="border rounded px-3 py-2">
            <option value="">Toutes les catégories</option>
            <option value="Design">Design</option>
            <option value="Programmation">Programmation</option>
            <option value="Mathematique">Mathematique</option>
            <option value="Multimedia">Multimédia</option>
            
        </select>

        <select wire:model="filtreNiveau" class="border rounded px-3 py-2">
            <option value="">Tous les niveaux</option>
            <option value="débutant">Débutant</option>
            <option value="intermédiaire">Intermédiaire</option>
            <option value="avancé">Avancé</option>
        </select>

        <select wire:model="filtreStatut" class="border rounded px-3 py-2">
            <option value="">Tous les statuts</option>
            <option value="brouillon">Brouillon</option>
            <option value="publie">Publié</option>
        </select>
    </div>

    <!-- les vues 
    <div class="mb-4">
        <button wire:click="$toggle('vueGrille')" class="text-sm text-blue-600">
            {{ $vueGrille ? 'Vue liste' : 'Vue grille' }}
        </button>
    </div>
    -->

    <div class="{{ $vueGrille ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-6' }}">
        @forelse ($cours as $c)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col gap-4 min-h-[400px] transition duration-300 ease-in-out hover:bg-gray-50">
                {{-- Image du cours --}}
                @if ($c->type === 'video')
                    <video controls class="rounded-lg w-full h-40 object-cover">
                        <source src="{{ Storage::url($c->media_path) }}" type="video/mp4">
                    </video>
                @elseif ($c->type === 'image')
                    <img src="{{ Storage::url($c->media_path) }}" alt="Image du cours" class="rounded-lg w-full h-40 object-cover">
                @endif

                {{-- Titre + Niveau --}}
                <div class="flex justify-between items-center mt-2">
                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $c->titre }}</h3>
                    <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                        {{ ucfirst($c->niveau) }}
                    </span>
                </div>

                {{-- Description --}}
                <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($c->description, 100) }}</p>

                {{-- Accès + Certificat + Statut --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="text-xs px-2 py-1 rounded-full {{ $c->payant ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                        {{ $c->payant ? 'Payant' : 'Gratuit' }}
                    </span>

                    @if ($c->certificat_disponible)
                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                            🎓 Certificat disponible
                        </span>
                    @endif

                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                        Statut : {{ ucfirst($c->statut) }}
                    </span>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('cours.edit', $c->id) }}"
                        style="background-color: #f59e0b !important; color: white !important;"
                        class="inline-block px-4 py-2 text-sm font-medium rounded shadow hover:bg-yellow-600">
                            Modifier
                    </a>

                    <button wire:click="demanderSuppression({{ $c->id }})"
                        style="background-color: #ef4444 !important; color: white !important;"
                        class="inline-block px-4 py-2 text-sm font-medium rounded shadow hover:bg-red-600">
                        Supprimer
                    </button>

                    <a href="{{ route('cours.details', $c->id) }}"
                        style="background-color: #3b82f6 !important; color: white !important;"
                        class="inline-block px-4 py-2 text-sm font-medium rounded shadow hover:bg-blue-600">
                            Voir détail
                    </a>

                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Aucun cours enregistré pour le moment.</p>
        @endforelse
    </div>


    @if ($confirmationVisible)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Confirmer la suppression</h2>
                <p class="text-sm text-gray-700 mb-4">Êtes-vous sûr de vouloir supprimer ce cours ? Cette action est irréversible.</p>

                <div class="flex justify-end gap-4">
                    <button wire:click="$set('confirmationVisible', false)" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Annuler
                    </button>
                    <button wire:click="confirmerSuppression" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

