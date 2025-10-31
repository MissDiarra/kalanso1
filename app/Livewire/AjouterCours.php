<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cours;
use App\Models\Module;
use App\Models\Chapitre;

class AjouterCours extends Component
{
    use WithFileUploads;

    public $titre, $description, $type = 'video', $media, $statut = 'brouillon', $niveau = 'débutant', $categorie;
    public $modules = [];
    public $payant = false;
    public $certificat_disponible = false;

    protected $rules = [
        'titre' => 'required|string|max:255',
        'type' => 'required|in:video,image',
        'media' => 'required|file|max:2048000',
        'description' => 'required|string',
        'modules.*.titre' => 'required|string|max:255',
        'modules.*.chapitres.*.titre' => 'required|string|max:255',
        'categorie' => 'required|string|max:255',
        'niveau' => 'required|in:débutant,intermédiaire,avancé',
        'payant' => 'required|boolean',
        'certificat_disponible' => 'required|boolean',
    ];

    public function addModule()
    {
        $this->modules[] = ['titre' => '', 'chapitres' => [['titre' => '']]];
    }

    public function addChapitre($index)
    {
        $this->modules[$index]['chapitres'][] = ['titre' => ''];
    }

    public function submit()
    {
        $this->validate();

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
                Chapitre::create([
                    'module_id' => $module->id,
                    'titre' => $chap['titre'],
                ]);
            }
        }

        session()->flash('success', 'Cours et modules enregistrés avec succès !');
        $this->reset();
    }
    
    public function render()
    {
        return view('livewire.ajouter-cours')
           ->layout('layouts.app');
    }
}
