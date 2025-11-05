<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cours;
use Livewire\WithPagination;

class EtudiantCours extends Component
{
    use WithPagination;

    public $filtreCategorie = '';
    public $filtreNiveau = '';
    public $filtrePayant = '';
    public $page = 1;

    protected $paginationTheme = 'tailwind';
    protected $queryString = ['page'];
    
    public function getCategoriesProperty()
    {
        return Cours::distinct()->pluck('categorie')->filter()->values();
    }

    public function render()
    {
        $cours = Cours::query()
            ->when($this->filtreCategorie, fn($q) => $q->where('categorie', $this->filtreCategorie))
            ->when($this->filtreNiveau, fn($q) => $q->where('niveau', $this->filtreNiveau))
            ->when($this->filtrePayant !== '', fn($q) => $q->where('payant', $this->filtrePayant))
            ->paginate(9);

        return view('livewire.etudiant-cours', [
            'cours' => $cours,
            'categories' => $this->categories,
        ])->layout('layouts.app');
    }
}
