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

    <!-- les vues -->
    <div class="mb-4">
        <button wire:click="$toggle('vueGrille')" class="text-sm text-blue-600">
            {{ $vueGrille ? 'Vue liste' : 'Vue grille' }}
        </button>
    </div>

    <div class="{{ $vueGrille ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}">
        @forelse ($cours as $c)
            <div class="border p-4 mb-4 rounded shadow">
                <h3 class="text-lg font-semibold truncate">{{ $c->titre }}</h3>

                <!-- Badge accès -->
                <div class="flex flex-wrap gap-2 mb-2"> 
                    <span class="inline-block px-2 py-1 text-xs rounded 
                        {{ $c->payant ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                        {{ $c->payant ? 'Payant' : 'Gratuit' }}
                    </span>
                </div>

                <!-- Niveau -->
                <span class="inline-block px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 ml-2">
                    Niveau : {{ ucfirst($c->niveau) }}
                </span>

                <!-- Certificat -->
                @if ($c->certificat_disponible)
                    <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700 ml-2">
                        🎓 Certificat disponible
                    </span>
                @endif

                <!-- Description -->
                <p class="text-sm text-gray-600">{{ $c->description }}</p>

                <!-- Modules et chapitres -->
                @php
                    $modules = $c->modules;
                @endphp

                @if ($modules->count())
                    <div class="mt-2">
                        <h4 class="text-sm font-semibold">Modules</h4>
                        <ul class="list-disc list-inside text-sm text-gray-700">
                            @foreach ($modules as $m)
                                <li>
                                    {{ $m->titre }}
                                    @if ($m->chapitres->count())
                                        <ul class="list-disc list-inside ml-4 text-xs text-gray-600">
                                            @foreach ($m->chapitres as $ch)
                                                <li>{{ $ch->titre }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- statut -->
                <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-600 ml-2">
                    Statut : {{ ucfirst($c->statut) }}
                </span>

                <!-- Média -->
                @if ($c->type === 'video')
                    <video controls class="mt-2 w-full max-w-md">
                        <source src="{{ Storage::url($c->media_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                @elseif ($c->type === 'image')
                    <img src="{{ Storage::url($c->media_path) }}" alt="Image du cours" class="mt-2 w-full max-w-md rounded">
                @endif

                <!-- pour le bouton voir plus -->
                <button class="text-gray-500 hover:text-gray-700" title="Options">
                    ⋮
                </button>
                <!-- redirection vers la page modif -->
                <a href="{{ route('cours.details', $c->id) }}" class="text-sm text-blue-600 hover:underline">
                    Voir les détails
                </a>

                <a href="{{ route('cours.edit', $c->id) }}" class="text-sm text-yellow-600 hover:underline mr-2">
                    Modifier
                </a>
                <a href="#" wire:click="supprimer({{ $c->id }})" class="text-sm text-red-600 hover:underline">
                    Supprimer
                </a>

            </div>
        @empty
            <p>Aucun cours enregistré pour le moment.</p>
        @endforelse
    </div>
</div>

