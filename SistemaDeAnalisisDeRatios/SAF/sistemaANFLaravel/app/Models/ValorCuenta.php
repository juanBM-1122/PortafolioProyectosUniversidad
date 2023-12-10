<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorCuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        "cuentaEmpresa",
        "valorCuenta",
        "year"
    ];

    public function cuentaEmpresa(){
        return $this->belongsTo(CuentaEmpresa::class);
    }

    public function analisisHorizontal(){
        return $this->hasMany(AnalisisHorizontal::class);
    }

    public function analisisVertical(){
        return $this->hasMany(analisisVertical::class);
    }


}
