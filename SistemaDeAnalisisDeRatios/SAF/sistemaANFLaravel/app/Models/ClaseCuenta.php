<?php

namespace App\Models;

use App\Http\Controllers\ClaseCuentaController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCuenta;

class ClaseCuenta extends Model
{
    use HasFactory;


    protected $fillable = [
        "nombre",
    ];

    public function subCuentas()
    {
        return $this->hasMany(Subcuenta::class, 'claseCuenta');
    }

    public function getTotal($year,$empresa_id)
    {
        /*$totalClaseCuenta = ValorCuenta::join('cuenta_empresas', 'valor_cuentas.cuenta_empresa_id', '=', 'cuenta_empresas.id')
            ->join('cuentas', 'cuenta_empresas.cuenta_id', '=', 'cuentas.id')
            ->join('sub_cuentas', 'cuentas.sub_cuenta_id', '=', 'sub_cuentas.id')
            ->join('clase_cuentas', 'sub_cuentas.clase_cuenta_id', '=', 'clase_cuentas.id')
            ->where('clase_cuentas.nombre', $this->nombre)
            ->where('valor_cuentas.year', $year)
            ->where('cuenta_empresas.empresa_id', $empresa_id)
            ->sum('valor_cuentas.valorCuenta');

        return $totalClaseCuenta;*/
        $clase_cuenta_controller = new ClaseCuentaController();
        $total = $clase_cuenta_controller->getTotalClaseCuenta($year,$empresa_id,$this->nombre);
        return $total;
    }
}
