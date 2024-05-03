<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\organizacion\PPTController;
use App\Http\Controllers\organizacion\DPTController;




// RUTA PRINCIPAL 


Route::get('/', function () {return view('tablero.index');});

//BANCO DE CV

Route::get('/vacantes',function(){return view('RH.reclutamiento.bancocv');});



//==============================================  ORGANIZACION  ============================================== 

// ORGANIGRAMA

Route::get('/organigrama',function(){return view('RH.organizacion.organigrama');});
Route::get('/organigrama1',function(){return view('RH.organizacion.org');});
//PPT
Route::get('/PPT',function(){return view('RH.organizacion.PPT');});
Route::post('/upload/excel', [PPTController::class, 'upload'])->name('upload.excel');

Route::get('/PPT', [PPTController::class, 'getAllData'])->name('Datos_PPT');

Route::get('/ver-excel/{id}', [PPTController::class, 'verExcel'])->name('ver-excel');

Route::delete('/eliminar/{id}', [PPTController::class, 'eliminar'])->name('eliminar.registro');


// DPT
Route::get('/DPT',function(){return view('RH.organizacion.DPT');});


Route::post('/guardar/excel', [DPTController::class, 'guardar'])->name('guardar.excel');

Route::get('/DPT', [DPTController::class, 'getAllData_DPT'])->name('Datos_DPT');

Route::get('/ver-excel/{id}', [DPTController::class, 'verExcel'])->name('ver-excel');

Route::delete('/eliminar/{id}', [DPTController::class, 'eliminar'])->name('eliminar.registro');

//Requerimientos personales
Route::get('/requerimiento',function(){return view('RH.organizacion.requerimiento_personal');});





