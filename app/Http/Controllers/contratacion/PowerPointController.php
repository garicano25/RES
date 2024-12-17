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
    // Ruta de la plantilla en el storage
    $rutaPlantilla = storage_path('app/CREDENCIAL/ID_RIP.pptx'); 

    if (!file_exists($rutaPlantilla)) {
        return response()->json(['error' => 'La plantilla no existe.'], 404);
    }

    // Cargar la plantilla
    $pptReader = IOFactory::createReader('PowerPoint2007');
    $presentation = $pptReader->load($rutaPlantilla);

    // Datos dinámicos
    $nombreEmpleado = "Juan Pérez";
    $cargoEmpleado = "Analista de Datos";
    $numeroEmpleado = "12345";
    $correoEmpleado = "juan.perez@ejemplo.com";
    $numeroSeguro = "67890";
    $tipoSangre = "O+";

    // Reemplazar los marcadores en la plantilla
    $slides = $presentation->getAllSlides();
    $slide = $slides[0];

    // Recorrer todas las formas de la diapositiva
    foreach ($slide->getShapeCollection() as $shape) {
        // Verificar si el shape es de tipo RichText
        if ($shape instanceof \PhpOffice\PhpPresentation\Shape\RichText) {
            foreach ($shape->getParagraphs() as $paragraph) {
                foreach ($paragraph->getRichTextElements() as $textElement) {
                    if ($textElement instanceof \PhpOffice\PhpPresentation\Shape\RichText\Run) {
                        $text = $textElement->getText();

                        // Reemplazar marcadores con datos dinámicos
                        $text = str_replace('${NOMBRE_EMPLEADO}', $nombreEmpleado, $text);
                        $text = str_replace('${CARGO_EMPLEADO}', $cargoEmpleado, $text);
                        $text = str_replace('${NUMERO_EMPLEADO}', $numeroEmpleado, $text);
                        $text = str_replace('${CORREO_EMPLEADO}', $correoEmpleado, $text);
                        $text = str_replace('${NUMERO_SEGURO}', $numeroSeguro, $text);
                        $text = str_replace('${TIPO_SANGRE}', $tipoSangre, $text);

                        // Establecer el texto modificado
                        $textElement->setText($text);
                    }
                }
            }
        }

    }

    // Guardar el archivo generado en el storage temporal
    $nombreArchivo = 'credencial_' . time() . '.pptx';
    $rutaSalida = storage_path('app/temp/' . $nombreArchivo);

    $pptWriter = IOFactory::createWriter($presentation, 'PowerPoint2007');
    $pptWriter->save($rutaSalida);

    // Descargar el archivo generado
    return response()->download($rutaSalida)->deleteFileAfterSend(true);
}
    
   
    
    
}
