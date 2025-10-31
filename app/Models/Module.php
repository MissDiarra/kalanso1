<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['cours_id', 'titre'];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
