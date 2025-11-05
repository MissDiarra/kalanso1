<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as BaseController;

class CustomAuthenticatedSessionController extends BaseController
{
    public function store(Request $request)
    {
        $response = parent::store($request);

        $user = Auth::user();

        if ($user->role === 'enseignant') {
            return redirect()->route('enseignant.dashboard');
        }

        if ($user->role === 'etudiant') {
            return redirect()->route('etudiant.cours.index');
        }

        return redirect('/dashboard');
    }
}
