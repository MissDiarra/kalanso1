<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Créer un nouveau cours</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
    @endif

    @if (session()->has('error'))
            <div class="mb-4 text-red-600 font-semibold">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6 min-h-screen">
        <!-- Informations générales -->

         <hr class="my-6">
         <h3 class="text-lg font-semibold text-gray-800">Informations générales</h3>

        <!--pour le titre du cours-->
        <div>
            <label>Titre</label>
            <input type="text" wire:model="titre" class="w-full border rounded px-3 py-2">
            @error('titre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour la description du cours-->
        <div>
            <label>Description</label>
            <textarea wire:model="description" class="w-full border rounded px-3 py-2"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour le type de cours-->
        <div>
            <label>Type</label>
            <select wire:model="type" class="w-full border rounded px-3 py-2">
                <option value="video">Vidéo</option>
                <option value="image">Image</option>
            </select>
        </div>

        <!--pour les fichiers média-->
        <div>
            <label>Fichier média principal</label>
            <input type="file" wire:model="media" class="w-full">
            @error('media') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--pour le catégorie de cours-->
        <div class="mb-4">
            <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select wire:model="categorie" id="categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Choisir une catégorie --</option>
                <option value="Développement web">Développement web</option>
                <option value="Design">Design</option>
                <option value="Math">Math</option>
                <option value="Anglais">Anglais</option>
                <option value="Français">Français</option>
                <option value="Physique-Chimie">Physique-Chimie</option>
                <option value="Géométrie">Géométrie</option>
                <option value="Algorithme">Algorithme</option>
                <option value="Gestion des ressources humaines">Gestion des ressources humaines</option>
                <option value="Finances">Finances</option>
                <option value="Comptabilité">Comptabilité</option>
                <option value="Montage vidéo">Montage vidéo</option>
                <option value="Développement mobile">Développement mobile</option>
                <option value="Programmation">Programmation</option>
                <option value="Robotique">Robotique</option>
                <option value="Multimédia">Multimédia</option>
                <option value="Communication d'entreprise">Communication d'entreprise</option>
                <option value="Marketing">Marketing</option>
                <option value="Assurance">Assurance</option>
                <option value="Management">Management</option>
            </select>
            @error('categorie') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--niveau genre deb, avancee ou intermed-->
        <div>
            <label>Niveau</label>
            <select wire:model="niveau" class="w-full border rounded px-3 py-2">
                <option value="débutant">Débutant</option>
                <option value="intermédiaire">Intermédiaire</option>
                <option value="avancé">Avancé</option>
            </select>
        </div>

        <!--acces gratuit ou payant-->
        <div>
            <label>Accès</label>
            <select wire:model="payant" class="w-full border rounded px-3 py-2">
                <option value="0">Gratuit</option>
                <option value="1">Payant</option>
            </select>
            @error('payant') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!--disponibilité du certificat-->
        @if ($niveau === 'avancé')
            <div>
                <label>Certificat disponible ?</label>
                <select wire:model="certificat_disponible" class="w-full border rounded px-3 py-2">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
                @error('certificat_disponible') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!--Module et chapitres-->
        <hr class="my-6">
        <h3 class="text-lg font-semibold text-blue-700">Modules et chapitres</h3>
        @foreach ($modules as $i => $module)
            <div class="border p-4 rounded mb-4">
                <label>Titre du module</label>
                <input type="text" wire:model="modules.{{ $i }}.titre" class="w-full border rounded px-3 py-2">

                <h4 class="text-sm font-semibold mt-4">Chapitres</h4>
                @foreach ($module['chapitres'] as $j => $chapitre)
                    <input type="text" wire:model="modules.{{ $i }}.chapitres.{{ $j }}.titre" placeholder="Titre du chapitre" class="w-full border rounded px-3 py-2 mb-2">

                    <select wire:model="modules.{{ $i }}.chapitres.{{ $j }}.type" class="w-full border rounded px-3 py-2 mb-2">
                        <option value="video">Vidéo</option>
                        <option value="image">Image</option>
                    </select>

                    <input type="file" wire:model="modules.{{ $i }}.chapitres.{{ $j }}.media" class="w-full mb-2">
                    <input type="file" wire:model="testVideo">

                    <div wire:loading wire:target="modules.{{ $i }}.chapitres.{{ $j }}.media" class="text-blue-600 text-sm">
                        Chargement de la vidéo du chapitre...
                    </div>

                     @if ($chapitre['type'] === 'video' && isset($chapitre['media']))
                        <video controls class="w-full max-w-md mb-2">
                            <source src="{{ $chapitre['media']->temporaryUrl() }}" type="video/mp4">
                        </video>
                    @endif

                    @error("modules.$i.chapitres.$j.media")
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                @endforeach

                <button type="button" wire:click="addChapitre({{ $i }})" class="text-blue-600 text-sm mt-2">+ Ajouter un chapitre</button>
            </div>
        @endforeach

        <button type="button" wire:click="addModule" class="text-blue-600 text-sm" title="Ajouter un nouveau module">+ Ajouter un module</button>

        <!--Quiz par module-->
        <hr class="my-6">
        <h3 class="text-lg font-semibold text-purple-700">Quiz par module</h3>

        @foreach ($quizzes as $i => $quiz)
            <div class="border p-4 rounded mb-4">
                <label>Intitulé de la question</label>
                <input type="text" wire:model="quizzes.{{ $i }}.intitule" class="w-full border rounded px-3 py-2 mb-2">

                <label>Réponses possibles</label>
                @foreach ($quiz['reponses'] as $j => $reponse)
                    <input type="text" wire:model="quizzes.{{ $i }}.reponses.{{ $j }}" class="w-full border rounded px-3 py-2 mb-1">
                @endforeach

                <label>Bonne réponse (index 0 à 3)</label>
                <input type="number" wire:model="quizzes.{{ $i }}.bonne_reponse" min="0" max="3" class="w-full border rounded px-3 py-2">
            </div>
        @endforeach

        <button type="button" wire:click="addQuiz" class="text-blue-600 text-sm mt-2">+ Ajouter un quiz</button>

        <!--Quiz global-->
        <hr class="my-6">
        <h3 class="text-lg font-semibold text-green-700">Quiz global du cours</h3>
        <p class="text-sm text-gray-600 mb-2">
            Ce quiz global sera utilisé pour déterminer l'obtention du certificat ou du badge.
        </p>

        @foreach ($quizGlobal as $i => $q)
            <input type="text" wire:model="quizGlobal.{{ $i }}.intitule" placeholder="Question" class="w-full mb-2">
            @foreach ($q['reponses'] as $j => $r)
                <input type="text" wire:model="quizGlobal.{{ $i }}.reponses.{{ $j }}" placeholder="Réponse {{ $j+1 }}" class="w-full mb-1">
            @endforeach
            <input type="number" wire:model="quizGlobal.{{ $i }}.bonne_reponse" min="0" max="3" class="w-full mb-2">
        @endforeach

        <button type="button" wire:click="addGlobalQuestion" class="text-blue-600 text-sm">+ Ajouter une question</button>

        <!--pour le statut soit c'est publié soit c'est en brouillon-->
        <hr class="my-6">
        <h3 class="text-lg font-semibold text-gray-800">Statut du cours</h3>
        <div>
            <label>Statut</label>
            <select wire:model="statut" class="w-full border rounded px-3 py-2">
                <option value="brouillon">Brouillon</option>
                <option value="publie">Publié</option>
            </select>
        </div>

        <!--barre de chargement pendant l'upload-->
        <div wire:loading wire:target="media" class="text-blue-600 text-sm">
            Chargement du fichier en cours...
        </div>

        

        

        <!-- Bouton d'enregistrement -->
        <!--<div class="bg-white p-4 shadow mt-6"> -->
        <div class="bg-white p-4 shadow mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                Enregistrer le cours
            </button>
        </div>




    </form>
</div>
