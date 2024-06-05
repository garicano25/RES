<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reclutamiento\catalogovacantesModel;

class PuestoController extends Controller
{



    public function index()
    {
        $vacantes = catalogovacantesModel::all();
        return view('RH.reclutamiento.puestos', compact('vacantes'));
    }


}
