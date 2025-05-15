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

                // Guardamos el contenido modificado
                file_put_contents($slideFile, $content);
            }

            // Procesar la imagen del colaborador en una función separada
            $this->reemplazarFotoColaborador($tempDir, $curp);

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
     * Función para reemplazar la foto del colaborador manteniendo la forma circular
     */
    /**
     * Función para reemplazar la foto del colaborador manteniendo la forma circular
     */
    private function reemplazarFotoColaborador($tempDir, $curp)
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

            // Buscar en todas las diapositivas el texto ${FOTO_COLABORADOR}
            $slideFiles = glob($tempDir . '/ppt/slides/slide*.xml');
            $marcador = '${FOTO_COLABORADOR}';
            $encontrado = false;

            // Primero, buscar en cada diapositiva y mostrar el contenido para depuración
            foreach ($slideFiles as $slideFile) {
                $slideContent = file_get_contents($slideFile);
                preg_match('/slide(\d+)\.xml/', $slideFile, $matches);
                $slideNumber = $matches[1];

                if (strpos($slideContent, $marcador) !== false) {
                    \Log::info("¡Marcador encontrado en slide{$slideNumber}.xml!");
                    $encontrado = true;

                    // Guardar el contenido XML para inspección (solo en entorno de desarrollo)
                    Storage::put("debug/slide{$slideNumber}.xml", $slideContent);

                    // Directorio de medios
                    $mediaDir = $tempDir . '/ppt/media';
                    if (!file_exists($mediaDir)) {
                        mkdir($mediaDir, 0755, true);
                    }

                    // Guardar la foto con un nombre predecible
                    $nuevaImagenNombre = 'foto_empleado_' . $slideNumber . '.png';
                    $nuevaImagenRuta = $mediaDir . '/' . $nuevaImagenNombre;
                    file_put_contents($nuevaImagenRuta, $imagenContenido);

                    // Ruta del archivo de relaciones
                    $relsFile = $tempDir . '/ppt/slides/_rels/slide' . $slideNumber . '.xml.rels';
                    if (!file_exists(dirname($relsFile))) {
                        mkdir(dirname($relsFile), 0755, true);
                    }

                    // Crear o actualizar el archivo de relaciones
                    $nuevoRelId = 'rId' . (900 + $slideNumber); // Usar un ID alto para evitar conflictos
                    if (file_exists($relsFile)) {
                        $relsContent = file_get_contents($relsFile);

                        // Verificar si ya existe la relación
                        if (strpos($relsContent, $nuevaImagenNombre) === false) {
                            // Añadir nueva relación
                            $relsContent = str_replace(
                                '</Relationships>',
                                '  <Relationship Id="' . $nuevoRelId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $nuevaImagenNombre . '"/>
</Relationships>',
                                $relsContent
                            );
                        } else {
                            // Extraer el ID existente si ya hay una relación con esta imagen
                            preg_match('/Id="(rId[^"]+)" [^>]*Target="[^"]*' . preg_quote($nuevaImagenNombre, '/') . '"/', $relsContent, $idMatch);
                            if (!empty($idMatch)) {
                                $nuevoRelId = $idMatch[1];
                            }
                        }
                    } else {
                        // Crear nuevo archivo de relaciones
                        $relsContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="' . $nuevoRelId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $nuevaImagenNombre . '"/>
</Relationships>';
                    }

                    // Guardar el archivo de relaciones
                    file_put_contents($relsFile, $relsContent);

                    // Método alternativo: buscar cualquier elemento que contenga el marcador
                    if (preg_match_all('/<a:t[^>]*>([^<]*' . preg_quote($marcador, '/') . '[^<]*)<\/a:t>/s', $slideContent, $matches, PREG_OFFSET_CAPTURE)) {
                        \Log::info("Encontrados " . count($matches[0]) . " textos con el marcador");

                        foreach ($matches[0] as $index => $match) {
                            $textoCompleto = $match[0];
                            $posicion = $match[1];

                            // Buscar el elemento p:sp (forma) que contiene este texto
                            $posicionAnterior = $posicion;
                            $posicionInicio = strrpos(substr($slideContent, 0, $posicionAnterior), '<p:sp');
                            if ($posicionInicio !== false) {
                                $posicionFin = strpos($slideContent, '</p:sp>', $posicionAnterior);
                                if ($posicionFin !== false) {
                                    $shapeXml = substr($slideContent, $posicionInicio, $posicionFin - $posicionInicio + 6);

                                    // Extraer la sección spPr (propiedades de forma)
                                    preg_match('/<p:spPr[^>]*>.*?<\/p:spPr>/s', $shapeXml, $spPrMatch);
                                    $spPrXml = $spPrMatch[0] ?? '';

                                    // Extraer solo la parte de posición y tamaño
                                    preg_match('/<a:xfrm>.*?<\/a:xfrm>/s', $spPrXml, $xfrmMatch);
                                    $xfrmXml = $xfrmMatch[0] ?? '<a:xfrm><a:off x="3048000" y="1524000"/><a:ext cx="3048000" cy="3048000"/></a:xfrm>';

                                    // Modificar el contenido de la forma para usar la imagen como relleno
                                    $modifiedSpPr = '<p:spPr>
    ' . $xfrmXml . '
    <a:prstGeom prst="ellipse">
        <a:avLst/>
    </a:prstGeom>
    <a:blipFill rotWithShape="1">
        <a:blip r:embed="' . $nuevoRelId . '">
            <a:lum/>
        </a:blip>
        <a:srcRect/>
        <a:stretch>
            <a:fillRect/>
        </a:stretch>
    </a:blipFill>
</p:spPr>';

                                    // Reemplazar la sección spPr en la forma original
                                    $modifiedShapeXml = preg_replace('/<p:spPr[^>]*>.*?<\/p:spPr>/s', $modifiedSpPr, $shapeXml);

                                    // Reemplazar el texto marcador con texto vacío
                                    $modifiedShapeXml = str_replace($textoCompleto, '<a:t></a:t>', $modifiedShapeXml);

                                    // Asegurar que tenemos el namespace de relaciones
                                    if (strpos($slideContent, 'xmlns:r=') === false) {
                                        $slideContent = preg_replace('/<p:sld([^>]*)>/', '<p:sld$1 xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">', $slideContent);
                                    }

                                    // Finalmente reemplazar la forma original con nuestra forma modificada
                                    $slideContent = substr_replace($slideContent, $modifiedShapeXml, $posicionInicio, $posicionFin - $posicionInicio + 6);
                                    file_put_contents($slideFile, $slideContent);

                                    \Log::info("Se ha reemplazado la forma con la imagen del colaborador");
                                    return true;
                                }
                            }
                        }
                    } else {
                        \Log::warning("El marcador se encontró en el contenido pero no se pudo extraer con regex");
                    }

                    // Método directo: buscar y reemplazar el texto XML completo
                    $xmlAnterior = file_get_contents($slideFile);

                    // Asegurar que tenemos el namespace de relaciones
                    if (strpos($xmlAnterior, 'xmlns:r=') === false) {
                        $xmlAnterior = preg_replace('/<p:sld([^>]*)>/', '<p:sld$1 xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">', $xmlAnterior);
                    }

                    // Reemplazar la referencia completa
                    $xmlModificado = $xmlAnterior; // Copia para modificar

                    // Identificar la forma circular que contiene el marcador y modificarla
                    if (preg_match('/<p:sp[^>]*>.*?' . preg_quote($marcador, '/') . '.*?<\/p:sp>/s', $xmlAnterior, $formaMatch)) {
                        $formaOriginal = $formaMatch[0];

                        // Extraer posición y tamaño
                        preg_match('/<a:xfrm>.*?<\/a:xfrm>/s', $formaOriginal, $xfrmMatch);
                        $xfrmXml = $xfrmMatch[0] ?? '<a:xfrm><a:off x="3048000" y="1524000"/><a:ext cx="3048000" cy="3048000"/></a:xfrm>';

                        // Crear una nueva forma con la imagen
                        $nuevaForma = '<p:sp>
  <p:nvSpPr>
    <p:cNvPr id="' . rand(1000, 9999) . '" name="Foto Colaborador">
      <a:extLst/>
    </p:cNvPr>
    <p:cNvSpPr/>
    <p:nvPr/>
  </p:nvSpPr>
  <p:spPr>
    ' . $xfrmXml . '
    <a:prstGeom prst="ellipse">
      <a:avLst/>
    </a:prstGeom>
    <a:blipFill rotWithShape="1">
      <a:blip r:embed="' . $nuevoRelId . '">
        <a:lum/>
      </a:blip>
      <a:srcRect/>
      <a:stretch>
        <a:fillRect/>
      </a:stretch>
    </a:blipFill>
  </p:spPr>
  <p:txBody>
    <a:bodyPr rtlCol="0" anchor="ctr"/>
    <a:lstStyle/>
    <a:p>
      <a:pPr algn="ctr"/>
      <a:r>
        <a:rPr lang="es-ES" altLang="en-US" smtClean="0"/>
        <a:t></a:t>
      </a:r>
      <a:endParaRPr lang="es-ES" altLang="en-US"/>
    </a:p>
  </p:txBody>
</p:sp>';

                        // Reemplazar la forma original con la nueva
                        $xmlModificado = str_replace($formaOriginal, $nuevaForma, $xmlAnterior);
                        file_put_contents($slideFile, $xmlModificado);

                        \Log::info("Se ha reemplazado la forma con método directo");
                        return true;
                    }
                }
            }

            if (!$encontrado) {
                \Log::warning("No se encontró ninguna diapositiva con el marcador ${FOTO_COLABORADOR}");

                // Verificar si hay algún otro texto similar que pueda estar causando confusión
                foreach ($slideFiles as $slideFile) {
                    $slideContent = file_get_contents($slideFile);
                    if (stripos($slideContent, 'FOTO') !== false || stripos($slideContent, 'COLABORADOR') !== false) {
                        preg_match('/slide(\d+)\.xml/', $slideFile, $matches);
                        $slideNumber = $matches[1];
                        \Log::info("Se encontró texto relacionado en slide{$slideNumber}.xml");

                        // Extraer textos que contengan FOTO o COLABORADOR para depuración
                        preg_match_all('/<a:t[^>]*>([^<]*(?:FOTO|COLABORADOR)[^<]*)<\/a:t>/si', $slideContent, $matches);
                        if (!empty($matches[1])) {
                            foreach ($matches[1] as $match) {
                                \Log::info("Texto encontrado: " . $match);
                            }
                        }
                    }
                }

                return false;
            }
        } catch (\Exception $e) {
            \Log::error("Error al reemplazar la foto del colaborador: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
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
