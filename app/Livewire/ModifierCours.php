<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cours;
use App\Models\Module;
use App\Models\Chapitre;
use Illuminate\Support\Facades\Storage;


class ModifierCours extends Component
{
    use WithFileUploads;

    public $cours;
    public $titre;
    public $description;
    public $niveau;
    public $categorie;
    public $statut;
    public $type;
    public $media;
    public $modules;
    public $mode = 'modification';


    public function mount($id)
    {
        $this->mode = 'modification';
        $this->cours = Cours::with('modules.chapitres')->findOrFail($id);
        $this->media = null;
        $this->titre = $this->cours->titre;
        $this->description = $this->cours->description;
        $this->niveau = $this->cours->niveau;
        $this->categorie = $this->cours->categorie;
        $this->statut = $this->cours->statut;
        $this->type = $this->cours->type;
        $this->modules = $this->cours->modules->toArray();
     
    }

    public function update()
    {
        $this->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required',
            'categorie' => 'required',
            'statut' => 'required',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

        $data = [
            'titre' => $this->titre,
            'description' => $this->description,
            'niveau' => $this->niveau,
            'categorie' => $this->categorie,
            'statut' => $this->statut,
            'type' => $this->type,

        ];
        // Supprimer les modules et chapitres qui ne sont plus présents
        $this->cours->modules->each(function ($module) {
            if (!collect($this->modules)->pluck('id')->contains($module->id)) {
                $module->chapitres()->delete();
                $module->delete();
            } else {
                $module->chapitres->each(function ($chapitre) use ($module) {
                    $moduleIndex = collect($this->modules)->search(fn($m) => $m['id'] === $module->id);
                    $chapitreIds = collect($this->modules[$moduleIndex]['chapitres'])->pluck('id');
                    if (!$chapitreIds->contains($chapitre->id)) {
                        $chapitre->delete();
                    }
                });
            }
        });

        if ($this->media instanceof \Livewire\TemporaryUploadedFile) {
            if ($this->cours->media_path && Storage::disk('public')->exists($this->cours->media_path)) {
                Storage::disk('public')->delete($this->cours->media_path);
            }

            $path = $this->media->store('cours_media', 'public');
            $data['media_path'] = $path;
        } elseif ($this->type !== $this->cours->type) {
            $data['media_path'] = null;
        }  
        $this->cours->update($data);

        // Mise à jour des modules et chapitres
        foreach ($this->modules as $moduleData) {
            $module = Module::updateOrCreate(
                ['id' => $moduleData['id'] ?? null],
                ['cours_id' => $this->cours->id, 'titre' => $moduleData['titre']]
            );

            foreach ($moduleData['chapitres'] as $chapitreData) {
                if (!isset($chapitreData['titre']) || !isset($chapitreData['type'])) {
                    continue; // ignorer les chapitres incomplets
                }
                $chapitre = Chapitre::updateOrCreate(
                    ['id' => $chapitreData['id'] ?? null],
                    [
                        'module_id' => $module->id,
                        'titre' => $chapitreData['titre'],
                        'type' => $chapitreData['type'],
                    ]
                );
                // Gestion du média du chapitre
                if (isset($chapitreData['media']) && $chapitreData['media'] instanceof \Livewire\TemporaryUploadedFile) {
                    if ($chapitre->media_path && Storage::disk('public')->exists($chapitre->media_path)) {
                        Storage::disk('public')->delete($chapitre->media_path);
                    }
                    $mediaPath = $chapitreData['media']->store('chapitre_media', 'public');
                    $chapitre->update(['media_path' => $mediaPath]);
                }
            }
        }
        
        session()->flash('success', 'Cours mis à jour avec succès.');
    }

    public function supprimerMedia()
    {
        $this->cours->update(['media_path' => null]);
        $this->media = null;
        session()->flash('success', 'Le média principal a été supprimé.');
    }

    public function supprimerChapitre($i, $j)
    {
        unset($this->modules[$i]['chapitres'][$j]);
        $this->modules[$i]['chapitres'] = array_values($this->modules[$i]['chapitres']);
    }

    public function supprimerModule($i)
    {
        unset($this->modules[$i]);
        $this->modules = array_values($this->modules);
    }

    protected function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required',
            'categorie' => 'required',
            'statut' => 'required',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ];
    }

    public function supprimerCours()
    {
        // Supprimer les fichiers liés
        if ($this->cours->media_path && Storage::disk('public')->exists($this->cours->media_path)) {
            Storage::disk('public')->delete($this->cours->media_path);
        }

        // Supprimer les médias des chapitres
        foreach ($this->cours->modules as $module) {
            foreach ($module->chapitres as $chapitre) {
                $this->deleteFileIfExists($chapitre->media_path);
            }
        }

        // Supprimer les modules et chapitres
        $this->cours->modules()->each(function ($module) {
            $module->chapitres()->delete();
        });
        $this->cours->modules()->delete();

        // Supprimer le cours
        $this->cours->delete();

        session()->flash('success', 'Le cours a été supprimé avec tous ses fichiers.');
        return redirect()->route('cours.index'); // ou autre redirection
    }

    protected function deleteFileIfExists($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function render()
    {
        return view('livewire.modifier-cours')
            ->layout('layouts.app');
    }
}
