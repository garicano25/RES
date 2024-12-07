@extends('principal.maestra')

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






</style>







<div class="contenedor-contenido">
  

   


<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratos" role="tab" aria-controls="contratos" aria-selected="true">Lista de colaboradores</a>
            </li>
            <li class="nav-item"   style="display: none;">
                <a class="nav-link" id="datosgenerales-tab" data-toggle="tab" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false" >Expediente del colaborador</a>
            </li>
            <li class="nav-item"   style="display: none;">
                <a class="nav-link" id="contratosdoc-tab" data-toggle="tab" href="#contratosdoc" role="tab" aria-controls="contratosdoc" aria-selected="false" >Contratos y anexos</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            
            <!-- Lista de contratos Tab -->
            <div class="tab-pane fade show active" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
                <ol class="breadcrumb mb-5">
                    <h3 style="color: #ffffff; margin: 0;">
                        <i class="bi bi-folder2-open"></i>&nbsp;&nbsp;Contratos
                    </h3>        
                    <button type="button" class="btn btn-light waves-effect waves-light" id="boton_nuevo_contrato" style="margin-left: auto;">
                        Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                    </button>
                </ol>
            
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <span id="texto_activo" class="texto-seleccionado me-4" style="cursor: pointer;">Activo</span>
                    <span id="texto_inactivo" class="texto-no-seleccionado" style="cursor: pointer;">Inactivo</span>
                </div>
            
                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                    <i id="loadingIcon8" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                    <table id="Tablacontratacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                    </table>
                </div>
            
                <div class="card-body position-relative" id="tabla_inactivo" style="display: none;">
                    <i id="loadingIcon7" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                    <table id="Tablacontratacion1" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                    </table>
                </div>
            </div>
            

            <!-- Datos Generales Tab -->
            <div class="tab-pane fade" id="datosgenerales" role="tabpanel" aria-labelledby="datosgenerales-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="padding: 6px 10px;">
                                <table class="table" style="border: 0px #000 solid; margin: 0px;">
                                    <tbody>
                                        <tr>
                                            <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                <h7 style="margin: 0px;">
                                                    <i class="bi bi-person-circle"></i>&nbsp;<span class="text-success div_trabajador_nombre">NOMBRE DEL COLABORADOR</span>
                                                </h7>
                                                <br>
                                                <span class="text-success div_trabajador_cargo" style="color: #AAAAAA; font-size: 12px;">Cargo</span> &nbsp;
                                                <span class="text-success div_trabajador_numeoro" style="color: #AAAAAA; font-size: 12px;">Número</span>
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
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </div>
                                    <span>Documentos de soporte</span>
                                </div>
                                <div class="multisteps-form__progress-btn" id="step3">
                                    <div class="step-circle">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </div>
                                    <span>Contratos y anexos</span>
                                </div>
                                {{-- <div class="multisteps-form__progress-btn" id="step4">
                                    <div class="step-circle">
                                        <i class="bi bi-hospital-fill"></i>
                                    </div>
                                    <span>Información Médica</span>
                                </div>
                                <div class="multisteps-form__progress-btn" id="step5">
                                    <div class="step-circle">
                                        <i class="bi bi-person-check-fill"></i>
                                    </div>
                                    <span>Incidencias</span>
                                </div>
                                <div class="multisteps-form__progress-btn" id="step6">
                                    <div class="step-circle">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <span>Acciones disciplinarias</span>
                                </div> --}}
                                <div class="multisteps-form__progress-btn" id="step4">
                                    <div class="step-circle">
                                        <i class="bi bi-file-person-fill"></i>
                                    </div>
                                    <span>CV</span>
                                </div>
                                {{-- <div class="multisteps-form__progress-btn" id="step8">
                                    <div class="step-circle">
                                        <i class="bi bi-pen-fill"></i>
                                    </div>
                                    <span>Recibos</span>
                                </div> --}}
                            </div>
                        </div>
                        
                    </div>
                </div>


                <!-- Step 1 de Datos Generales -->
                <div id="step1-content" style="display: block;">
                    <ol class="breadcrumb mt-5">
                        <h3 style="color: #ffffff; margin: 0;">
                            <i class="bi bi-person"></i>&nbsp;&nbsp;Información del colaborador 
                        </h3>
                    </ol>
                
                    <!-- Formulario de Datos Generales -->
                    <form method="post" enctype="multipart/form-data" id="FormularioCONTRATACION">
                        {!! csrf_field() !!}
                        <div class="row">

                            <div class="col-9">
                                <div class="row">
                                    
                                    <div class="col-6 mb-3">
                                        <label>Nombre(s) del colaborador *</label>
                                        <input type="text" class="form-control" id="NOMBRE_COLABORADOR" name="NOMBRE_COLABORADOR" required>
                                    </div>
                                    
                                    <div class="col-6 mb-3">
                                        <label>Primer apellido *</label>
                                        <input type="text" class="form-control" id="PRIMER_APELLIDO" name="PRIMER_APELLIDO" required>
                                    </div>
                                    
                                    <div class="col-5 mb-3">
                                        <label>Segundo apellido *</label>
                                        <input type="text" class="form-control" id="SEGUNDO_APELLIDO" name="SEGUNDO_APELLIDO" required>
                                    </div>

                                    <div class="col-5 mb-3">
                                        <label>CURP *</label>
                                        <input type="text" class="form-control" id="CURP" name="CURP" required>
                                    </div>
                                    
                                    <div class="col-2 mb-3">
                                        <label>Iniciales</label>
                                        <input type="text" class="form-control" id="INICIALES_COLABORADOR" name="INICIALES_COLABORADOR">
                                    </div>
                                    {{-- <div class="col-12 mb-3 text-center">
                                        <label>Fecha de nacimiento</label>
                                    </div> --}}

                                    <div class="col-3 mb-3">
                                        <label></label>
                                        <select class="form-select me-2" id="DIA_COLABORADOR" name="DIA_COLABORADOR" required>
                                            <option value="" selected disabled>Día</option>
                                            <script>
                                                for (let i = 1; i <= 31; i++) {
                                                    document.write('<option value="' + i + '">' + i + '</option>');
                                                }
                                            </script>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3 text-center">
                                        <label>Fecha de nacimiento</label>
                                        <select class="form-select me-2" id="MES_COLABORADOR" name="MES_COLABORADOR" required>
                                            <option value="" selected disabled>Mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                  
                                    <div class="col-3 mb-3">
                                        <label></label>
                                        <select class="form-select me-2" id="ANIO_COLABORADOR" name="ANIO_COLABORADOR" required>
                                            <option value="" selected disabled>Año</option>
                                            <script>
                                                const currentYear = new Date().getFullYear();
                                                for (let i = currentYear; i >= 1900; i--) {
                                                    document.write('<option value="' + i + '">' + i + '</option>');
                                                }
                                            </script>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label>Edad</label>
                                        <input type="number" class="form-control" id="EDAD_COLABORADOR" name="EDAD_COLABORADOR" readonly>
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label>Teléfono *</label>
                                        <input type="number" class="form-control" id="TELEFONO_COLABORADOR" name="TELEFONO_COLABORADOR" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="correo">Correo *</label>
                                        <input type="email" class="form-control" id="CORREO_COLABORADOR" name="CORREO_COLABORADOR" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="estadoCivil">Estado Civil *</label>
                                        <select class="form-control" id="ESTADO_CIVIL" name="ESTADO_CIVIL" required>
                                            <option value=""></option>
                                            <option value="1">Soltero (a)</option>
                                            <option value="2">Casado (a)</option>
                                            <option value="3">Divorciado (a)</option>
                                            <option value="4">Viudo (a)</option>
                                            <option value="5">Unión libre</option>

                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label >RFC *</label>
                                        <input type="text" class="form-control" id="RFC_COLABORADOR" name="RFC_COLABORADOR" required>
                                    </div>
                                </div>
                            </div>


                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="FOTO_TITULO">Foto colaborador *</label>
                                        <style>
                                            .dropify-wrapper {
                                                height: 270px !important;
                                                border-radius: 5px;
                                                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                                                text-align: center;
                                            }
                    
                                            .dropify-message p {
                                                font-size: 14px;
                                                margin: 0;
                                            }
                                        </style>
                                        <input type="file" accept="image/jpeg,image/x-png" id="FOTO_USUARIO" name="FOTO_USUARIO" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file="" />
                                    </div>
                                </div>                       
                    

                            


                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Lugar de nacimiento </b></h5>
                                </div>   

                                <div class="col-4 mb-3">
                                    <label >Ciudad</label>
                                    <input type="text" class="form-control" id="CIUDAD_LUGAR_NACIMIENTO" name="CIUDAD_LUGAR_NACIMIENTO" >
                                </div>         
                                
                                <div class="col-4 mb-3">
                                    <label >Estado/Departamento/Provincia</label>
                                    <input type="text" class="form-control" id="ESTADO_LUGAR_NACIMIENTO" name="ESTADO_LUGAR_NACIMIENTO" >
                                </div>  

                                <div class="col-4 mb-3">
                                    <label >País </label>
                                    <input type="text" class="form-control" id="PAIS_LUGAR_NACIMIENTO" name="PAIS_LUGAR_NACIMIENTO" >
                                </div>  

                                
                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Documento de identificación oficial</b></h5>
                                </div>  


                                <div class="col-2 mb-3">
                                    <label for="estadoCivil">Tipo *</label>
                                    <select class="form-control" id="TIPO_DOCUMENTO_IDENTIFICACION" name="TIPO_DOCUMENTO_IDENTIFICACION" required>
                                        <option value=""></option>
                                        <option value="1">Residencia temporal</option>
                                        <option value="2">Residencia Permanente</option>
                                        <option value="3">INE</option>
                                        <option value="4">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-2 mb-3">
                                    <label>Emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="EMISION_DOCUMENTO" name="EMISION_DOCUMENTO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-2 mb-3">
                                    <label>Vigencia *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_DOCUMENTO" name="VIGENCIA_DOCUMENTO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Número *</label>
                                    <input type="text" class="form-control" id="NUMERO_DOCUMENTO" name="NUMERO_DOCUMENTO" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Expedido en *</label>
                                    <input type="text" class="form-control" id="EXPEDIDO_DOCUMENTO" name="EXPEDIDO_DOCUMENTO" required>
                                </div>

                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Domicilio</b></h5>
                                </div>  

                                <div class="col-3 mb-3">
                                    <label>Código Postal *</label>
                                    <input type="number" class="form-control" id="CODIGO_POSTAL" name="CODIGO_POSTAL" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Tipo de Vialidad *</label>
                                    <input type="text" class="form-control" id="TIPO_VIALIDAD" name="TIPO_VIALIDAD" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la Vialidad *</label>
                                    <input type="text" class="form-control" id="NOMBRE_VIALIDAD" name="NOMBRE_VIALIDAD" required>
                                </div>


                                <div class="col-3 mb-3">
                                    <label>Número Exterior </label>
                                    <input type="number" class="form-control" id="NUMERO_EXTERIOR" name="NUMERO_EXTERIOR" >
                                </div>


                                <div class="col-3 mb-3">
                                    <label>Número Interior </label>
                                    <input type="number" class="form-control" id="NUMERO_INTERIOR" name="NUMERO_INTERIOR" >
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la colonia *</label>
                                    <input type="text" class="form-control" id="NOMBRE_COLONIA" name="NOMBRE_COLONIA" required>
                                </div>


                                <div class="col-3 mb-3">
                                    <label>Nombre de la Localidad *</label>
                                    <input type="text" class="form-control" id="NOMBRE_LOCALIDAD" name="NOMBRE_LOCALIDAD" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre del Municipio o Demarcación Territorial *</label>
                                    <input type="text" class="form-control" id="NOMBRE_MUNICIPIO" name="NOMBRE_MUNICIPIO" required>
                                </div>
                               
                                <div class="col-3 mb-3">
                                    <label>Nombre de la Entidad Federativa *</label>
                                    <input type="text" class="form-control" id="NOMBRE_ENTIDAD" name="NOMBRE_ENTIDAD" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Entre Calle</label>
                                    <input type="text" class="form-control" id="ENTRE_CALLE" name="ENTRE_CALLE" >
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Y Calle</label>
                                    <input type="text" class="form-control" id="ENTRE_CALLE_2" name="ENTRE_CALLE_2" >
                                </div>


                               



                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Información de emergencia</b></h5>
                                </div>  

                                <div class="col-4 mb-3">
                                    <label >Número de Seguridad Social (NSS) *</label>
                                    <input type="number" class="form-control" id="NSS_COLABORADOR" name="NSS_COLABORADOR" required>
                                </div>
                                
                                <div class="col-4 mb-3">
                                    <label >Tipo de Sangre *</label>
                                    <select class="form-control" id="TIPO_SANGRE" name="TIPO_SANGRE" required>
                                        <option value="" disabled selected></option>
                                        <option value="1">A+</option>
                                        <option value="2">A-</option>
                                        <option value="3">B+</option>
                                        <option value="4">B-</option>
                                        <option value="5">AB+</option>
                                        <option value="6">AB-</option>
                                        <option value="7">O+</option>
                                        <option value="8">O-</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label>Alergias </label>
                                    <input type="text" class="form-control" id="ALERGIAS_COLABORADOR" name="ALERGIAS_COLABORADOR">
                                </div>

                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Contacto de emergencia</b></h5>
                                </div>  
                                
                                <div class="col-3 mb-3">
                                    <label>Nombre completo *</label>
                                    <input type="text" class="form-control" id="NOMBRE_EMERGENCIA" name="NOMBRE_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Parentesco *</label>
                                    <input type="text" class="form-control" id="PARENTESCO_EMERGENCIA" name="PARENTESCO_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Teléfono 1 *</label>
                                    <input type="number" class="form-control" id="TELEFONO1_EMERGENCIA" name="TELEFONO1_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Teléfono  2 </label>
                                    <input type="number" class="form-control" id="TELEFONO2_EMERGENCIA" name="TELEFONO2_EMERGENCIA" >
                                </div>

                            
                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Beneficiario</b></h5>
                                </div>  

                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group" style="text-align: center;">
                                            <button type="button" class="btn btn-danger botonagregarbeneficiario" id="botonagregarbeneficiario">
                                                Agregar beneficiario <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="listadeBeneficiario mt-4"></div>


                        
                            <div class="col-11 mt-4">
                                <div class="form-group" style="text-align: right;">
                                <button type="submit" class="btn btn-success " id="guardarDatosGenerales">Guardar</button>
                                </div>
                            </div>              
                       
                         </div>
                    </form>
                </div>
                    
                




                <!-- Step 2 de Documentos de soporte -->

                <div id="step2-content" style="display: none;">
                    <ol class="breadcrumb mt-5">
                        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Documentos de soporte</h3>
                        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_DOCUMENTOS_SOPORTE" style="margin-left: auto;">
                            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                        </button>
                    </ol>
                    <div class="card-body position-relative">
                        <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tabladocumentosoporte" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>
                </div>


                <!-- Step 3 Contratos y anexos -->


                <div id="step3-content" style="display: none;">
                    <ol class="breadcrumb mt-5">
                        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Contratos y anexos</h3>
                        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_CONTRATO" style="margin-left: auto;">
                            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                        </button>
                    </ol>
                    <div class="card-body position-relative">
                        <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablacontratosyanexos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>
                </div>


                <!-- Step 4 CV´S -->

                <div id="step4-content" style="display: none;">
                    <ol class="breadcrumb mt-5">
                        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-person-fill"></i> &nbsp;CV</h3>
                        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                        </button>
                    </ol>
                    <div class="card-body position-relative">
                        <i id="loadingIcon9" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablacvs" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>
                </div>






                


























                </div> {{--  FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}


                <div class="tab-pane fade" id="contratosdoc" role="tabpanel" aria-labelledby="contratosdoc-tab">

                    <div class="col-12 mt-4">
                        <ol class="breadcrumb m-b-10" style="background-color: #ffffff !important; color: #0c3f64; border: #0c3f64 2px solid; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="fa fa-users" aria-hidden="true"></i> 
                                    Cargo: <span id="contrato_cargo" style="color: #009efb;"></span>
                                </p>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i> 
                                    Fecha vigencia: <span id="contrato_fecha_final" style="color: #009efb;"></span>
                                </p>
                            </div>
                        </ol>
                    </div>
                    



                    {{-- <div id="anexos_contrato" >
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Anexos</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablanexos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div> --}}



                    <div id="informacion_medica_contratos" >
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-hospital-fill"></i> &nbsp;Información Médica</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon3" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablainformacionmedica" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>

                    <div id="incidencias_contratos" >
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-check-fill"></i> &nbsp;Incidencias</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon4" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablaincidencias" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <div id="acciones_disciplinarias_contratos" >
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-circle"></i> &nbsp;Acciones disciplinarias</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon5" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablaccionesdisciplinarias" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>



                    <div id="recibos_nomina" >
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pen-fill"></i> &nbsp;Recibos de nómina</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_RECIBOS_NOMINA" style="margin-left: auto;">
                                Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon6" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablarecibonomina" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>
            
                </div> {{--  FINALIZA EL TAB DE CONTRATO --}}


            </div>
        </div>
    </div>
</div>

































<!-- ============================================================== -->
<!-- MODAL DOCUMENTO DE SOPORTE-->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_DOCUMENTOS_SOPORTE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post"  enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">              
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Documento de soporte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="mb-3">
                        <label>Tipo de documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTO" name="TIPO_DOCUMENTO" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Copia del INE</option>
                            <option value="2">Copia del Pasaporte</option>
                            <option value="3">Copia de la licencia de conducción tipo chofer</option>
                            <option value="4">Copia del número de seguridad social (NSS)</option>
                            <option value="5">Copia del acta de nacimiento</option>
                            <option value="6">Copia de la CURP</option>
                            <option value="7">Copia del Registro Federal de Contribuyentes (RFC)</option>
                            <option value="8">Copia de la cartilla de servicio militar (hombres)</option>
                            <option value="9">Copia del comprobante de domicilio </option>
                            <option value="10">Dos (2) cartas de recomendación</option>
                            <option value="11">Contrato o caratula del estado de cuenta </option>
                            <option value="12">Constancia de situación fiscal</option>
                            <option value="13">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO" name="NOMBRE_DOCUMENTO" readonly required>
                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                        <input type="file" class="form-control" id="DOCUMENTO_SOPORTE" name="DOCUMENTO_SOPORTE" accept=".pdf" style="width: auto; flex: 1;" >
                        <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUMENTO_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOSOPORTE">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- ============================================================== -->
<!-- MODAL CONTRATOS Y ANEXOS-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_CONTRATO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post"  enctype="multipart/form-data" id="formularioCONTRATO" style="background-color: #ffffff;">              
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Contratos y anexos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="mb-3">
                        <label>Tipo de documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTO_CONTRATO" name="TIPO_DOCUMENTO_CONTRATO" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Requisición de personal</option>
                            <option value="2">Antecedentes, Imparcialidad y Beneficiarios</option>
                            <option value="3" >Contrato</option>
                            <option value="4">Acuerdo de confidencialidad</option>
                            <option value="5">Compromiso de independencia, integridad e imparcialidad</option>
                            <option value="6">Aviso de privacidad</option>
                            <option value="7">Encuesta socioeconómica y protección de datos</option>
                            <option value="8">Recepción de la descripción del puesto de trabajo</option>
                            <option value="9">Autorización de emisión de recibos de nómina</option>
                            <option value="10">Autorización de firma y rúbrica</option>
                            <option value="11">Acuse de recibo del Catálogo de Políticas</option>
                            <option value="12">Solicitud de derechos ARCO</option>
                            <option value="13">Carta de vínculo con Personal Políticamente Expuesto</option>
                            <option value="14">Carta presentación declaración anual</option>
                            <option value="15">Carta de no crédito INFONAVIT/Retención de descuentos</option>
                            <option value="16">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_CONTRATO" name="NOMBRE_DOCUMENTO_CONTRATO" readonly required>
                    </div>

                    <div class="row  mb-3"  id="CONTRATO" style="display: none">
                        <div class="col-12 mb-3">
                            <label>Cargo</label>
                            <select class="form-control" id="NOMBRE_CARGO" name="NOMBRE_CARGO" >
                                <option value="0" selected disabled>Seleccione una opción</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label>Vigencia *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_CONTRATO" name="VIGENCIA_CONTRATO" >
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                    </div>

                    <div class="row  mb-3"  id="VIGENCIA" style="display: none">
                        <label>Vigencia *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_ACUERDO" name="VIGENCIA_ACUERDO">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                        </div>
                    </div>



                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                        <input type="file" class="form-control" id="DOCUMENTO_CONTRATO" name="DOCUMENTO_CONTRATO" accept=".pdf" style="width: auto; flex: 1;" >
                        <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_contrato" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUEMNTO_ERROR_CONTRATO" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONTRATO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL RECIBO -->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_RECIBOS_NOMINA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post"  enctype="multipart/form-data" id="formularioRECIBO" style="background-color: #ffffff;">              
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recibos de nómina</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_RECIBO" name="NOMBRE_RECIBO"  required>
                    </div>



                    <div class="mb-3">
                        <label>Fecha recibo *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RECIBO" name="FECHA_RECIBO" required>
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                   

                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                        <input type="file" class="form-control" id="DOCUMENTO_RECIBO" name="DOCUMENTO_RECIBO" accept=".pdf" style="width: auto; flex: 1;" >
                        <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_recibo" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="RECIBO_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarRECIBONOMINA">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>








@endsection