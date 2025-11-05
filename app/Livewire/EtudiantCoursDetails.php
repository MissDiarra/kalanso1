<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cours;

class EtudiantCoursDetails extends Component
{
    public $cours;

    public function mount($id)
    {
        $this->cours = Cours::with('modules.chapitres')->findOrFail($id); 
    }

    public function render()
    {
        return view('livewire.etudiant-cours-details');
    }
}
