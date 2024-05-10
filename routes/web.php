<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\organizacion\areasController;
use App\Http\Controllers\organizacion\pptController;
use App\Http\Controllers\organizacion\dptController;




// RUTA PRINCIPAL 
Route::get('/', function () {return view('tablero.index');});

//BANCO DE CV
Route::get('/vacantes', function () {return view('RH.reclutamiento.bancocv');});


//==============================================  ORGANIZACION  ============================================== 

// ORGANIGRAMA
Route::get('/organigrama', function () {return view('RH.organizacion.organigrama');});
Route::post('/areasSave', [areasController::class, 'store']);
Route::get('/areasDelete', [areasController::class, 'store']);
Route::get('/TablaAreas', [areasController::class, 'TablaAreas']);
Route::get('/TablaCargos/{area_id}', [areasController::class, 'TablaCargos']);

//PPT
Route::get('/PPT', function () {return view('RH.organizacion.PPT');});
Route::post('/pptSave', [pptController::class, 'store']);
Route::get('/TablaPPT', [pptController::class, 'TablaPPT']);



// DPT

Route::get('/DPT', [dptController::class, 'index']);
Route::post('/dptSave', [dptController::class, 'store']);
Route::get('/TablaDPT', [dptController::class, 'TablaDPT']);













// REQUERIMIENTO PERSONAL 
Route::get('/REQUERIMIENTO', function () {return view('RH.organizacion.requerimiento_personal');});
