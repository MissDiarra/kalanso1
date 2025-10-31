<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cours;
use App\Models\Achat;

class EnseignantDashboard extends Component
{

    public $totalCours;
    public $totalAchats;
    public $revenuTotal;
    public $coursRecents;

    public function mount()
    {
        $enseignantId = auth()->id();

        $this->totalCours = Cours::where('user_id', $enseignantId)->count();

        $this->totalAchats = Achat::whereHas('cours', function ($q) use ($enseignantId) {
            $q->where('user_id', $enseignantId);
        })->count();

        $this->revenuTotal = Achat::whereHas('cours', function ($q) use ($enseignantId) {
            $q->where('user_id', $enseignantId);
        })->sum('montant');

        $this->coursRecents = Cours::where('user_id', $enseignantId)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }
    
    public function render()
    {
        return view('livewire.enseignant-dashboard')
            ->layout('layouts.app');
    }
}
