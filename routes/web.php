<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Artisan;

//  USUARIOS

use App\Http\Controllers\usuario\usuarioController;
use App\Http\Controllers\AuthController;
// Controladores de organizacion

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





// Controladores de reclutamiento
use App\Http\Controllers\reclutamiento\catalogovacantesController;
use App\Http\Controllers\reclutamiento\PuestoController;
use App\Http\Controllers\reclutamiento\bancocvController;
use App\Http\Controllers\reclutamiento\vacantesactivasController;
use App\Http\Controllers\organizacion\catalogoareainteresController;
use App\Http\Controllers\organizacion\catalogogeneroControlller;
use App\Http\Controllers\reclutamiento\formCVController;



// Controladores de seleccion

use App\Http\Controllers\seleccion\seleccionController;
use App\Http\Controllers\seleccion\catalogopruebasController;
use App\Http\Controllers\TestController;


// Controladores de contratacion

use App\Http\Controllers\contratacion\contratacionController;
use App\Http\Controllers\contratacion\PowerPointController;
use App\Http\Controllers\contratacion\pendientecontratarController;

// Controladores de desvinculacion

use App\Http\Controllers\desvinculacion\desvinculacionController;


//==============================================  RECLUTAMIENTO  ============================

//==============================================  login  ============================================== 
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/tablero', function () {
        return view('tablero.index');
    })->name('dashboard');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//==============================================  USUARIO  ============================================== 


Route::get('/usuario', function () {return view('usuario.usuario');});

Route::post('/usuarioSave', [usuarioController::class, 'store']);
Route::get('/Tablausuarios', [usuarioController::class, 'Tablausuarios']);

Route::get('/usuarioDelete', [usuarioController::class, 'store']);
Route::get('/usuariofoto/{id}', [usuarioController::class, 'mostrarFotoUsuario']);


//==============================================  EXTERNO  ============================================== 
Route::get('/inicio', function () {return view('RH.externa.diseño');});


//==============================================  RRHH  ============================================== 


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

//PPT
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
Route::get('/RequisiciónDePersonal', [requerimientoPersonalController::class, 'index']);
Route::post('/RequerimientoSave', [requerimientoPersonalController::class, 'store']);
Route::get('/RequerimientoDelete', [requerimientoPersonalController::class, 'store']);
Route::get('/Tablarequerimiento', [requerimientoPersonalController::class, 'Tablarequerimiento']);
Route::get('/makeExcelRP/{id_formulario}', [makeExcelController::class, 'makeExcelRP']);
Route::get('/mostrardocumentorequisicion/{id}', [requerimientoPersonalController::class, 'mostrardocumentorequisicion']);


//catálogo de jerarquia
Route::get('/Jerárquico', function () {return view('RH.Catalogos.catalogo_Jerárquico');});
Route::post('/jerarquiaSave', [catalogosController::class, 'store']);
Route::get('/jerarquiaDelete', [catalogosController::class, 'store']);
Route::get('/Tablajerarquia', [catalogosController::class, 'Tablajerarquia']);

//catálogo de asesores
Route::get('/Asesores', function () {return view('RH.Catalogos.catalogo_asesores');});
Route::post('/asesorSave', [catalogosasesoresController::class, 'store']);
Route::get('/asesorDelete', [catalogosasesoresController::class, 'store']);
Route::get('/Tablaasesores', [catalogosasesoresController::class, 'Tablaasesores']);

//catálogo de funciones cargo
Route::get('/FuncionesCargo', [catalogosfuncionescargoController::class, 'index']);
Route::post('/CargoSave', [catalogosfuncionescargoController::class, 'store']);
Route::get('/CargoDelete', [catalogosfuncionescargoController::class, 'store']);
Route::get('/Tablaafuncionescargo', [catalogosfuncionescargoController::class, 'Tablaafuncionescargo']);

//catálogo de funciones  gestiones
Route::get('/Funcionesgestión', function () {return view('RH.Catalogos.catalogo_funcionesgestion');});
Route::post('/GestionSave', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/GestionDelete', [catalogosfuncionesgestionController::class, 'store']);
Route::get('/Tablafuncionesgestion', [catalogosfuncionesgestionController::class, 'Tablafuncionesgestion']);

// catálogo de relaciones externas 
Route::get('/RelacionesExternas', function () {return view('RH.Catalogos.catalogo_relacionesexternas');});
Route::post('/ExternaSave', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/ExternaDelete', [catalogosrelacionesexternasController::class, 'store']);
Route::get('/Tablarelacionesexterna', [catalogosrelacionesexternasController::class, 'Tablarelacionesexterna']);

// catálogo de Categorías
Route::get('/Categorías', [catalogocategoriaControlller::class, 'index']);
// Route::get('/Categorías', function () {return view('RH.Catalogos.catalogo_categorias');});
Route::post('/CategoriaSave', [catalogocategoriaControlller::class, 'store']);
Route::get('CategoriaDelete', [catalogocategoriaControlller::class, 'store']);
Route::get('/Tablacategoria', [catalogocategoriaControlller::class, 'Tablacategoria']);

//  Catálogo de Género 
Route::get('/Género', function () {return view('RH.Catalogos.catalogo_genero');});
Route::post('/GeneroSave', [catalogogeneroControlller::class, 'store']);
Route::get('/GeneroDelete', [catalogogeneroControlller::class, 'store']);
Route::get('/Tablageneros', [catalogogeneroControlller::class, 'Tablageneros']);

// Catálogo de Puesto que se requiere como experiencia
Route::get('/Puesto-experiencia', function () {return view('RH.Catalogos.catalogo_experiencia');});
Route::post('/PuestoSave', [catalogoexperienciaController::class, 'store']);
Route::get('/PuestoDelete', [catalogoexperienciaController::class, 'store']);
Route::get('/Tablaexperiencia', [catalogoexperienciaController::class, 'Tablaexperiencia']);

// Catálogo Competencias básicas o cardinales 
Route::get('/Competencias-básicas', function () {return view('RH.Catalogos.catalogo_competenciasbasicas');});
Route::post('/BasicoSave', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/BasicoDelete', [catalogocompetenciabasicaController::class, 'store']);
Route::get('/Tablacompetenciabasica', [catalogocompetenciabasicaController::class, 'Tablacompetenciabasica']);

// Catálogo Competencias gerenciales 
Route::get('/Competencias-gerenciales', function () {return view('RH.Catalogos.catalogo_competenciasGerenciales'); });
Route::post('/GerencialesSave', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/GerencialesDelete', [catalogoCompotenciasGerencialesController::class, 'store']);
Route::get('/TablaCompetenciasGerenciales', [catalogoCompotenciasGerencialesController::class, 'TablaCompetenciasGerenciales']);

// Catálogo de Tipoo de vacantes
Route::get('/Tipo-vacante', function () {return view('RH.Catalogos.catalogo_tipovacante');});
Route::post('/TipoSave', [catalogotipovacanteController::class, 'store']);
Route::get('/TipoDelete', [catalogotipovacanteController::class, 'store']);
Route::get('/Tablatipovacantes', [catalogotipovacanteController::class, 'Tablatipovacantes']);

// Catálogo de  Motivo de vacantes 
Route::get('/Motivo-vacante', function () {return view('RH.Catalogos.catalogo_motivovacante');});
Route::post('/MotivoSave', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/MotivoDelete', [catalogomotivovacanteControlller::class, 'store']);
Route::get('/Tablamotivovacante', [catalogomotivovacanteControlller::class, 'Tablamotivovacante']);




// CATALOGOS
Route::get('/Catálogo_ppt', function () {return view('RH.Catalogos.catalogo_ppt');});
Route::get('/Catálogo_dpt', function () {return view('RH.Catalogos.catalogo_dpt');});
Route::get('/Catálogo_requisición', function () {return view('RH.Catalogos.catalogo_requisicion');});
Route::get('/Catálogo_generales', function () {return view('RH.Catalogos.catalogo_generales');});





//==============================================  RECLUTAMIENTO  ============================================== 

// Formulario de Banco de CV externo a la aplicación
Route::get('/Formulario-vacantes', [bancocvController::class, 'index1']);
Route::post('/BancoSave', [bancocvController::class, 'store']);


Route::post('/FormCVSave', [formCVController::class, 'store']);
Route::post('/actualizarinfocv', [formCVController::class, 'actualizarinfocv'])->name('actualizarinfocv');


//  Tabla para poder la información del formulario de Banco de CV 
Route::get('/Listavacantes', [bancocvController::class, 'index']);
Route::get('/BancoDelete', [bancocvController::class, 'store']);
Route::get('/Tablabancocv', [bancocvController::class, 'Tablabancocv']);

Route::get('/mostrarCurpCv/{id}', [bancocvController::class, 'mostrarCurpCv']);
Route::get('/mostrarCv/{id}', [bancocvController::class, 'mostrarCv']);


// Ruta para ver las vacantes externa en la aplicación
Route::get('/Vacantes', [PuestoController::class, 'index']);
Route::post('/actualizarinfo', [PuestoController::class, 'getCvInfo'])->name('actualizarinfo');
Route::post('/ActualizarSave', [PuestoController::class, 'store']);
Route::post('/PostularseSave', [PuestoController::class, 'store1']);

// Catálogo de vacantes
Route::get('/CatálogoDeVacantes', [catalogovacantesController::class, 'index']);
Route::post('/VacantesSave', [catalogovacantesController::class, 'store']);
Route::get('/VacanteDelete', [catalogovacantesController::class, 'store']);
Route::get('/Tablavacantes', [catalogovacantesController::class, 'Tablavacantes']);

//  Catálogo área de intereses
Route::get('/Área_interes', function () {return view('RH.Catalogos.catalogo_areainteres');});
Route::post('/interesSave', [catalogoareainteresController::class, 'store']);
Route::get('/interesDelete', [catalogoareainteresController::class, 'store']);
Route::get('/Tablaareainteres', [catalogoareainteresController::class, 'Tablaareainteres']);


// visualizar la vacantes y poder ver los que se han postulado y poder mandar a selección
Route::get('/Postulaciones', [vacantesactivasController::class, 'index']);
Route::get('/Tablapostulaciones', [vacantesactivasController::class, 'Tablapostulaciones']);
Route::post('/VacantesactSave', [vacantesactivasController::class, 'store']);

// Poder visualizar la información de los postulantes y guardarlos 
Route::get('/informacionpostulantes/{idVacante}', [vacantesactivasController::class, 'informacionpostulantes']);
Route::get('/obtener-cv/{curp}', [vacantesactivasController::class, 'mostrarCvPorCurp'])->name('mostrarCvPorCurp');
Route::post('/guardarPostulantes', [vacantesactivasController::class, 'guardarPostulantes']);

// Poder visualizar la informacion de los que se van a  preseleccionar y  mandarlos a selección
Route::post('/guardarPreseleccion', [vacantesactivasController::class, 'guardarPreseleccion']);
Route::get('/informacionpreseleccion/{idVacante}', [VacantesactivasController::class, 'informacionpreseleccion']);
Route::post('/actualizarDisponibilidad', [VacantesactivasController::class, 'actualizarDisponibilidad']);




//==============================================  SELECCION  ============================================== 

Route::get('/Selección', [seleccionController::class, 'index']);
// Route::get('/Selección', function () {return view('RH.Selección.seleccion');});
Route::get('/Tablaseleccion', [seleccionController::class, 'Tablaseleccion']);
Route::post('/SeleccionSave', [seleccionController::class, 'store']);
Route::get('/consultarSeleccion/{vacantesId}', [seleccionController::class, 'consultarSeleccion']);




Route::post('/guardarPendiente', [seleccionController::class, 'guardarPendiente']);



// AUTORIZACION
Route::get('/ver-archivo/{curp}', [seleccionController::class, 'visualizarArchivo']);
Route::get('/ver-pdf', [seleccionController::class, 'mostrarPDF'])->name('ver-pdf');
Route::get('/Tablaautorizacion', [seleccionController::class, 'Tablaautorizacion']);

//  Inteligencia laboral
Route::get('/Tablainteligencia', [seleccionController::class, 'Tablainteligencia']);
Route::get('/mostrarcompetencias/{id}', [seleccionController::class, 'mostrarcompetencias']);
Route::get('/mostrarcompleto/{id}', [seleccionController::class, 'mostrarcompleto']);

//  Buró laboral
Route::get('/Tablaburo', [seleccionController::class, 'Tablaburo']);
Route::get('/mostrarburo/{id}', [seleccionController::class, 'mostrarburo']);

//  Perfil de puesto de trabajo (PPT)
Route::get('/Tablapptseleccion', [seleccionController::class, 'Tablapptseleccion']);
Route::get('/consultarformppt/{id}', [seleccionController::class, 'consultarformppt']);

//Referencias laboral
Route::get('/Tablareferencia', [seleccionController::class, 'Tablareferencia']);
Route::get('/mostrareferencias/{id}', [seleccionController::class, 'mostrareferencias']);

// Pruebas de conocimientos
Route::get('/obtenerRequerimientos/{id}', [seleccionController::class, 'obtenerRequerimientos']);
Route::get('/Tablapruebaconocimientoseleccion', [seleccionController::class, 'Tablapruebaconocimientoseleccion']);
Route::get('/mostrarprueba/{id}', [seleccionController::class, 'mostrarprueba']);



// Entrevista
Route::get('/Tablaentrevistaseleccion', [seleccionController::class, 'Tablaentrevistaseleccion']);



//  Catálogo de pruebas de conocimientos
Route::get('/Pruebas-conocimientos', function () {return view('RH.Catalogos.catalogo_pruebasconocimiento');});
Route::post('/pruebaSave', [catalogopruebasController::class, 'store']);
Route::get('/pruebaDelete', [catalogopruebasController::class, 'store']);
Route::get('/Tablapruebaconocimiento', [catalogopruebasController::class, 'Tablapruebaconocimiento']);


//==============================================  CONTRATACION  ============================================== 



// PENDIENTE AL CONTRATAR
Route::get('/Pendiente-Contratar', function () {return view('RH.contratacion.pendientecontratar');});

Route::get('/Tablapendientecontratacion', [pendientecontratarController::class, 'Tablapendientecontratacion']);
Route::post('/mandarcontratacion', [pendientecontratarController::class, 'mandarcontratacion']);



// DATOS GENERALES

Route::get('/Contratación', [contratacionController::class, 'index']);

Route::post('/contratoSave', [contratacionController::class, 'store']);

Route::post('/obtenerbajasalta', [contratacionController::class, 'obtenerbajasalta']);

Route::get('/Tablacontratacion', [contratacionController::class, 'Tablacontratacion']);
Route::get('/Tablacontratacion1', [contratacionController::class, 'Tablacontratacion1']);
Route::post('/activarColaborador/{id}', [contratacionController::class, 'activarColaborador']);

Route::get('/usuariocolaborador/{id}', [contratacionController::class, 'mostrarfotocolaborador']);
Route::post('/verificarestadobloqueo', [contratacionController::class, 'verificarestadobloqueo']);

// CREAR CREDENCIAL 
Route::get('/descargar-credencial', [PowerPointController::class, 'descargarCredencial']);
Route::get('/prueba-presentation', [TestController::class, 'prueba']);
Route::get('/prueba-editar', [TestController::class, 'editarPlantilla']);

// DOCUMENTOS DE SOPORTE
Route::get('/Tabladocumentosoporte', [contratacionController::class, 'Tabladocumentosoporte']);
Route::get('/mostrardocumentosoporte/{id}', [contratacionController::class, 'mostrardocumentosoporte']);
Route::post('/obtenerguardados', [contratacionController::class, 'obtenerguardados']);

// DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL

Route::get('/Tablasoportecontrato', [contratacionController::class, 'Tablasoportecontrato']);
Route::get('/mostrardocumentocolaboradorcontratosoporte/{id}', [contratacionController::class, 'mostrardocumentocolaboradorcontratosoporte']);
Route::post('/obtenerdocumentosoportescontratos', [contratacionController::class, 'obtenerdocumentosoportescontratos']);


///////////////////////////////////////////////////////////// CONTRATOS Y ANEXOS //////////////////////////////////////////////////////////

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

///////////////////////////////////////////////////////////// RECURSOS DE LOS EMPLEADOS //////////////////////////////////////////////////////////

 Route::get('/Rec.Empleado', function () {return view('RH.RecEmpleados.RecEmpleados');});


///////////////////////////////////////////////////////////// DESVINCULACIÓN //////////////////////////////////////////////////////////

// Route::get('/Desvinculación', function () {return view('RH.desvinculacion.desvinculacion');});

Route::get('/Desvinculación', [desvinculacionController::class, 'index']);
Route::post('/desvinculacionSave', [desvinculacionController::class, 'store']);
Route::get('/Tabladesvinculacion', [desvinculacionController::class, 'Tabladesvinculacion']);

Route::get('/mostrardocumentobaja/{id}', [desvinculacionController::class, 'mostrardocumentobaja']);
Route::get('/mostrardocumenconvenio/{id}', [desvinculacionController::class, 'mostrardocumenconvenio']);
Route::get('/mostrardocumenadeudo/{id}', [desvinculacionController::class, 'mostrardocumenadeudo']);



Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Application cache cleared';
});



