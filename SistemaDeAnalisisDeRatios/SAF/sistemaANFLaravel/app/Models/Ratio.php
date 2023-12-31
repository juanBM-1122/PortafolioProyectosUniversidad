<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    public function valorSectorRatio(){
        return $this->hasMany(ValorSectorRatio::class);
    }
}
