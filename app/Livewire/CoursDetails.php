<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Achat;
use App\Models\Cours;
use App\Models\Commentaiire;

class CoursDetails extends Component
{
    public $cours;
    public $dejaAchete = false;
    public $nouveauCommentaire = '';

    public function mount($id)
    {
        $this->cours = Cours::with(['modules.chapitres', 'commentaires.user'])->findOrFail($id);
        
        //verifie si l'utilisateur a déjà acheté le cours
        $this->dejaAchete = Achat::where('user_id', auth()->id())
        ->where('cours_id', $id)
        ->exists();
    }

    public function acheter()
    {
        if (!$this->dejaAchete && $this->cours->payant) {
            Achat::create([
                'user_id' => auth()->id(),
                'cours_id' => $this->cours->id,
                'montant' => $this->cours->prix ?? 0,
            ]);

            $this->dejaAchete = true;
            session()->flash('success', 'Achat enregistré avec succès.');
        }
    }

    public function ajouterCommentaire()
    {
        $this->validate([
            'nouveauCommentaire' => 'required|string|min:3',
        ]);

        Commentaire::create([
            'user_id' => auth()->id(),
            'cours_id' => $this->cours->id,
            'contenu' => $this->nouveauCommentaire,
        ]);

        $this->nouveauCommentaire = '';
        $this->cours->load('commentaires.user');
    }

    public function render()
    {
        return view('livewire.cours-details')
            ->layout('layouts.app');
    }
}
