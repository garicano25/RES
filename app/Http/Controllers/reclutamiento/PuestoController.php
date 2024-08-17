<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reclutamiento\catalogovacantesModel;
use DB;

class PuestoController extends Controller
{


    public function index()
    {
        $today = now()->toDateString(); 
    
        $vacantes = catalogovacantesModel::where('LA_VACANTES_ES', 'Pública')
                                         ->whereDate('FECHA_EXPIRACION', '>', $today)
                                         ->where('ACTIVO', 1)  
                                         ->get();
    
        foreach ($vacantes as $vacante) {
            $requerimientos = DB::table('requerimientos_vacantes')
                                ->where('CATALOGO_VACANTES_ID', $vacante->ID_CATALOGO_VACANTE)
                                ->pluck('NOMBRE_REQUERIMINETO');
    
            $vacante->requerimientos = $requerimientos;
        }
    
        return view('RH.reclutamiento.VacantesExterna', compact('vacantes'));
    }
    
    
    

}
