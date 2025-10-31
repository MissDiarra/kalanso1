<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = ['user_id', 'cours_id', 'montant'];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
