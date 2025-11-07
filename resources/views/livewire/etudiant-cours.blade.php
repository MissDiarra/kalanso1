<div class="px-6 py-8">
    <!-- Header immersif -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-10 px-6 rounded-lg shadow-md mb-8">
        <h1 class="text-3xl font-bold">Éducation, talents et opportunités de carrière</h1>
        <p class="mt-2 text-lg">Développez vos compétences avec des cours en ligne flexibles en marketing, programmation, design et plus encore.</p>
    </div>

    <!-- Barre de recherche -->
    <div class="mb-6">
        <input type="text" placeholder="🔍 Trouver votre cours" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <!-- Filtres -->
    <div class="mb-4 flex flex-wrap gap-4">
        <select wire:model="filtreCategorie" class="border rounded px-3 py-2">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        <select wire:model="filtreNiveau" class="border rounded px-3 py-2">
            <option value="">Tous les niveaux</option>
            <option value="débutant">Débutant</option>
            <option value="intermédiaire">Intermédiaire</option>
            <option value="avancé">Avancé</option>
        </select>

        <select wire:model="filtrePayant" class="border rounded px-3 py-2">
            <option value="">Tous</option>
            <option value="0">Gratuit</option>
            <option value="1">Payant</option>
        </select>
    </div>

    <!-- 3. résumé des cours achetés -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Mes cours</h2>
        <p class="text-sm text-gray-500">Vous avez acheté {{ $cours->count() }} cours au total</p>
    </div>

    <!-- 4. Cartes des cours -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($cours as $c)
            <div class="group relative p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                

                {{-- Badge Top cours --}}
                @if ($c->note >= 4.5)
                    <span class="absolute top-2 right-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded-full shadow">🔥 Top cours</span>
                @endif

                {{-- Badge Nouveau 
                @if ($c->created_at >= now()->subDays(7))
                    <span class="absolute top-4 left-4 bg-blue-500 text-white text-xs font-bold px-3 py-2 rounded-full shadow">🆕</span>
                @endif --}}

                {{-- Image du cours toujours visible --}}
                @if ($c->image_path)
                    <img src="{{ asset('storage/' . $c->image_path) }}" alt="Image du cours {{ $c->titre }}"
                        class="w-full h-40 object-cover rounded mb-4">
                @endif

                {{-- Vidéo visible uniquement si progression > 0 --}}
                @if ($c->progression > 0 && $c->media_path)
                    <video controls class="w-full h-40 rounded mb-4 transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                        <source src="{{ asset('storage/' . $c->media_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                @endif

                {{-- Catégorie + Étoiles --}}
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold px-2 py-1 rounded 
                        @if($c->categorie === 'Marketing') bg-yellow-100 text-yellow-800
                        @elseif($c->categorie === 'Design') bg-pink-100 text-pink-800
                        @elseif($c->categorie === 'Développement') bg-blue-100 text-blue-800
                        @else bg-indigo-100 text-indigo-800
                        @endif">
                        {{ $c->categorie }}
                    </span>

                    <span class="text-yellow-500 font-semibold">
                        {{ number_format($c->note, 1) }} ★
                    </span>
                </div>

                <h3 class="text-lg font-bold">{{ $c->titre }}</h3>
                <p class="text-sm text-gray-600">{{ $c->description }}</p>

                <div class="mt-3 text-sm text-gray-500">
                    ⏱️ Durée : {{ $c->duree }}
                </div>

                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $c->progression }}%;"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Progression : {{ $c->progression }}%</p>

                    @if ($c->progression == 100)
                        <span class="inline-block mt-2 text-xs text-green-600 font-semibold bg-green-100 px-2 py-1 rounded">✅ Complété</span>
                    @endif
                </div>

                <div class="mt-4 flex justify-between">
                    @if ($c->progression == 0)
                        <a href="{{ route('etudiant.cours.commencer', $c->id) }}" class="text-indigo-600 hover:underline">Commencer</a>
                    @else
                        <a href="{{ route('etudiant.cours.recommencer', $c->id) }}" class="text-red-600 hover:underline">Recommencer</a>
                        <a href="{{ route('etudiant.cours.details', $c->id) }}" class="text-indigo-600 hover:underline">Continuer</a>
                    @endif
                </div>
                
            </div>
        @endforeach
    </div>

    <!-- 5. Pagination -->
    <div class="mt-8">
        {{ $cours->links('pagination::tailwind') }}
    </div>

    @if ($cours->isEmpty())
        <div class="text-center text-gray-500 py-10">
            Aucun cours disponible pour le moment. Revenez bientôt !
        </div>
    @endif

    

</div>