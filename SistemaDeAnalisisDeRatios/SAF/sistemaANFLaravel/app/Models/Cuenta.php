<?php

namespace App\Models;

use App\Http\Controllers\CuentaController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "subCuenta",
    ];

    public function subCuenta(){
        return $this->belongsTo(SubCuenta::class);
    }

    public function getTotal($year,$empresa){
        $cuenta_controller = new CuentaController;
        return $cuenta_controller->getTotalCuenta($year,$empresa,$this->nombre);
    }

    public function getPromedio($year,$empresa){
        $cuenta_controller = new CuentaController;
        return $cuenta_controller->getPromedioCuenta($year,$empresa,$this->nombre);
    }
}
