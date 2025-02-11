<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\ofertas\ofertasModel;

class otController extends Controller
{
    public function index()
    {
        $solicitudes = ofertasModel::select(
            'ID_FORMULARIO_OFERTAS',
            'NO_OFERTA',
          
        )
            ->where('ESTATUS_OFERTA', 'like', '%Aceptada%')
            ->get();

     

        return view('ventas.orden_trabajo.orden_trabajo', compact('solicitudes'));
    }

}
