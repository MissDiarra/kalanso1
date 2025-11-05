<div>
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
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ $c->image_url }}" alt="{{ $c->titre }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">{{ $c->categorie }}</span>
                    <h3 class="mt-2 text-lg font-bold">{{ $c->titre }}</h3>
                    <p class="text-sm text-gray-600">{{ $c->description }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ $c->duree }}</span>
                        <span class="text-yellow-500 font-semibold">{{ $c->note }} ★</span>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <a href="{{ route('etudiant.cours.details', $c->id) }}" class="text-indigo-600 hover:underline">Continuer</a>
                        <button class="text-sm text-red-600 hover:underline">Recommencer</button>
                    </div>
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