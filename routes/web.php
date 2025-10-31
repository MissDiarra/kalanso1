<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\EnseignantDashboard;
use App\Livewire\AjouterQuiz;
use App\Livewire\AjouterCours;
use App\Livewire\CoursDetails;
use App\Livewire\ModifierCours;

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
