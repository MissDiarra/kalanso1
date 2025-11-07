<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Livewire\EnseignantDashboard;
use App\Livewire\AjouterQuiz;
use App\Livewire\AjouterCours;
use App\Livewire\CoursDetails;
use App\Livewire\ModifierCours;
use App\Livewire\EtudiantCours;
use App\Livewire\EtudiantCoursDetails;
use App\Http\Controllers\EtudiantCoursController;


Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])
    ->middleware(['web'])
    ->name('login');
    
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
});

Route::middleware(['auth', 'enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', EnseignantDashboard::class)->name('enseignant.dashboard');
    Route::get('/enseignant/cours/nouveau', AjouterCours::class)->name('enseignant.cours.nouveau');
    Route::get('/module/{id}/quiz', AjouterQuiz::class)->name('module.quiz');
    Route::get('/enseignant/cours', \App\Livewire\EnseignantCoursList::class)->name('enseignant.cours');
    Route::get('/enseignant/cours/{id}/details', CoursDetails::class)->name('cours.details');
    Route::get('/enseignant/cours/{id}/modifier', ModifierCours::class)->name('cours.edit');
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/etudiant/cours', EtudiantCours::class)->name('etudiant.cours.index');
    Route::get('/etudiant/cours/{id}/live', EtudiantCoursDetails::class)->name('etudiant.cours.live');
    Route::get('/etudiant/cours/{id}/commencer', [EtudiantCoursController::class, 'commencer'])->name('etudiant.cours.commencer');
    Route::get('/etudiant/cours/{id}/recommencer', [EtudiantCoursController::class, 'recommencer'])->name('etudiant.cours.recommencer');
    Route::get('/etudiant/cours/{id}', [EtudiantCoursController::class, 'details'])->name('etudiant.cours.details');
});