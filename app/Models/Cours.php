<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'type',
        'media_path',
        'description',
        'statut',
        'categorie'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function achats()
    {
        return $this->hasMany(Achat::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function quizGlobal()
    {
        return $this->hasOne(Quiz::class)->whereNull('module_id');
    }


}
