<?php

namespace App\Models;

use App\Http\Controllers\SubCuentaController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "claseCuenta"
    ];

    public function claseCuenta(){
        return $this->belongsTo(ClaseCuenta::class);
    }

    public function cuentas(){
        return $this->hasMany(Cuenta::class);
    }

    public function getEmpresa(){

    }

    public function getTotal($year, $empresa){
        $sub_cuenta_controller = new SubCuentaController;
        $total = $sub_cuenta_controller->getTotalSubCuenta($year,$empresa,$this->nombre);

        return $total;
    }
}