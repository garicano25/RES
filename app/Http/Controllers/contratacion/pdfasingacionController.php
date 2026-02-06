<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;

class pdfasingacionController extends Controller
{
    public function pdfAsignacion($id)
    {
        $asignacion = DB::table('asignaciones_contratacion')
            ->where('ID_ASINGACIONES_CONTRATACION', $id)
            ->first();

        if (!$asignacion) {
            abort(404, 'Asignación no encontrada');
        }

        $empleado = DB::table('formulario_contratacion')
            ->where('CURP', $asignacion->CURP)
            ->select(
                'NOMBRE_COLABORADOR',
                'PRIMER_APELLIDO',
                'SEGUNDO_APELLIDO',
                'NUMERO_EMPLEADO'
            )
            ->first();



        $idsAsignaciones = json_decode($asignacion->ASIGNACIONES_ID, true);

        if (!is_array($idsAsignaciones) || empty($idsAsignaciones)) {
            abort(404, 'No hay inventarios asociados');
        }

        $inventarios = DB::table('asignaciones_inventario as ai')
            ->leftJoin(
                'formulario_inventario as fi',
                'fi.ID_FORMULARIO_INVENTARIO',
                '=',
                'ai.INVENTARIO_ID'
            )
            ->whereIn('ai.ID_ASIGNACION_FORMULARIO', $idsAsignaciones)
            ->select(
                'ai.CANTIDAD_SALIDA',
                'fi.DESCRIPCION_EQUIPO',
                'fi.MARCA_EQUIPO',
                'fi.MODELO_EQUIPO',
                'fi.SERIE_EQUIPO',
                'fi.CODIGO_EQUIPO'
            )
            ->get();

        $data = [
            'asignacion'  => $asignacion,
            'inventarios' => $inventarios,
            'empleado'    => $empleado,
        ];

        return Pdf::loadView('pdf.asignacion_equipo', $data)
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'isPhpEnabled'     => true,   // 🔥 CLAVE
                'isRemoteEnabled' => true,
                'chroot'          => public_path()
            ])
            ->stream('Asignacion_' . $asignacion->ID_ASINGACIONES_CONTRATACION . '.pdf');
    }
}