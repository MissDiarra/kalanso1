<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'titre', 'contenu'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
