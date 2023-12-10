<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaEmpresa extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombreCuenta",
        "empresa_id",
        "cuenta_id",
        "tipo_estado_financiero_id"
    ];

    public function tipoEstadoFinanciero(){
        return $this->belongsTo(TipoEstadoFinanciero::class);
    }

    public function cuenta(){
        return $this->belongsTo(Cuenta::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function valoresCuenta(){
        return $this->hasMany(ValorCuenta::class);
    }

    public function getClase(){
        $subClase = $this->getSubClase();
        return $subClase->claseCuenta()->first();
    }
    public function getSubClase(){
        $cuenta = $this->cuenta()->first();
        return $cuenta->subCuenta()->first();
    }

}
