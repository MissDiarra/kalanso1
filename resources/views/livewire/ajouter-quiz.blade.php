<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Créer un quiz pour ce module</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <x-input label="Titre du quiz" wire:model="titre" />

        @foreach ($questions as $i => $q)
            <div class="border p-4 rounded">
                <x-input label="Question" wire:model="questions.{{ $i }}.intitule" />

                @for ($j = 0; $j < 4; $j++)
                    <x-input label="Réponse {{ $j + 1 }}" wire:model="questions.{{ $i }}.reponses.{{ $j }}" />
                @endfor

                <label>Bonne réponse</label>
                <select wire:model="questions.{{ $i }}.bonne_reponse" class="w-full border rounded px-3 py-2">
                    <option value="0">Réponse 1</option>
                    <option value="1">Réponse 2</option>
                    <option value="2">Réponse 3</option>
                    <option value="3">Réponse 4</option>
                </select>
            </div>
        @endforeach

        <button type="button" wire:click="addQuestion" class="text-blue-600 text-sm">+ Ajouter une question</button>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">
            Enregistrer le quiz
        </button>
    </form>
</div>
