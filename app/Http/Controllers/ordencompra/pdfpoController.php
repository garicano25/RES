<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;
use App\Models\ordencompra\poModel;
use App\Models\proveedor\directorioModel;


class pdfpoController extends Controller
{

    public function generarPDFPO($id)
    {
        $orden = poModel::find($id);

        if (!$orden) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        $proveedor = directorioModel::where('RFC_PROVEEDOR', $orden->PROVEEDOR_SELECCIONADO)->first();

        $usuarioSolicito = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $orden->USUARIO_ID)
            ->first();

        $usuarioAprobo = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $orden->APROBO_ID)
            ->first();

        return Pdf::loadView('pdf.po_pdf', compact('orden', 'proveedor', 'usuarioSolicito', 'usuarioAprobo'))
            ->download("PO_{$orden->NO_PO}.pdf");
    }
}
