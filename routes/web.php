<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//  USUARIOS
use App\Http\Controllers\usuario\usuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;

// CONTROLADORES DE ORGANIZACION 
use App\Http\Controllers\organizacion\areasController;
use App\Http\Controllers\organizacion\pptController;
use App\Http\Controllers\organizacion\dptController;
use App\Http\Controllers\excel\makeExcelController;
use App\Http\Controllers\organizacion\catalogosController;
use App\Http\Controllers\organizacion\catalogosasesoresController;
use App\Http\Controllers\organizacion\catalogosfuncionescargoController;
use App\Http\Controllers\organizacion\catalogosfuncionesgestionController;
use App\Http\Controllers\organizacion\catalogosrelacionesexternasController;
use App\Http\Controllers\organizacion\requerimientoPersonalController;
use App\Http\Controllers\organizacion\catalogocategoriaControlller;
use App\Http\Controllers\organizacion\catalogoexperienciaController;
use App\Http\Controllers\organizacion\catalogocompetenciabasicaController;
use App\Http\Controllers\organizacion\catalogotipovacanteController;
use App\Http\Controllers\organizacion\catalogoCompotenciasGerencialesController;
use App\Http\Controllers\organizacion\catalogomotivovacanteControlller;
use App\Http\Controllers\organizacion\catalogoanuncioController;


// CONTROLADORES DE RECLUTAMIENO 
use App\Http\Controllers\reclutamiento\catalogovacantesController;
use App\Http\Controllers\reclutamiento\PuestoController;
use App\Http\Controllers\reclutamiento\bancocvController;
use App\Http\Controllers\reclutamiento\vacantesactivasController;
use App\Http\Controllers\organizacion\catalogoareainteresController;
use App\Http\Controllers\organizacion\catalogogeneroControlller;
use App\Http\Controllers\reclutamiento\formCVController;


// CONTROLADORES DE SELECCION
use App\Http\Controllers\seleccion\seleccionController;
use App\Http\Controllers\seleccion\catalogopruebasController;
use App\Http\Controllers\TestController;


// CONTROLADORES DE CONTRATACION 
use App\Http\Controllers\contratacion\contratacionController;
use App\Http\Controllers\contratacion\PowerPointController;
use App\Http\Controllers\contratacion\pendientecontratarController;
use App\Http\Controllers\contratacion\CvController;


// CONTROLADORES DE DESVINCULACION
use App\Http\Controllers\desvinculacion\desvinculacionController;


// CONTROLADORES DE SOLICITUDES
use App\Http\Controllers\solicitudes\solicitudesController;
use App\Http\Controllers\solicitudes\catalogomediocontactoController;
use App\Http\Controllers\solicitudes\catalogogiroempresaController;
use App\Http\Controllers\solicitudes\catalogonecesidadController;
use App\Http\Controllers\solicitudes\catalogolineanegociosController;
use App\Http\Controllers\solicitudes\catalogotiposervicioController;


// CONTROLADORES DE OFERTAS 
use App\Http\Controllers\ofertas\ofertasController;


// CONTROLADORES DE CONFIRMACION 
use App\Http\Controllers\confirmacion\confirmacionController;
use App\Http\Controllers\confirmacion\catalagoverificacioninformacionController;


// CONTROLADORES DE ORDEN DE TRABAJO

use App\Http\Controllers\ordentrabajo\otController;


// CONTROLADORES DE MR

use App\Http\Controllers\requisicionmaterial\mrController;


// CONTROLADORES DE PROVEEDORES

use App\Http\Controllers\proveedor\directorioController;
use App\Http\Controllers\proveedor\altaproveedorController;
use App\Http\Controllers\proveedor\altacuentaController;
use App\Http\Controllers\proveedor\altacontactoController;
use App\Http\Controllers\proveedor\altacerticacionController;
use App\Http\Controllers\proveedor\altareferenciasController;

use App\Http\Controllers\proveedor\listaproveedorController;


use App\Http\Controllers\proveedor\catalagofuncionesproveedorController;
use App\Http\Controllers\proveedor\catalagotituloproveedorController;



//==============================================  login  ============================================== 
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasAnyRole(['Superusuario', 'Administrador'])) {
            return redirect('/Módulos');
        }
        return response()->noContent(); 
    }
    return response()->noContent(); 
});



// Rutas públicas (excluidas del middleware global)

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/verify-code', [AuthController::class, 'verifyCode']);


// Route::middleware(['auth'])->group(function () {
//     Route::get('/Módulos', function () {
//         return view('principal.modulos');
//     })->name('dashboard');
// });

//==============================================  ENVIAR CORREO  ============================================== 


Route::post('/enviar-codigo', [VerificationController::class, 'enviarCodigo']);
Route::post('/verificar-codigo', [VerificationController::class, 'verificarCodigo']);
//==============================================  Módulos  ============================================== 
// Route::get('/Módulos', function () {return view('principal.modulos');})->middleware('role:Superusuario,Administrador');

Route::get('/Módulos', [catalogoanuncioController::class, 'index'])->middleware('role:Superusuario,Administrador,Asistente de planeación y logística');


//==============================================  USUARIO  ============================================== 


Route::get('/usuario', [usuarioController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::post('/usuarioSave', [usuarioController::class, 'store']);
Route::get('/Tablausuarios', [usuarioController::class, 'Tablausuarios']);
Route::get('/Tablaproveedores', [usuarioController::class, 'Tablaproveedores']);

Route::get('/usuarioDelete', [usuarioController::class, 'store']);
// Route::get('/usuariofoto/{id}', [usuarioController::class, 'mostrarFotoUsuario']);
Route::get('/usuariofoto/{id}', [usuarioController::class, 'mostrarFotoUsuario'])->name('usuariofoto');


//==============================================  EXTERNO  ============================================== 
Route::get('/inicio', function () {return view('RH.externa.diseño');});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////RRHH//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//==============================================  ORGANIZACION  ============================================== 
Route::get('/tablero', function () {return view('tablero.index');});

// ORGANIGRAMA
Route::get('/organigrama', [areasController::class, 'index']);
Route::post('/areasSave', [areasController::class, 'store']);
Route::get('/areasDelete', [areasController::class, 'store']);
Route::get('/TablaAreas', [areasController::class, 'TablaAreas']);
Route::get('/mostrararchivo/{id}', [areasController::class, 'mostrararchivo']);
Route::get('/TablaCargos/{area_id}', [areasController::class, 'TablaCargos']);
Route::get('/TablaEncargados/{area_id}', [areasController::class, 'TablaEncargados']);
Route::get('/listaEncagadosAreas/{area_id}', [areasController::class, 'listaEncagadosAreas']);
Route::get('/getDataOrganigrama/{area_id}/{esGeneral}', [areasController::class, 'getDataOrganigrama']);
Route::get('/mostrarFoto/{id}', [areasController::class, 'mostrarFoto']);

// PPT
Route::get('/PPT', [pptController::class, 'index']);
Route::post('/pptSave', [pptController::class, 'store']);
Route::get('/TablaPPT', [pptController::class, 'TablaPPT']);
Route::get('/autorizarPPT/{id_formulario}', [pptController::class, 'autorizarPPT']);
Route::get('/revisarPPT/{id_formulario}', [pptController::class, 'revisarPPT']);
Route::get('/makeExcelPPT/{id_formulario}', [makeExcelController::class, 'makeExcelPPT']);
Route::get('pptDelete', [pptController::class, 'store']);

// DPT
Route::get('/DPT', [dptController::class, 'index']);
Route::post('/dptSave', [dptController::class, 'store']);
Route::get('/TablaDPT', [dptController::class, 'TablaDPT']);
Route::get('/dptDelete', [dptController::class, 'store']);
// Route::get('/autorizarDPT/{id_formulario}', [dptController::class, 'autorizarDPT']);
// Route::get('/revisarDPT/{id_formulario}', [dptController::class, 'revisarDPT']);
Route::get('/makeExcelDPT/{id_formulario}', [makeExcelController::class, 'makeExcelDPT']);
Route::get('/infoReportan/{ID}/{LIDER}', [dptController::class, 'infoReportan']);
Route::get('/consultarfuncionescargo/{areaId}', [dptController::class, 'consultarfuncionescargo']);

// REQUERIMIENTO PERSONAL 
Route::get('/RequisiciónDePersonal', [requerimientoPersonalController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::post('/RequerimientoSave', [requerimientoPersonalController::class, 'store']);
Route::get('/RequerimientoDelete', [requerimientoPersonalController::class, 'store']);
Route::get('/Tablarequerimiento', [requerimientoPersonalController::class, 'Tablarequerimiento']);
Route::get('/makeExcelRP/{id_formulario}', [makeExcelController::class, 'makeExcelRP']);
Route::get('/mostrardocumentorequisicion/{id}', [requerimientoPersonalController::class, 'mostrardocumentorequisicion']);

// CATÁLOGO DE JERARQUÍA
Route::get('/Jerárquico', function () {return view('RH.Catalogos.catalogo_Jerárquico');});
Route::post('/jerarquiaSave', [catalogosController::class, 'store']);
Route::get('/jerarquiaDelete', [catalogosController::class, 'store']);
Route::get('/Tablajerarquia', [catalogosController::class, 'Tablajerarquia']);

// CATÁLOGO DE ASESORES
Route::get('/Asesores', function () {return view('RH.Catalogos.catalogo_asesores');});
Route::post('/asesorSave', [catalogosasesoresController::class, 'store']);
Route::get('/asesorDelete', [catalogosasesoresController::class, 'store']);
Route::get('/Tablaasesores', [catalogosasesoresController::class, 'Tablaasesores']);

// CATÁLOGO DE FUNCIONES CARGO
Route::get('/FuncionesCargo', [catalogosfuncionescargoController::class, 'index']);
Route::post('/CargoSave', [catalogosfuncionescargoController::class, 'store']);
Route::get('/CargoDelete', [catalogosfuncionescargoController::class, 'store']);
Route::get('/Tablaafuncionescargo', [catalogosfuncionescargoController::class, 'Tablaafuncionescargo']);

// CATÁLOGO DE FUNCIONES GESTIONES
Route::get('/Funcionesgestión', function () {return view('RH.Catalogos.catalogo_funcionesgestion');});
Route::post('/GestionSave', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/GestionDelete', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/Tablafuncionesgestion', [catalogosfuncionesgestionController::class, 'Tablafuncionesgestion']);

// CATÁLOGO DE RELACIONES EXTERNAS 
Route::get('/RelacionesExternas', function () {return view('RH.Catalogos.catalogo_relacionesexternas');});
Route::post('/ExternaSave', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/ExternaDelete', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/Tablarelacionesexterna', [catalogosrelacionesexternasController::class, 'Tablarelacionesexterna']);

// CATÁLOGO DE CATEGORÍAS
Route::get('/Categorías', [catalogocategoriaControlller::class, 'index']);
Route::post('/CategoriaSave', [catalogocategoriaControlller::class, 'store']);
Route::get('CategoriaDelete', [catalogocategoriaControlller::class, 'store']);
Route::get('/Tablacategoria', [catalogocategoriaControlller::class, 'Tablacategoria']);

// CATÁLOGO DE GÉNERO 
Route::get('/Género', function () {return view('RH.Catalogos.catalogo_genero');});
Route::post('/GeneroSave', [catalogogeneroControlller::class, 'store']);
Route::get('/GeneroDelete', [catalogogeneroControlller::class, 'store']);
Route::get('/Tablageneros', [catalogogeneroControlller::class, 'Tablageneros']);

// CATÁLOGO DE PUESTO QUE SE REQUIERE COMO EXPERIENCIA
Route::get('/Puesto-experiencia', function () {return view('RH.Catalogos.catalogo_experiencia');});
Route::post('/PuestoSave', [catalogoexperienciaController::class, 'store']);
Route::get('/PuestoDelete', [catalogoexperienciaController::class, 'store']);
Route::get('/Tablaexperiencia', [catalogoexperienciaController::class, 'Tablaexperiencia']);

// CATÁLOGO COMPETENCIAS BÁSICAS O CARDINALES 
Route::get('/Competencias-básicas', function () {return view('RH.Catalogos.catalogo_competenciasbasicas');});
Route::post('/BasicoSave', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/BasicoDelete', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/Tablacompetenciabasica', [catalogocompetenciabasicaController::class, 'Tablacompetenciabasica']);

// CATÁLOGO COMPETENCIAS GERENCIALES 
Route::get('/Competencias-gerenciales', function () {return view('RH.Catalogos.catalogo_competenciasGerenciales'); });
Route::post('/GerencialesSave', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/GerencialesDelete', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/TablaCompetenciasGerenciales', [catalogoCompotenciasGerencialesController::class, 'TablaCompetenciasGerenciales']);

// CATÁLOGO DE TIPO DE VACANTES
Route::get('/Tipo-vacante', function () {return view('RH.Catalogos.catalogo_tipovacante');});
Route::post('/TipoSave', [catalogotipovacanteController::class, 'store']);
Route::get('/TipoDelete', [catalogotipovacanteController::class, 'store']);
Route::get('/Tablatipovacantes', [catalogotipovacanteController::class, 'Tablatipovacantes']);

// CATÁLOGO DE  MOTIVO DE VACANTES 
Route::get('/Motivo-vacante', function () {return view('RH.Catalogos.catalogo_motivovacante');});
Route::post('/MotivoSave', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/MotivoDelete', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/Tablamotivovacante', [catalogomotivovacanteControlller::class, 'Tablamotivovacante']);



// CATÁLOGO DE ANUNCIO
Route::get('/Anuncios', function () { return view('RH.Catalogos.catalogo_anucios');});
Route::post('/AnuncioSave', [catalogoanuncioController::class, 'store']);
 Route::get('/Tablanuncios', [catalogoanuncioController::class, 'Tablanuncios']);
 Route::get('/AnuncioDelete', [catalogoanuncioController::class, 'store']);
Route::get('/anunciofoto/{id}', [catalogoanuncioController::class, 'mostrarfotoanuncio'])->name('anunciofoto');

// Route::get('anuncio/foto/{anuncio_id}', [catalogoanuncioController::class, 'mostrarfotoanuncio'])->name('mostrar.foto.anuncio');

// CATALOGOS
Route::get('/Catálogo_ppt', function () {return view('RH.Catalogos.catalogo_ppt');});
Route::get('/Catálogo_dpt', function () {return view('RH.Catalogos.catalogo_dpt');});
Route::get('/Catálogo_requisición', function () {return view('RH.Catalogos.catalogo_requisicion');});
Route::get('/Catálogo_generales', function () {return view('RH.Catalogos.catalogo_generales');});





//==============================================  RECLUTAMIENTO  ============================================== 

// FORMULARIO DE BANCO DE CV EXTERNO A LA APLICACIÓN
Route::get('/Formulario-vacantes', [bancocvController::class, 'index1']); //// RUTA EXTERNA ////

Route::post('/BancoSave', [bancocvController::class, 'store']);
Route::post('/FormCVSave', [formCVController::class, 'store']);
Route::post('/actualizarinfocv', [formCVController::class, 'actualizarinfocv'])->name('actualizarinfocv');

//  TABLA PARA PODER LA INFORMACIÓN DEL FORMULARIO DE BANCO DE CV 
Route::get('/Listavacantes', [bancocvController::class, 'index']);
Route::get('/BancoDelete', [bancocvController::class, 'store']);
Route::get('/Tablabancocv', [bancocvController::class, 'Tablabancocv']);
Route::get('/mostrarCurpCv/{id}', [bancocvController::class, 'mostrarCurpCv']);
Route::get('/mostrarCv/{id}', [bancocvController::class, 'mostrarCv']);

// RUTA PARA VER LAS VACANTES EXTERNA EN LA APLICACIÓN
Route::get('/Vacantes', [PuestoController::class, 'index']); //// RUTA EXTERNA ////
Route::post('/actualizarinfo', [PuestoController::class, 'getCvInfo'])->name('actualizarinfo');
Route::post('/ActualizarSave', [PuestoController::class, 'store']);
Route::post('/PostularseSave', [PuestoController::class, 'store1']);

// CATÁLOGO DE VACANTES
Route::get('/CatálogoDeVacantes', [catalogovacantesController::class, 'index']);
Route::post('/VacantesSave', [catalogovacantesController::class, 'store']);
Route::get('/VacanteDelete', [catalogovacantesController::class, 'store']);
Route::get('/Tablavacantes', [catalogovacantesController::class, 'Tablavacantes']);

//  CATÁLOGO ÁREA DE INTERESES
Route::get('/Área_interes', function () {return view('RH.Catalogos.catalogo_areainteres');});
Route::post('/interesSave', [catalogoareainteresController::class, 'store']);
Route::get('/interesDelete', [catalogoareainteresController::class, 'store']);
Route::get('/Tablaareainteres', [catalogoareainteresController::class, 'Tablaareainteres']);

// VISUALIZAR LA VACANTES Y PODER VER LOS QUE SE HAN POSTULADO Y PODER MANDAR A SELECCIÓN
Route::get('/Postulaciones', [vacantesactivasController::class, 'index']);
Route::get('/Tablapostulaciones', [vacantesactivasController::class, 'Tablapostulaciones']);
Route::post('/VacantesactSave', [vacantesactivasController::class, 'store']);

// PODER VISUALIZAR LA INFORMACIÓN DE LOS POSTULANTES Y GUARDARLOS 
Route::get('/informacionpostulantes/{idVacante}', [vacantesactivasController::class, 'informacionpostulantes']);
Route::get('/obtener-cv/{curp}', [vacantesactivasController::class, 'mostrarCvPorCurp'])->name('mostrarCvPorCurp');
Route::post('/guardarPostulantes', [vacantesactivasController::class, 'guardarPostulantes']);

// PODER VISUALIZAR LA INFORMACIÓN DE LOS QUE SE VAN A  PRESELECCIONAR Y  MANDARLOS A SELECCIÓN
Route::post('/guardarPreseleccion', [vacantesactivasController::class, 'guardarPreseleccion']);
Route::get('/informacionpreseleccion/{idVacante}', [VacantesactivasController::class, 'informacionpreseleccion']);
Route::post('/actualizarDisponibilidad', [VacantesactivasController::class, 'actualizarDisponibilidad']);




//==============================================  SELECCION  ============================================== 

// VISUALIZAR HISTORIAL DE SELECCION



Route::get('/Visualizar_selección', [seleccionController::class, 'index2'])->middleware('role:Superusuario,Administrador');
Route::get('/Tablaseleccion2Visualizar', [seleccionController::class, 'Tablaseleccion2Visualizar']);

Route::get('/consultarSeleccion2Visualizar/{vacantesId}', [seleccionController::class, 'consultarSeleccion2Visualizar']);


// SELECCION

Route::get('/Selección', [seleccionController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::get('/Tablaseleccion', [seleccionController::class, 'Tablaseleccion']);
Route::post('/SeleccionSave', [seleccionController::class, 'store']);
Route::get('/consultarSeleccion/{vacantesId}', [seleccionController::class, 'consultarSeleccion']);
Route::post('/guardarPendiente', [seleccionController::class, 'guardarPendiente']);

// AUTORIZACION
Route::get('/ver-archivo/{curp}', [seleccionController::class, 'visualizarArchivo']);
Route::get('/ver-pdf', [seleccionController::class, 'mostrarPDF'])->name('ver-pdf');
Route::get('/Tablaautorizacion', [seleccionController::class, 'Tablaautorizacion']);

// INTELIGENCIA LABORAL
Route::get('/Tablainteligencia', [seleccionController::class, 'Tablainteligencia']);
Route::get('/mostrarcompetencias/{id}', [seleccionController::class, 'mostrarcompetencias']);
Route::get('/mostrarcompleto/{id}', [seleccionController::class, 'mostrarcompleto']);

// BURÓ LABORAL
Route::get('/Tablaburo', [seleccionController::class, 'Tablaburo']);
Route::get('/mostrarburo/{id}', [seleccionController::class, 'mostrarburo']);

// PERFIL DE PUESTO DE TRABAJO (PPT)
Route::get('/Tablapptseleccion', [seleccionController::class, 'Tablapptseleccion']);
Route::get('/consultarformppt/{id}', [seleccionController::class, 'consultarformppt']);

// REFERENCIAS LABORAL
Route::get('/Tablareferencia', [seleccionController::class, 'Tablareferencia']);
Route::get('/mostrareferencias/{id}', [seleccionController::class, 'mostrareferencias']);

// PRUEBAS DE CONOCIMIENTOS
Route::get('/obtenerRequerimientos/{id}', [seleccionController::class, 'obtenerRequerimientos']);
Route::get('/Tablapruebaconocimientoseleccion', [seleccionController::class, 'Tablapruebaconocimientoseleccion']);
Route::get('/mostrarprueba/{id}', [seleccionController::class, 'mostrarprueba']);

// ENTREVISTA
Route::get('/Tablaentrevistaseleccion', [seleccionController::class, 'Tablaentrevistaseleccion']);

// CATÁLOGO DE PRUEBAS DE CONOCIMIENTOS
Route::get('/Pruebas-conocimientos', function () {return view('RH.Catalogos.catalogo_pruebasconocimiento');});
Route::post('/pruebaSave', [catalogopruebasController::class, 'store']);
Route::get('/pruebaDelete', [catalogopruebasController::class, 'store']);
Route::get('/Tablapruebaconocimiento', [catalogopruebasController::class, 'Tablapruebaconocimiento']);


//==============================================  CONTRATACION  ============================================== 

// PENDIENTE AL CONTRATAR
Route::get('/Pendiente-Contratar', function () {return view('RH.contratacion.pendientecontratar');});
Route::get('/Tablapendientecontratacion', [pendientecontratarController::class, 'Tablapendientecontratacion']);
Route::post('/mandarcontratacion', [pendientecontratarController::class, 'mandarcontratacion']);

Route::get('/obtenerInformacionContrato/{contrato_id}', [contratacionController::class, 'obtenerInformacionContrato']);

/////////////////////////////////////// STEP 1 DATOS GENERALES
Route::get('/Contratación', [contratacionController::class, 'index']);
Route::post('/contratoSave', [contratacionController::class, 'store']);
Route::post('/obtenerbajasalta', [contratacionController::class, 'obtenerbajasalta']);
Route::get('/Tablacontratacion', [contratacionController::class, 'Tablacontratacion']);
Route::get('/Tablacontratacion1', [contratacionController::class, 'Tablacontratacion1']);
Route::post('/activarColaborador/{id}', [contratacionController::class, 'activarColaborador']);
Route::get('/usuariocolaborador/{id}', [contratacionController::class, 'mostrarfotocolaborador']);
Route::post('/verificarestadobloqueo', [contratacionController::class, 'verificarestadobloqueo']);

Route::post('/obtenerUltimoCargo', [contratacionController::class, 'obtenerUltimoCargo']);


// CREAR CREDENCIAL 
Route::get('/descargar-credencial', [PowerPointController::class, 'descargarCredencial']);
Route::get('/prueba-presentation', [TestController::class, 'prueba']);
Route::get('/prueba-editar', [TestController::class, 'editarPlantilla']);

/////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE
Route::get('/Tabladocumentosoporte', [contratacionController::class, 'Tabladocumentosoporte']);
Route::get('/mostrardocumentosoporte/{id}', [contratacionController::class, 'mostrardocumentosoporte']);
Route::post('/obtenerguardados', [contratacionController::class, 'obtenerguardados']);

/////////////////////////////////////// STEP 3 CONTRATOS Y ANEXOS 
Route::get('/Tablacontratosyanexos', [contratacionController::class, 'Tablacontratosyanexos']);
Route::get('/mostrarcontratosyanexos/{id}', [contratacionController::class, 'mostrarcontratosyanexos']);

// DOCUMENTOS DE SOPORTE DEL CONTRATO  
Route::get('/Tabladocumentosoportecontrato', [contratacionController::class, 'Tabladocumentosoportecontrato']);
Route::get('/mostrardocumentosoportecontrato/{id}', [contratacionController::class, 'mostrardocumentosoportecontrato']);

// RENOVACION DE CONTRATO
Route::get('/Tablarenovacioncontrato', [contratacionController::class, 'Tablarenovacioncontrato']);
Route::get('/mostrardocumentorenovacion/{id}', [contratacionController::class, 'mostrardocumentorenovacion']);

// INFORAMCION MEDICA 
Route::get('/Tablainformacionmedica', [contratacionController::class, 'Tablainformacionmedica']);
Route::get('/mostrarinformacionmedica/{id}', [contratacionController::class, 'mostrarinformacionmedica']);

// INCIDENCIAS 
Route::get('/Tablaincidencias', [contratacionController::class, 'Tablaincidencias']);
Route::get('/mostrarincidencias/{id}', [contratacionController::class, 'mostrarincidencias']);

// INCIDENCIAS 
Route::get('/Tablaccionesdisciplinarias', [contratacionController::class, 'Tablaccionesdisciplinarias']);
Route::get('/mostraracciones/{id}', [contratacionController::class, 'mostraracciones']);

// RECIBOS DE NOMINA
Route::get('/Tablarecibonomina', [contratacionController::class, 'Tablarecibonomina']);
Route::get('/mostrarecibosnomina/{id}', [contratacionController::class, 'mostrarecibosnomina']);

/////////////////////////////////////// STEP 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL
Route::get('/Tablasoportecontrato', [contratacionController::class, 'Tablasoportecontrato']);
Route::get('/mostrardocumentocolaboradorcontratosoporte/{id}', [contratacionController::class, 'mostrardocumentocolaboradorcontratosoporte']);
Route::post('/obtenerdocumentosoportescontratos', [contratacionController::class, 'obtenerdocumentosoportescontratos']);


/////////////////////////////////////// STEP 5 CV

Route::post('/cvSave', [CvController::class, 'store']);
Route::get('/Tablacvs', [CvController::class, 'Tablacvs']);
Route::get('/mostrarFotoCV/{id}', [CvController::class, 'mostrarFotoCV']);


/////////////////////////////////////// STEP 6 REQUISICION DE PERSONAL 

Route::get('/Tablarequisicioncontratacion', [contratacionController::class, 'Tablarequisicioncontratacion']);
Route::get('/obtenerDatosCategoria', [contratacionController::class, 'obtenerDatosCategoria']);
Route::get('/mostrarrequisicon/{id}', [contratacionController::class, 'mostrarrequisicon']);



//============================================== RECURSOS DE LOS EMPLEADOS ============================================== 

Route::get('/Rec.Empleado', function () {return view('RH.RecEmpleados.RecEmpleados');});

 //============================================== DESVINCULACIÓN ============================================== 

Route::get('/Desvinculación', [desvinculacionController::class, 'index']);
Route::post('/desvinculacionSave', [desvinculacionController::class, 'store']);
Route::get('/Tabladesvinculacion', [desvinculacionController::class, 'Tabladesvinculacion']);
Route::get('/mostrardocumentobaja/{id}', [desvinculacionController::class, 'mostrardocumentobaja']);
Route::get('/mostrardocumenconvenio/{id}', [desvinculacionController::class, 'mostrardocumenconvenio']);
Route::get('/mostrardocumenadeudo/{id}', [desvinculacionController::class, 'mostrardocumenadeudo']);










//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////VENTAS///////////////////////////////////////////////////////7
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================  SOLICITUDES  ============================================== 
 Route::get('/Solicitudes', [solicitudesController::class, 'index']);

// Route::get('/Solicitudes', function () {
//     // Encriptar la ruta para redirigir a la versión encriptada
//     $encryptedRoute = Crypt::encryptString('Solicitudes');
//     return redirect()->route('route.encrypted', ['encryptedRoute' => $encryptedRoute]);
// });


Route::post('/solicitudSave', [solicitudesController::class, 'store']);
Route::get('/Tablasolicitudes', [solicitudesController::class, 'Tablasolicitudes']);
Route::get('/solicitudDelete', [solicitudesController::class, 'store']);
Route::post('/actualizarEstatusSolicitud', [solicitudesController::class, 'actualizarEstatusSolicitud']);
Route::get('/mostrarverificacioncliente/{id}', [solicitudesController::class, 'mostrarverificacioncliente']);
Route::post('/actualizarSolicitud', [solicitudesController::class, 'actualizarSolicitud']);

//==============================================  OFERTAS/COTIZACION  ============================================== 
Route::get('/Ofertas', [ofertasController::class, 'index']);
Route::post('/ofertaSave', [ofertasController::class, 'store']);
Route::get('/Tablaofertas', [ofertasController::class, 'Tablaofertas']);
Route::get('/ofertaDelete', [ofertasController::class, 'store']);
Route::post('/actualizarEstatusOferta', [ofertasController::class, 'actualizarEstatusOferta']);
Route::get('/mostrarcotizacion/{id}', [ofertasController::class, 'mostrarcotizacion']);

//==============================================   CONFIRMACION DEL SERVICIO  ============================================== 
Route::get('/Confirmación', [confirmacionController::class, 'index']);
Route::get('/Tablaconfirmacion', [confirmacionController::class, 'Tablaconfirmacion']);
Route::post('/ContratacionSave', [confirmacionController::class, 'store']);
Route::get('/mostraraceptacion/{id}', [confirmacionController::class, 'mostraraceptacion']);
Route::get('/confirmacionDelete', [confirmacionController::class, 'store']);
Route::get('/mostrarevidencias/{id}', [confirmacionController::class, 'mostrarevidencias']);

//==============================================   ORDEN DE TRABAJO  ============================================== 
Route::get('/Orden_trabajo', [otController::class, 'index']);
Route::get('/Tablaordentrabajo', [otController::class, 'Tablaordentrabajo']);
Route::post('/otSave', [otController::class, 'store']);


//==============================================   CATALOGOS SOLICITUDES ============================================== 

Route::get('/Catálogo_solicitudes', function () {return view('ventas.Catalogos.catalogos_solicitud');});


// CATÁLOGO DE MEDIO DE CONTACTO 

Route::get('/Catálogo_medio_contacto', function () {return view('ventas.Catalogos.catalogo_mediocontacto');});
Route::post('/MedioSave', [catalogomediocontactoController::class, 'store']);
Route::get('/MedioDelete', [catalogomediocontactoController::class, 'store']);
Route::get('/Tablamediocontacto', [catalogomediocontactoController::class, 'Tablamediocontacto']);

// CATÁLOGO DE  GIRO DE EMPRESA

Route::get('/Catálogo_giro_empresa', function () {return view('ventas.Catalogos.catalogo_giroempresa');});
Route::post('/GiroSave', [catalogogiroempresaController::class, 'store']);
Route::get('/GiroDelete', [catalogogiroempresaController::class, 'store']);
Route::get('/Tablagiroempresa', [catalogogiroempresaController::class, 'Tablagiroempresa']);

// CATÁLOGO DE  NECESIDAD SERVICIO

Route::get('/Catálogo_necesidad_servicio', function () {return view('ventas.Catalogos.catalogo_necesidadservicio');});
Route::post('/NecesidadSave', [catalogonecesidadController::class, 'store']);
Route::get('/NecesidadDelete', [catalogonecesidadController::class, 'store']);
Route::get('/Tablanecesidadservicio', [catalogonecesidadController::class, 'Tablanecesidadservicio']);

// CATÁLOGO DE LINEA DE NEGOCIO

Route::get('/Catálogo_línea_negocio', function () {return view('ventas.Catalogos.catalogo_lineanegocio');});
Route::post('/LineaSave', [catalogolineanegociosController::class, 'store']);
Route::get('/LineaDelete', [catalogolineanegociosController::class, 'store']);
Route::get('/Tablalineanegocio', [catalogolineanegociosController::class, 'Tablalineanegocio']);


// CATÁLOGO DE TIPO DE SERVICIO

Route::get('/Catálogo_tipo_servicio', function () {return view('ventas.Catalogos.catalogo_tiposervicio');});
Route::post('/TiposSave', [catalogotiposervicioController::class, 'store']);
Route::get('/TiposDelete', [catalogotiposervicioController::class, 'store']);
Route::get('/Tablatiposervicio', [catalogotiposervicioController::class, 'Tablatiposervicio']);



//==============================================   CATALOGOS CONFIRMACION ============================================== 
Route::get('/Catálogo_confirmación', function () {return view('ventas.Catalogos.catalogos_confirmacion');});



// CATÁLOGO DE VERIFIACION DEL CLIENTE

Route::get('/Catálogo_verificación', function () {return view('ventas.Catalogos.catalago_verificacioncliente');});
Route::post('/InformacionSave', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/InformacionDelete', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/Tablaverificacioncliente', [catalagoverificacioninformacionController::class, 'Tablaverificacioncliente']);





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////COMPRAS///////////////////////////////////////////////////////7
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================  M.R  ============================================== 


Route::get('/Requisición_Materiales', function () {return view('compras.requisicionesmaterial.requisicion_material');});

Route::post('/MrSave', [mrController::class, 'store']);
Route::get('/Tablamr', [mrController::class, 'Tablamr']);


Route::get('/Bitácora', function () {return view('compras.requisicionesmaterial.bitacora');});


//==============================================   DIRECTORIO INTERNO  ============================================== 



Route::get('/Banco_proveedores', function () {return view('compras.proveedores.proveedorespotencial');});
Route::get('/Tabladirectorio', [directorioController::class, 'Tabladirectorio']);
Route::get('/ServicioDelete', [directorioController::class, 'store']);


//==============================================    LISTA DE PROVEEDORES  ============================================== 


//==============================================   CATALOGOS PROVEEDORES  ============================================== 
Route::get('/Catálogos_proveedores', function () {return view('compras.Catalogos.catalogo_generales');});



//  CATALOGO FUNCIONEES/AREAS CONTACTOS
Route::get('/Catálogo_funciones', function () {return view('compras.Catalogos.catalogo_funcionproveedor');});
Route::post('/FuncionesareasSave', [catalagofuncionesproveedorController::class, 'store']);
Route::get('/Tablafuncionescontacto', [catalagofuncionesproveedorController::class, 'Tablafuncionescontacto']);
Route::get('/FuncionesareasDelete', [catalagofuncionesproveedorController::class, 'store']);


//  CATALOGO TITULO 

Route::get('/Catálogo_títulos', function () { return view('compras.Catalogos.catalogo_titulosproveedor');});
Route::post('/TituloSave', [catalagotituloproveedorController::class, 'store']);
Route::get('/Tablatitulocontacto', [catalagotituloproveedorController::class, 'Tablatitulocontacto']);
Route::get('/TituloDelete', [catalagotituloproveedorController::class, 'store']);


//==============================================  PROVEEDOR  ============================================== 
Route::get('/Lista_proveedores', [listaproveedorController::class, 'index']);
Route::get('/Tablalistaproveedores', [listaproveedorController::class, 'Tablalistaproveedores']);
Route::post('/AltaSave1', [listaproveedorController::class, 'store']);
Route::get('/Tablacuentas', [listaproveedorController::class, 'Tablacuentas']);
Route::get('/Tablacontactos', [listaproveedorController::class, 'Tablacontactos']);
Route::get('/Tablacertificaciones', [listaproveedorController::class, 'Tablacertificaciones']);
Route::get('/Tablareferencias', [listaproveedorController::class, 'Tablareferencias']);


//  DIRECTORIO EXTERNO


Route::get('/Directorio', function () {return view('compras.proveedores.directorio');});
Route::post('/ServiciosSave', [directorioController::class, 'store']);
Route::get('/mostrarconstanciaproveedor/{id}', [directorioController::class, 'mostrarconstanciaproveedor']);
Route::post('/actualizarinfoproveedor', [directorioController::class, 'actualizarinfoproveedor'])->name('actualizarinfoproveedor');


//  ALTA 
Route::get('/Alta', function () {return view('compras.proveedores.altaproveedores');});
Route::get('/obtenerDatosProveedor', [altaproveedorController::class, 'obtenerDatosProveedor']);
Route::post('/AltaSave', [altaproveedorController::class, 'store']);


//ALTA DE CERTIFICACIONES
Route::get('/Proveedores_Certificaciones', function () {return view('compras.proveedores.altacertificacion');});
Route::post('/AltacertificacionSave', [altacerticacionController::class, 'store']);
Route::get('/Tablacertificacionproveedores', [altacerticacionController::class, 'Tablacertificacionproveedores']);
Route::get('/CertificacionDelete', [altacerticacionController::class, 'store']);
Route::get('/mostrarcertificacion/{id}', [altacerticacionController::class, 'mostrarcertificacion']);
Route::get('/mostraracreditacion/{id}', [altacerticacionController::class, 'mostraracreditacion']);
Route::get('/mostrarautorizacion/{id}', [altacerticacionController::class, 'mostrarautorizacion']);
Route::get('/mostrarmembresia/{id}', [altacerticacionController::class, 'mostrarmembresia']);


//ALTA DE REFERENCIAS 

Route::get('/Proveedores_Referencias', function () {return view('compras.proveedores.altareferencias');});
Route::post('/AltareferenciaSave', [altareferenciasController::class, 'store']);
Route::get('/Tablareferenciasproveedor', [altareferenciasController::class, 'Tablareferenciasproveedor']);
Route::get('/ReferenciasDelete', [altacontactoController::class, 'store']);

//ALTA DE CONTACTOS
// Route::get('/Proveedores_Contactos', function () {return view('compras.proveedores.altacontactos');});
Route::get('/Proveedores_Contactos', [altacontactoController::class, 'index']);
Route::get('/Tablacontactosproveedor', [altacontactoController::class, 'Tablacontactosproveedor']);
Route::post('/AltacontactoSave', [altacontactoController::class, 'store']);
Route::get('/ContactoDelete', [altacontactoController::class, 'store']);




Route::get('/Proveedores_documentos', function () { return view('compras.proveedores.altadocumentosoporte');});


//ALTA DE CUENTAS BANCARIAS 
Route::get('/Proveedores_Cuentas', function () { return view('compras.proveedores.altacuentas');});
Route::post('/AltacuentaSave', [altacuentaController::class, 'store']);
Route::get('/Tablacuentasproveedores', [altacuentaController::class, 'Tablacuentasproveedores']);
Route::get('/CuentasDelete', [altacuentaController::class, 'store']);
Route::get('/mostrarcaratula/{id}', [altacuentaController::class, 'mostrarcaratula']);


//==============================================  EXTERNO  ============================================== 
Route::get('/Proveedor', function () {return view('compras.externa.diseño');});


//============================================== ENCRIPTAR TURAS ============================================== 


// Route::get('/{encryptedRoute}', function ($encryptedRoute) {
//     try {
//         $decryptedRoute = Crypt::decryptString($encryptedRoute);

//         switch ($decryptedRoute) {
//             case 'Directorio':
//                 return view('compras.proveedores.directorio');
//             case 'Alta':
//                 return view('compras.proveedores.altaproveedores');
//             default:
//                 abort(404);
//         }
//     } catch (\Exception $e) {
//         abort(404);
//     }
// })->name('route.encrypted');


// Route::get('/{encryptedRoute}', function ($encryptedRoute) {
//     try {
//         // Desencriptar la URL
//         $decryptedRoute = Crypt::decryptString($encryptedRoute);

//         // Verificar la ruta desencriptada
//         switch ($decryptedRoute) {
//             // case 'Solicitudes':
//             //     // Llamar al controlador y su método 'index'
//             //     return app(SolicitudesController::class)->index();
//             case 'Directorio':
//                 return view('compras.proveedores.directorio');
//             default:
//                 abort(404);
//         }
//     } catch (\Exception $e) {
//         // En caso de que la encriptación falle, lanzar error 404
//         abort(404);
//     }
// })->name('route.encrypted');
//============================================== C.P ============================================== 


// Route::get('codigo-postal/{cp}', function ($cp) {
//     $token = env('COPOMEX_API_TOKEN'); // Obtiene el token del archivo .env
//     $url = "https://api.copomex.com/query/info_cp/{$cp}?type=simplified&token={$token}";

//     $response = Http::get($url);

//     if ($response->successful()) {
//         dd($response->json()); // Esto imprimirá la respuesta en el navegador para revisión
//     }

//     return response()->json([
//         'error' => true,
//         'mensaje' => 'No se pudo obtener información de Copomex',
//         'status' => $response->status(),
//         'detalle' => $response->body()
//     ], 400);
// });



Route::get('codigo-postal/{cp}', function ($cp) {
    $token = "a5ba768d-eeac-4c0f-b0be-202ef91df93c";
    $url = "https://api.copomex.com/query/info_cp/{$cp}?type=simplified&token={$token}";

    $response = Http::get($url);

    if ($response->successful()) {
        return response()->json($response->json()); 
    }

    return response()->json([
        'error' => true,
        'mensaje' => 'No se pudo obtener información de Copomex',
        'status' => $response->status(),
        'detalle' => $response->body()
    ], 400);
});


//============================================== LIMPIAR RUTAS ============================================== 


Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Application cache cleared';
});



