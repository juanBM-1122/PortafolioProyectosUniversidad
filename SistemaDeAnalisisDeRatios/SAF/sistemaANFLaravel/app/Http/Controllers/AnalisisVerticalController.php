<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ValorCuenta;
use App\Models\AnalisisVertical;
use Illuminate\Support\Facades\DB;

class AnalisisVerticalController extends Controller
{
        //Tipos de cuentas
        const ACTIVOS = "Activos";
        const PASIVOS = "Pasivos";
        const PATRIMONIO = "Patrimonio";
        const GASTOS = "Gastos";
        const COSTOS = "Costos";
        const INGRESOS = "Ingresos";

        //Tipos de subcuentas
        const ACTIVOS_CORRIENTES = "Activos corrientes";
        const ACTIVOS_NO_CORRIENTES = "Activos no corrientes";
        const PASIVOS_CORRIENTES = "Pasivos corrientes";
        const PASIVOS_NO_CORRIENTES = "Pasivos no corrientes";
        const CAPITAL_CONTABLE = "Capital contable";
        const GASTOS_DE_OPERACION = "Gastos de operacion";
        const COSTOS_DE_OPERACION = "Costos de operacion";
        const INGRESOS_DE_OPERACION = "Ingresos de operacion";

    private $valoresCuentasActivosCorriente;
    private $valoresCuentasActivosNoCorrientes;
    private $valoresCuentasPasivosCorrientes;
    private $valoreCuentasPasivosNoCorrientes;
    private $valoresCuentasCapital;

    /*No se si se va a usar*/
    private $valoresCuentaIngresos;
    private $valoresCuentaGastos;
    private $valoresCuentaCostos;

    /**El total de venta es la base para sacar la razón de los porcentajes en el esatdo de resultado */
    private $totalVentas;

    private $totalActivos;
    private $totalPasivos;
    private $totalCapital;
    private $parametrosConsulta;


    public function __construct () {
        $this->totalActivos = 0;
        $this->totalPasivos = 0;
        $this->totalCapital = 0;
        $this->totalVentas = 0;
        $this->parametrosConsulta = [
            self::ACTIVOS_CORRIENTES,
            self::ACTIVOS_NO_CORRIENTES,
            self::PASIVOS_CORRIENTES,
            self::PASIVOS_NO_CORRIENTES,
            self::CAPITAL_CONTABLE,
            self::INGRESOS_DE_OPERACION,
            self::GASTOS_DE_OPERACION,
            self::COSTOS_DE_OPERACION,
        ];
    }


    public function generarAnalisisVertical(Request $request){

        $validator = Validator::make($request->all(),[
            "anio"=>"required|Integer",
            "empresa"=>"required|Integer"
        ]);

        if ($validator->fails()){
            return response()->json([
                "status"=>false,
                "errores"=>$validator->errors()
            ],404);
        }
        //validated se puede tratar como una matriz asociativa.
        $validated = $validator->validated();
        $anio = $validated["anio"];
        $empresa = $validated["empresa"];

        if(!(count($this->verificarExistenciaDeAnalisisParaPeriodo($this->obtenerValoresCuentaAnio($anio,$empresa))) > 0)){

            $this->llenarValoresCuentasPorSubCuentas($anio,$empresa);
            $this->realizarAnalisisVerticalBalanceGeneral($anio,$empresa);
            $this->realizarAnalisisVerticalEstadoResultado($anio,$empresa);
        }


        return response()->json([
            "status"=>true,
            "analisisActivos"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::ACTIVOS),
            "totalActivos"=>$this->obtenerTotalClaseCuenta(self::ACTIVOS,$anio,$empresa),
            "analisisPasivos"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::PASIVOS),
            "totalPasivos"=>$this->obtenerTotalClaseCuenta(self::PASIVOS,$anio,$empresa),
            "analisisPatrimonio"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::PATRIMONIO),
            "totalPatrimonio"=>$this->obtenerTotalClaseCuenta(self::PATRIMONIO,$anio,$empresa),

            "totalVentas"=>$this->obtenerTotalVentas($this->obtenerValoresCuentaAnio($anio,$empresa)),

            "totalVentas"=>$this->obtenerTotalVentas($this->obtenerValoresCuentaAnio($anio,$empresa)),
            "analisisIngresos"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::INGRESOS),
            "analisisGastos"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::GASTOS),
            "analisisCostos"=>$this->obtenerResultadosPorClaseCuenta($this->obtenerValoresCuentaAnio($anio,$empresa),self::COSTOS),
        ],200);

    }

    public function realizarAnalisisVerticalBalanceGeneral($anio,$empresa){
        $this->totalActivos = $this->obtenerTotalClaseCuenta(self::ACTIVOS,$anio,$empresa);
        $this->totalPasivos =$this->obtenerTotalClaseCuenta(self::PASIVOS,$anio,$empresa);
        $this->totalCapital =$this->obtenerTotalClaseCuenta(self::PATRIMONIO,$anio,$empresa);
        //agregar los analisis de activos
        $this->guardarValorAnalisis($this->valoresCuentasActivosCorrientes,$this->totalActivos);
        $this->guardarValorAnalisis($this->valoresCuentasActivosNoCorrientes,$this->totalActivos);

        //agregar los analisi de pasivos
        $this->guardarValorAnalisis($this->valoresCuentasPasivosCorrientes,$this->totalPasivos);
        $this->guardarValorAnalisis($this->valoresCuentasPasivosNoCorrientes,$this->totalPasivos);

        //agregar los analisis de Patrimonio
        $this->guardarValorAnalisis($this->valoresCuentasCapital,$this->totalCapital);
    }

    public function realizarAnalisisVerticalEstadoResultado($anio,$empresa){
        $totalDescuentos = $this->obtenerTotalDescuentos($this->obtenerValoresCuentaAnio($anio,$empresa));
        $this->totalDeVenta = $this->obtenerTotalVentas($this->obtenerValoresCuentaAnio($anio,$empresa));
        //agregar los analisis de Ingresos
        $this->guardarValorAnalisis($this->valoresCuentaIngresos,$this->totalDeVenta);
        //agregar los analisis de costos
        $this->guardarValorAnalisis($this->valoresCuentaCostos,$this->totalDeVenta);
        //agreaga los analisis de Gastos.
        $this->guardarValorAnalisis($this->valoresCuentaGastos,$this->totalDeVenta);
    }

    public function guardarValorAnalisis($valoresCuentas,$totalClaseCuenta){
        foreach($valoresCuentas as ["valorCuenta"=>$valor,"id"=>$id]){
            $valorAnalisisVertical = round($valor/$totalClaseCuenta,4);
            $analisisVertical = new AnalisisVertical;
            $analisisVertical->valorAnalisisVertical = $valorAnalisisVertical;
            $analisisVertical->valor_cuenta_id = $id;
            $analisisVertical->save();
        }
    }

    public function llenarValoresCuentasPorSubCuentas($anio,$empresa){
        for($i = 0; $i < count($this->parametrosConsulta); $i++){
            switch($i){
                case 0:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentasActivosCorrientes = $this->obtenerValorCuentaPorSubCuentas($valoresCuenta,$this->parametrosConsulta[$i]);
                    break;
                case 1:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentasActivosNoCorrientes = $this->obtenerValorCuentaPorSubCuentas($valoresCuenta,$this->parametrosConsulta[$i]);
                break;
                case 2:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentasPasivosCorrientes = $this->obtenerValorCuentaPorSubCuentas($valoresCuenta,$this->parametrosConsulta[$i]);
                break;
                case 3:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentasPasivosNoCorrientes = $this->obtenerValorCuentaPorSubCuentas($valoresCuenta,$this->parametrosConsulta[$i]);
                break;
                case 4:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentasCapital = $this->obtenerValorCuentaPorSubCuentas($valoresCuenta,$this->parametrosConsulta[$i]);
                break;
                case 5:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentaIngresos = $this->obtenerCuentasPorClaseCuenta($valoresCuenta,self::INGRESOS)->get();
                break;
                case 6:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentaGastos = $this->obtenerCuentasPorClaseCuenta($valoresCuenta,self::GASTOS)->get();
                break;
                case 7:
                    $valoresCuenta = $this->obtenerValoresCuentaAnio($anio,$empresa);
                    $this->valoresCuentaCostos = $this->obtenerCuentasPorClaseCuenta($valoresCuenta,self::COSTOS)->get();
                break;
            }
        }
    }

    public function obtenerValoresCuentaAnio(int $anio,string $empresa){

        $valoresCuenta = ValorCuenta::where("year",$anio)->whereHas("cuentaEmpresa",function ($q) use ($empresa) {
            $q->where("empresa_id","=",$empresa);
        })->with("cuentaEmpresa");
        return $valoresCuenta;
    }

    public function obtenerCuentasPorClaseCuenta($valoresCuenta,$tipoCuenta = ""){
        $valorCuentasPorClaseCuentas = $valoresCuenta->whereHas("cuentaEmpresa", function($q) use($tipoCuenta){
            $q->whereHas("cuenta",function($q) use($tipoCuenta){
                $q->whereHas("subCuenta",function($q) use($tipoCuenta){
                    $q->whereHas("claseCuenta",function($q) use($tipoCuenta){
                        $q->where("nombre","=",$tipoCuenta);
                    });
                });
            });
        });

        return $valorCuentasPorClaseCuentas;
    }

    public function obtenerValorCuentaPorSubCuentas($valoresCuenta,$tipoSubCuenta = ""){
        $valoresCuentaPorSubCuentas = $valoresCuenta->whereHas("cuentaEmpresa", function($q) use($tipoSubCuenta){
            $q->whereHas("cuenta",function($q) use ($tipoSubCuenta){
                $q->whereHas("subCuenta", function($q) use($tipoSubCuenta){
                    $q->where("nombre","=",$tipoSubCuenta);
                });
            });
        });

        return $valoresCuentaPorSubCuentas->get();
    }

    public function obtenerTotalClaseCuenta($tipoCuenta = "",$anio,$empresa){
        $totalValoresPorClaseCuenta = 0;
        $valorePorClaseCuenta = $this->obtenerCuentasPorClaseCuenta(
            $this->obtenerValoresCuentaAnio($anio,$empresa),
            $tipoCuenta
            )->get();
        foreach($valorePorClaseCuenta as ["valorCuenta"=>$valor]){
            $totalValoresPorClaseCuenta+=$valor;
        }
        return $totalValoresPorClaseCuenta;
    }

    public function verificarExistenciaDeAnalisisParaPeriodo($valoresCuentaEmpresa){
            return $valoresCuentaEmpresa
            ->with("cuentaEmpresa")
            ->has("analisisVertical")
            ->with("analisisVertical")
            ->get();
    }

    public function obtenerResultadosPorClaseCuenta($valoresCuenta, $tipoCuenta = "" ){
        $valorCuentasPorClaseCuentas = $valoresCuenta->whereHas("cuentaEmpresa", function($q) use($tipoCuenta){
            $q->whereHas("cuenta",function($q) use($tipoCuenta){
                $q->whereHas("subCuenta",function($q) use($tipoCuenta){
                    $q->whereHas("claseCuenta",function($q) use($tipoCuenta){
                        $q->where("nombre","=",$tipoCuenta);
                    });
                });
            });
        })->with("cuentaEmpresa")->with("analisisVertical");
        return $valorCuentasPorClaseCuentas->get();
    }

    //obtener total de ventas en funcion de las subcuentas de tipo Ingresos de operacion
    public function obtenerTotalVentas($valoresCuenta){
        $totalVentas = 0;
       /* $valoresVenta = $valoresCuenta->whereHas("cuentaEmpresa", function($q){
            $q->whereHas("cuenta",function($q){
                $q->where("nombre","<>","Descuentos y devoluciones")->whereHas("subCuenta",function($q){
                    $q->where("nombre","=","Ingresos de operacion");
                });
            });
        })->get();

        foreach($valoresVenta as ["valorCuenta"=>$valor]){
            $totalVentas+=$valor;
        }*/
        $valoresCuenta = $valoresCuenta->whereHas("cuentaEmpresa",function($q){
            $q->where("nombreCuenta","like","%enta%")->whereHas("cuenta",function($q){
                $q->whereHas("subCuenta", function ($q){
                    $q->where("nombre","=","Ingresos de operacion");
                });
            });
        })->select(
            DB::raw('SUM(valorCuenta) as total_ventas'),
        )->get();
        return $valoresCuenta[0]["total_ventas"];

    }

    public function obtenerTotalDescuentos($valoresCuenta){
            $descuentosDeVenta = 0;
            $listaDescuentos = $valoresCuenta->whereHas("cuentaEmpresa", function($q){
                $q->whereHas("cuenta",function($q){
                    $q->where("nombre","=","Descuentos y devoluciones")->whereHas("subCuenta",function($q){
                        $q->where("nombre","=","Ingresos de operacion");
                    });
                });
            })->with("cuentaEmpresa")->get();

            if(count($listaDescuentos)>0){
                foreach($listaDescuentos as ["valorCuenta"=>$valor]){
                    $descuentosDeVenta+=$valor;
                }
            }

            return $descuentosDeVenta;
    }
}
