<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\CoursEtudiant;

class EtudiantCoursController extends Controller
{
    public function commencer($id)
    {
        $cours = Cours::findOrFail($id);
        // Enregistre le démarrage du cours
        CoursEtudiant::updateOrCreate(
            ['user_id' => auth()->id(), 'cours_id' => $cours->id],
            ['progression' => 1]
        );

        return redirect()->route('etudiant.cours.details', $cours->id);
    }

    public function recommencer($id)
    {
        $cours = Cours::findOrFail($id);
        
        CoursEtudiant::updateOrCreate(
            ['user_id' => auth()->id(), 'cours_id' => $cours->id],
            ['progression' => 1] // ou 0 si tu veux tout réinitialiser
        );

        return redirect()->route('etudiant.cours.details', $cours->id);
    }

    public function details($id)
    {
        $cours = Cours::findOrFail($id);
        // Logique pour afficher les détails du cours
        return view('etudiant.cours.details', compact('cours'));
    }
}
