<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cours;

class ModifierCours extends Component
{
     public $cours;
    public $titre;
    public $description;
    public $niveau;
    public $categorie;
    public $statut;

    public function mount($id)
    {
        $this->cours = Cours::with('modules.chapitres')->findOrFail($id);
        $this->titre = $this->cours->titre;
        $this->description = $this->cours->description;
        $this->niveau = $this->cours->niveau;
        $this->categorie = $this->cours->categorie;
        $this->statut = $this->cours->statut;
    }

    public function update()
    {
        $this->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required',
            'categorie' => 'required',
            'statut' => 'required',
        ]);

        $this->cours->update([
            'titre' => $this->titre,
            'description' => $this->description,
            'niveau' => $this->niveau,
            'categorie' => $this->categorie,
            'statut' => $this->statut,
        ]);

        session()->flash('success', 'Cours mis à jour avec succès.');
    }

    public function render()
    {
        return view('livewire.modifier-cours')
            ->layout('layouts.app');
    }
}
