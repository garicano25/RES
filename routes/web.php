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

// CONTROLADORES DE REC.EMPLEADOS
use App\Http\Controllers\recursosempleado\recempleadoController;
use App\Http\Controllers\recursosempleado\pdfrecempleadoController;


// CONTROLADORES DE CAPACITACION 
use App\Http\Controllers\capacitacion\brechaController;

// CONTROLADORES DE DESVINCULACION
use App\Http\Controllers\desvinculacion\desvinculacionController;

// CONTROLADORES DE CLIENTES
use App\Http\Controllers\clientes\clientesController;

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
use App\Http\Controllers\proveedor\altadocumentosController;
use App\Http\Controllers\proveedor\listaproveedorController;
use App\Http\Controllers\proveedor\proveedortempController;
use App\Http\Controllers\proveedor\catalagofuncionesproveedorController;
use App\Http\Controllers\proveedor\catalagotituloproveedorController;
use App\Http\Controllers\proveedor\catalagodocumentosproveedorController;
use App\Http\Controllers\proveedor\catalogoverificacionproveedorController;
use App\Http\Controllers\proveedor\listaproveedorescriticosController;

// CONTROLADORES DE PO 
use App\Http\Controllers\ordencompra\poController;
use App\Http\Controllers\ordencompra\pdfpoController;

// CONTROLADORES DE MATRIZ COMPARATIVA
use App\Http\Controllers\matrizcomparativa\matrizController;

// GENERAR PDF
use App\Http\Controllers\pdf\pdfController;

// CONTROLADORES GR  
use App\Http\Controllers\requisicongr\grController;
use App\Http\Controllers\requisicongr\vobogrusuarioController;
use App\Http\Controllers\requisicongr\pdfgrController;

// CONTROLADORES DE LA PAGINA WEB
use App\Http\Controllers\paginaweb\mensajespaginaController;

// CONTROLADORES DE INVENTARIO
use App\Http\Controllers\inventario\inventarioController;
use App\Http\Controllers\inventario\catalogotipoinventarioController;
use App\Http\Controllers\inventario\salidalmacenController;
use App\Http\Controllers\aprobacionsalidalmacen\aprobacionsalidalmacenController;
use App\Http\Controllers\listaaf\listaafController;
use App\Http\Controllers\listaafn\listaafnController;
use App\Http\Controllers\listacomercializacion\listacomercializacionController;
use App\Http\Controllers\listaitemcritico\listaitemcriticoController;
use App\Http\Controllers\listaalerta\listaalertaController;


//// BITACORAS INVENTARIO

use App\Http\Controllers\bitacorasinventario\bitacoraconsumiblesController;
use App\Http\Controllers\bitacorasinventario\bitacoraretornableController;
use App\Http\Controllers\bitacorasinventario\bitacoravehiculosController;


/// NOTIFICACIONES 

use App\Http\Controllers\notificacion\notificacionController;


//==============================================  login  ============================================== 
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasAnyRole(['Superusuario', 'Administrador'])) {
            return redirect('/modulos');
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

//==============================================  ENVIAR CORREO  ============================================== 

Route::post('/enviar-codigo', [VerificationController::class, 'enviarCodigo']);
Route::post('/verificar-codigo', [VerificationController::class, 'verificarCodigo']);
//==============================================  Módulos  ============================================== 

// Route::get('/modulos', [catalogoanuncioController::class, 'index'])->middleware('role:Superusuario,Administrador,Líder contable y financiero,Asistente de compras,Almacenista,Líder RRHH y Administración,Intendente,Líder de Operaciones,Consultor-Instructor (Junior/Senior),Ejecutivo de ventas,Asistente contable,Analista HSEQ,Asistente de planeación y logística,Desarrollador de Software Junior,Consultor-Instructor Junior,Ama de llaves');


Route::get('/modulos', [catalogoanuncioController::class, 'index']);

Route::get('/tipo-cambio', [catalogoanuncioController::class, 'getTipoCambio']);

//==============================================  USUARIO  ============================================== 


Route::get('/usuario', [usuarioController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::post('/usuarioSave', [usuarioController::class, 'store']);
Route::get('/Tablausuarios', [usuarioController::class, 'Tablausuarios']);
Route::get('/Tablaproveedores', [usuarioController::class, 'Tablaproveedores']);
Route::get('/usuarioDelete', [usuarioController::class, 'store']);
Route::get('/usuariofoto/{id}', [usuarioController::class, 'mostrarFotoUsuario'])->name('usuariofoto');

Route::post('/validarRFC', [usuarioController::class, 'validarRFC']);



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
Route::get('/ppt', [pptController::class, 'index'])->middleware('role:Superusuario,Administrador,Analista HSEQ,Asistente de planeación y logística,Desarrollador de software,Intendente,Consultor-Instructor (Junior/Senior)');
Route::post('/pptSave', [pptController::class, 'store']);
Route::get('/TablaPPT', [pptController::class, 'TablaPPT']);
Route::get('/autorizarPPT/{id_formulario}', [pptController::class, 'autorizarPPT']);
Route::get('/revisarPPT/{id_formulario}', [pptController::class, 'revisarPPT']);
Route::get('/makeExcelPPT/{id_formulario}', [makeExcelController::class, 'makeExcelPPT']);
Route::get('pptDelete', [pptController::class, 'store']);

// DPT
Route::get('/dpt', [dptController::class, 'index']);
Route::post('/dptSave', [dptController::class, 'store']);
Route::get('/TablaDPT', [dptController::class, 'TablaDPT']);
Route::get('/dptDelete', [dptController::class, 'store']);

Route::get('/makeExcelDPT/{id_formulario}', [makeExcelController::class, 'makeExcelDPT']);
Route::get('/infoReportan/{ID}/{LIDER}', [dptController::class, 'infoReportan']);
Route::get('/consultarfuncionescargo/{areaId}', [dptController::class, 'consultarfuncionescargo']);

// REQUERIMIENTO PERSONAL 
Route::get('/requisiciondepersonal', [requerimientoPersonalController::class, 'index'])->middleware('role:Superusuario,Administrador');
Route::post('/RequerimientoSave', [requerimientoPersonalController::class, 'store']);
Route::get('/RequerimientoDelete', [requerimientoPersonalController::class, 'store']);
Route::get('/Tablarequerimiento', [requerimientoPersonalController::class, 'Tablarequerimiento']);
Route::get('/makeExcelRP/{id_formulario}', [makeExcelController::class, 'makeExcelRP']);
Route::get('/mostrardocumentorequisicion/{id}', [requerimientoPersonalController::class, 'mostrardocumentorequisicion']);

// CATÁLOGO DE JERARQUÍA
Route::get('/jerarquico', function () {return view('RH.Catalogos.catalogo_Jerárquico');});
Route::post('/jerarquiaSave', [catalogosController::class, 'store']);
Route::get('/jerarquiaDelete', [catalogosController::class, 'store']);
Route::get('/Tablajerarquia', [catalogosController::class, 'Tablajerarquia']);

// CATÁLOGO DE ASESORES
Route::get('/asesores', function () {return view('RH.Catalogos.catalogo_asesores');});
Route::post('/asesorSave', [catalogosasesoresController::class, 'store']);
Route::get('/asesorDelete', [catalogosasesoresController::class, 'store']);
Route::get('/Tablaasesores', [catalogosasesoresController::class, 'Tablaasesores']);

// CATÁLOGO DE FUNCIONES CARGO
Route::get('/funcionescargo', [catalogosfuncionescargoController::class, 'index']);
Route::post('/CargoSave', [catalogosfuncionescargoController::class, 'store']);
Route::get('/CargoDelete', [catalogosfuncionescargoController::class, 'store']);
Route::get('/Tablaafuncionescargo', [catalogosfuncionescargoController::class, 'Tablaafuncionescargo']);

// CATÁLOGO DE FUNCIONES GESTIONES
Route::get('/funcionesgestion', function () {return view('RH.Catalogos.catalogo_funcionesgestion');});
Route::post('/GestionSave', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/GestionDelete', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/Tablafuncionesgestion', [catalogosfuncionesgestionController::class, 'Tablafuncionesgestion']);

// CATÁLOGO DE RELACIONES EXTERNAS 
Route::get('/relacionesexternas', function () {return view('RH.Catalogos.catalogo_relacionesexternas');});
Route::post('/ExternaSave', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/ExternaDelete', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/Tablarelacionesexterna', [catalogosrelacionesexternasController::class, 'Tablarelacionesexterna']);

// CATÁLOGO DE CATEGORÍAS
Route::get('/categorias', [catalogocategoriaControlller::class, 'index']);
Route::post('/CategoriaSave', [catalogocategoriaControlller::class, 'store']);
Route::get('CategoriaDelete', [catalogocategoriaControlller::class, 'store']);
Route::get('/Tablacategoria', [catalogocategoriaControlller::class, 'Tablacategoria']);

// CATÁLOGO DE GÉNERO 
Route::get('/genero', function () {return view('RH.Catalogos.catalogo_genero');});
Route::post('/GeneroSave', [catalogogeneroControlller::class, 'store']);
Route::get('/GeneroDelete', [catalogogeneroControlller::class, 'store']);
Route::get('/Tablageneros', [catalogogeneroControlller::class, 'Tablageneros']);

// CATÁLOGO DE PUESTO QUE SE REQUIERE COMO EXPERIENCIA
Route::get('/puestoexperiencia', function () {return view('RH.Catalogos.catalogo_experiencia');});
Route::post('/PuestoSave', [catalogoexperienciaController::class, 'store']);
Route::get('/PuestoDelete', [catalogoexperienciaController::class, 'store']);
Route::get('/Tablaexperiencia', [catalogoexperienciaController::class, 'Tablaexperiencia']);

// CATÁLOGO COMPETENCIAS BÁSICAS O CARDINALES 
Route::get('/competenciasbasicas', function () {return view('RH.Catalogos.catalogo_competenciasbasicas');});
Route::post('/BasicoSave', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/BasicoDelete', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/Tablacompetenciabasica', [catalogocompetenciabasicaController::class, 'Tablacompetenciabasica']);

// CATÁLOGO COMPETENCIAS GERENCIALES 
Route::get('/competenciasgerenciales', function () {return view('RH.Catalogos.catalogo_competenciasGerenciales'); });
Route::post('/GerencialesSave', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/GerencialesDelete', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/TablaCompetenciasGerenciales', [catalogoCompotenciasGerencialesController::class, 'TablaCompetenciasGerenciales']);

// CATÁLOGO DE TIPO DE VACANTES
Route::get('/tipovacante', function () {return view('RH.Catalogos.catalogo_tipovacante');});
Route::post('/TipoSave', [catalogotipovacanteController::class, 'store']);
Route::get('/TipoDelete', [catalogotipovacanteController::class, 'store']);
Route::get('/Tablatipovacantes', [catalogotipovacanteController::class, 'Tablatipovacantes']);

// CATÁLOGO DE  MOTIVO DE VACANTES 
Route::get('/motivovacante', function () {return view('RH.Catalogos.catalogo_motivovacante');});
Route::post('/MotivoSave', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/MotivoDelete', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/Tablamotivovacante', [catalogomotivovacanteControlller::class, 'Tablamotivovacante']);



// CATÁLOGO DE ANUNCIO
Route::get('/anuncios', function () { return view('RH.Catalogos.catalogo_anucios');});
Route::post('/AnuncioSave', [catalogoanuncioController::class, 'store']);
Route::get('/Tablanuncios', [catalogoanuncioController::class, 'Tablanuncios']);
Route::get('/AnuncioDelete', [catalogoanuncioController::class, 'store']);
Route::get('/anunciofoto/{id}', [catalogoanuncioController::class, 'mostrarfotoanuncio'])->name('anunciofoto');

// CATALOGOS
Route::get('/catalogoppt', function () {return view('RH.Catalogos.catalogo_ppt');});
Route::get('/catalogodpt', function () {return view('RH.Catalogos.catalogo_dpt');});
Route::get('/catalogorequisicion', function () {return view('RH.Catalogos.catalogo_requisicion');});
Route::get('/catalogogenerales', function () {return view('RH.Catalogos.catalogo_generales');});





//==============================================  RECLUTAMIENTO  ============================================== 


Route::post('/BancoSave', [bancocvController::class, 'store']);
Route::post('/FormCVSave', [formCVController::class, 'store']);
Route::post('/actualizarinfocv', [formCVController::class, 'actualizarinfocv'])->name('actualizarinfocv');

//  TABLA PARA PODER LA INFORMACIÓN DEL FORMULARIO DE BANCO DE CV 
Route::get('/listavacantes', [bancocvController::class, 'index']);
Route::get('/BancoDelete', [bancocvController::class, 'store']);
Route::get('/Tablabancocv', [bancocvController::class, 'Tablabancocv']);
Route::get('/mostrarCurpCv/{id}', [bancocvController::class, 'mostrarCurpCv']);
Route::get('/mostrarCv/{id}', [bancocvController::class, 'mostrarCv']);

// RUTA PARA VER LAS VACANTES EXTERNA EN LA APLICACIÓN
Route::post('/actualizarinfo', [PuestoController::class, 'getCvInfo'])->name('actualizarinfo');
Route::post('/ActualizarSave', [PuestoController::class, 'store']);
Route::post('/PostularseSave', [PuestoController::class, 'store1']);

// CATÁLOGO DE VACANTES
Route::get('/catalogodevacantes', [catalogovacantesController::class, 'index']);
Route::post('/VacantesSave', [catalogovacantesController::class, 'store']);
Route::get('/VacanteDelete', [catalogovacantesController::class, 'store']);
Route::get('/Tablavacantes', [catalogovacantesController::class, 'Tablavacantes']);

//  CATÁLOGO ÁREA DE INTERESES
Route::get('/areainteres', function () {return view('RH.Catalogos.catalogo_areainteres');});
Route::post('/interesSave', [catalogoareainteresController::class, 'store']);
Route::get('/interesDelete', [catalogoareainteresController::class, 'store']);
Route::get('/Tablaareainteres', [catalogoareainteresController::class, 'Tablaareainteres']);

// VISUALIZAR LA VACANTES Y PODER VER LOS QUE SE HAN POSTULADO Y PODER MANDAR A SELECCIÓN
Route::get('/postulaciones', [vacantesactivasController::class, 'index']);
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


Route::get('/visualizarseleccion', [seleccionController::class, 'index2'])->middleware('role:Superusuario,Administrador');
Route::get('/Tablaseleccion2Visualizar', [seleccionController::class, 'Tablaseleccion2Visualizar']);
Route::get('/consultarSeleccion2Visualizar/{vacantesId}', [seleccionController::class, 'consultarSeleccion2Visualizar']);


// SELECCION

Route::get('/seleccion', [seleccionController::class, 'index'])->middleware('role:Superusuario,Administrador');
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
Route::get('/pruebasconocimientos', function () {return view('RH.Catalogos.catalogo_pruebasconocimiento');});
Route::post('/pruebaSave', [catalogopruebasController::class, 'store']);
Route::get('/pruebaDelete', [catalogopruebasController::class, 'store']);
Route::get('/Tablapruebaconocimiento', [catalogopruebasController::class, 'Tablapruebaconocimiento']);


//==============================================  CONTRATACION  ============================================== 

// PENDIENTE AL CONTRATAR
Route::get('/pendientecontratar', function () {return view('RH.contratacion.pendientecontratar');});
Route::get('/Tablapendientecontratacion', [pendientecontratarController::class, 'Tablapendientecontratacion']);
Route::post('/mandarcontratacion', [pendientecontratarController::class, 'mandarcontratacion']);
Route::get('/obtenerInformacionContrato/{contrato_id}', [contratacionController::class, 'obtenerInformacionContrato']);

/////////////////////////////////////// STEP 1 DATOS GENERALES
Route::get('/contratacion', [contratacionController::class, 'index'])->middleware('role:Superusuario,Administrador');
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
Route::get('/mostraradendacontrato/{id}', [contratacionController::class, 'mostraradendacontrato']);

// DOCUMENTOS DE SOPORTE DEL CONTRATO  
Route::get('/Tabladocumentosoportecontrato', [contratacionController::class, 'Tabladocumentosoportecontrato']);
Route::get('/mostrardocumentosoportecontrato/{id}', [contratacionController::class, 'mostrardocumentosoportecontrato']);

// RENOVACION DE CONTRATO
Route::get('/Tablarenovacioncontrato', [contratacionController::class, 'Tablarenovacioncontrato']);
Route::get('/mostrardocumentorenovacion/{id}', [contratacionController::class, 'mostrardocumentorenovacion']);
Route::get('/mostraradenda/{id}', [contratacionController::class, 'mostraradenda']);

// INFORMACION MEDICA 
Route::get('/Tablainformacionmedica', [contratacionController::class, 'Tablainformacionmedica']);
Route::get('/mostrarinformacionmedica/{id}', [contratacionController::class, 'mostrarinformacionmedica']);

// INCIDENCIAS 
Route::get('/Tablaincidencias', [contratacionController::class, 'Tablaincidencias']);
Route::get('/mostrarincidencias/{id}', [contratacionController::class, 'mostrarincidencias']);
Route::get('/Tablaspermisosrecempleados', [contratacionController::class, 'Tablaspermisosrecempleados']);

// SOLICITUD DE VACACIONES 
Route::get('/Tablasolicitudvacaciones', [contratacionController::class, 'Tablasolicitudvacaciones']);

// ACCIONES DISCIPLINARIAS 
Route::get('/Tablaccionesdisciplinarias', [contratacionController::class, 'Tablaccionesdisciplinarias']);
Route::get('/mostraracciones/{id}', [contratacionController::class, 'mostraracciones']);

// RECIBOS DE NOMINA
Route::get('/Tablarecibonomina', [contratacionController::class, 'Tablarecibonomina']);
Route::get('/mostrarecibosnomina/{id}', [contratacionController::class, 'mostrarecibosnomina']);

/////////////////////////////////////// STEP 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL
Route::get('/Tablasoportecontrato', [contratacionController::class, 'Tablasoportecontrato']);
Route::get('/mostrardocumentocolaboradorcontratosoporte/{id}', [contratacionController::class, 'mostrardocumentocolaboradorcontratosoporte']);
Route::post('/obtenerdocumentosoportescontratos', [contratacionController::class, 'obtenerdocumentosoportescontratos']);

Route::get('/firmacolaborador/{id}', [contratacionController::class, 'mostrarFotofirma']);
Route::get('/firmarh/{id}', [contratacionController::class, 'mostrarFotofirmaRH']);


/////////////////////////////////////// STEP 5 CV

Route::post('/cvSave', [CvController::class, 'store']);
Route::get('/Tablacvs', [CvController::class, 'Tablacvs']);
Route::get('/mostrarFotoCV/{id}', [CvController::class, 'mostrarFotoCV']);


/////////////////////////////////////// STEP 6 REQUISICION DE PERSONAL 

Route::get('/Tablarequisicioncontratacion', [contratacionController::class, 'Tablarequisicioncontratacion']);
Route::get('/obtenerDatosCategoria', [contratacionController::class, 'obtenerDatosCategoria']);
Route::get('/mostrarrequisicon/{id}', [contratacionController::class, 'mostrarrequisicon']);



//============================================== RECURSOS DE LOS EMPLEADOS ============================================== 

Route::get('/recempleado', function () {return view('RH.RecEmpleados.RecEmpleados');});
Route::get('/obtenerDatosPermiso', [recempleadoController::class, 'obtenerDatosPermiso']);
Route::get('/obtenerDatosVacaciones', [recempleadoController::class, 'obtenerDatosVacaciones']);

Route::get('/Tablarecempleados', [recempleadoController::class, 'Tablarecempleados']);
Route::post('/RecempleadoSave', [recempleadoController::class, 'store']);
Route::get('/solicitudesvobo', function () { return view('RH.RecEmpleados.recempleadovobo');});
Route::get('/Tablarecempleadovobo', [recempleadoController::class, 'Tablarecempleadovobo']);
Route::get('/solicitudesaprobaciones', function () {return view('RH.RecEmpleados.recempleadoaprobacion');});
Route::get('/Tablarecempleadoaprobacion', [recempleadoController::class, 'Tablarecempleadoaprobacion']);


Route::get('/obtenerContratoPorFechaPermiso/{curp}', [recempleadoController::class, 'obtenerContratoPorFechaPermiso']);
Route::get('/obtenerContratoPorFechaVacaciones/{curp}', [recempleadoController::class, 'obtenerContratoPorFechaVacaciones']);



Route::get('/mostrardocumentosrecempleados/{id}', [recempleadoController::class, 'mostrardocumentosrecempleados']);

//// DESCARGA DOCUMENTOS PDF 

Route::get('/generarPermisoausencia/{id}', [pdfrecempleadoController::class, 'generarPermisoausencia']);
Route::get('/generarVacaciones/{id}', [pdfrecempleadoController::class, 'generarVacaciones']);



//==============================================  CAPACITACION  ============================================== 


/// BRECHA DE COMPETENCIA

Route::get('/brechacompetencia', function () {  return view('RH.capacitacion.brechacomp');});
Route::get('/Tablabrecha', [brechaController::class, 'Tablabrecha']);


//============================================== DESVINCULACIÓN ============================================== 

Route::get('/desvinculacion', [desvinculacionController::class, 'index']);
Route::post('/desvinculacionSave', [desvinculacionController::class, 'store']);
Route::get('/Tabladesvinculacion', [desvinculacionController::class, 'Tabladesvinculacion']);
Route::get('/mostrardocumentobaja/{id}', [desvinculacionController::class, 'mostrardocumentobaja']);
Route::get('/mostrardocumenconvenio/{id}', [desvinculacionController::class, 'mostrardocumenconvenio']);
Route::get('/mostrardocumenadeudo/{id}', [desvinculacionController::class, 'mostrardocumenadeudo']);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////VENTAS///////////////////////////////////////////////////////7
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================   CLIENTES ============================================== 

Route::get('/clientes', [clientesController::class, 'index']);
Route::post('/ClienteSave', [clientesController::class, 'store']);
Route::get('/Tablaclientesventas', [clientesController::class, 'Tablaclientesventas']);
Route::get('/ClienteDelete', [clientesController::class, 'store']);
Route::get('/mostrarconstanciacliente/{id}', [clientesController::class, 'mostrarconstanciacliente']);
Route::get('/Tablaverificacionusuario', [clientesController::class, 'Tablaverificacionusuario']);
Route::get('/mostrarverificacionclienteventas/{id}', [clientesController::class, 'mostrarverificacionclienteventas']);
Route::get('/Tablactaconstitutivausuario', [clientesController::class, 'Tablactaconstitutivausuario']);
Route::get('/mostraractaclienteventas/{id}', [clientesController::class, 'mostraractaclienteventas']);


//==============================================  SOLICITUDES  ============================================== 


Route::get('/solicitudes', [solicitudesController::class, 'index']);
Route::post('/solicitudSave', [solicitudesController::class, 'store']);
Route::get('/Tablasolicitudes', [solicitudesController::class, 'Tablasolicitudes']);
Route::get('/solicitudDelete', [solicitudesController::class, 'store']);
Route::post('/actualizarEstatusSolicitud', [solicitudesController::class, 'actualizarEstatusSolicitud']);
Route::get('/mostrarverificacioncliente/{id}', [solicitudesController::class, 'mostrarverificacioncliente']);
Route::post('/actualizarSolicitud', [solicitudesController::class, 'actualizarSolicitud']);
Route::get('/buscarCliente', [solicitudesController::class, 'buscarCliente']);


//==============================================  OFERTAS/COTIZACION  ============================================== 

Route::get('/ofertas', [ofertasController::class, 'index']);
Route::post('/ofertaSave', [ofertasController::class, 'store']);
Route::get('/Tablaofertas', [ofertasController::class, 'Tablaofertas']);
Route::get('/ofertaDelete', [ofertasController::class, 'store']);
Route::post('/actualizarEstatusOferta', [ofertasController::class, 'actualizarEstatusOferta']);
Route::get('/mostrarcotizacion/{id}', [ofertasController::class, 'mostrarcotizacion']);
Route::get('/mostrarterminos/{id}', [ofertasController::class, 'mostrarterminos']);


//==============================================   CONFIRMACION DEL SERVICIO  ============================================== 

Route::get('/confirmacion', [confirmacionController::class, 'index']);
Route::get('/Tablaconfirmacion', [confirmacionController::class, 'Tablaconfirmacion']);
Route::post('/ContratacionSave', [confirmacionController::class, 'store']);
Route::get('/mostraraceptacion/{id}', [confirmacionController::class, 'mostraraceptacion']);
Route::get('/confirmacionDelete', [confirmacionController::class, 'store']);
Route::get('/mostrarevidencias/{id}', [confirmacionController::class, 'mostrarevidencias']);

//==============================================   ORDEN DE TRABAJO  ============================================== 

Route::get('/ordentrabajo', [otController::class, 'index']);
Route::get('/Tablaordentrabajo', [otController::class, 'Tablaordentrabajo']);
Route::post('/otSave', [otController::class, 'store']);
Route::post('/obtenerDatosOferta', [otController::class, 'obtenerDatosOferta']);



//==============================================   CATALOGOS SOLICITUDES ============================================== 

Route::get('/catalogosolicitudes', function () {return view('ventas.Catalogos.catalogos_solicitud');});

// CATÁLOGO TITULOS CLIENTEs
Route::get('/catalogoclientestitulos', function () { return view('ventas.Catalogos.catalogo_titulosclientes');});

// CATÁLOGO DE MEDIO DE CONTACTO 
Route::get('/catalogomediocontacto', function () {return view('ventas.Catalogos.catalogo_mediocontacto');});
Route::post('/MedioSave', [catalogomediocontactoController::class, 'store']);
Route::get('/MedioDelete', [catalogomediocontactoController::class, 'store']);
Route::get('/Tablamediocontacto', [catalogomediocontactoController::class, 'Tablamediocontacto']);

// CATÁLOGO DE  GIRO DE EMPRESA
Route::get('/catalogogiroempresa', function () {return view('ventas.Catalogos.catalogo_giroempresa');});
Route::post('/GiroSave', [catalogogiroempresaController::class, 'store']);
Route::get('/GiroDelete', [catalogogiroempresaController::class, 'store']);
Route::get('/Tablagiroempresa', [catalogogiroempresaController::class, 'Tablagiroempresa']);

// CATÁLOGO DE  NECESIDAD SERVICIO
Route::get('/catalogonecesidadservicio', function () {return view('ventas.Catalogos.catalogo_necesidadservicio');});
Route::post('/NecesidadSave', [catalogonecesidadController::class, 'store']);
Route::get('/NecesidadDelete', [catalogonecesidadController::class, 'store']);
Route::get('/Tablanecesidadservicio', [catalogonecesidadController::class, 'Tablanecesidadservicio']);

// CATÁLOGO DE LINEA DE NEGOCIO
Route::get('/catalogolineanegocio', function () {return view('ventas.Catalogos.catalogo_lineanegocio');});
Route::post('/LineaSave', [catalogolineanegociosController::class, 'store']);
Route::get('/LineaDelete', [catalogolineanegociosController::class, 'store']);
Route::get('/Tablalineanegocio', [catalogolineanegociosController::class, 'Tablalineanegocio']);


// CATÁLOGO DE TIPO DE SERVICIO
Route::get('/catalogotiposervicio', function () {return view('ventas.Catalogos.catalogo_tiposervicio');});
Route::post('/TiposSave', [catalogotiposervicioController::class, 'store']);
Route::get('/TiposDelete', [catalogotiposervicioController::class, 'store']);
Route::get('/Tablatiposervicio', [catalogotiposervicioController::class, 'Tablatiposervicio']);



//==============================================   CATALOGOS CONFIRMACION ============================================== 

Route::get('/catalogoconfirmacion', function () {return view('ventas.Catalogos.catalogos_confirmacion');});

// CATÁLOGO DE VERIFIACION DEL CLIENTE
Route::get('/catalogoverificacion', function () {return view('ventas.Catalogos.catalago_verificacioncliente');});
Route::post('/InformacionSave', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/InformacionDelete', [catalagoverificacioninformacionController::class, 'store']);
Route::get('/Tablaverificacioncliente', [catalagoverificacioninformacionController::class, 'Tablaverificacioncliente']);





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////COMPRAS///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================  M.R  ============================================== 

Route::get('/requisicionmateriales', function () {return view('compras.requisicionesmaterial.requisicion_material');});
Route::post('/MrSave', [mrController::class, 'store']);
Route::get('/Tablamr', [mrController::class, 'Tablamr']);
Route::get('/obtenerAreaSolicitante', [mrController::class, 'obtenerAreaSolicitante'])->middleware('auth');
Route::post('/guardarYDarVistoBueno', [mrController::class, 'guardarYDarVistoBueno']);
Route::post('/rechazar', [mrController::class, 'rechazar']);

//==============================================  M.R APRUEBA LIDER  ============================================== 

Route::get('/requisicionmaterialeslideres', function () {return view('compras.requisicionesmaterial.requisicionlider');});
Route::get('/Tablarequisicion', [mrController::class, 'Tablarequisicion']);

//==============================================  M.R APRUEBA DIRECCION  ============================================== 

Route::get('/Tablarequsicionaprobada', [mrController::class, 'Tablarequsicionaprobada']);
Route::get('/requisicionmaterialesaprobacion', function () {return view('compras.requisicionesmaterial.requisiconaprobar');});

//==============================================  BITACORA M.R  ============================================== 

Route::get('/bitacora', [mrController::class, 'index']);
Route::get('/Tablabitacora', [mrController::class, 'Tablabitacora']);
Route::post('/guardarHOJAS', [mrController::class, 'guardarHOJAS']);
Route::get('/api/hoja-trabajo/{no_mr}', [mrController::class, 'obtenerPorMR']);
Route::get('/mostrarcotizacionq1/{id}', [mrController::class, 'mostrarcotizacionq1']);
Route::get('/mostrarcotizacionq2/{id}', [mrController::class, 'mostrarcotizacionq2']);
Route::get('/mostrarcotizacionq3/{id}', [mrController::class, 'mostrarcotizacionq3']);
Route::get('/mr/{id}/generar-pdf', [pdfController::class, 'descargarPDF'])->name('mr.generar.pdf');

//==============================================   DIRECTORIO INTERNO  ============================================== 

Route::get('/bancoproveedores', function () {return view('compras.proveedores.proveedorespotencial');});
Route::get('/Tabladirectorio', [directorioController::class, 'Tabladirectorio']);
Route::get('/ServicioDelete', [directorioController::class, 'store']);
Route::get('/Tablaverificacionproveedor', [directorioController::class, 'Tablaverificacionproveedor']);
Route::get('/mostrarverificacionproveedor/{id}', [directorioController::class, 'mostrarverificacionproveedor']);
Route::get('/listaproveedorescriticos', function () {return view('compras.proveedores.listaproveedorescriticos');});
Route::get('/Tablaproveedorescriticos', [listaproveedorescriticosController::class, 'Tablaproveedorescriticos']);

//==============================================    LISTA DE PROVEEDORES  ============================================== 

Route::get('/listaproveedores', [listaproveedorController::class, 'index']);
Route::get('/Tablalistaproveedores', [listaproveedorController::class, 'Tablalistaproveedores']);
Route::post('/AltaSave1', [listaproveedorController::class, 'store']);
Route::get('/Tablacuentas', [listaproveedorController::class, 'Tablacuentas']);
Route::get('/Tablacontactos', [listaproveedorController::class, 'Tablacontactos']);
Route::get('/Tablacertificaciones', [listaproveedorController::class, 'Tablacertificaciones']);
Route::get('/Tablareferencias', [listaproveedorController::class, 'Tablareferencias']);
Route::get('/Tabladocumentosoporteproveedores', [listaproveedorController::class, 'Tabladocumentosoporteproveedores']);
Route::get('/documentosProveedorAdmin/{rfc}', [listaproveedorController::class, 'documentosProveedorAdmin']);
Route::post('/enviarCorreoFaltantes/{id}', [listaproveedorController::class, 'enviarCorreoFaltantes']);
Route::post('/actualizarVerificacionSolicitada', [listaproveedorController::class, 'actualizarVerificacionSolicitada']);
Route::post('/verificarEstadoVerificacion', [listaproveedorController::class, 'verificarEstadoVerificacion']);

//==============================================     PROVEEDORES TEMPORALES  ============================================== 

Route::get('/proveedorestemporales', function () { return view('compras.listaproveedor.proveedorestemporales');});
Route::post('/TempSave', [proveedortempController::class, 'store']);
Route::get('/Tablaproveedortemporal', [proveedortempController::class, 'Tablaproveedortemporal']);
Route::get('/TempDelete', [proveedortempController::class, 'store']);
Route::get('/mostrarequierecontrato/{id}', [proveedortempController::class, 'mostrarequierecontrato']);

//==============================================    ORDEN DE COMPRA  ============================================== 

Route::get('/ordencompra', [poController::class, 'index']);
Route::get('/Tablaordencompra', [poController::class, 'Tablaordencompra']);
Route::get('/ordencompraaprobacion', [poController::class, 'index1']);
Route::get('/Tablaordencompraprobacion', [poController::class, 'Tablaordencompraprobacion']);
Route::post('/PoSave', [poController::class, 'store']);
Route::get('/obtenerNombreUsuario/{id}', [poController::class, 'obtenerNombreUsuario']);
Route::get('/generarPDFPO/{id}', [pdfpoController::class, 'generarPDFPO']);

//==============================================    MATRIZ COMPARATIVA  ============================================== 

Route::get('/matrizcomparativa', [matrizController::class, 'index']);
Route::get('/Tablamatrizcomparativa', [matrizController::class, 'Tablamatrizcomparativa']);
Route::post('/MatrizSave', [matrizController::class, 'store']);
Route::get('/matrizaprobacion', [matrizController::class, 'index1']);
Route::get('/Tablamatirzaprobada', [matrizController::class, 'Tablamatirzaprobada']);

//==============================================    RECEPCION DE BIENES Y/O SERVICIOS - GR  ============================================== 

Route::get('/bitacoragr', [grController::class, 'index']);
Route::get('/Tablabitacoragr', [grController::class, 'Tablabitacoragr']);
Route::post('/guardarGR', [grController::class, 'guardarGR']);
Route::post('/consultar-gr', [grController::class, 'consultarGR'])->name('consultar.gr');
Route::get('/generarGRpdf/{id}', [pdfgrController::class, 'generarGRpdf']);


/// VO.BO USUARIO EN GR 

Route::get('/vobogrusuario', [vobogrusuarioController::class, 'index']);
Route::get('/TablaVoBoGRusuarios', [vobogrusuarioController::class, 'TablaVoBoGRusuarios']);
Route::get('/ConsultarProductosVoBo/{idGR}', [vobogrusuarioController::class, 'ConsultarProductosVoBo']);
Route::post('/guardarVoBoUsuario', [vobogrusuarioController::class, 'guardarVoBoUsuario']);

//==============================================   CATALOGOS PROVEEDORES  ============================================== 
Route::get('/catalogosproveedores', function () {return view('compras.Catalogos.catalogo_generales');});


//  CATALOGO FUNCIONEES/AREAS CONTACTOS
Route::get('/catalogofunciones', function () {return view('compras.Catalogos.catalogo_funcionproveedor');});
Route::post('/FuncionesareasSave', [catalagofuncionesproveedorController::class, 'store']);
Route::get('/Tablafuncionescontacto', [catalagofuncionesproveedorController::class, 'Tablafuncionescontacto']);
Route::get('/FuncionesareasDelete', [catalagofuncionesproveedorController::class, 'store']);

//  CATALOGO TITULO 
Route::get('/catalogotitulos', function () { return view('compras.Catalogos.catalogo_titulosproveedor');});
Route::post('/TituloSave', [catalagotituloproveedorController::class, 'store']);
Route::get('/Tablatitulocontacto', [catalagotituloproveedorController::class, 'Tablatitulocontacto']);
Route::get('/TituloDelete', [catalagotituloproveedorController::class, 'store']);

//  CATALOGO VERIFICACION DE LA INFORMACION DEL PROVEEDOR 
Route::get('/catalogoverificacionproveedor', function () {return view('compras.Catalogos.catalogo_verificacionproveedor');});
Route::get('/Tablacatalogoverificacionproveedor', [catalogoverificacionproveedorController::class, 'Tablacatalogoverificacionproveedor']);
Route::post('/CatVerProSave', [catalogoverificacionproveedorController::class, 'store']);
Route::get('/CatVerProDelete', [catalogoverificacionproveedorController::class, 'store']);

//  CATALOGO DOCUMENTOS DE SOPORTE DEL PROVEEDOR 
Route::get('/catalogodocumentosoporte', function () {return view('compras.Catalogos.catalogo_documentosoporte');});
Route::post('/DocumentosSave', [catalagodocumentosproveedorController::class, 'store']);
Route::get('/Tabladocumentosoportes', [catalagodocumentosproveedorController::class, 'Tabladocumentosoportes']);
Route::get('/DocumentosDeleteProveedor', [catalagodocumentosproveedorController::class, 'store']);


//==============================================  PROVEEDOR  ============================================== 

Route::post('/ServiciosSave', [directorioController::class, 'store']);
Route::get('/mostrarconstanciaproveedor/{id}', [directorioController::class, 'mostrarconstanciaproveedor']);
Route::post('/actualizarinfoproveedor', [directorioController::class, 'actualizarinfoproveedor'])->name('actualizarinfoproveedor');
Route::post('/enviarCorreoProveedor', [directorioController::class, 'enviarCorreoProveedor']);
Route::post('/verificarProveedor', [directorioController::class, 'verificarProveedor']);

//  ALTA 
Route::get('/alta', function () { return view('compras.proveedores.altaproveedores');})->name('Alta');
Route::get('/obtenerDatosProveedor', [altaproveedorController::class, 'obtenerDatosProveedor']);
Route::post('/AltaSave', [altaproveedorController::class, 'store']);
Route::post('/solicitarValidacion', [altaproveedorController::class, 'solicitarValidacion']);
Route::get('/verificarBloqueoPorVerificacion', [altaproveedorController::class, 'verificarBloqueoPorVerificacion']);

//ALTA DE CERTIFICACIONES
Route::get('/proveedorescertificaciones', function () {return view('compras.proveedores.altacertificacion');});
Route::post('/AltacertificacionSave', [altacerticacionController::class, 'store']);
Route::get('/Tablacertificacionproveedores', [altacerticacionController::class, 'Tablacertificacionproveedores']);
Route::get('/CertificacionDelete', [altacerticacionController::class, 'store']);
Route::get('/mostrarcertificacion/{id}', [altacerticacionController::class, 'mostrarcertificacion']);
Route::get('/mostraracreditacion/{id}', [altacerticacionController::class, 'mostraracreditacion']);
Route::get('/mostrarautorizacion/{id}', [altacerticacionController::class, 'mostrarautorizacion']);
Route::get('/mostrarmembresia/{id}', [altacerticacionController::class, 'mostrarmembresia']);

//ALTA DE REFERENCIAS 
Route::get('/proveedoresreferencias', function () {return view('compras.proveedores.altareferencias');});
Route::post('/AltareferenciaSave', [altareferenciasController::class, 'store']);
Route::get('/Tablareferenciasproveedor', [altareferenciasController::class, 'Tablareferenciasproveedor']);
Route::get('/ReferenciasDelete', [altacontactoController::class, 'store']);

//ALTA DE CONTACTOS
// Route::get('/Proveedores_Contactos', function () {return view('compras.proveedores.altacontactos');});
Route::get('/proveedorescontactos', [altacontactoController::class, 'index']);
Route::get('/Tablacontactosproveedor', [altacontactoController::class, 'Tablacontactosproveedor']);
Route::post('/AltacontactoSave', [altacontactoController::class, 'store']);
Route::get('/ContactoDelete', [altacontactoController::class, 'store']);

//ALTA DOCUMENTOS DE SOPORTE
Route::get('/proveedoresdocumentos', [altadocumentosController::class, 'index']);
Route::get('/Tabladocumentosproveedores', [altadocumentosController::class, 'Tabladocumentosproveedores']);
Route::post('/AltaDocumentosSave', [altadocumentosController::class, 'store']);
Route::get('/DocumentosDelete', [altadocumentosController::class, 'store']);
Route::get('/mostrardocumentosoporteproveedor/{id}', [altadocumentosController::class, 'mostrardocumentosoporteproveedor']);
Route::get('/documentosRegistrados', [altadocumentosController::class, 'documentosRegistrados']);

//ALTA DE CUENTAS BANCARIAS 
Route::get('/proveedorescuentas', function () { return view('compras.proveedores.altacuentas');});
Route::post('/AltacuentaSave', [altacuentaController::class, 'store']);
Route::get('/Tablacuentasproveedores', [altacuentaController::class, 'Tablacuentasproveedores']);
Route::get('/CuentasDelete', [altacuentaController::class, 'store']);
Route::get('/mostrarcaratula/{id}', [altacuentaController::class, 'mostrarcaratula']);





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////ALMACEN//////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//==============================================    INVENTRARIO  ============================================== 

Route::get('/inventario', [inventarioController::class, 'index']);
Route::get('/Tablainventario', [inventarioController::class, 'Tablainventario']);
Route::post('/InventarioSave', [inventarioController::class, 'store']);
Route::get('/equipofoto/{id}', [inventarioController::class, 'mostrarFotoEquipo'])->name('equipofoto');
Route::get('/inventarioDelete', [inventarioController::class, 'store']);
Route::get('/generarCodigoAF', [inventarioController::class, 'generarCodigoAF']);
Route::get('/generarCodigoANF', [inventarioController::class, 'generarCodigoANF']);

/// ENTRADA INVENTARIO
Route::get('/Tablaentradainventario', [inventarioController::class, 'Tablaentradainventario']);
Route::post('/inventario/respaldar', [inventarioController::class, 'respaldarInventario'])->name('inventario.respaldar');

/// DOCUMENTOS DEL EQUIPO
Route::get('/Tabladocumentosinventario', [inventarioController::class, 'Tabladocumentosinventario']);
Route::get('/mostrardocumentoquipo/{id}', [inventarioController::class, 'mostrardocumentoquipo']);

/// VISUALIZAR FECHAS DE DOCUMENTOS 
Route::get('/obtenerDocumentosPorInventario/{inventario_id}', [inventarioController::class, 'obtenerDocumentosPorInventario']);

//==============================================   CATALOGOS INVENTRARIO  ============================================== 
Route::get('/catalogosinventarios', function () { return view('almacen.Catalogos.catalogo_inventarios');});
Route::get('/catalogotipoinventario', function () { return view('almacen.Catalogos.catalogo_tipo');});
Route::post('/TipoinventarioSave', [catalogotipoinventarioController::class, 'store']);
Route::get('/Tablatipoinventario', [catalogotipoinventarioController::class, 'Tablatipoinventario']);
Route::get('/TipoinventarioDelete', [catalogotipoinventarioController::class, 'store']);

//==============================================   APROBACION DE SOLICITUDES  ============================================== 
Route::get('/aprobacionalmacen', function () {return view('almacen.aprobarsolicitudes.aprobarsolicitudes');});
Route::get('/Tablaaprobacionalmacen', [aprobacionsalidalmacenController::class, 'Tablaaprobacionalmacen']);

//==============================================    SALIDA DE ALMACEN   ============================================== 
Route::get('/salidaalmacen', [salidalmacenController::class, 'index']);
Route::get('/Tablasalidalmacen', [salidalmacenController::class, 'Tablasalidalmacen']);
Route::post('/SalidalmacenSave', [salidalmacenController::class, 'store']);

//==============================================    LISTA DE AF   ============================================== 
Route::get('/listadeaf', [listaafController::class, 'index']);
Route::get('/Tablalistadeaf', [listaafController::class, 'Tablalistadeaf']);

//==============================================    LISTA DE AFN   ============================================== 
Route::get('/listadeafn', [listaafnController::class, 'index']);
Route::get('/Tablalistadeafn', [listaafnController::class, 'Tablalistadeafn']);

//==============================================    LISTA DE COMERCIALIZACION   ==============================================
Route::get('/listadecomercializacion', [listacomercializacionController::class, 'index']);
Route::get('/Tablalistacomercializacion', [listacomercializacionController::class, 'Tablalistacomercializacion']);

//==============================================    LISTA DE ITEMS CRITICOS   ==============================================
Route::get('/listadeitemcriticos', [listaitemcriticoController::class, 'index']);
Route::get('/Tablalistaitemcriticos', [listaitemcriticoController::class, 'Tablalistaitemcriticos']);

//==============================================    LISTA DE ALERTAS INVENTARIO  ==============================================
Route::get('/listadealertas', [listaalertaController::class, 'index']);
Route::get('/Tablalistadealertas', [listaalertaController::class, 'Tablalistadealertas']);




//==============================================    BITACORAS   ============================================== 


/// CONSUMIBLES

Route::get('/bitacoraconsumibles', [bitacoraconsumiblesController::class, 'index']);
Route::get('/Tablabitacoraconsumibles', [bitacoraconsumiblesController::class, 'Tablabitacoraconsumibles']);
Route::get('/obtenerMaterialIndividual', [bitacoraconsumiblesController::class, 'obtenerMaterialIndividual']);
Route::post('/BitacoraSave', [bitacoraconsumiblesController::class, 'store']);


/// RETORNABLES

Route::get('/bitacoraretornables', [bitacoraretornableController::class, 'index']);
Route::get('/Tablabitacoraretornable', [bitacoraretornableController::class, 'Tablabitacoraretornable']);


/// VEHICULOS

Route::get('/bitacoravehiculos', [bitacoravehiculosController::class, 'index']);
Route::get('/Tablabitacoravehiculos', [bitacoravehiculosController::class, 'Tablabitacoravehiculos']);






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////PAGINA WEB///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/mensajespaginaweb', function () {    return view('pagina_web.mensajespagina');});
Route::get('/Tablamensajepaginaweb', [mensajespaginaController::class, 'Tablamensajepaginaweb']);
Route::get('/MensajespaginaDelete', [mensajespaginaController::class, 'store']);



//==============================================  RUTAS EXTERNAS  ============================================== 
Route::get('/inicio', function () { return view('RH.externa.diseño');});
Route::get('/Formulario-vacantes', [bancocvController::class, 'index1']); 
Route::get('/Vacantes', [PuestoController::class, 'index']); 
Route::get('/Proveedor', function () { return view('compras.externa.diseño'); });
Route::get('/Directorio', function () { return view('compras.proveedores.directorio');});



//==============================================  NOTIFICACIONES  ============================================== 

Route::get('/notificaciones', [notificacionController::class, 'notificaciones']);

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

Route::get('codigo-postal/{cp}', function ($cp) {
    Log::info('Consulta CP desde: ' . request()->ip() . ', User-Agent: ' . request()->header('User-Agent'));

    $token = "a5ba768d-eeac-4c0f-b0be-202ef91df93c";
    $url = "https://api.copomex.com/query/info_cp/{$cp}?type=simplified&token={$token}";

    try {
        $response = Http::timeout(10)->get($url);

        Log::info('Respuesta de Copomex para CP ' . $cp . ': ' . $response->body());

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'error' => true,
            'mensaje' => 'No se pudo obtener información de Copomex',
            'status' => $response->status(),
            'detalle' => $response->body()
        ], 400);
    } catch (\Exception $e) {
        Log::error('Error en consulta CP ' . $cp . ': ' . $e->getMessage());

        return response()->json([
            'error' => true,
            'mensaje' => 'Error de conexión con el servicio: ' . $e->getMessage(),
            'detalle' => 'Excepción capturada en el servidor'
        ], 500);
    }
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

Route::get('/pruebasww', function () {
    return view('welprueba');
});
