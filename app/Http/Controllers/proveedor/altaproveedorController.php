<?php

namespace App\Http\Controllers\proveedor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB; 

use App\Models\proveedor\directorioModel;


class altaproveedorController extends Controller
{
    public function obtenerDatosProveedor()
{
    $rfcProveedor = Auth::user()->RFC_PROVEEDOR;

    $proveedor = directorioModel::where('RFC_PROVEEDOR', $rfcProveedor)->first();

    if (!$proveedor) {
        return response()->json(['error' => 'No se encontraron datos'], 404);
    }

    return response()->json([
        'TIPO_PERSONA_ALTA' => $proveedor->TIPO_PERSONA,
        'RAZON_SOCIAL_ALTA' => $proveedor->RAZON_SOCIAL,
        'RFC_ALTA' => $proveedor->RFC_PROVEEDOR,
        'ACTVIDAD_COMERCIAL' => $proveedor->GIRO_PROVEEDOR,
        'CODIGO_POSTAL' => $proveedor->CODIGO_POSTAL,
        'TIPO_VIALIDAD_EMPRESA' => $proveedor->TIPO_VIALIDAD_EMPRESA,
        'NOMBRE_VIALIDAD_EMPRESA' => $proveedor->NOMBRE_VIALIDAD_EMPRESA,
        'NUMERO_EXTERIOR_EMPRESA' => $proveedor->NUMERO_EXTERIOR_EMPRESA,
        'NUMERO_INTERIOR_EMPRESA' => $proveedor->NUMERO_INTERIOR_EMPRESA,
        'NOMBRE_COLONIA_EMPRESA' => $proveedor->NOMBRE_COLONIA_EMPRESA,
        'NOMBRE_LOCALIDAD_EMPRESA' => $proveedor->NOMBRE_LOCALIDAD_EMPRESA,
        'NOMBRE_MUNICIPIO_EMPRESA' => $proveedor->NOMBRE_MUNICIPIO_EMPRESA,
        'NOMBRE_ENTIDAD_EMPRESA' => $proveedor->NOMBRE_ENTIDAD_EMPRESA,
        'PAIS_EMPRESA' => $proveedor->PAIS_EMPRESA,
        'ENTRE_CALLE_EMPRESA' => $proveedor->ENTRE_CALLE_EMPRESA,
        'ENTRE_CALLE2_EMPRESA' => $proveedor->ENTRE_CALLE2_EMPRESA,
        'DOMICILIO_EXTRANJERO' => $proveedor->DOMICILIO_EXTRANJERO,
        'CODIGO_EXTRANJERO' => $proveedor->CODIGO_EXTRANJERO,
        'CIUDAD_EXTRANJERO' => $proveedor->CIUDAD_EXTRANJERO,
        'ESTADO_EXTRANJERO' => $proveedor->ESTADO_EXTRANJERO,
        'PAIS_EXTRANJERO' => $proveedor->PAIS_EXTRANJERO,
        'DEPARTAMENTO_EXTRANJERO' => $proveedor->DEPARTAMENTO_EXTRANJERO
    ]);
}
}
