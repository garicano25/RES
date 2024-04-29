<?php

namespace App\Http\Controllers\Organizacion;

use App\Http\Controllers\Controller;
use App\Models\organizacion\AreaModel;
use Illuminate\Http\Request;


class AreaController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'ID_AREA' => 'required',
            'NOMBRE' => 'required',
            'DESCRIPCION' => 'required',
            'TIPO_AREA_ID' => 'required',
            'USUARIO_ID' => 'required',
            'ACTIVO' => 'required|image',
        ]);



        
        
    }



}
