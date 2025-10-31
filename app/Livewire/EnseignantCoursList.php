<?php

namespace App\Livewire;

use Livewire\Component;

class EnseignantCoursList extends Component
{
    public function render()
    {
        return view('livewire.enseignant-cours-list')
             ->layout('layouts.app');
    }

    public $cours = [];
    public $filtreCategorie = '';
    public $filtreNiveau = '';
    public $filtreStatut = '';
    public $vueGrille = true;

    public function mount()
    {
        $this->cours = \App\Models\Cours::where('user_id', auth()->id())
        ->orderBy('payant', 'asc') // 0 = gratuit, 1 = payant
        ->latest() // optionnel si je veux faire trie par date
        ->get();
    }

    public function updated()
    {
        $this->cours = \App\Models\Cours::where('user_id', auth()->id())
            ->when($this->filtreCategorie, fn($q) => $q->where('categorie', $this->filtreCategorie))
            ->when($this->filtreNiveau, fn($q) => $q->where('niveau', $this->filtreNiveau))
            ->when($this->filtreStatut, fn($q) => $q->where('statut', $this->filtreStatut))
            ->orderBy('payant', 'asc')
            ->latest()
            ->get();
    }

    public function supprimer($id)
    {
        Cours::findOrFail($id)->delete();
        $this->mount(); // pour recharger la liste
    }


}
