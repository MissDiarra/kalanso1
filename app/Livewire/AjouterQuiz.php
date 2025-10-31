<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Module;

class AjouterQuiz extends Component
{

    public int $moduleId;
    public $titre;
    public $questions = [];

    protected $rules = [
        'titre' => 'required|string|max:255',
        'questions.*.intitule' => 'required|string',
        'questions.*.reponses.*' => 'required|string',
        'questions.*.bonne_reponse' => 'required|integer|min:0|max:3',
    ];

    public function mount($moduleId)
    {
        // Vérifie si le module existe
        $module = Module::find($moduleId);

        if (!$module) {
            abort(404, 'Module introuvable.');
        }
        $this->moduleId = $moduleId;
        $this->questions = [
            [
                'intitule' => '',
                'reponses' => ['', '', '', ''],
                'bonne_reponse' => 0,
            ]
        ];
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'intitule' => '',
            'reponses' => ['', '', '', ''],
            'bonne_reponse' => 0,
        ];
    }

     public function submit()
    {
        $this->validate();

        Quiz::create([
            'module_id' => $this->moduleId,
            'titre' => $this->titre,
            'questions' => $this->questions,
        ]);

        session()->flash('success', 'Quiz enregistré avec succès !');
        $this->reset(['titre', 'questions']);
    }
    public function render()
    {
        return view('livewire.ajouter-quiz');
    }
}
