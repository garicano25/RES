<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use App\Models\organizacion\PPTModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importar la clase Storage

class PPTController extends Controller
{
    public function upload(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'NOMBRE_PUESTO' => 'required|string',
            'ARCHIVO_PPT' => 'required|mimes:xls,xlsx'
        ]);

        try {
            // Guardar el archivo en el servidor
            $file = $request->file('ARCHIVO_PPT');
            $file->move('uploads', $file->getClientOriginalName());

            // Insertar los datos en la tabla "PPT"
            PPTModel::create([
                'NOMBRE_PUESTO' => $request->input('NOMBRE_PUESTO'),
                'ARCHIVO_PPT' => $file->getClientOriginalName()
            ]);

            // Devolver una respuesta JSON indicando que los datos se han guardado
            return response()->json(['message' => 'Datos guardados correctamente.']);
        } catch (\Exception $e) {
            // Mostrar alerta de error
            return response()->json(['error' => 'Error al guardar los datos. Por favor, inténtalo de nuevo.'], 500);
        }
    }
    


    public function getAllData()
    {
        $data = PPTModel::all();
        return view('RH.organizacion.PPT', compact('data'));
    }

    public function verExcel($id)
    {
        $ppt = PPTModel::find($id);
    
        if (!$ppt) {
            abort(404); // Mostrar página de error si no se encuentra el registro
        }
    
        $archivoPath = public_path("uploads/{$ppt->ARCHIVO_PPT}");
    
        // Verificar la existencia del archivo
        if (!file_exists($archivoPath)) {
            abort(404); // Mostrar página de error si el archivo no existe
        }
    
        // Leer el contenido del archivo Excel
        $contenido = file_get_contents($archivoPath);
    
        return response()->json(['excel' => base64_encode($contenido)]);
    }
    
    
}
