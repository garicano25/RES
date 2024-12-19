<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Style\Shadow;
use PhpOffice\PhpPresentation\Shape\RichText\Run;

class PowerPointController extends Controller
{
 
    public function descargarCredencial()
{
    try {
        // Ruta de la plantilla en el storage
        $rutaPlantilla = storage_path('app/CREDENCIAL/ID_RIP.pptx');

        if (!file_exists($rutaPlantilla)) {
            return response()->json(['error' => 'La plantilla no existe.'], 404);
        }

        // Cargar la plantilla
        $pptReader = IOFactory::createReader('PowerPoint2007');
        $presentation = $pptReader->load($rutaPlantilla);

        // Datos dinámicos
        $datos = [
            '${NOMBRE_EMPLEADO}' => "Juan Pérez",
            '${CARGO_EMPLEADO}' => "Analista de Datos",
            '${NUMERO_EMPLEADO}' => "12345",
            '${CORREO_EMPLEADO}' => "juan.perez@ejemplo.com",
            '${NUMERO_SEGURO}' => "67890",
            '${TIPO_SANGRE}' => "O+",
        ];

        // Reemplazar los marcadores en la plantilla
        $slides = $presentation->getAllSlides();
        foreach ($slides as $slide) {
            foreach ($slide->getShapeCollection() as $shape) {
                if ($shape instanceof \PhpOffice\PhpPresentation\Shape\RichText) {
                    foreach ($shape->getParagraphs() as $paragraph) {
                        foreach ($paragraph->getRichTextElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpPresentation\Shape\RichText\Run) {
                                // Reemplazar marcadores
                                $texto = $textElement->getText();
                                foreach ($datos as $marcador => $valor) {
                                    $texto = str_replace($marcador, $valor, $texto);
                                }
                                $textElement->setText($texto);
                            }
                        }
                    }
                }
            }
        }

        // Generar el archivo en memoria
        $response = response()->stream(function () use ($presentation) {
            $pptWriter = IOFactory::createWriter($presentation, 'PowerPoint2007');
            $pptWriter->save('php://output'); // Enviar directamente al flujo de salida
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'Content-Disposition' => 'attachment; filename="credencial_generada.pptx"',
        ]);

        return $response;

    } catch (\Exception $e) {
        \Log::error('Error al procesar la presentación: ' . $e->getMessage());
        return response()->json(['error' => 'Ocurrió un problema al generar la presentación.'], 500);
    }
}

    

    
    
}
