<?php

namespace App\Http\Controllers\Auth;

//use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as BaseController;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class CustomAuthenticatedSessionController extends BaseController
{
    public function store(LoginRequest $request)
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
