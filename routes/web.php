<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\organizacion\areasController;
use App\Http\Controllers\organizacion\pptController;
use App\Http\Controllers\organizacion\dptController;
use App\Http\Controllers\excel\makeExcelController;
use App\Http\Controllers\organizacion\catalogosController;
use App\Http\Controllers\organizacion\catalogosasesoresController;
use App\Http\Controllers\organizacion\catalogosfuncionescargoController;
use App\Http\Controllers\organizacion\catalogosfuncionesgestionController;
use App\Http\Controllers\organizacion\catalogosrelacionesexternasController;
use App\Http\Controllers\organizacion\requerimientoPersonalController;

// RUTA PRINCIPAL 
Route::get('/', function () {return view('tablero.index');});



//==============================================  ORGANIZACION  ============================================== 

// ORGANIGRAMA
Route::get('/organigrama', function () {return view('RH.organizacion.organigrama');});
Route::post('/areasSave', [areasController::class, 'store']);
Route::get('/areasDelete', [areasController::class, 'store']);
Route::get('/TablaAreas', [areasController::class, 'TablaAreas']);
Route::get('/TablaCargos/{area_id}', [areasController::class, 'TablaCargos']);
Route::get('/TablaEncargados/{area_id}', [areasController::class, 'TablaEncargados']);
Route::get('/listaEncagadosAreas/{area_id}', [areasController::class, 'listaEncagadosAreas']);
Route::get('/getDataOrganigrama/{area_id}/{esGeneral}', [areasController::class, 'getDataOrganigrama']);


//PPT
Route::get('/PPT', [pptController::class, 'index']);
Route::post('/pptSave', [pptController::class, 'store']);
Route::get('/TablaPPT', [pptController::class, 'TablaPPT']);
Route::get('/autorizarPPT/{id_formulario}', [pptController::class, 'autorizarPPT']);
Route::get('/revisarPPT/{id_formulario}', [pptController::class, 'revisarPPT']);
Route::get('/makeExcelPPT/{id_formulario}', [makeExcelController::class, 'makeExcelPPT']);
// Route::get('/PPTDelete', [pptController::class, 'store']);



// DPT
Route::get('/DPT', [dptController::class, 'index']);
Route::post('/dptSave', [dptController::class, 'store']);
Route::get('/TablaDPT', [dptController::class, 'TablaDPT']);
// Route::get('/autorizarDPT/{id_formulario}', [dptController::class, 'autorizarDPT']);
// Route::get('/revisarDPT/{id_formulario}', [dptController::class, 'revisarDPT']);

Route::get('/makeExcelDPT/{id_formulario}', [makeExcelController::class, 'makeExcelDPT']);

Route::get('/infoReportan/{ID}/{LIDER}', [dptController::class, 'infoReportan']);


// REQUERIMIENTO PERSONAL 
Route::get('/RequisiciónDePersonal', [requerimientoPersonalController::class, 'index']);


Route::post('/RequerimientoSave', [requerimientoPersonalController::class, 'store']);
Route::get('/RequerimientoDelete', [requerimientoPersonalController::class, 'store']);
Route::get('/Tablarequerimiento', [requerimientoPersonalController::class, 'Tablarequerimiento']);
Route::get('/makeExcelRP/{id_formulario}', [makeExcelController::class, 'makeExcelRP']);


//==============================================  CATALOGOS  ============================================== 


//catalogo de jerarquia
Route::get('/Jerárquico', function () {return view('RH.organizacion.Catálogos.catálogo_Jerárquico');});
Route::post('/jerarquiaSave', [catalogosController::class, 'store']);
Route::get('/jerarquiaDelete', [catalogosController::class, 'store']);
Route::get('/Tablajerarquia', [catalogosController::class, 'Tablajerarquia']);

//catalogo de asesores


Route::get('/Asesores', function () {return view('RH.organizacion.Catálogos.catálogo_asesores');});
Route::post('/asesorSave', [catalogosasesoresController::class, 'store']);
Route::get('/asesorDelete', [catalogosasesoresController::class, 'store']);
Route::get('/Tablaasesores', [catalogosasesoresController::class, 'Tablaasesores']);

//catalogo de funciones cargo



Route::get('/FuncionesCargo', [catalogosfuncionescargoController::class, 'index']);
Route::post('/CargoSave', [catalogosfuncionescargoController::class, 'store']);
Route::get('/CargoDelete', [catalogosfuncionescargoController::class, 'store']);
Route::get('/Tablaafuncionescargo', [catalogosfuncionescargoController::class, 'Tablaafuncionescargo']);

//catalogo de funciones  gestiones



Route::get('/Funcionesgestión', function () {return view('RH.organizacion.Catálogos.catálogo_funcionesgestion');});
Route::post('/GestionSave', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/GestionDelete', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/Tablafuncionesgestion', [catalogosfuncionesgestionController::class, 'Tablafuncionesgestion']);

// catalogo de relaciones externas 

Route::get('/RelacionesExternas', function () {return view('RH.organizacion.Catálogos.catálogo_relacionesexternas');});
Route::post('/ExternaSave', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/ExternaDelete', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/Tablarelacionesexterna', [catalogosrelacionesexternasController::class, 'Tablarelacionesexterna']);




//==============================================  RECLUTAMIENTO  ============================================== 


//BANCO DE CV
Route::get('/vacantes', function () {return view('RH.reclutamiento.bancocv');});
