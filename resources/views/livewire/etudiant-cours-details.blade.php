<a href="{{ route('etudiant.cours.index') }}" class="text-sm text-indigo-600 hover:underline mb-4 inline-block">← Retour à mes cours</a>

<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-2 text-indigo-700">{{ $cours->titre }}</h2>
    <p class="text-gray-600 mb-4">{{ $cours->description }}</p>

    <div class="flex items-center gap-4 mb-6">
        <span class="text-sm bg-indigo-100 text-indigo-800 px-3 py-1 rounded">{{ $cours->categorie }}</span>
        <span class="text-sm text-gray-500">Durée : {{ $cours->duree }}</span>
        <span class="text-sm text-yellow-500 font-semibold">{{ $cours->note }} ★</span>
    </div>

    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $cours->progression }}%;"></div>
    </div>

    <h3 class="text-lg font-semibold text-blue-700 mb-2">Modules</h3>
    @foreach ($cours->modules as $module)
        <div class="border p-4 rounded mb-4 bg-gray-50">
            <h4 class="font-semibold text-indigo-600">{{ $module->titre }}</h4>
            <ul class="list-disc ml-6 mt-2 text-sm text-gray-700">
                @foreach ($module->chapitres as $chapitre)
                    <li>{{ $chapitre->titre }} <span class="text-xs text-gray-500">({{ $chapitre->type }})</span></li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
