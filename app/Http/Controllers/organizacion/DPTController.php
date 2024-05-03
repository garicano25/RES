<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use App\Models\organizacion\DPTModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importar la clase Storage

class DPTController extends Controller
{
    public function guardar(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'NOMBRE_PUESTO' => 'required|string',
            'ARCHIVO_DPT' => 'required|mimes:xls,xlsx'
        ]);

        try {
            // Guardar el archivo en el servidor
            $file = $request->file('ARCHIVO_DPT');
            $file->move('DPT_EXCEL', $file->getClientOriginalName());

            // Insertar los datos en la tabla "PPT"
            DPTModel::create([
                'NOMBRE_PUESTO' => $request->input('NOMBRE_PUESTO'),
                'ARCHIVO_DPT' => $file->getClientOriginalName()
            ]);

            // Devolver una respuesta JSON indicando que los datos se han guardado
            return redirect()->back()->with('success', 'Datos guardados correctamente.');
        } catch (\Exception $e) {
            // Mostrar alerta de error
            return response()->json(['error' => 'Error al guardar los datos. Por favor, inténtalo de nuevo.'], 500);
        }
    }
    

    public function getAllData_DPT()
    {
        $data = DPTModel::all();
        return view('RH.organizacion.DPT', compact('data'));
    }


    public function verExcel($id)
    {
        $dpt = DPTModel::find($id);
    
        if (!$dpt) {
            abort(404); // Mostrar página de error si no se encuentra el registro
        }
    
        $archivoPath = public_path("DPT_EXCEL/{$dpt->ARCHIVO_DPT}");
    
        // Verificar la existencia del archivo
        if (!file_exists($archivoPath)) {
            abort(404); // Mostrar página de error si el archivo no existe
        }
    
        // Leer el contenido del archivo Excel
        $contenido = file_get_contents($archivoPath);
    
        return response()->json(['excel' => base64_encode($contenido)]);
    }
    

    public function eliminar($id)
    {
        // Buscar el registro por su ID
        $registro = DPTModel::find($id);
    
        if (!$registro) {
            return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
        }
    
        try {
            // Eliminar el registro
            $registro->delete();
    
            return response()->json(['success' => true, 'message' => 'Registro eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el registro: ' . $e->getMessage()], 500);
        }
    }
}
