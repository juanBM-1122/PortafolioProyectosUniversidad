<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculoRatio extends Model
{
    use HasFactory;
    protected $fillable = [
        "valor",
        "year"
    ];

    public function ratio(){
        return $this->belongsTo(Ratio::class);
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
