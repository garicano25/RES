<?php

namespace App\Http\Controllers;

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;

class TestController extends Controller
{
    public function prueba()
    {
        // Crear una presentación para verificar funcionalidad
        $presentation = new PhpPresentation();
        $slide = $presentation->getActiveSlide();
        $shape = $slide->createRichTextShape();
        $shape->setHeight(100)->setWidth(600)->setOffsetX(170)->setOffsetY(180);
        $shape->createTextRun('¡Hola, PhpPresentation está funcionando!')->getFont()->setBold(true)->setSize(24);

        // Guardar archivo en storage
        $path = storage_path('app/test.pptx');
        $writer = IOFactory::createWriter($presentation, 'PowerPoint2007');
        $writer->save($path);

        return response()->download($path);
    }


    
    public function editarPlantilla()
{
    // Ruta de la plantilla existente
    $templatePath = storage_path('app/CREDENCIA/ID_RIP.pptx');

    // Validar si la plantilla existe
    if (!file_exists($templatePath)) {
        return response()->json(['error' => 'La plantilla no existe.'], 404);
    }

    // Cargar la plantilla de PowerPoint
    $pptReader = IOFactory::createReader('PowerPoint2007');
    try {
        $presentation = $pptReader->load($templatePath);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al cargar la plantilla: ' . $e->getMessage()], 500);
    }

    // Iterar sobre todas las diapositivas
    foreach ($presentation->getAllSlides() as $slideIndex => $slide) {
        foreach ($slide->getShapeCollection() as $shapeIndex => $shape) {
            try {
                // Configurar una sombra predeterminada para todos los shapes
                if ($shape->getShadow() === null) {
                    $defaultShadow = new \PhpOffice\PhpPresentation\Style\Shadow();
                    $defaultShadow->setDistance(0); // Sin desplazamiento
                    $defaultShadow->setBlurRadius(0); // Sin desenfoque
                    $defaultShadow->setDirection(0); // Sin dirección
                    $defaultShadow->setColor(new \PhpOffice\PhpPresentation\Style\Color('000000')); // Color negro
                    $shape->setShadow($defaultShadow);
                }

                // Si el shape es RichText, modificarlo
                if ($shape instanceof \PhpOffice\PhpPresentation\Shape\RichText) {
                    foreach ($shape->getParagraphs() as $paragraph) {
                        foreach ($paragraph->getRichTextElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpPresentation\Shape\RichText\Run) {
                                $text = $textElement->getText();

                                // Reemplazar texto dinámico
                                $text = str_replace('${NOMBRE_EMPLEADO}', 'Juan Pérez', $text);
                                $text = str_replace('${CARGO_EMPLEADO}', 'Analista de Datos', $text);

                                // Establecer el texto actualizado
                                $textElement->setText($text);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                error_log("Error procesando shape en slide {$slideIndex}, shape {$shapeIndex}: " . $e->getMessage());
            }
        }
    }

    // Guardar el archivo modificado
    $outputPath = storage_path('app/plantilla_modificada.pptx');
    try {
        $pptWriter = IOFactory::createWriter($presentation, 'PowerPoint2007');
        $pptWriter->save($outputPath);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al guardar la presentación: ' . $e->getMessage()], 500);
    }

    // Descargar el archivo modificado
    return response()->download($outputPath)->deleteFileAfterSend(true);
}

    
    


}
