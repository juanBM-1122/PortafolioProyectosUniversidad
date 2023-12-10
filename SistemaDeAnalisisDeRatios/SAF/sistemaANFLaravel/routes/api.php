<?php

use App\Http\Controllers\CalculoRatioController;
use App\Http\Controllers\CuentaEmpresaController;
use App\Http\Controllers\SectorEmpresaController;
use App\Models\AnalisisHorizontal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalisisVerticalController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ValorCuentaController;
use App\Http\Controllers\AnalisisHorizontalController;
use App\Http\Controllers\RatioController;
use App\Http\Controllers\ValorSectorRatioController;
use App\Http\Controllers\EstadoFinancieroController;

use App\Http\Controllers\ClaseCuentaController;
use App\Http\Controllers\SubCuentaController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\TipoEstadoFinancieroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/realizar_analisis_vertical",[AnalisisVerticalController::class,"generarAnalisisVertical"]);
Route::resource("empresas",EmpresaController::class);
Route::get("/obtener_empresas",[EmpresaController::class,"obtenerEmpresasRegistradas"]);
Route::get("/obtener_anios_unicos",[ValorCuentaController::class,"obtenerAniosUnicos"]);
Route::post("/analisis_horizontal",[AnalisisHorizontalController::class,'showAnalisisHorizontal']);
Route::post('obtener_years_empresa',[EmpresaController::class,'aniosConEstadosFinancieros']);
Route::get('obtener_years',[CalculoRatioController::class,'getYears']);
Route::get('obtener_sectores',[SectorEmpresaController::class,'getSectores']);
Route::post('obtener_ratios_empresa_vs_sector',[CalculoRatioController::class,'getValoresRatiosVsSector']);
Route::get("obtener_anios_por_empresa",[ValorCuentaController::class,"obtenerAniosUnicosPorEmpresa"]);
//----------------------------------Gestión sectores y Ratios por sector-------------------------------------------
Route::resource('/ratios', RatioController::class);
Route::post('guardar_editar_ratio', [RatioController::class, 'guardarEditarValorRatio']);
Route::resource('/sectores', SectorEmpresaController::class);
Route::post('sectores/{sector}', [SectorEmpresaController::class, 'update']);
Route::resource('/valor_sector_ratios', ValorSectorRatioController::class);
Route::get('/valor_sector_ratios/{sector}', [ValorSectorRatioController::class, 'getValorRatioSector']);

//----------------------------------Cuentas y valores
Route::post('obtener_cuentas_empresa', [CuentaEmpresaController::class,'getCuentasEmpresa']);
Route::post('obtener_valores_cuenta_empresa', [ValorCuentaController::class,'getValoresCuenta']);
Route::post('obtener_valores_ratio_empresa', [CalculoRatioController::class,'getValorRatio']);
Route::get('obtener_nombres_ratios',[RatioController::class,'index']);
Route::post('/obtener_ratios_empresa_vs_promedio',[CalculoRatioController::class,'getValoresRatiosVsPromedio']);
//----------------------------------Para guardar estados financieros
Route::resource('estados_financieros',EstadoFinancieroController::class);

Route::post("/realizar_analisis_vertical",[AnalisisVerticalController::class,"generarAnalisisVertical"]);
Route::resource("empresas",EmpresaController::class);
Route::get("/obtener_anios_unicos",[ValorCuentaController::class,"obtenerAniosUnicos"]);
Route::post("/analisis_horizontal",[AnalisisHorizontalController::class,'showAnalisisHorizontal']);
Route::post('obtener_years_empresa',[EmpresaController::class,'aniosConEstadosFinancieros']);
Route::post('obtener_ratios_empresa_vs_sector',[CalculoRatioController::class,'getValoresRatiosVsSector']);
Route::resource("sectorempresas",SectorEmpresaController::class);
Route::resource("clasecuentas",ClaseCuentaController::class);
Route::resource("subcuentas",SubCuentaController::class);
Route::resource("cuenta",CuentaController::class);
Route::get('cuentas_por_clase',[CuentaController::class,'getCuentasClasificadasPorClase']);
Route::resource("tipo_estado_financieros",TipoEstadoFinancieroController::class);
Route::resource("cuenta_empresas",CuentaEmpresaController::class);
//Route::get('empresas', [EmpresaController::class, 'ultima']);
