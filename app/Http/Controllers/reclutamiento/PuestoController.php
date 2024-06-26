<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reclutamiento\catalogovacantesModel;

class PuestoController extends Controller
{


    public function index()
    {
        $vacantes = catalogovacantesModel::where('LA_VACANTES_ES', 'Pública')->get();
        return view('RH.reclutamiento.VacantesExterna', compact('vacantes'));
    }
    
    

}
