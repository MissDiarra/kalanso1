<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Espace Enseignant</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold">Mes cours</h2>
            <livewire:enseignant-cours-list />
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold">Créer un nouveau cours</h2>
            <a href="{{ route('enseignant.cours.nouveau') }}" class="text-blue-600 hover:underline">Ajouter un cours</a>
        </div>
    </div>
</div>

