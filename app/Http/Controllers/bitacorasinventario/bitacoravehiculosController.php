<?php

namespace App\Http\Controllers\bitacorasinventario;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;


use DB;



use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;


use App\Models\recempleados\recemplaedosModel;


class bitacoravehiculosController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();

        return view('almacen.bitacoras.bitacora_vehiculos', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario'));
    }
}
