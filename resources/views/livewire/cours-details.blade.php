<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">{{ $cours->titre }}</h2>

    <p class="text-gray-700 mb-2">{{ $cours->description }}</p>

    <p class="text-sm text-gray-500 mb-2">
        Catégorie : {{ $cours->categorie }} |
        Niveau : {{ ucfirst($cours->niveau) }} |
        Accès : {{ $cours->payant ? 'Payant' : 'Gratuit' }} |
        Statut : {{ ucfirst($cours->statut) }}
    </p>

    @if ($cours->certificat_disponible)
        <p class="text-yellow-600 text-sm mb-2">🎓 Certificat disponible</p>
    @endif

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
</div>

