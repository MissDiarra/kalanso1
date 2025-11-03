<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cours;
use App\Models\Module;
use App\Models\Chapitre;
use App\Models\Quiz;

class AjouterCours extends Component
{
    use WithFileUploads;

    public $titre, $description, $type = 'video', $media, $statut = 'brouillon', $niveau = 'débutant', $categorie;
    public $modules = [];
    public $testVideo;
    public $payant = false;
    public $certificat_disponible = false;
    public $quizzes = [];
    public $quizGlobal = [
        ['intitule' => '', 'reponses' => ['', '', '', ''], 'bonne_reponse' => 0]
    ];

    protected function rules()
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'type' => 'required|in:video,image',
            'media' => 'required|file|max:2048000',
            'description' => 'required|string',
            'modules.*.titre' => 'required|string|max:255',
            'modules.*.chapitres.*.titre' => 'required|string|max:255',
            'modules.*.chapitres.*.media' => 'nullable|file|max:2048000|mimes:mp4,mov,avi',
            'modules.*.quizzes.*.intitule' => 'nullable|string|max:255',
            'modules.*.quizzes.*.reponses.*' => 'nullable|string|max:255',
            'modules.*.quizzes.*.bonne_reponse' => 'nullable|integer|min:0|max:3',
            'categorie' => 'required|string|max:255',
            'niveau' => 'required|in:débutant,intermédiaire,avancé',
            'payant' => 'required|boolean',
            'testVideo' => 'nullable|file|max:2048000|mimes:mp4,mov,avi',

        ];

        if ($this->niveau === 'avancé') {
            $rules['certificat_disponible'] = 'required|boolean';
        }

        return $rules;
    }    

    public function addModule()
    {
        $this->modules[] = [
            'titre' => '',
            'chapitres' => [
                ['titre' => '', 'type' => 'video', 'media' => null]
            ],
            'quizzes' => [
                ['intitule' => '', 'reponses' => ['', '', '', ''], 'bonne_reponse' => 0]
            ]
        ];
    }

    public function addChapitre($index)
    {
        $this->modules[$index]['chapitres'][] = [
            'titre' => '',
            'type' => 'video',
            'media' => null,
        ];
    }

    public function addQuiz()
    {
        $this->quizzes[] = [
            'intitule' => '',
            'reponses' => ['', '', '', ''],
            'bonne_reponse' => 0,
        ];
        
    }

    public function submit()
    {
        try {

            if (count($this->modules) === 0) {
                session()->flash('error', 'Veuillez ajouter au moins un module.');
                return;
            }

            if ($this->testVideo instanceof \Livewire\TemporaryUploadedFile) {
                $path = $this->testVideo->store('test', 'public');
                dd($path);
            }
  
            // 🔍 Nettoyer les quizzes vides avant validation
            $this->modules = collect($this->modules)->map(function ($module) {
                $module['quizzes'] = collect($module['quizzes'] ?? [])
                    ->filter(fn ($quiz) => !empty($quiz['intitule']))
                    ->values()
                    ->toArray();
                return $module;
            })->toArray();

            // ✅ Ensuite, valider
            $this->validate($this->rules());

            $path = $this->media->store('cours-media', 'public');

            $cours = Cours::create([
                'user_id' => auth()->id(),
                'titre' => $this->titre,
                'type' => $this->type,
                'media_path' => $path,
                'description' => $this->description,
                'statut' => $this->statut,
                'categorie' => $this->categorie,
                'niveau' => $this->niveau,
                'payant' => $this->payant,
                'certificat_disponible' => $this->certificat_disponible,
            ]);

            foreach ($this->modules as $mod) {
                $module = Module::create([
                    'cours_id' => $cours->id,
                    'titre' => $mod['titre'],
                ]);

                foreach ($mod['chapitres'] as $chap) {
                    $mediaPath = null;
                    if (isset($chap['media']) && $chap['media'] instanceof \Livewire\TemporaryUploadedFile) {
                        $mediaPath = $chap['media']->store('chapitre-media', 'public');
                    }

                    Chapitre::create([
                        'module_id' => $module->id,
                        'titre' => $chap['titre'],
                        'type' => $chap['type'],
                        'media_path' => $mediaPath,
                    ]);
                }

                foreach ($mod['quizzes'] ?? [] as $quiz) {
                    Quiz::create([
                        'module_id' => $module->id,
                        'titre' => $quiz['intitule'],
                        'questions' => json_encode($quiz),
                    ]);
                }
            }

            foreach ($this->quizGlobal as $q) {
                Quiz::create([
                    'cours_id' => $cours->id,
                    'titre' => 'Quiz global',
                    'questions' => json_encode($q), 
                ]);
            }

            session()->flash('success', 'Cours et modules enregistrés avec succès !');
            $this->reset([
                'titre', 'description', 'type', 'media', 'statut', 'niveau',
                'categorie', 'modules', 'payant', 'certificat_disponible',
                'quizzes', 'quizGlobal'
            ]);    

        } catch (\Throwable $e) {
            \Log::error('Erreur lors de la soumission du cours : ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        } finally {
            //pour nettoyer les fichiers temporaires
            if ($this->media instanceof \Livewire\TemporaryUploadedFile) {
                $this->media->delete();
            }

            foreach ($this->modules as $mod) {
                foreach ($mod['chapitres'] as $chap) {
                    if (isset($chap['media']) && $chap['media'] instanceof \Livewire\TemporaryUploadedFile) {
                        $chap['media']->delete();
                    }
                }
            }
        }
    }
    
    public function render()
    {
        return view('livewire.ajouter-cours')
           ->layout('layouts.app');
    }
}
