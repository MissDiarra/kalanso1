<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Espace Enseignant</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total des cours</p>
                <p class="text-2xl font-bold">{{ $totalCours }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cours achetés</p>
                <p class="text-2xl font-bold">{{ $totalAchats }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Revenu total</p>
                <p class="text-2xl font-bold">{{ number_format($revenuTotal, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold">Mes cours</h2>
            <livewire:enseignant-cours-list />
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">📚 Cours récents</h2>

            @forelse ($coursRecents as $cours)
                <div class="border-l-4 border-blue-500 pl-4 mb-4">
                    <a href="{{ route('cours.details', $cours->id) }}" class="text-blue-700 font-semibold hover:underline">
                        {{ $cours->titre }}
                    </a>
                    <p class="text-xs text-gray-500">Ajouté {{ $cours->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucun cours récent pour le moment.</p>
            @endforelse
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold">Créer un nouveau cours</h2>
            <a href="{{ route('enseignant.cours.nouveau') }}" class="text-blue-600 hover:underline">Ajouter un cours</a>
        </div>

        <div class="bg-white shadow rounded p-4 mt-6">
            <h2 class="text-lg font-semibold mb-2">Suggestions pédagogiques</h2>
            <ul class="list-disc list-inside text-sm text-gray-600">
                <li>Ajoutez un quiz à vos cours pour renforcer l’apprentissage</li>
                <li>Utilisez des vidéos courtes pour garder l’attention</li>
                <li>Activez les certificats pour valoriser les apprenants</li>
            </ul>
        </div>

    </div>
</div>

