<?php

namespace App\Http\Controllers\excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


//LIBRERIAS
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

//DATOS DEL PPT
use App\Models\organizacion\documentosPPTModel;
use App\Models\organizacion\formulariopptModel;
use App\Models\organizacion\cursospptModel;
use App\Models\organizacion\departamentosAreasModel;



class makeExcelController extends Controller{

   
    public function makeExcelPPT($id_formulario){

        //OBTENER DATOS DEL FORMULARIO EN LA BASE DE DATOS
        $form = formulariopptModel::where('ID_FORMULARIO_PPT', $id_formulario)->get();
        $cursos = cursospptModel::where('FORMULARIO_PPT_ID', $id_formulario)->get();
        

        // CARGAR EL EXCEL EN BLANCO
        $ruta = storage_path('app/excelBlanco/PPT.xlsx');
        $spreadsheet = IOFactory::load($ruta);
        $sheet = $spreadsheet->getActiveSheet();
        

        foreach ($form as $key => $val) {
            
            $puesto = departamentosAreasModel::where('ID_DEPARTAMENTO_AREA', $val->DEPARTAMENTO_AREA_ID)->pluck('NOMBRE');

            //DATOS DE LA PERSONA

            $sheet->setCellValue('G6', str_replace(['[', ']', '"'], '', $puesto)); 
            $sheet->setCellValue('G7', $val->NOMBRE_TRABAJADOR_PPT);
            $sheet->setCellValue('G8', $val->AREA_TRABAJADOR_PPT);
            $sheet->setCellValue('G9', $val->PROPOSITO_FINALIDAD_PPT);

            //I. Características generales																						



          

            if (!is_null($val->EDAD_PPT)) {
                $sheet->setCellValue('H13', $val->EDAD_PPT);        
            }



            if (!is_null($val->EDAD_CUMPLE_PPT)) {               
                if(strtoupper($val->EDAD_CUMPLE_PPT) == 'SI' ){
                    $sheet->setCellValue('L13', 'X');
                }else{
                    $sheet->setCellValue('M13', 'X');
                }
            }



            if (!is_null($val->GENERO_PPT)) {
                $sheet->setCellValue('S13', $val->GENERO_PPT);
            }   
            
            
            if (!is_null($val->GENERO_CUMPLE_PPT)) {               
                if(strtoupper($val->GENERO_CUMPLE_PPT) == 'SI' ){
                    $sheet->setCellValue('W13', 'X');
                }else{
                    $sheet->setCellValue('X13', 'X');
                }
            }




            if (!is_null($val->ESTADO_CIVIL_PPT)) {
                $sheet->setCellValue('H14', $val->ESTADO_CIVIL_PPT); 
            }


            if (!is_null($val->ESTADO_CIVIL_CUMPLE_PPT)) {               
                if(strtoupper($val->ESTADO_CIVIL_CUMPLE_PPT) == 'SI' ){
                    $sheet->setCellValue('L14', 'X');
                }else{
                    $sheet->setCellValue('M14', 'X');
                }
            }


            if (!is_null($val->NACIONALIDAD_PPT)) {
                $sheet->setCellValue('S14', $val->NACIONALIDAD_PPT); 
            }


            if (!is_null($val->NACIONALIDAD_CUMPLE_PPT)) {               
                if(strtoupper($val->NACIONALIDAD_CUMPLE_PPT) == 'SI' ){
                    $sheet->setCellValue('W14', 'X');
                }else{
                    $sheet->setCellValue('X14', 'X');
                }
            }

        

            if (!is_null($val->DISCAPACIDAD_PPT)) {
                $sheet->setCellValue('H15', $val->DISCAPACIDAD_PPT); 
            }


            if (!is_null($val->DISCAPACIDAD_CUMPLE_PPT)) {               
                if(strtoupper($val->DISCAPACIDAD_CUMPLE_PPT) == 'SI' ){
                    $sheet->setCellValue('L15', 'X');
                }else{
                    $sheet->setCellValue('M15', 'X');
                }
            }
        

            if (!is_null($val->CUAL_PPT)) {
                $sheet->setCellValue('P15', $val->CUAL_PPT); 
            }

            //II. Formación académica		
            

            if (!is_null($val->SECUNDARIA_PPT)) {               
                if(strtoupper($val->SECUNDARIA_PPT) == 'COMPLETA' ){
                    $sheet->setCellValue('H19', 'X');
                }else{
                    $sheet->setCellValue('G19', 'X');
                }
            }

            if (!is_null($val->SECUNDARIA_CUMPLE_PPT)) {
                if (strtoupper($val->SECUNDARIA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J19', 'Si');
                } else {
                    $sheet->setCellValue('J19', 'No');
                }
            }


            if (!is_null($val->TECNICA_PPT)) {               
                if(strtoupper($val->TECNICA_PPT) == 'COMPLETA' ){
                    $sheet->setCellValue('H20', 'X');
                }else{
                    $sheet->setCellValue('G20', 'X');
                }
            }

            if (!is_null($val->TECNICA_CUMPLE_PPT)) {
                if (strtoupper($val->TECNICA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J20', 'Si');
                } else {
                    $sheet->setCellValue('J20', 'No');
                }
            }


            
            if (!is_null($val->TECNICO_PPT)) {               
                if(strtoupper($val->TECNICO_PPT) == 'COMPLETA' ){
                    $sheet->setCellValue('H21', 'X');
                }else{
                    $sheet->setCellValue('G21', 'X');
                }
             }


            if (!is_null($val->TECNICO_CUMPLE_PPT)) {
                if (strtoupper($val->TECNICO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J21', 'Si');
                } else {
                    $sheet->setCellValue('J21', 'No');
                }
            }


            if (!is_null($val->UNIVERSITARIO_PPT)) {               
                if(strtoupper($val->UNIVERSITARIO_PPT) == 'COMPLETA' ){
                    $sheet->setCellValue('H22', 'X');
                }else{
                    $sheet->setCellValue('G22', 'X');
                }
            }


            if (!is_null($val->UNIVERSITARIO_CUMPLE_PPT)) {
                if (strtoupper($val->UNIVERSITARIO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J22', 'Si');
                } else {
                    $sheet->setCellValue('J22', 'No');
                }
            }



            if (!is_null($val->SITUACION_PPT)) {
                $sheet->setCellValue('L19', $val->SITUACION_PPT);        
            }

            
            if (!is_null($val->SITUACION_CUMPLE_PPT)) {
                if (strtoupper($val->SITUACION_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('Q19', 'Si');
                } else {
                    $sheet->setCellValue('Q19', 'No');
                }
            }


            if (!is_null($val->CEDULA_PPT)) {
                $sheet->setCellValue('L22', $val->CEDULA_PPT);        
            }


            if (!is_null($val->CEDULA_CUMPLE_PPT)) {
                if (strtoupper($val->CEDULA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('Q22', 'Si');
                } else {
                    $sheet->setCellValue('Q22', 'No');
                }
            }

            if (!is_null($val->AREA1_PPT)) {
                $sheet->setCellValue('S19', $val->AREA1_PPT);        
            }

            if (!is_null($val->AREA1_CUMPLE_PPT)) {
                if (strtoupper($val->AREA1_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X19', 'Si');
                } else {
                    $sheet->setCellValue('X19', 'No');
                }
            }


            if (!is_null($val->AREA2_PPT)) {
                $sheet->setCellValue('S20', $val->AREA2_PPT);        
            }

            if (!is_null($val->AREA2_CUMPLE_PPT)) {
                if (strtoupper($val->AREA2_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X20', 'Si');
                } else {
                    $sheet->setCellValue('X20', 'No');
                }
            }

            
            if (!is_null($val->AREA3_PPT)) {
                $sheet->setCellValue('S21', $val->AREA3_PPT);        
            }


            if (!is_null($val->AREA3_CUMPLE_PPT)) {
                if (strtoupper($val->AREA3_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X21', 'Si');
                } else {
                    $sheet->setCellValue('X21', 'No');
                }
            }

            if (!is_null($val->AREA4_PPT)) {
                $sheet->setCellValue('S22', $val->AREA4_PPT);        
            }

            if (!is_null($val->AREA4_CUMPLE_PPT)) {
                if (strtoupper($val->AREA4_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X22', 'Si');
                } else {
                    $sheet->setCellValue('X22', 'No');
                }
            }


            if (!is_null($val->AREA_REQUERIDA_PPT)) {
                $sheet->setCellValue('B25', $val->AREA_REQUERIDA_PPT);        
            }

            if (!is_null($val->AREA_CONOCIMIENTOTRABAJADOR_PPT)) {
                $sheet->setCellValue('O25', $val->AREA_CONOCIMIENTOTRABAJADOR_PPT);        
            }



            if (!is_null($val->EGRESADO_ESPECIALIDAD_PPT)) {
                $sheet->setCellValue('F29', 'D*');
            }

            if (!is_null($val->GRADUADO_ESPECIALIDA_PPT)) {
                $sheet->setCellValue('H29', 'D*');
            } 

            if (!is_null($val->ESPECIALIDAD_CUMPLE_PPT)) {

                if (strtoupper($val->ESPECIALIDAD_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J29', 'Si');
                } else {
                    $sheet->setCellValue('J29', 'No');
                }
            }


            if (!is_null($val->AREAREQUERIDA_CONOCIMIENTO_PPT)) {
                $sheet->setCellValue('L29', $val->AREAREQUERIDA_CONOCIMIENTO_PPT); 
            }


           


            if (!is_null($val->EGRESADO_MAESTRIA_PPT)) {
                $sheet->setCellValue('F30', 'D*');
            }
            if (!is_null($val->GRADUADO_MAESTRIA_PPT)) {
                $sheet->setCellValue('H30', 'D*');
            }



            if (!is_null($val->MAESTRIA_CUMPLE_PPT)) {

                if (strtoupper($val->MAESTRIA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J30', 'Si');
                } else {
                    $sheet->setCellValue('J30', 'No');
                }
            }


            if (!is_null($val->EGRESADO_DOCTORADO_PPT)) {
                $sheet->setCellValue('F31', 'D*');
            }
            if (!is_null($val->GRADUADO_DOCTORADO_PPT)) {
                $sheet->setCellValue('H31', 'D*');
            }


            if (!is_null($val->DOCTORADO_CUMPLE_PPT)) {
                if (strtoupper($val->DOCTORADO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J31', 'Si');
                } else {
                    $sheet->setCellValue('J31', 'No');
                }
            }


            if (!is_null($val->AREA_CONOCIMINETO_TRABAJADOR_PPT)) {
                $sheet->setCellValue('L32', $val->AREA_CONOCIMINETO_TRABAJADOR_PPT); 
            }
            




            //III. Conocimiento adicionales

            if (!is_null($val->WORD_APLICA_PPT)) {
                $sheet->setCellValue('E38', $val->WORD_APLICA_PPT);
            }
            if (!is_null($val->WORD_BAJO_PPT)) {
                $sheet->setCellValue('F38', $val->WORD_BAJO_PPT);
            }
            if (!is_null($val->WORD_MEDIO_PPT)) {
                $sheet->setCellValue('G38', $val->WORD_MEDIO_PPT);
            }
            if (!is_null($val->WORD_ALTO_PPT)) {
                $sheet->setCellValue('H38', $val->WORD_ALTO_PPT);
            }

            if (!is_null($val->WORD_CUMPLE_PPT)) {
                if (strtoupper($val->WORD_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J38', 'Si');
                } else {
                    $sheet->setCellValue('J38', 'No');
                }
            }



            if (!is_null($val->EXCEL_APLICA_PPT)) {
                $sheet->setCellValue('E39', $val->EXCEL_APLICA_PPT);
            }
            
            if (!is_null($val->EXCEL_BAJO_PPT)) {
                $sheet->setCellValue('F39', $val->EXCEL_BAJO_PPT);
            }
            if (!is_null($val->EXCEL_MEDIO_PPT)) {
                $sheet->setCellValue('G39', $val->EXCEL_MEDIO_PPT);
            }
            if (!is_null($val->EXCEL_ALTO_PPT)) {
                $sheet->setCellValue('H39', $val->EXCEL_ALTO_PPT);
            }

            if (!is_null($val->EXCEL_CUMPLE_PPT)) {
                if (strtoupper($val->EXCEL_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J39', 'Si');
                } else {
                    $sheet->setCellValue('J39', 'No');
                }
            }


            if (!is_null($val->POWER_APLICA_PPT)) {
                $sheet->setCellValue('E40', $val->POWER_APLICA_PPT);
            }            
            if (!is_null($val->POWER_BAJO_PPT)) {
                $sheet->setCellValue('F40', $val->POWER_BAJO_PPT);
            }
            if (!is_null($val->POWER_MEDIO_PPT)) {
                $sheet->setCellValue('G40', $val->POWER_MEDIO_PPT);
            }
            if (!is_null($val->POWER_ALTO_PPT)) {
                $sheet->setCellValue('H40', $val->POWER_ALTO_PPT);
            }

            if (!is_null($val->POWER_CUMPLE_PPT)) {
                if (strtoupper($val->POWER_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('J40', 'Si');
                } else {
                    $sheet->setCellValue('J40', 'No');
                }
            }
            
        


            if (!is_null($val->NOMBRE_IDIOMA1_PPT)) {
                $sheet->setCellValue('N38', $val->NOMBRE_IDIOMA1_PPT);
            }
            if (!is_null($val->APLICA_IDIOMA1_PPT)) {
                $sheet->setCellValue('Q38', $val->APLICA_IDIOMA1_PPT);
            }
            if (!is_null($val->HABLAR_IDIOMA1_PPT)) {
                $sheet->setCellValue('R38', $val->HABLAR_IDIOMA1_PPT);
            }
            if (!is_null($val->ESCRIBIR_IDIOMA1_PPT)) {
                $sheet->setCellValue('S38', $val->ESCRIBIR_IDIOMA1_PPT);
            }
            if (!is_null($val->LEER_IDIOMA1_PPT)) {
                $sheet->setCellValue('T38', $val->LEER_IDIOMA1_PPT);
            }
            if (!is_null($val->ESCUCHAR_IDIOMA1_PPT)) {
                $sheet->setCellValue('U38', $val->ESCUCHAR_IDIOMA1_PPT);
            }

            if (!is_null($val->IDIOMA1_CUMPLE_PPT)) {
                if (strtoupper($val->IDIOMA1_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W38', 'Si');
                } else {
                    $sheet->setCellValue('W38', 'No');
                }
            }

            if (!is_null($val->NOMBRE_IDIOMA2_PPT)) {
                $sheet->setCellValue('N39', $val->NOMBRE_IDIOMA2_PPT);
            }
            if (!is_null($val->APLICA_IDIOMA2_PPT)) {
                $sheet->setCellValue('Q39', $val->APLICA_IDIOMA2_PPT);
            }
            if (!is_null($val->HABLAR_IDIOMA2_PPT)) {
                $sheet->setCellValue('R39', $val->HABLAR_IDIOMA2_PPT);
            }
            if (!is_null($val->ESCRIBIR_IDIOMA2_PPT)) {
                $sheet->setCellValue('S39', $val->ESCRIBIR_IDIOMA2_PPT);
            }
            if (!is_null($val->LEER_IDIOMA2_PPT)) {
                $sheet->setCellValue('T39', $val->LEER_IDIOMA2_PPT);
            }
            if (!is_null($val->ESCUCHAR_IDIOMA2_PPT)) {
                $sheet->setCellValue('U39', $val->ESCUCHAR_IDIOMA2_PPT);
            }


            if (!is_null($val->IDIOMA2_CUMPLE_PPT)) {
                if (strtoupper($val->IDIOMA2_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W39', 'Si');
                } else {
                    $sheet->setCellValue('W39', 'No');
                }
            }



            if (!is_null($val->NOMBRE_IDIOMA3_PPT)) {
                $sheet->setCellValue('N40', $val->NOMBRE_IDIOMA3_PPT);
            }
            if (!is_null($val->APLICA_IDIOMA3_PPT)) {
                $sheet->setCellValue('Q40', $val->APLICA_IDIOMA3_PPT);
            }
            if (!is_null($val->HABLAR_IDIOMA3_PPT)) {
                $sheet->setCellValue('R40', $val->HABLAR_IDIOMA3_PPT);
            }
            if (!is_null($val->ESCRIBIR_IDIOMA3_PPT)) {
                $sheet->setCellValue('S40', $val->ESCRIBIR_IDIOMA3_PPT);
            }
            if (!is_null($val->LEER_IDIOMA3_PPT)) {
                $sheet->setCellValue('T40', $val->LEER_IDIOMA3_PPT);
            }
            if (!is_null($val->ESCUCHAR_IDIOMA3_PPT)) {
                $sheet->setCellValue('U40', $val->ESCUCHAR_IDIOMA3_PPT);
            }


            if (!is_null($val->IDIOMA3_CUMPLE_PPT)) {
                if (strtoupper($val->IDIOMA3_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W40', 'Si');
                } else {
                    $sheet->setCellValue('W40', 'No');
                }
            }

           

            //CURSOS - PENDIENTE

            //IV. Experiencia


            if (!is_null($val->EXPERIENCIA_LABORAL_GENERAL_PPT)) {
                $sheet->setCellValue('N77', $val->EXPERIENCIA_LABORAL_GENERAL_PPT); 
            }

            
            if (!is_null($val->EXPERIENCIAGENERAL_CUMPLE_PPT)) {
                if (strtoupper($val->EXPERIENCIAGENERAL_CUMPLE_PPT) == 'SI') {
                     $sheet->setCellValue('V77', 'X');
                } else {
                    $sheet->setCellValue('W77', 'X');
                }
            }

            if (!is_null($val->CANTIDAD_EXPERIENCIA_PPT)) {
                $sheet->setCellValue('N78', $val->CANTIDAD_EXPERIENCIA_PPT); 
            }

            if (!is_null($val->CANTIDAD_EXPERIENCIA_CUMPLE_PPT)) {
                if (strtoupper($val->CANTIDAD_EXPERIENCIA_CUMPLE_PPT) == 'SI') {
                     $sheet->setCellValue('V78', 'X');
                } else {
                    $sheet->setCellValue('W78', 'X');
                }
            }


            if (!is_null($val->EXPERIENCIA_ESPECIFICA_PPT)) {
                $sheet->setCellValue('N79', $val->EXPERIENCIA_ESPECIFICA_PPT); 
            }


            if (!is_null($val->EXPERIENCIA_ESPECIFICA_CUMPLE_PPT)) {
                if (strtoupper($val->EXPERIENCIA_ESPECIFICA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V79', 'X');
                } else {
                     $sheet->setCellValue('W79', 'X');
                }
            }


            if (!is_null($val->PRACTICA_PROFESIONAL_PPT)) {
                $sheet->setCellValue('I83', $val->PRACTICA_PROFESIONAL_PPT);
            }
            if (!is_null($val->PRACTICA_PROFESIONAL_CUMPLE_PPT)) {
                if (strtoupper($val->PRACTICA_PROFESIONAL_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('K83', 'X');
                } else {
                     $sheet->setCellValue('L83', 'X');
                }
            }


            if (!is_null($val->ELABORACION_REPORTES_PPT)) {
                $sheet->setCellValue('U84', $val->ELABORACION_REPORTES_PPT);
            }

            if (!is_null($val->ELABORACION_REPORTES_CUMPLE_PPT)) {
                if (strtoupper($val->ELABORACION_REPORTES_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W84', 'X');
                } else {
                     $sheet->setCellValue('X84', 'X');
                }
            }


            if (!is_null($val->AUXILIAR_ASISTENTE_PPT)) {
                $sheet->setCellValue('U83', $val->AUXILIAR_ASISTENTE_PPT);
            }

            if (!is_null($val->AUXILIAR_ASISTENTE_CUMPLE_PPT)) {
                if (strtoupper($val->AUXILIAR_ASISTENTE_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W83', 'X');
                } else {
                     $sheet->setCellValue('X83', 'X');
                }
            }


            if (!is_null($val->SUPERVISOR_COORDINADOR_PPT)) {
                $sheet->setCellValue('I86', $val->SUPERVISOR_COORDINADOR_PPT);
            }

            if (!is_null($val->SUPERVISOR_COORDINADOR_CUMPLE_PPT)) {
                if (strtoupper($val->SUPERVISOR_COORDINADOR_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('K86', 'X');
                } else {
                     $sheet->setCellValue('L86', 'X');
                }
            }

            if (!is_null($val->ANALISTA_ESPECIALISTA_PPT)) {
                $sheet->setCellValue('I84', $val->ANALISTA_ESPECIALISTA_PPT);
            }

            if (!is_null($val->ANALISTA_ESPECIALISTA_CUMPLE_PPT)) {
                if (strtoupper($val->ANALISTA_ESPECIALISTA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('K84', 'X');
                } else {
                     $sheet->setCellValue('L84', 'X');
                }
            }

            if (!is_null($val->CONSULTOR_ASESOR_PPT)) {
                $sheet->setCellValue('U85', $val->CONSULTOR_ASESOR_PPT);
            }


            if (!is_null($val->CONSULTOR_ASESOR_CUMPLE_PPT)) {
                if (strtoupper($val->CONSULTOR_ASESOR_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W85', 'X');
                } else {
                     $sheet->setCellValue('X85', 'X');
                }
            }

            if (!is_null($val->TECNICO_MUESTREO_PPT)) {
                $sheet->setCellValue('I85', $val->TECNICO_MUESTREO_PPT);
            }

            if (!is_null($val->TECNICO_MUESTREO_CUMPLE_PPT)) {
                if (strtoupper($val->TECNICO_MUESTREO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('K85', 'X');
                } else {
                     $sheet->setCellValue('L85', 'X');
                }
            }

            if (!is_null($val->JEFE_AREA_PPT)) {
                $sheet->setCellValue('I87', $val->JEFE_AREA_PPT);
            }


            if (!is_null($val->JEFE_AREA_CUMPLE_PPT)) {
                if (strtoupper($val->JEFE_AREA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('K87', 'X');
                } else {
                     $sheet->setCellValue('L87', 'X');
                }
            }

            if (!is_null($val->SIGNATARIO_PPT)) {
                $sheet->setCellValue('U86', $val->SIGNATARIO_PPT);
            }

            if (!is_null($val->SIGNATARIO_CUMPLE_PPT)) {
                if (strtoupper($val->SIGNATARIO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W86', 'X');
                } else {
                     $sheet->setCellValue('X86', 'X');
                }
            }

            if (!is_null($val->GERENTE_DIRECTOR_PPT)) {
                $sheet->setCellValue('U87', $val->GERENTE_DIRECTOR_PPT);
            }


            if (!is_null($val->GERENTE_DIRECTOR_CUMPLE_PPT)) {
                if (strtoupper($val->GERENTE_DIRECTOR_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('W87', 'X');
                } else {
                     $sheet->setCellValue('X87', 'X');
                }
            }

            if (!is_null($val->TIEMPO_EXPERIENCIA_PPT)) {
                $sheet->setCellValue('B90', $val->TIEMPO_EXPERIENCIA_PPT);
            }

            if (!is_null($val->TIEMPO_EXPERIENCIA_CUMPLE_PPT)) {
                if (strtoupper($val->TIEMPO_EXPERIENCIA_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V90', 'X');
                } else {
                     $sheet->setCellValue('W90', 'X');
                }
            }


            // V. habilidades y competencias funcionales
            if (!is_null($val->INNOVACION_REQUERIDA_PPT)) {
                $sheet->setCellValue('L94', $val->INNOVACION_REQUERIDA_PPT);
            }
            if (!is_null($val->INNOVACION_DESEABLE_PPT)) {
                $sheet->setCellValue('O94', $val->INNOVACION_DESEABLE_PPT);
            }
            if (!is_null($val->INNOVACION_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R94', $val->INNOVACION_NO_REQUERIDA_PPT);
            }


            if (!is_null($val->INNOVACION_CUMPLE_PPT)) {
                if (strtoupper($val->INNOVACION_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V94', 'X');
                } else {
                     $sheet->setCellValue('W94', 'X');
                }
            }


            if (!is_null($val->PASION_REQUERIDA_PPT)) {
                $sheet->setCellValue('L95', $val->PASION_REQUERIDA_PPT);
            }
            if (!is_null($val->PASION_DESEABLE_PPT)) {
                $sheet->setCellValue('O95', $val->PASION_DESEABLE_PPT);
            }
            if (!is_null($val->PASION_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R95', $val->PASION_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->PASION_CUMPLE_PPT)) {
                if (strtoupper($val->PASION_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V95', 'X');
                } else {
                     $sheet->setCellValue('W95', 'X');
                }
            }

            if (!is_null($val->SERVICIO_CLIENTE_REQUERIDA_PPT)) {
                $sheet->setCellValue('L96', $val->SERVICIO_CLIENTE_REQUERIDA_PPT);
            }
            if (!is_null($val->SERVICIO_CLIENTE_DESEABLE_PPT)) {
                $sheet->setCellValue('O96', $val->SERVICIO_CLIENTE_DESEABLE_PPT);
            }
            if (!is_null($val->SERVICIO_CLIENTE_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R96', $val->SERVICIO_CLIENTE_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->SERVICIO_CLIENTE_CUMPLE_PPT)) {
                if (strtoupper($val->SERVICIO_CLIENTE_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V96', 'X');
                } else {
                     $sheet->setCellValue('W96', 'X');
                }
            }

            if (!is_null($val->COMUNICACION_EFICAZ_REQUERIDA_PPT)) {
                $sheet->setCellValue('L97', $val->COMUNICACION_EFICAZ_REQUERIDA_PPT);
            }
            if (!is_null($val->COMUNICACION_EFICAZ_DESEABLE_PPT)) {
                $sheet->setCellValue('O97', $val->COMUNICACION_EFICAZ_DESEABLE_PPT);
            }
            if (!is_null($val->COMUNICACION_EFICAZ_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R97', $val->COMUNICACION_EFICAZ_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->COMUNICACION_EFICAZ_CUMPLE_PPT)) {
                if (strtoupper($val->COMUNICACION_EFICAZ_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V97', 'X');
                } else {
                     $sheet->setCellValue('W97', 'X');
                }
            }


            if (!is_null($val->TRABAJO_EQUIPO_REQUERIDA_PPT)) {
                $sheet->setCellValue('L98', $val->TRABAJO_EQUIPO_REQUERIDA_PPT);
            }
            if (!is_null($val->TRABAJO_EQUIPO_DESEABLE_PPT)) {
                $sheet->setCellValue('O98', $val->TRABAJO_EQUIPO_DESEABLE_PPT);
            }
            if (!is_null($val->TRABAJO_EQUIPO_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R98', $val->TRABAJO_EQUIPO_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->TRABAJO_EQUIPO_CUMPLE_PPT)) {
                if (strtoupper($val->TRABAJO_EQUIPO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V98', 'X');
                } else {
                     $sheet->setCellValue('W98', 'X');
                }
            }

            if (!is_null($val->INTEGRIDAD_REQUERIDA_PPT)) {
                $sheet->setCellValue('L99', $val->INTEGRIDAD_REQUERIDA_PPT);
            }
            if (!is_null($val->INTEGRIDAD_DESEABLE_PPT)) {
                $sheet->setCellValue('O99', $val->INTEGRIDAD_DESEABLE_PPT);
            }
            if (!is_null($val->INTEGRIDAD_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R99', $val->INTEGRIDAD_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->INTEGRIDAD_CUMPLE_PPT)) {
                if (strtoupper($val->INTEGRIDAD_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V99', 'X');
                } else {
                     $sheet->setCellValue('W99', 'X');
                }
            }

            if (!is_null($val->RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT)) {
                $sheet->setCellValue('L100', $val->RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT);
            }
            if (!is_null($val->RESPONSABILIDAD_SOCIAL_DESEABLE_PPT)) {
                $sheet->setCellValue('O100', $val->RESPONSABILIDAD_SOCIAL_DESEABLE_PPT);
            }
            if (!is_null($val->RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R100', $val->RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->RESPONSABILIDAD_SOCIAL_CUMPLE_PPT)) {
                if (strtoupper($val->RESPONSABILIDAD_SOCIAL_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V100', 'X');
                } else {
                     $sheet->setCellValue('W100', 'X');
                }
            }

            if (!is_null($val->ADAPTABILIDAD_REQUERIDA_PPT)) {
                $sheet->setCellValue('L101', $val->ADAPTABILIDAD_REQUERIDA_PPT);
            }
            if (!is_null($val->ADAPTABILIDAD_DESEABLE_PPT)) {
                $sheet->setCellValue('O101', $val->ADAPTABILIDAD_DESEABLE_PPT);
            }
            if (!is_null($val->ADAPTABILIDAD_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R101', $val->ADAPTABILIDAD_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->ADAPTABILIDAD_CUMPLE_PPT)) {
                if (strtoupper($val->ADAPTABILIDAD_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V101', 'X');
                } else {
                     $sheet->setCellValue('W101', 'X');
                }
            }

            if (!is_null($val->LIDERAZGO_REQUERIDA_PPT)) {
                $sheet->setCellValue('L102', $val->LIDERAZGO_REQUERIDA_PPT);
            }
            if (!is_null($val->LIDERAZGO_DESEABLE_PPT)) {
                $sheet->setCellValue('O102', $val->LIDERAZGO_DESEABLE_PPT);
            }
            if (!is_null($val->LIDERAZGO_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R102', $val->LIDERAZGO_NO_REQUERIDA_PPT);
            }

            
            if (!is_null($val->LIDERAZGO_CUMPLE_PPT)) {
                if (strtoupper($val->LIDERAZGO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V102', 'X');
                } else {
                     $sheet->setCellValue('W102', 'X');
                }
            }

            if (!is_null($val->TOMA_DECISIONES_REQUERIDA_PPT)) {
                $sheet->setCellValue('L103', $val->TOMA_DECISIONES_REQUERIDA_PPT);
            }
            if (!is_null($val->TOMA_DECISIONES_DESEABLE_PPT)) {
                $sheet->setCellValue('O103', $val->TOMA_DECISIONES_DESEABLE_PPT);
            }
            if (!is_null($val->TOMA_DECISIONES_NO_REQUERIDA_PPT)) {
                $sheet->setCellValue('R103', $val->TOMA_DECISIONES_NO_REQUERIDA_PPT);
            }

            if (!is_null($val->TOMA_DECISIONES_CUMPLE_PPT)) {
                if (strtoupper($val->TOMA_DECISIONES_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('V103', 'X');
                } else {
                     $sheet->setCellValue('W103', 'X');
                }
            }




            if (!is_null($val->DISPONIBILAD_VIAJAR_PPT)) {
                if (strtoupper($val->DISPONIBILAD_VIAJAR_PPT) == 'SI') {
                    $sheet->setCellValue('J107', 'X');
                } else {
                     $sheet->setCellValue('K107', 'X');
                }
            }


            if (!is_null($val->REQUIERE_PASAPORTE_PPT)) {
                if (strtoupper($val->REQUIERE_PASAPORTE_PPT) == 'SI') {
                    $sheet->setCellValue('J108', 'X');
                } else {
                     $sheet->setCellValue('K108', 'X');
                }
            }

            
            if (!is_null($val->REQUIERE_VISA_PPT)) {
                if (strtoupper($val->REQUIERE_VISA_PPT) == 'SI') {
                    $sheet->setCellValue('J109', 'X');
                } else {
                     $sheet->setCellValue('K109', 'X');
                }
            }


            if (!is_null($val->REQUIERE_LICENCIA_PPT)) {
                if (strtoupper($val->REQUIERE_LICENCIA_PPT) == 'SI') {
                    $sheet->setCellValue('J110', 'X');
                } else {
                     $sheet->setCellValue('K110', 'X');
                }
            }


            if (!is_null($val->CAMBIO_RESIDENCIA_PPT)) {
                if (strtoupper($val->CAMBIO_RESIDENCIA_PPT) == 'SI') {
                    $sheet->setCellValue('J111', 'X');
                } else {
                     $sheet->setCellValue('K111', 'X');
                }
            }




            if (!is_null($val->DISPONIBILADVIAJAR_OPCION_PPT)) {
                $sheet->setCellValue('M107', $val->DISPONIBILADVIAJAR_OPCION_PPT);        
            }

            if (!is_null($val->DISPONIBILADVIAJAR_OPCION_CUMPLE)) {
                if (strtoupper($val->DISPONIBILADVIAJAR_OPCION_CUMPLE) == 'SI') {
                    $sheet->setCellValue('S107', 'X');
                } else {
                     $sheet->setCellValue('T107', 'X');
                }
            }

            if (!is_null($val->REQUIEREPASAPORTE_OPCION_PPT)) {
                $sheet->setCellValue('M108', $val->REQUIEREPASAPORTE_OPCION_PPT);        
            }


            if (!is_null($val->REQUIEREPASAPORTE_OPCION_CUMPLE)) {
                if (strtoupper($val->REQUIEREPASAPORTE_OPCION_CUMPLE) == 'SI') {
                    $sheet->setCellValue('S108', 'X');
                } else {
                     $sheet->setCellValue('T108', 'X');
                }
            }


            if (!is_null($val->REQUIERE_VISA_OPCION_PPT)) {
                $sheet->setCellValue('M109', $val->REQUIERE_VISA_OPCION_PPT);        
            }



            if (!is_null($val->REQUIEREVISA_OPCION_CUMPLE)) {
                if (strtoupper($val->REQUIEREVISA_OPCION_CUMPLE) == 'SI') {
                    $sheet->setCellValue('S109', 'X');
                } else {
                     $sheet->setCellValue('T109', 'X');
                }
            }


            if (!is_null($val->REQUIERELICENCIA_OPCION_PPT)) {
                $sheet->setCellValue('M110', $val->REQUIERELICENCIA_OPCION_PPT);        
            }


            if (!is_null($val->REQUIERELICENCIA_OPCION_CUMPLE)) {
                if (strtoupper($val->REQUIERELICENCIA_OPCION_CUMPLE) == 'SI') {
                    $sheet->setCellValue('S110', 'X');
                } else {
                     $sheet->setCellValue('T110', 'X');
                }
            }



            if (!is_null($val->CAMBIORESIDENCIA_OPCION_PPT)) {
                $sheet->setCellValue('M111', $val->CAMBIORESIDENCIA_OPCION_PPT);        
            }


            if (!is_null($val->CAMBIORESIDENCIA_OPCION_CUMPLE)) {
                if (strtoupper($val->CAMBIORESIDENCIA_OPCION_CUMPLE) == 'SI') {
                    $sheet->setCellValue('S111', 'X');
                } else {
                     $sheet->setCellValue('T111', 'X');
                }
            }


            // X. Observaciones
            if (!is_null($val->OBSERVACIONES_PPT)) {
                $sheet->setCellValue('B114', $val->OBSERVACIONES_PPT);
            }


            if (!is_null($val->ELABORADO_NOMBRE_PPT)) {
                $sheet->setCellValue('B117', $val->ELABORADO_NOMBRE_PPT);
            }
            if (!is_null($val->ELABORADO_FIRMA_PPT)) {
                $sheet->setCellValue('B119', $val->ELABORADO_FIRMA_PPT);
            }
            if (!is_null($val->ELABORADO_FECHA_PPT)) {
                $sheet->setCellValue('B121', $val->ELABORADO_FECHA_PPT);
            }


            if (!is_null($val->REVISADO_NOMBRE_PPT)) {
                $sheet->setCellValue('I117', $val->REVISADO_NOMBRE_PPT);
            }
            if (!is_null($val->REVISADO_FIRMA_PPT)) {
                $sheet->setCellValue('I119', $val->REVISADO_FIRMA_PPT);
            }
            if (!is_null($val->REVISADO_FECHA_PPT)) {
                $sheet->setCellValue('I121', $val->REVISADO_FECHA_PPT);
            }

            if (!is_null($val->AUTORIZADO_NOMBRE_PPT)) {
                $sheet->setCellValue('Q117', $val->AUTORIZADO_NOMBRE_PPT);
            }
            if (!is_null($val->AUTORIZADO_FIRMA_PPT)) {
                $sheet->setCellValue('Q119', $val->AUTORIZADO_FIRMA_PPT);
            }
            if (!is_null($val->AUTORIZADO_FECHA_PPT)) {
                $sheet->setCellValue('Q121', $val->AUTORIZADO_FECHA_PPT);
        }
    }

        $fila1 = 44;
        $fila2 = 44;
        $fila3 = 63;
        $fila4 = 63; 

        $longitud = 1;
        foreach ($cursos as $key => $val) {

            if ($longitud <= 10) {

                $sheet->setCellValue('B'.$fila1, $val->CURSO_PPT);

                if (!is_null($val->CURSO_REQUERIDO)) {
                    $sheet->setCellValue('I' . $fila1, $val->CURSO_REQUERIDO);
                }
                if (!is_null($val->CURSO_DESEABLE)) {
                    $sheet->setCellValue('J' . $fila1, $val->CURSO_DESEABLE);
                }
                if (strtoupper($val->CURSO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('L' . $fila1, 'Si');
                } else {
                    $sheet->setCellValue('L' . $fila1, 'No');
                }

                $fila1++;

            } else if ($longitud > 10 && $longitud <= 20) {

                $sheet->setCellValue('N' . $fila2, $val->CURSO_PPT);

                if (!is_null($val->CURSO_REQUERIDO)) {
                    $sheet->setCellValue('U' . $fila2, $val->CURSO_REQUERIDO);
                }
                if (!is_null($val->CURSO_DESEABLE)) {
                    $sheet->setCellValue('V' . $fila2, $val->CURSO_DESEABLE);
                }
                if (strtoupper($val->CURSO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X' . $fila2, 'Si');
                } else {
                    $sheet->setCellValue('X' . $fila2, 'No');
                }

                $fila2++;


            } else if ($longitud > 20 && $longitud <= 30) {

                $sheet->setCellValue('B' . $fila3, $val->CURSO_PPT);

                if (!is_null($val->CURSO_REQUERIDO)) {
                    $sheet->setCellValue('I' . $fila3, $val->CURSO_REQUERIDO);
                }
                if (!is_null($val->CURSO_DESEABLE)) {
                    $sheet->setCellValue('J' . $fila3, $val->CURSO_DESEABLE);
                }
                if (strtoupper($val->CURSO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('L' . $fila3, 'Si');
                } else {
                    $sheet->setCellValue('L' . $fila3, 'No');
                }

                $fila3++;

            } else if ($longitud > 30){

                $sheet->setCellValue('N' . $fila4, $val->CURSO_PPT);

                if (!is_null($val->CURSO_REQUERIDO)) {
                    $sheet->setCellValue('U' . $fila4, $val->CURSO_REQUERIDO);
                }
                if (!is_null($val->CURSO_DESEABLE)) {
                    $sheet->setCellValue('V' . $fila4, $val->CURSO_DESEABLE);
                }
                if (strtoupper($val->CURSO_CUMPLE_PPT) == 'SI') {
                    $sheet->setCellValue('X' . $fila4, 'Si');
                } else {
                    $sheet->setCellValue('X' . $fila4, 'No');
                }
                $fila4++;


            }

            $longitud++;
            
        }



        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

     
        
        $puesto = str_replace(['[', ']'], '', $puesto);
        
        $nombre_archivo = str_replace(['\\', '/', ':', '*', '?', '"', '<', '>', '|'], '', $puesto);
        
        $fecha_actual = date("dmy");
        // $fecha_actual = date("ymd");

        
        $nombre_descarga = "PPT-{$nombre_archivo}- {$fecha_actual}.xlsx";
        
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $nombre_descarga);
        

    }


    public function makeExcelDPT(){
        return view('excel.makeExcelDPT');
    }

    public function makeExcelRequerimientos(){
        return view('excel.makeExcelArea');
    }
}
