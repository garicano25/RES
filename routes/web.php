<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

//     return view('welcome');
// });



// RUTA PRINCIPAL 


Route::get('/', function () {return view('tablero.index');});


//BANCO DE CV

Route::get('/vacantes',function(){return view('RH.reclutamiento.bancocv');});


// ORGANIGRAMA

Route::get('/organigrama',function(){return view('RH.organizacion.organigrama');});


