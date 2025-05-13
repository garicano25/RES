<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PowerPointController extends Controller
{
    public function descargarCredencial(Request $request)
    {
        try {
            // Obtener la CURP de la petición o de JavaScript
            $curp = $request->input('curp');

            if (empty($curp)) {
                return response()->json(['error' => 'CURP no proporcionada.'], 400);
            }

            // Ruta de la plantilla en el storage
            $rutaPlantilla = storage_path('app/CREDENCIAL/Credenciales_ID.pptx');

            if (!file_exists($rutaPlantilla)) {
                return response()->json(['error' => 'La plantilla no existe.'], 404);
            }

            // Obtener datos del empleado desde la base de datos
            $empleado = DB::table('formulario_contratacion')
                ->where('CURP', $curp)
                ->first();

            if (!$empleado) {
                return response()->json(['error' => 'No se encontró al empleado con la CURP proporcionada.'], 404);
            }

            // Obtener el cargo del empleado
            $cargo = DB::table('contratos_anexos_contratacion as cac')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'cac.NOMBRE_CARGO')
                ->where('cac.CURP', $curp)
                ->orderBy('cac.ID_CONTRATOS_ANEXOS', 'desc')
                ->select('cc.NOMBRE_CATEGORIA')
                ->first();

            $nombreCargo = $cargo ? $cargo->NOMBRE_CATEGORIA : "No disponible";

            // Generar el nombre completo
            $nombreCompleto = trim($empleado->NOMBRE_COLABORADOR . ' ' . $empleado->PRIMER_APELLIDO . ' ' . ($empleado->SEGUNDO_APELLIDO ?? ''));

            // Preparar los datos para reemplazar en la plantilla
            $datos = [
                '${NOMBRE_EMPLEADO}'   => $nombreCompleto,
                '${CARGO_EMPLEADO}'    => $nombreCargo,
                '${NUMERO_EMPLEADO}'   => $empleado->NUMERO_EMPLEADO ?? 'N/A',
                '${CURP_EMPLEADO}'     => $empleado->CURP ?? 'N/A',
                '${RFC_EMPLEADO}'      => $empleado->RFC_COLABORADOR ?? 'N/A',
                '${NUMERO_SEGURO}'     => $empleado->NSS_COLABORADOR ?? 'N/A',
                '${TIPO_SANGRE}'       => $empleado->TIPO_SANGRE ?? 'N/A',
            ];

            // Crear directorio temporal único
            $tempDir = storage_path('app/temp_' . uniqid());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Extraer el archivo .pptx (que es un archivo ZIP)
            $zip = new \ZipArchive();
            if ($zip->open($rutaPlantilla) === TRUE) {
                $zip->extractTo($tempDir);
                $zip->close();
            } else {
                return response()->json(['error' => 'No se pudo extraer la plantilla.'], 500);
            }

            // Procesamos los archivos slide*.xml donde están los textos
            $slideFiles = glob($tempDir . '/ppt/slides/slide*.xml');
            foreach ($slideFiles as $slideFile) {
                $content = file_get_contents($slideFile);

                // Reemplazar cada marcador manteniendo el formato XML original
                foreach ($datos as $marcador => $valor) {
                    $content = str_replace($marcador, $valor, $content);
                }

                // Buscar el marcador de la foto
                if (strpos($content, '${FOTO_COLABORADOR}') !== false) {
                    // Obtener el número de diapositiva del nombre del archivo
                    preg_match('/slide(\d+)\.xml$/', $slideFile, $matches);
                    $slideNumber = $matches[1];

                    // Guardar el contenido modificado sin el marcador
                    $content = str_replace('${FOTO_COLABORADOR}', '', $content);
                    file_put_contents($slideFile, $content);

                    // Buscar y reemplazar la imagen en la forma específica
                    $this->reemplazarImagenEnForma($tempDir, $curp, $slideNumber);
                } else {
                    // Guardamos el contenido modificado
                    file_put_contents($slideFile, $content);
                }
            }

            // Crear el nuevo archivo .pptx
            $outputFile = storage_path('app/credencial_' . $curp . '_' . uniqid() . '.pptx');
            $zip = new \ZipArchive();
            if ($zip->open($outputFile, \ZipArchive::CREATE) === TRUE) {
                // Añadir todos los archivos del directorio temporal
                $this->addFolderToZip($tempDir, $zip, $tempDir);
                $zip->close();
            } else {
                return response()->json(['error' => 'No se pudo crear el archivo de salida.'], 500);
            }

            // Limpiar el directorio temporal
            $this->removeDirectory($tempDir);

            // Descargar el archivo
            return response()->download($outputFile, 'credencial_' . $curp . '.pptx')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error('Error al procesar la presentación: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un problema al generar la presentación: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Función para reemplazar la imagen dentro de una forma específica en PowerPoint
     */
    private function reemplazarImagenEnForma($tempDir, $curp, $slideNumber)
    {
        try {
            // Ruta de la imagen del colaborador en el storage
            $rutaImagen = "reclutamiento/{$curp}/IMAGEN COLABORADOR/foto_usuario.png";

            // Verificar si la imagen existe
            if (!Storage::exists($rutaImagen)) {
                \Log::warning("No se encontró la imagen del colaborador: {$rutaImagen}");
                return false;
            }

            // Obtener el contenido de la imagen
            $imagenContenido = Storage::get($rutaImagen);

            // Ruta para guardar la imagen temporalmente
            $tempImagePath = $tempDir . '/imagen_temp.png';
            file_put_contents($tempImagePath, $imagenContenido);

            // Obtener las dimensiones de la imagen
            list($width, $height) = getimagesize($tempImagePath);

            // Preparar la nueva imagen (forma circular) que reemplazará la existente
            // Vamos a reemplazar la imagen dentro de un blip (el contenedor de imágenes en OOXML)

            // Archivo de relaciones de la diapositiva
            $relsFile = $tempDir . '/ppt/slides/_rels/slide' . $slideNumber . '.xml.rels';
            $slideRels = file_get_contents($relsFile);

            // Archivo de la diapositiva
            $slideFile = $tempDir . '/ppt/slides/slide' . $slideNumber . '.xml';
            $slideContent = file_get_contents($slideFile);

            // Determinar si la forma tiene un relleno de imagen existente o si necesitamos crear uno nuevo

            // 1. Primero, buscar la forma que contiene el marcador (ahora vacío porque lo reemplazamos arriba)
            // Buscar elementos <p:sp> (formas) que tengan alguna característica que los identifique
            // como nuestra forma de destino (ej: una forma circular o que contenía el marcador)

            // La imagen puede estar en una forma que antes contenía el marcador ${FOTO_COLABORADOR}
            // O puede estar en un elemento <p:pic> que ya contenga una imagen

            // Identificar la forma que queremos modificar
            $foundShape = false;

            // Buscar primero en las formas <p:sp> que podrían contener nuestra forma circular
            if (preg_match('/<p:sp[^>]*>.*?<a:t>.*?<\/a:t>.*?<\/p:sp>/s', $slideContent, $shapeMatch)) {
                $foundShape = true;

                // Generar un nuevo ID de relación
                $newRelId = 'rId' . (substr_count($slideRels, 'Id="rId') + 1);

                // Copiar la imagen al directorio de medios
                // Crear un nombre único para la imagen
                $newMediaFileName = 'image' . (count(glob($tempDir . '/ppt/media/image*.png')) + 1) . '.png';
                $newMediaPath = $tempDir . '/ppt/media/' . $newMediaFileName;

                // Crear la carpeta de medios si no existe
                if (!is_dir($tempDir . '/ppt/media')) {
                    mkdir($tempDir . '/ppt/media', 0755, true);
                }

                // Copiar la imagen a la carpeta de medios
                copy($tempImagePath, $newMediaPath);

                // Añadir la nueva relación al archivo de relaciones
                $newRelationship = '<Relationship Id="' . $newRelId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $newMediaFileName . '"/>';
                $slideRels = str_replace('</Relationships>', $newRelationship . '</Relationships>', $slideRels);
                file_put_contents($relsFile, $slideRels);

                // Modificar la forma para que use la imagen como relleno
                // Buscar la sección de propiedades de la forma
                if (preg_match('/<p:spPr>(.*?)<\/p:spPr>/s', $shapeMatch[0], $propMatch)) {
                    $newProps = $propMatch[1];

                    // Verificar si ya tiene un relleno y reemplazarlo o agregar uno nuevo
                    if (strpos($newProps, '<a:solidFill>') !== false) {
                        // Reemplazar el relleno sólido con un relleno de imagen
                        $newProps = preg_replace(
                            '/<a:solidFill>.*?<\/a:solidFill>/s',
                            '<a:blipFill><a:blip r:embed="' . $newRelId . '"/><a:stretch><a:fillRect/></a:stretch></a:blipFill>',
                            $newProps
                        );
                    } else {
                        // Agregar un nuevo relleno de imagen
                        $newProps .= '<a:blipFill><a:blip r:embed="' . $newRelId . '"/><a:stretch><a:fillRect/></a:stretch></a:blipFill>';
                    }

                    // Reemplazar las propiedades originales con las nuevas
                    $newShapeContent = str_replace($propMatch[0], '<p:spPr>' . $newProps . '</p:spPr>', $shapeMatch[0]);
                    $slideContent = str_replace($shapeMatch[0], $newShapeContent, $slideContent);
                }
            }

            // Si no encontramos una forma adecuada, busquemos imágenes existentes para reemplazar
            if (!$foundShape) {
                // Buscar todas las imágenes en la diapositiva
                if (preg_match_all('/<p:pic[^>]*>.*?<a:blip r:embed="(rId\d+)".*?<\/p:pic>/s', $slideContent, $picMatches, PREG_SET_ORDER)) {
                    foreach ($picMatches as $picMatch) {
                        $rId = $picMatch[1];

                        // Buscar este rId en el archivo .rels
                        if (preg_match('/<Relationship Id="' . $rId . '" [^>]*Target="..\/media\/([^"]+)"/', $slideRels, $targetMatch)) {
                            $imageFile = $tempDir . '/ppt/media/' . $targetMatch[1];

                            // Reemplazar la imagen existente
                            file_put_contents($imageFile, $imagenContenido);
                            $foundShape = true;
                            break;
                        }
                    }
                }
            }

            // Si aún no encontramos dónde colocar la imagen, agregar una nueva imagen a la diapositiva
            if (!$foundShape) {
                // Este es un caso de fallback si no encontramos ninguna forma o imagen para reemplazar
                // Tendríamos que insertar una nueva imagen en la diapositiva

                // Generar un nuevo ID de relación
                $newRelId = 'rId' . (substr_count($slideRels, 'Id="rId') + 1);

                // Copiar la imagen al directorio de medios
                $newMediaFileName = 'image' . (count(glob($tempDir . '/ppt/media/image*.png')) + 1) . '.png';
                $newMediaPath = $tempDir . '/ppt/media/' . $newMediaFileName;

                // Crear la carpeta de medios si no existe
                if (!is_dir($tempDir . '/ppt/media')) {
                    mkdir($tempDir . '/ppt/media', 0755, true);
                }

                // Copiar la imagen a la carpeta de medios
                copy($tempImagePath, $newMediaPath);

                // Añadir la nueva relación al archivo de relaciones
                $newRelationship = '<Relationship Id="' . $newRelId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $newMediaFileName . '"/>';
                $slideRels = str_replace('</Relationships>', $newRelationship . '</Relationships>', $slideRels);
                file_put_contents($relsFile, $slideRels);

                // Crear una nueva imagen en la diapositiva
                $newPicXml = $this->createNewPictureXml($newRelId, $width, $height);

                // Insertar la nueva imagen en la diapositiva antes del cierre de p:spTree
                $slideContent = preg_replace('/<\/p:spTree>/', $newPicXml . '</p:spTree>', $slideContent);
            }

            // Guardar los cambios en el archivo de la diapositiva
            file_put_contents($slideFile, $slideContent);

            // Eliminar la imagen temporal
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Error al reemplazar la imagen en la forma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crea el XML para una nueva imagen en la diapositiva
     */
    private function createNewPictureXml($relId, $width, $height)
    {
        // Convertir dimensiones de píxeles a EMU (English Metric Units)
        // 1 pulgada = 914400 EMU, y 1 pulgada = 96 píxeles (en pantalla)
        $emuWidth = round($width * 9525);  // 9525 = 914400/96
        $emuHeight = round($height * 9525);

        // Centrar la imagen en la diapositiva
        // Asumiendo tamaño estándar de diapositiva (10 pulgadas x 7.5 pulgadas)
        $slideWidth = 9144000;  // 10 pulgadas en EMU
        $slideHeight = 6858000; // 7.5 pulgadas en EMU

        $xPos = ($slideWidth - $emuWidth) / 2;
        $yPos = ($slideHeight - $emuHeight) / 2;

        // XML para la imagen
        return '<p:pic>
            <p:nvPicPr>
                <p:cNvPr id="' . (1000 + rand(1, 9000)) . '" name="Foto Colaborador"/>
                <p:cNvPicPr/>
                <p:nvPr/>
            </p:nvPicPr>
            <p:blipFill>
                <a:blip r:embed="' . $relId . '"/>
                <a:stretch>
                    <a:fillRect/>
                </a:stretch>
            </p:blipFill>
            <p:spPr>
                <a:xfrm>
                    <a:off x="' . $xPos . '" y="' . $yPos . '"/>
                    <a:ext cx="' . $emuWidth . '" cy="' . $emuHeight . '"/>
                </a:xfrm>
                <a:prstGeom prst="ellipse">
                    <a:avLst/>
                </a:prstGeom>
            </p:spPr>
        </p:pic>';
    }

    /**
     * Función auxiliar para añadir un directorio completo a un archivo ZIP
     */
    private function addFolderToZip($folder, $zipFile, $basePath)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($basePath) + 1);
                $zipFile->addFile($filePath, $relativePath);
            }
        }
    }

    /**
     * Función auxiliar para eliminar un directorio y su contenido
     */
    private function removeDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->removeDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
