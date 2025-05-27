@extends('principal.maestracompras')

@section('contenido')




<style>
    .multisteps-form__progress {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-bottom: 20px;
        width: 100%;
        height: 40px;
    }

    /* .multisteps-form__progress::before {
    content: '';
    position: absolute;
    top: 24%; 
    left: calc(7%); 
    width: calc(87%); 
    height: 7px; 
    background-color: #e0e0e0;
    z-index: 0;
    transform: translateY(-50%); 
} */




    .multisteps-form__progress-btn {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 14px;
        color: ##f3f3f3;
        flex: 1;
        text-align: center;
    }

    .step-circle {
        width: 49px;
        height: 49px;
        border-radius: 50%;
        background-color: #fffdfd;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 5px;
        position: relative;
        z-index: 1;
    }

    .step-circle i {
        font-size: 24px;
        color: #c9c4c4;
    }



    .texto-seleccionado {
        color: #0d6efd;
        font-weight: bold;
    }

    .texto-no-seleccionado {
        color: gray;
    }

    .texto-no-seleccionado:hover {
        text-decoration: underline;
    }


    .text-warning {
        color: orange !important;
    }

    .text-success {
        color: green !important;
    }
</style>







<div class="contenedor-contenido">





    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratos" role="tab" aria-controls="contratos" aria-selected="true">Lista de proveedores</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" id="datosgenerales-tab" data-toggle="tab" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Expediente del proveedores</a>
                </li>

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- Lista de contratos Tab -->
                <div class="tab-pane fade show active" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
                    <ol class="breadcrumb mb-5">
                        <h3 style="color: #ffffff; margin: 0;">
                            <i class="bi bi-folder2-open"></i>&nbsp;&nbsp;Proveedores
                        </h3>

                    </ol>



                    <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                        <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablalistaproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>


                </div>


                <!-- Datos Generales Tab -->
                <div class="tab-pane fade" id="datosgenerales" role="tabpanel" aria-labelledby="datosgenerales-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body" style="padding: 6px 10px;">
                                    <table class="table" style="border: px #000 solid; margin: 0px;">
                                        <tbody>
                                            <tr>
                                                <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                    <h7 style="margin: 0px;">
                                                        <i class="bi bi-person-circle"></i>&nbsp;&nbsp; <span class="text-primary div_trabajador_nombre">RFC PROVEEDOR</span>
                                                    </h7>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="multisteps-form">
                                <div class="multisteps-form__progress">
                                    <div class="multisteps-form__progress-btn js-active" id="step1">
                                        <div class="step-circle">
                                            <i class="bi bi-briefcase-fill"></i>
                                        </div>
                                        <span>Datos generales</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step2">
                                        <div class="step-circle">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <span>Cuentas bancarias</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step3">
                                        <div class="step-circle">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </div>
                                        <span> Contactos</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step4">
                                        <div class="step-circle">
                                            <i class="bi bi-award-fill"></i>
                                        </div>
                                        <span>Certificaciones</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step5">
                                        <div class="step-circle">
                                            <i class="bi bi-journal-text"></i>
                                        </div>
                                        <span>Referencias comerciales</span>
                                    </div>

                                    <div class="multisteps-form__progress-btn" id="step6">
                                        <div class="step-circle">
                                            <i class="bi bi-file-earmark-fill"></i>
                                        </div>
                                        <span>Documentos de soporte</span>
                                    </div>



                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Step 1 de Datos Generales -->
                    <div id="step1-content" style="display: block;">
                        <ol class="breadcrumb mt-5 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="color: #ffffff; margin: 0;">
                                <i class="bi bi-person"></i>&nbsp;&nbsp;Información del proveedor
                            </h3>
                            <button class="btn" style="background-color: #236192; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px; display: none;" id="DESCARGAR_CREDENCIAL">Crear Credencial</button>
                        </ol>

                        <!-- Formulario de Datos Generales -->
                        <form method="post" enctype="multipart/form-data" id="formularioALTA">
                            {!! csrf_field() !!}



                            <input type="hidden" name="ID_FORMULARIO_ALTA" id="ID_FORMULARIO_ALTA" value="0">


                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label>Tipo de Proveedor *</label>
                                        <select class="form-control" name="TIPO_PERSONA_ALTA" id="TIPO_PERSONA_ALTA" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="1">Nacional</option>
                                            <option value="2">Extranjero</option>
                                        </select>
                                    </div>


                                    <div class="col-4 mb-3">
                                        <label>Tipo de Persona *</label>
                                        <select class="form-control" name="TIPO_PERSONA_OPCION" id="TIPO_PERSONA_OPCION" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="1">Moral</option>
                                            <option value="2">Física</option>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label>Razón social/Nombre *</label>
                                        <input type="text" class="form-control" name="RAZON_SOCIAL_ALTA" id="RAZON_SOCIAL_ALTA" required>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label>Representante Legal *</label>
                                        <input type="text" class="form-control" name="REPRESENTANTE_LEGAL_ALTA" id="REPRESENTANTE_LEGAL_ALTA" required>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="RFC_LABEL">R.F.C *</label>
                                        <input type="text" class="form-control" name="RFC_ALTA" id="RFC_ALTA" required readonly>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label>Régimen </label>
                                        <select class="form-control" name="REGIMEN_ALTA" id="REGIMEN_ALTA">
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="1">General de Ley Personas Morales </option>
                                            <option value="2">Personas Morales con Fines no Lucrativos </option>
                                            <option value="3">Sueldos y Salarios e Ingresos Asimilados a Salarios </option>
                                            <option value="4">Arrendamiento </option>
                                            <option value="5">Demás ingresos </option>
                                            <option value="6">Consolidación </option>
                                            <option value="7">Residentes en el Extranjero sin Establecimiento Permanente en México </option>
                                            <option value="8">Ingresos por Dividendos (socios y accionistas) </option>
                                            <option value="9">Personas Físicas con Actividades Empresariales y Profesionales </option>
                                            <option value="10">Ingresos por intereses </option>
                                            <option value="11">Sin obligaciones fiscales </option>
                                            <option value="12">Sociedades Cooperativas de Producción que optan por diferir sus ingresos </option>
                                            <option value="13">Incorporación Fiscal </option>
                                            <option value="14">Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras </option>
                                            <option value="15">Opcional para Grupos de Sociedades </option>
                                            <option value="16">Coordinados </option>
                                            <option value="17">Hidrocarburos </option>
                                            <option value="18">Régimen de Enajenación o Adquisición de Bienes </option>
                                            <option value="19">De los Regimenes Fiscales Preferentes y de las Empresas Multinacionales</option>
                                            <option value="20">Enajenación de acciones en bolsa de valores </option>
                                            <option value="21">Régimen de los ingresos por obtención de premios </option>
                                            <option value="22">Otro </option>


                                        </select>
                                    </div>


                                    <div class="mb-3 text-center">
                                        <h4><b>Datos generales</b></label>
                                    </div>


                                    <div class="col-12" id="DOMICILIO_NACIONAL" style="display: block;">

                                        <div class="row">

                                            <div class="col-3 mb-3">
                                                <label>Código Postal *</label>
                                                <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label>Tipo de Vialidad *</label>
                                                <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA">
                                            </div>
                                            <div class="col-5 mb-3">
                                                <label>Nombre de la Vialidad *</label>
                                                <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label>Número Exterior</label>
                                                <input type="text" class="form-control" name="NUMERO_EXTERIOR_EMPRESA" id="NUMERO_EXTERIOR_EMPRESA">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label>Número Interior</label>
                                                <input type="text" class="form-control" name="NUMERO_INTERIOR_EMPRESA" id="NUMERO_INTERIOR_EMPRESA">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Nombre de la colonia *</label>
                                                <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA">
                                                    <option value="">Seleccione una opción</option>
                                                </select>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Nombre de la Localidad *</label>
                                                <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA">
                                            </div>


                                            <div class="col-6 mb-3">
                                                <label>Nombre del municipio o demarcación territorial *</label>
                                                <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Nombre de la Entidad Federativa *</label>
                                                <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>País *</label>
                                                <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA">
                                            </div>



                                            <div class="col-6 mb-3">
                                                <label>Entre Calle</label>
                                                <input type="text" class="form-control" name="ENTRE_CALLE_EMPRESA" id="ENTRE_CALLE_EMPRESA">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Y Calle</label>
                                                <input type="text" class="form-control" name="ENTRE_CALLE2_EMPRESA" id="ENTRE_CALLE2_EMPRESA">
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-12" id="DOMICILIO_ERXTRANJERO" style="display: none;">

                                        <div class="row">

                                            <div class="col-12 mb-3">
                                                <label>Domicilio *</label>
                                                <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" id="DOMICILIO_EXTRANJERO">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Código Postal </label>
                                                <input type="text" class="form-control" name="CODIGO_EXTRANJERO" id="CODIGO_EXTRANJERO">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Ciudad *</label>
                                                <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" id="CIUDAD_EXTRANJERO">
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label>Estado/Departamento/Provincia</label>
                                                <input type="text" class="form-control" name="ESTADO_EXTRANJERO" id="ESTADO_EXTRANJERO">
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label>País *</label>
                                                <input type="text" class="form-control" name="PAIS_EXTRANJERO" id="PAIS_EXTRANJERO">
                                            </div>

                                        </div>
                                    </div>





                                    <div class="col-6 mb-3">
                                        <label>Correo electrónico *</label>
                                        <input type="text" class="form-control" name="CORREO_DIRECTORIO" id="CORREO_DIRECTORIO" required>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label>Teléfono oficina *</label>
                                        <input type="text" class="form-control" name="TELEFONO_OFICINA_ALTA" id="TELEFONO_OFICINA_ALTA" required>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label>Página web </label>
                                        <input type="text" class="form-control" name="PAGINA_WEB_ALTA" id="PAGINA_WEB_ALTA">
                                    </div>


                                    <div class="mb-3 text-center">
                                        <h4><b>Actividad económica y términos comerciales</b></label>
                                    </div>



                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="ACTIVIDAD_ECONOMICA" id="VENTA_PRODUCTOS" value="1" required>
                                            <label class="form-check-label" for="VENTA_PRODUCTOS">Ventas de productos/bienes</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="ACTIVIDAD_ECONOMICA" id="VENTA_SERVICIOS" value="2">
                                            <label class="form-check-label" for="VENTA_SERVICIOS">Venta de servicios</label>
                                        </div>
                                    </div>

                                    <div id="CUAL_ACTIVIAD" class="col-12 mb-3" style="display: none;">
                                        <label>Cuál</label>
                                        <input type="text" class="form-control" name="CUAL_ACTVIDAD_ECONOMICA" id="CUAL_ACTVIDAD_ECONOMICA">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label>Actividad comercial principal</label>
                                        <input type="text" class="form-control" name="ACTVIDAD_COMERCIAL" id="ACTVIDAD_COMERCIAL" required>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="me-3">Descuentos que ofrece</label>
                                    </div>

                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PAGO" value="1" required>
                                            <label class="form-check-label" for="POR_PAGO">Por pronto pago</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_VOLUMEN" value="2">
                                            <label class="form-check-label" for="POR_VOLUMEN">Por volumen</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PROMOCION" value="3">
                                            <label class="form-check-label" for="POR_PROMOCION">Promociones</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="OTROS_DESCUENTO" onclick="cualdescuentos()" value="4">
                                            <label class="form-check-label" for="OTROS_DESCUENTO">Otros</label>
                                        </div>
                                    </div>

                                    <div id="CUAL_DESCUENTOS" class="col-12 mb-3" style="display: none;">
                                        <label>Cuál</label>
                                        <input type="text" class="form-control" name="CUAL_DESCUENTOS_ECONOMICA" id="CUAL_DESCUENTOS_ECONOMICA">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label>Días de crédito que otorga </label>
                                        <input type="number" class="form-control" name="DIAS_CREDITO_ALTA" id="DIAS_CREDITO_ALTA">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label>Otros términos comerciales de importancia </label>
                                        <textarea type="number" class="form-control" name="TERMINOS_IMPORTANCIAS_ALTA" id="TERMINOS_IMPORTANCIAS_ALTA" rows="5"></textarea>
                                    </div>







                                    <div class="mb-3 text-center">
                                        <h4><b>Información adicional para la debida diligencia</b></label>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">¿Usted o la compañía tiene vínculos familiares hasta en tercer grado de consanguinidad con personal que laboran en Results In Performance, sus filiales o cualquier tipo de vínculo puede ser personal o laboral que pueda generar un conflicto de interés?</label>
                                        <div class="form-check d-inline-block me-3">
                                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_SI" value="SI" onclick="vinculosres()">
                                            <label class="form-check-label" for="VINCULO_SI">Si</label>
                                        </div>
                                        <div class="form-check d-inline-block">
                                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_NO" value="NO">
                                            <label class="form-check-label" for="VINCULO_NO">No</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3" id="DIV_VINCULOS" style="display: none">
                                        <label class="form-label">Describa cuál:</label>
                                        <input type="text" class="form-control" name="DESCRIPCION_VINCULO" id="DESCRIPCION_VINCULO">
                                    </div>
                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <label class="me-3">¿La empresa que representa ofrece servicios directos como proveedor/contratista/subcontratista a PEMEX?</label>
                                    </div>
                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="SI_NUMEROPROVEEDOR" value="SI" onclick="numeroproveedor()">
                                            <label class="form-check-label" for="SI_NUMEROPROVEEDOR">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="NO_NUMEROPROVEEDOR" value="NO">
                                            <label class="form-check-label" for="NO_NUMEROPROVEEDOR">No</label>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3" id="DIV_NUMEROPROVEEDOR" style="display: none">
                                        <label class="form-label">No. de proveedor:</label>
                                        <input type="text" class="form-control" name="NUMERO_PROVEEDOR" id="NUMERO_PROVEEDOR">
                                    </div>

                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <label class="me-3">¿Alguno de sus empleados clave o miembro de la alta dirección de su organización proporciona o proporcionará beneficios financieros o de cualquier otro tipo a algún empleado de Pemex o la Sociedad, a algún funcionario de gobierno o un miembro de la familia de un funcionario de gobierno (por ejemplo, asistencia educativa o médica, vivienda), es decir, Personas Políticamente Expuestas?</label>
                                    </div>
                                    <div class="col-12 mb-3 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="BENEFICIOS_PERSONA" id="SI_BENEFICIOS_PERSONA" value="SI" onclick="politicamentexpuesto()">
                                            <label class="form-check-label" for="SI_BENEFICIOS_PERSONA">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="BENEFICIOS_PERSONA" id="NO_BENEFICIOS_PERSONA" value="NO">
                                            <label class="form-check-label" for="NO_BENEFICIOS_PERSONA">No</label>
                                        </div>
                                    </div>


                                    <div class="col-12 mb-3" id="PERSONA_EXPUESTA" style="display: none">
                                        <label class="form-label">Nombre de la persona políticamente expuesta:</label>
                                        <input type="text" class="form-control" name="NOMBRE_PERSONA" id="NOMBRE_PERSONA">
                                    </div>

                                </div>
                            </div>




                            <div class="col-12 text-center">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" id="guardarALTA" class="btn btn-success w-100">
                                        Guardar
                                    </button>
                                </div>
                            </div>


                        </form>






                    </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}






                    <!-- Step 2 de Documentos del colaborador -->

                    <div id="step2-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Información para pago/depósito/transferencia interbancaria</h3>

                            <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_CUENTA" data-bs-toggle="modal" data-bs-target="#miModal_cuentas" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablacuentas" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 3 Contratos y anexos -->


                    <div id="step3-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Contactos</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_CONTACTO" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon3" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablacontactos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>




                    <!-- Step 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL -->

                    <div id="step4-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-award-fill"></i>&nbsp;Certificaciones, acreditaciones y membresías</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_CERTIFICACION" data-bs-toggle="modal" data-bs-target="#miModal_certificaciones" style="margin-left: auto;">
                                Nueva &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon4" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablacertificaciones" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 5 CV´S -->

                    <div id="step5-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-journal-text"></i>&nbsp;Referencia comerciales</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_REFERENCIA" data-bs-toggle="modal" data-bs-target="#miModal_referencia" style="margin-left: auto;">
                                Nueva &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon5" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablareferencias" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 6 Requisición de personal  -->

                    <div id="step6-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-pdf-fill"></i>&nbsp;Documentos de soporte</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVO_DOCUMENTO" data-bs-toggle="modal" data-bs-target="#miModal_documentos" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon6" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tabladocumentosoporteproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


































                </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}



            </div>
        </div>
    </div>
</div>







<!-- ============================================================== -->
<!-- MODAL CUENTAS BANCARIAS-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_cuentas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCuentas" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de cuenta *</label>
                                    <select class="form-control" name="TIPO_CUENTA" id="TIPO_CUENTA" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Ahorros">Ahorros</option>
                                        <option value="Cheques">Cheques</option>
                                        <option value="Extranjera">Extranjera</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre del beneficiario *</label>
                                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" id="NOMBRE_BENEFICIARIO" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. de cuenta *</label>
                                    <input type="text" class="form-control" name="NUMERO_CUENTA" id="NUMERO_CUENTA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de moneda *</label>
                                    <input type="text" class="form-control" name="TIPO_MONEDA" id="TIPO_MONEDA" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3" id="CLABE_INTERBANCARIA" style="display: block;">
                            <label class="form-label">CLABE interbancaria *</label>
                            <input type="text" class="form-control" name="CLABE_INTERBANCARIA" id="CLABE_INTERBANCARIA" pattern="\d{18}" maxlength="18" placeholder="Ingrese 18 dígitos">
                        </div>

                        <div id="DIV_EXTRAJERO" style="display: none;">


                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código SWIFT o BIC</label>
                                        <input type="text" class="form-control" name="CODIGO_SWIFT_BIC" id="CODIGO_SWIFT_BIC">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código ABA</label>
                                        <input type="text" class="form-control" name="CODIGO_ABA" id="CODIGO_ABA">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Dirección del banco *</label>
                                <input type="text" class="form-control" name="DIRECCION_BANCO" id="DIRECCION_BANCO">
                            </div>

                        </div>


                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ciudad *</label>
                                    <input type="text" class="form-control" name="CIUDAD" id="CIUDAD" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">País *</label>
                                    <input type="text" class="form-control" name="PAIS" id="PAIS" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">
                                Carátula bancaria &nbsp;
                                <i class="bi bi-info-circle-fill" title="Anexar carátula bancaria sin saldo y que aparezcan los datos del beneficiario"></i>
                            </label>
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control" name="CARATULA_BANCARIA" id="CARATULA_BANCARIA" accept="application/pdf">
                                <i id="iconEliminarArchivo" class="bi bi-trash-fill ms-2 text-danger fs-5 d-none" style="cursor: pointer;" title="Eliminar archivo"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCuentas">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL CONTACTOS-->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_contactos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCONTACTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Contacto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Funciones/áreas *</label>
                                    <select class="form-control" name="FUNCIONES_CUENTA[]" id="FUNCIONES_CUENTA" multiple>
                                        @foreach ($funcionesCuenta as $funcion)
                                        <option value="{{ $funcion->ID_CATALOGO_FUNCIONESPROVEEDOR }}">
                                            {{ $funcion->NOMBRE_FUNCIONES }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Título *</label>
                                    <select class="form-control" name="TITULO_CUENTA" id="TITULO_CUENTA" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        @foreach ($titulosCuenta as $titulo)
                                        <option value="{{ $titulo->ABREVIATURA_TITULO }}">
                                            {{ $titulo->NOMBRE_TITULO }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-9 mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CONTACTO_CUENTA" id="NOMBRE_CONTACTO_CUENTA" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_CONTACTO_CUENTA" id="CARGO_CONTACTO_CUENTA" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="TELEFONO_CONTACTO_CUENTA" id="TELEFONO_CONTACTO_CUENTA">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Extensión</label>
                                    <input type="text" class="form-control" name="EXTENSION_CONTACTO_CUENTA" id="EXTENSION_CONTACTO_CUENTA">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Celular *</label>
                                    <input type="text" class="form-control" name="CELULAR_CONTACTO_CUENTA" id="CELULAR_CONTACTO_CUENTA" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="email" class="form-control" name="CORREO_CONTACTO_CUENTA" id="CORREO_CONTACTO_CUENTA" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONTACTOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL CERTIFICACIONES-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_certificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCertificaciones" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Certificación, acreditación o membresía</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Seleccione el tipo *</label>
                            <select class="form-control" id="TIPO_DOCUMENTO" name="TIPO_DOCUMENTO" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="Certificación">Certificación</option>
                                <option value="Acreditación">Acreditación</option>
                                <option value="Membresía">Membresía</option>
                            </select>
                        </div>

                        <!-- Sección Certificación -->
                        <div id="DIV_CERTIFICACION" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Norma estándar *</label>
                                    <input type="text" class="form-control" name="NORMA_CERTIFICACION" id="NORMA_CERTIFICACION">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Versión *</label>
                                    <input type="text" class="form-control" name="VERSION_CERTIFICACION" id="VERSION_CERTIFICACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Organismo certificador *</label>
                                    <input type="text" class="form-control" name="ENTIDAD_CERTIFICADORA" id="ENTIDAD_CERTIFICADORA">
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Certificado desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_CERTIFICACION" name="DESDE_CERTIFICACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_CERTIFICACION" name="HASTA_CERTIFICACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_CERTIFICACION" id="DOCUMENTO_CERTIFICACION" accept=".pdf">
                                </div>
                            </div>
                        </div>

                        <!-- Sección Acreditación -->
                        <div id="DIV_ACREDITACION" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Norma *</label>
                                    <input type="text" class="form-control" name="NORMA_ACREDITACION" id="NORMA_ACREDITACION">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Versión *</label>
                                    <input type="text" class="form-control" name="VERSION_ACREDITACION" id="VERSION_ACREDITACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Alcance de la certificación *</label>
                                    <input type="text" class="form-control" name="ALCANCE_ACREDITACION" id="ALCANCE_ACREDITACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Organismo acreditador *</label>
                                    <input type="text" class="form-control" name="ENTIDAD_ACREDITADORA" id="ENTIDAD_ACREDITADORA">
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Acreditado desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_ACREDITACION" name="DESDE_ACREDITACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_ACREDITACION" id="DOCUMENTO_ACREDITACION" accept=".pdf">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">¿El estándar requiere aprobación o autorización? *</label>
                                    <select class="form-control" id="REQUISITO_AUTORIZACION" name="REQUISITO_AUTORIZACION">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div id="DIV_AUTORIZACION" class="col-12" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Entidad *</label>
                                            <input type="text" class="form-control" name="ENTIDAD_AUTORIZADORA" id="ENTIDAD_AUTORIZADORA">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label>Desde *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_AUTORIZACION" name="DESDE_AUTORIZACION">
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>


                                        <div class="col-6 mb-3">
                                            <label>Desde *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_ACREDITACION" name="HASTA_ACREDITACION">
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Subir archivo (PDF) *</label>
                                            <input type="file" class="form-control" name="DOCUMENTO_AUTORIZACION" id="DOCUMENTO_AUTORIZACION" accept=".pdf">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Membresía -->
                        <div id="DIV_MEMBRESIA" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre de la entidad *</label>
                                    <input type="text" class="form-control" name="NOMBRE_ENTIDAD_MEMBRESIA" id="NOMBRE_ENTIDAD_MEMBRESIA">
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Miembro desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_MEMBRESIA" name="DESDE_MEMBRESIA">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Vigencia hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_MEMBRESIA" name="HASTA_MEMBRESIA">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_MEMBRESIA" id="DOCUMENTO_MEMBRESIA" accept=".pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCertificaciones">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- ============================================================== -->
<!-- MODAL REFERENCIAS-->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_referencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioReferencias" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva referencia comercial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre de la empresa *</label>
                                    <input type="text" class="form-control" name="NOMBRE_EMPRESA" id="NOMBRE_EMPRESA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Nombre del contacto *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CONTACTO" id="NOMBRE_CONTACTO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_REFERENCIA" id="CARGO_REFERENCIA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="text" class="form-control" name="TELEFONO_REFERENCIA" id="TELEFONO_REFERENCIA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="text" class="form-control" name="CORREO_REFERENCIA" id="CORREO_REFERENCIA" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Producto y/o servicio suministrado *</label>
                                    <input type="text" class="form-control" name="PRODUCTO_SERVICIO" id="PRODUCTO_SERVICIO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="DESDE_REFERENCIA" id="DESDE_REFERENCIA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>


                                <input type="hidden" name="REFERENCIA_VIGENTE" id="referenciaVigenteInput">


                                <div class="col-6 mb-3">
                                    <label class="form-label">Hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="HASTA_REFERENCIA" id="HASTA_REFERENCIA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarREFERENCIAS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL DOCUMENTOS DE SOPORTE-->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_documentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Documento *</label>
                            <select class="form-control" name="TIPO_DOCUMENTO_PROVEEDOR" id="TIPO_DOCUMENTO_PROVEEDOR">
                                <option value="" selected disabled>Seleccione una opción</option>

                                <optgroup label="Documentos obligatorios">
                                    @foreach ($documetoscatalogo->where('TIPO_DOCUMENTO', 1) as $documento)
                                    <option value="{{ $documento->ID_CATALOGO_DOCUMENTOSPROVEEDOR }}">
                                        {{ $documento->NOMBRE_DOCUMENTO }}
                                    </option>
                                    @endforeach
                                </optgroup>

                                <optgroup label="Documentos opcionales">
                                    @foreach ($documetoscatalogo->where('TIPO_DOCUMENTO', 2) as $documento)
                                    <option value="{{ $documento->ID_CATALOGO_DOCUMENTOSPROVEEDOR }}">
                                        {{ $documento->NOMBRE_DOCUMENTO }}
                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label>Nombre del archivo </label>
                            <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_PROVEEEDOR" name="NOMBRE_DOCUMENTO_PROVEEEDOR" readonly required>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">
                                Anexar documento &nbsp;
                            </label>
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control" name="DOCUMENTO_SOPORTE" id="DOCUMENTO_SOPORTE" accept="application/pdf">
                                <i id="iconEliminarArchivo" class="bi bi-trash-fill ms-2 text-danger fs-5 d-none" style="cursor: pointer;" title="Eliminar archivo"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("CODIGO_POSTAL").addEventListener("change", function() {
        let codigoPostal = this.value.trim();

        if (codigoPostal.length === 5) {
            fetch(`/codigo-postal/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;

                        let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = response.municipio || "No disponible";
                        document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = response.estado || "No disponible";
                        document.getElementById("NOMBRE_LOCALIDAD_EMPRESA").value = response.ciudad || "No disponible";
                        document.getElementById("PAIS_EMPRESA").value = response.pais || "No disponible";

                    } else {
                        alert("Código postal no encontrado");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                    alert("Hubo un error al consultar la API.");
                });
        }
    });
</script>



@endsection