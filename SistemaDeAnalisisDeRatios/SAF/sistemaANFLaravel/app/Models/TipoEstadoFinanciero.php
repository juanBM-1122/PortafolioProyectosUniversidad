<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEstadoFinanciero extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
    ];

    public function cuentaEmpresa(){
        return $this->hasMany(Empresa::class);
    }

    public function cuentaEmpresas(){
        return $this->hasMany(CuentaEmpresa::class);
    }
}
