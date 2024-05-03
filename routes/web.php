<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\organizacion\PPTController;



// RUTA PRINCIPAL 


Route::get('/', function () {return view('tablero.index');});


//BANCO DE CV

Route::get('/vacantes',function(){return view('RH.reclutamiento.bancocv');});


// ORGANIGRAMA

Route::get('/organigrama',function(){return view('RH.organizacion.organigrama');});
Route::get('/organigrama1',function(){return view('RH.organizacion.org');});




//PPT
Route::get('/PPT',function(){return view('RH.organizacion.PPT');});
Route::post('/upload/excel', [PPTController::class, 'upload'])->name('upload.excel');


// DPT
Route::get('/DPT',function(){return view('RH.organizacion.DPT');});




// Route::get('/PPT.Q', [PPTController::class, 'getDataForDataTable'])->name('Datos_PPT');

Route::get('/PPT', [PPTController::class, 'getAllData'])->name('Datos_PPT');



Route::get('/ver-excel/{id}', [PPTController::class, 'verExcel'])->name('ver-excel');





