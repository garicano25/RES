<?php

use Illuminate\Support\Facades\Route;






// RUTA PRINCIPAL 


Route::get('/', function () {return view('tablero.index');});

//BANCO DE CV

Route::get('/vacantes',function(){return view('RH.reclutamiento.bancocv');});



//==============================================  ORGANIZACION  ============================================== 

// ORGANIGRAMA

Route::get('/organigrama',function(){return view('RH.organizacion.organigrama');});
//PPT
Route::get('/PPT',function(){return view('RH.organizacion.PPT');});


// DPT
Route::get('/DPT',function(){return view('RH.organizacion.DPT');});


// REQUERIMIENTO PERSONAL 
Route::get('/requerimiento',function(){return view('RH.organizacion.requerimiento_personal');});





