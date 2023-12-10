<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisHorizontal extends Model
{
    use HasFactory;

    protected $fillable = [
        "valorAnalisis",
        "yearInicial",
        "yearFinal",
    ];

    public function valorCuenta(){
        return $this->belongsTo(ValorCuenta::class);
    }

}
