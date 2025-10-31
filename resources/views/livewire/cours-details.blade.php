<div class="p-6 space-y-6">
    {{-- Bloc principal du cours --}}
    <div>
        <a href="{{ route('enseignant.cours') }}" class="text-sm text-blue-600 hover:underline">
            ← Retour à mes cours
        </a>

        <h2 class="text-2xl font-bold mb-4">{{ $cours->titre }}</h2>

        <p class="text-gray-700 mb-2">{{ $cours->description }}</p>

        <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-2">
            <span>Catégorie : {{ $cours->categorie }}</span>
            <span>Niveau : {{ ucfirst($cours->niveau) }}</span>
            <span>Accès : {{ $cours->payant ? 'Payant' : 'Gratuit' }}</span>
            <span>Statut : {{ ucfirst($cours->statut) }}</span>
        </div>

        @if ($cours->certificat_disponible)
            <p class="text-yellow-600 text-sm mb-2">🎓 Certificat disponible</p>
        @endif

        <p class="text-xs text-gray-500 mb-1">
            Type de contenu : {{ ucfirst($cours->type) }}
        </p>

        @if ($cours->type === 'video')
            <video controls class="w-full max-w-2xl mb-4">
                <source src="{{ Storage::url($cours->media_path) }}" type="video/mp4">
            </video>
        @elseif ($cours->type === 'image')
            <img src="{{ Storage::url($cours->media_path) }}" class="w-full max-w-2xl mb-4 rounded">
        @endif

        <h3 class="text-lg font-semibold mt-4">Modules</h3>
        @foreach ($cours->modules as $m)
            <div class="mb-2">
                <p class="font-medium">{{ $m->titre }}</p>
                <ul class="list-disc list-inside text-sm text-gray-600 ml-4">
                    @foreach ($m->chapitres as $ch)
                        <li>{{ $ch->titre }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        @if ($cours->payant)
            @if ($dejaAchete)
                <p class="text-green-600 font-semibold">✅ Vous avez déjà acheté ce cours.</p>
            @else
                <button wire:click="acheter" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Acheter ce cours ({{ number_format($cours->prix, 0, ',', ' ') }} FCFA)
                </button>
            @endif
        @else
            <p class="text-green-600 font-semibold">✅ Ce cours est gratuit.</p>
        @endif

        @if (session()->has('success'))
            <div class="text-green-500 mt-2">{{ session('success') }}</div>
        @endif
    </div>

    {{-- Bloc commentaire --}}
    <div>
        <h3 class="text-lg font-semibold mb-2">Laisser un commentaire</h3>

        <form wire:submit.prevent="ajouterCommentaire" class="space-y-2">
            <textarea wire:model.defer="nouveauCommentaire" rows="3" class="w-full border rounded px-3 py-2" placeholder="Votre avis..."></textarea>
            @error('nouveauCommentaire') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <button type="submit" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                <span wire:loading.remove>Publier</span>
                <span wire:loading>Publication...</span>
            </button>
        </form>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-2">Commentaires</h3>

        @forelse ($cours->commentaires as $commentaire)
            <div class="border-b py-2">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($commentaire->user->name, 0, 1)) }}
                    </div>
                    <p class="text-sm text-gray-800">
                        <strong>{{ $commentaire->user->name }}</strong> :
                        {{ $commentaire->contenu }}
                    </p>
                </div>
                <p class="text-xs text-gray-500 ml-8">{{ $commentaire->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Aucun commentaire pour le moment.</p>
        @endforelse
    </div>
</div>
