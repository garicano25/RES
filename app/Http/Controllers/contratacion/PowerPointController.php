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
            // Añadir logs detallados para depuración en producción
            \Log::info("Iniciando reemplazo de foto para CURP: {$curp}");
            \Log::info("Directorio temporal: {$tempDir}");

            // Ruta de la imagen del colaborador en el storage
            $rutaImagen = "reclutamiento/{$curp}/IMAGEN COLABORADOR/foto_usuario.png";
            \Log::info("Buscando imagen en: {$rutaImagen}");

            // Verificar si la imagen existe usando ruta absoluta para depuración
            $rutaAbsoluta = Storage::path($rutaImagen);
            \Log::info("Ruta absoluta de la imagen: {$rutaAbsoluta}");

            if (!Storage::exists($rutaImagen)) {
                \Log::warning("No se encontró la imagen del colaborador: {$rutaImagen}");

                // Verificar si existe el directorio
                $directorioBase = "reclutamiento/{$curp}/IMAGEN COLABORADOR";
                if (Storage::exists($directorioBase)) {
                    $archivos = Storage::files($directorioBase);
                    \Log::info("Archivos encontrados en el directorio: " . json_encode($archivos));
                } else {
                    \Log::warning("El directorio {$directorioBase} no existe");
                }

                // Intentar con una imagen de respaldo
                $rutaImagen = "reclutamiento/{$curp}/IMAGEN COLABORADOR/foto.png";
                if (!Storage::exists($rutaImagen)) {
                    $rutaImagen = "reclutamiento/{$curp}/IMAGEN COLABORADOR/foto.jpg";
                    if (!Storage::exists($rutaImagen)) {
                        $rutaImagen = "reclutamiento/{$curp}/foto_usuario.png";
                        if (!Storage::exists($rutaImagen)) {
                            // Usar una imagen genérica como último recurso
                            $rutaImagen = "assets/img/placeholder_user.png";
                            if (!Storage::exists($rutaImagen)) {
                                \Log::error("No se pudo encontrar ninguna imagen válida para el usuario");
                                return false;
                            }
                        }
                    }
                }
                \Log::info("Se utilizará la imagen alternativa: {$rutaImagen}");
            }

            // Obtener el contenido de la imagen con manejo de errores
            try {
                $imagenContenido = Storage::get($rutaImagen);
                \Log::info("Imagen cargada correctamente, tamaño: " . strlen($imagenContenido) . " bytes");
            } catch (\Exception $e) {
                \Log::error("Error al cargar la imagen: " . $e->getMessage());
                return false;
            }

            // Verificar directorios y permisos
            \Log::info("Verificando directorios y permisos en el directorio temporal");
            if (!is_writable($tempDir)) {
                \Log::error("El directorio temporal no tiene permisos de escritura: {$tempDir}");
                // Intentar corregir los permisos
                chmod($tempDir, 0755);
                if (!is_writable($tempDir)) {
                    \Log::error("No se pudieron corregir los permisos del directorio temporal");
                    return false;
                }
            }

            // Buscar en todas las diapositivas
            $slideFiles = glob($tempDir . '/ppt/slides/slide*.xml');
            \Log::info("Archivos de diapositivas encontrados: " . count($slideFiles));

            foreach ($slideFiles as $slideFile) {
                \Log::info("Procesando archivo: {$slideFile}");

                if (!file_exists($slideFile)) {
                    \Log::warning("El archivo de diapositiva no existe: {$slideFile}");
                    continue;
                }

                if (!is_readable($slideFile)) {
                    \Log::warning("El archivo de diapositiva no se puede leer: {$slideFile}");
                    continue;
                }

                // Obtener el contenido con manejo de errores
                try {
                    $slideContent = file_get_contents($slideFile);
                    $slideSize = strlen($slideContent);
                    \Log::info("Contenido de diapositiva cargado, tamaño: {$slideSize} bytes");
                } catch (\Exception $e) {
                    \Log::error("Error al leer el archivo de diapositiva {$slideFile}: " . $e->getMessage());
                    continue;
                }

                // Verificar si contiene el marcador usando múltiples métodos
                $marcador = '${FOTO_COLABORADOR}';
                $encontrado = false;

                // Método 1: Búsqueda directa
                if (strpos($slideContent, $marcador) !== false) {
                    \Log::info("Marcador encontrado con búsqueda directa");
                    $encontrado = true;
                }
                // Método 2: Búsqueda con HTML entities
                else if (strpos($slideContent, htmlentities($marcador)) !== false) {
                    \Log::info("Marcador encontrado con HTML entities");
                    $marcador = htmlentities($marcador);
                    $encontrado = true;
                }
                // Método 3: Búsqueda insensible a mayúsculas/minúsculas
                else if (stripos($slideContent, $marcador) !== false) {
                    \Log::info("Marcador encontrado con búsqueda insensible a mayúsculas/minúsculas");
                    // Buscar el texto real para reemplazar
                    preg_match('/\${FOTO_COLABORADOR}/i', $slideContent, $matches);
                    if (!empty($matches[0])) {
                        $marcador = $matches[0];
                        $encontrado = true;
                    }
                }

                if ($encontrado) {
                    // Extraer número de diapositiva para nombres únicos
                    preg_match('/slide(\d+)\.xml/', $slideFile, $matches);
                    $slideNumber = $matches[1];
                    \Log::info("Procesando diapositiva número: {$slideNumber}");

                    // Crear directorio de medios si no existe
                    $mediaDir = $tempDir . '/ppt/media';
                    if (!file_exists($mediaDir)) {
                        \Log::info("Creando directorio de medios: {$mediaDir}");
                        if (!mkdir($mediaDir, 0755, true)) {
                            \Log::error("No se pudo crear el directorio de medios");
                            return false;
                        }
                    }

                    // Guardar la imagen en el directorio de medios
                    $nuevaImagenNombre = 'foto_empleado_' . $slideNumber . '.png';
                    $nuevaImagenRuta = $mediaDir . '/' . $nuevaImagenNombre;
                    \Log::info("Guardando imagen en: {$nuevaImagenRuta}");

                    try {
                        if (file_put_contents($nuevaImagenRuta, $imagenContenido) === false) {
                            \Log::error("Error al guardar la imagen en el directorio de medios");
                            return false;
                        }
                    } catch (\Exception $e) {
                        \Log::error("Excepción al guardar la imagen: " . $e->getMessage());
                        return false;
                    }

                    // Crear directorio de relaciones si no existe
                    $relsDir = $tempDir . '/ppt/slides/_rels';
                    if (!file_exists($relsDir)) {
                        \Log::info("Creando directorio de relaciones: {$relsDir}");
                        if (!mkdir($relsDir, 0755, true)) {
                            \Log::error("No se pudo crear el directorio de relaciones");
                            return false;
                        }
                    }

                    // Ruta del archivo de relaciones
                    $relsFile = $relsDir . '/slide' . $slideNumber . '.xml.rels';
                    \Log::info("Archivo de relaciones: {$relsFile}");

                    // Generar un ID único para la relación
                    $nuevoRelId = 'rId' . (900 + $slideNumber);

                    // Crear/actualizar archivo de relaciones
                    $relsContent = '';
                    if (file_exists($relsFile)) {
                        \Log::info("Archivo de relaciones existe, actualizando");
                        try {
                            $relsContent = file_get_contents($relsFile);
                        } catch (\Exception $e) {
                            \Log::error("Error al leer archivo de relaciones: " . $e->getMessage());
                            // Crear nuevo en caso de error
                            $relsContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    </Relationships>';
                        }

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
                            // Extraer el ID existente
                            preg_match('/Id="(rId[^"]+)" [^>]*Target="[^"]*' . preg_quote($nuevaImagenNombre, '/') . '"/', $relsContent, $idMatch);
                            if (!empty($idMatch)) {
                                $nuevoRelId = $idMatch[1];
                                \Log::info("Relación existente encontrada con ID: {$nuevoRelId}");
                            }
                        }
                    } else {
                        \Log::info("Creando nuevo archivo de relaciones");
                        // Crear nuevo archivo de relaciones
                        $relsContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
      <Relationship Id="' . $nuevoRelId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/' . $nuevaImagenNombre . '"/>
    </Relationships>';
                    }

                    // Guardar el archivo de relaciones
                    try {
                        \Log::info("Guardando archivo de relaciones...");
                        if (file_put_contents($relsFile, $relsContent) === false) {
                            \Log::error("Error al guardar el archivo de relaciones");
                            return false;
                        }
                    } catch (\Exception $e) {
                        \Log::error("Excepción al guardar archivo de relaciones: " . $e->getMessage());
                        return false;
                    }

                    // Ahora modificamos la diapositiva para reemplazar la forma con la imagen
                    \Log::info("Modificando la diapositiva para añadir la imagen");

                    // Asegurarse de que el namespace de relaciones esté presente
                    if (strpos($slideContent, 'xmlns:r=') === false) {
                        $slideContent = preg_replace('/<p:sld([^>]*)>/', '<p:sld$1 xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">', $slideContent);
                    }

                    // Enfoque simple: reemplazar todo el elemento p:sp que contiene el marcador
                    $pattern = '/<p:sp[^>]*>.*?' . preg_quote($marcador, '/') . '.*?<\/p:sp>/s';

                    if (preg_match($pattern, $slideContent, $matches)) {
                        $formaOriginal = $matches[0];
                        \Log::info("Forma original encontrada, longitud: " . strlen($formaOriginal));

                        // Extraer la posición y tamaño
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
                        $slideContentModificado = str_replace($formaOriginal, $nuevaForma, $slideContent);

                        // Verificar que se hizo el reemplazo
                        if ($slideContentModificado === $slideContent) {
                            \Log::warning("El reemplazo de la forma no tuvo efecto. Probando otro método...");

                            // Intento alternativo usando DOM XML para mayor precisión
                            $slideContentModificado = $this->reemplazarFormaAlternativo($slideContent, $marcador, $nuevoRelId, $xfrmXml);
                        }

                        // Guardar el archivo modificado
                        try {
                            \Log::info("Guardando diapositiva modificada...");
                            if (file_put_contents($slideFile, $slideContentModificado) === false) {
                                \Log::error("Error al guardar la diapositiva modificada");
                                return false;
                            }
                        } catch (\Exception $e) {
                            \Log::error("Excepción al guardar diapositiva modificada: " . $e->getMessage());
                            return false;
                        }

                        \Log::info("Proceso de reemplazo de foto completado con éxito");
                        return true;
                    } else {
                        \Log::warning("El marcador está presente pero no se pudo encontrar el elemento p:sp contenedor. Intentando método alternativo.");

                        // En este punto sabemos que el marcador existe pero el patrón no coincide
                        // Intentemos un método más directo 
                        $slideContentModificado = str_replace($marcador, '', $slideContent);

                        // Insertar la imagen directamente después de un elemento conocido
                        $puntoInsersion = strpos($slideContent, '</p:spTree>');
                        if ($puntoInsersion !== false) {
                            \Log::info("Insertando la imagen como un nuevo elemento");

                            $nuevaForma = '<p:sp>
      <p:nvSpPr>
        <p:cNvPr id="' . rand(1000, 9999) . '" name="Foto Colaborador">
          <a:extLst/>
        </p:cNvPr>
        <p:cNvSpPr/>
        <p:nvPr/>
      </p:nvSpPr>
      <p:spPr>
        <a:xfrm>
          <a:off x="3048000" y="1524000"/>
          <a:ext cx="3048000" cy="3048000"/>
        </a:xfrm>
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
          <a:endParaRPr lang="es-ES" altLang="en-US"/>
        </a:p>
      </p:txBody>
    </p:sp>';

                            $slideContentModificado = substr_replace($slideContent, $nuevaForma, $puntoInsersion, 0);

                            // Guardar el archivo modificado
                            try {
                                \Log::info("Guardando diapositiva con imagen insertada...");
                                if (file_put_contents($slideFile, $slideContentModificado) === false) {
                                    \Log::error("Error al guardar la diapositiva con imagen insertada");
                                    return false;
                                }
                            } catch (\Exception $e) {
                                \Log::error("Excepción al guardar diapositiva con imagen insertada: " . $e->getMessage());
                                return false;
                            }

                            \Log::info("Proceso de inserción de imagen completado");
                            return true;
                        }
                    }
                }
            }

            \Log::warning("No se encontró ninguna diapositiva con el marcador");
            return false;
        } catch (\Exception $e) {
            \Log::error("Error general al reemplazar la foto del colaborador: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Método alternativo para reemplazar la forma en caso de problemas con el método principal
     */
    private function reemplazarFormaAlternativo($slideContent, $marcador, $nuevoRelId, $xfrmXml)
    {
        \Log::info("Ejecutando método alternativo de reemplazo");

        // Primero reemplazar el texto del marcador
        $slideContent = str_replace($marcador, '', $slideContent);

        // Buscar la posición aproximada del marcador y añadir el blip cerca
        $posTexto = strpos($slideContent, '<a:t></a:t>');
        if ($posTexto !== false) {
            // Buscar hacia atrás el elemento p:spPr más cercano
            $posSpPr = strrpos(substr($slideContent, 0, $posTexto), '<p:spPr');
            if ($posSpPr !== false) {
                // Buscar el cierre del elemento spPr
                $posCierreSpPr = strpos($slideContent, '</p:spPr>', $posSpPr);
                if ($posCierreSpPr !== false) {
                    $spPrContent = substr($slideContent, $posSpPr, $posCierreSpPr - $posSpPr + 8);

                    // Crear un nuevo spPr con la imagen
                    $nuevoSpPr = '<p:spPr>
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

                    // Reemplazar el spPr original con nuestro nuevo spPr
                    $slideContent = substr_replace($slideContent, $nuevoSpPr, $posSpPr, $posCierreSpPr - $posSpPr + 8);
                    \Log::info("spPr reemplazado con método alternativo");
                }
            }
        }

        return $slideContent;
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
