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

.multisteps-form__progress::before {
    content: '';
    position: absolute;
    top: 24%; 
    left: calc(7%); 
    width: calc(87%); 
    height: 7px; 
    background-color: #e0e0e0;
    z-index: 0;
    transform: translateY(-50%); 
}




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
    background-color: #e0e0e0;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 5px;
    position: relative;
    z-index: 1;
}

.step-circle i {
    font-size: 24px;
    color: #999999;
}

.multisteps-form__progress-btn.active .step-circle {
    background-color: rgb(164, 214, 94); 
}

.multisteps-form__progress-btn.active i {
    color: white;
}

.multisteps-form__progress-btn.active span {
    color: rgb(164, 214, 94);
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
                        Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                    </button>
                </ol>

                
                <table id="Tablacontratacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                    
                </table>
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
                                <div class="multisteps-form__progress-btn" id="step1">
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
                                    <span>Contrato y anexos</span>
                                </div>
                                <div class="multisteps-form__progress-btn" id="step4">
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
                                </div>
                                <div class="multisteps-form__progress-btn" id="step7">
                                    <div class="step-circle">
                                        <i class="bi bi-file-person-fill"></i>
                                    </div>
                                    <span>CV</span>
                                </div>
                                <div class="multisteps-form__progress-btn" id="step8">
                                    <div class="step-circle">
                                        <i class="bi bi-pen-fill"></i>
                                    </div>
                                    <span>Recibos de nómina</span>
                                </div>
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
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label>Nombre(s) del colaborador *</label>
                                                            <input type="text" class="form-control" id="NOMBRE_COLABORADOR" name="NOMBRE_COLABORADOR" required>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label>Primer apellido *</label>
                                                            <input type="text" class="form-control" id="PRIMER_APELLIDO" name="PRIMER_APELLIDO" required>
                                                        </div>
                                                        
                                                        <div class="col-md-5 mb-3">
                                                            <label>Segundo apellido *</label>
                                                            <input type="text" class="form-control" id="SEGUNDO_APELLIDO" name="SEGUNDO_APELLIDO" required>
                                                        </div>

                                                        <div class="col-md-5 mb-3">
                                                            <label>CURP *</label>
                                                            <input type="text" class="form-control" id="CURP" name="CURP" required>
                                                        </div>
                                                        
                                                        <div class="col-md-2 mb-3">
                                                            <label>Iniciales</label>
                                                            <input type="text" class="form-control" id="INICIALES_COLABORADOR" name="INICIALES_COLABORADOR">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Día</label>
                                                            <select class="form-select me-2" id="DIA_COLABORADOR" name="DIA_COLABORADOR" required>
                                                                <option value="" selected disabled></option>
                                                                <script>
                                                                    for (let i = 1; i <= 31; i++) {
                                                                        document.write('<option value="' + i + '">' + i + '</option>');
                                                                    }
                                                                </script>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Mes</label>
                                                            <select class="form-select me-2" id="MES_COLABORADOR" name="MES_COLABORADOR" required>
                                                                <option value="" selected disabled></option>
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
                                                        <div class="col-md-6 mb-3">
                                                            <label>Año</label>
                                                            <select class="form-select me-2" id="ANIO_COLABORADOR" name="ANIO_COLABORADOR" required>
                                                                <option value="" selected disabled></option>
                                                                <script>
                                                                    const currentYear = new Date().getFullYear();
                                                                    for (let i = currentYear; i >= 1900; i--) {
                                                                        document.write('<option value="' + i + '">' + i + '</option>');
                                                                    }
                                                                </script>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Edad</label>
                                                            <input type="number" class="form-control" id="EDAD_COLABORADOR" name="EDAD_COLABORADOR" readonly>
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
                                
                                        <div class="col-md-6 mb-3">
                                            <label >Lugar de nacimiento *</label>
                                            <input type="text" class="form-control" id="LUGAR_NACIMIENTO" name="LUGAR_NACIMIENTO" required>
                                        </div>              
                                        <div class="col-md-6 mb-3">
                                            <label>Teléfono *</label>
                                            <input type="number" class="form-control" id="TELEFONO_COLABORADOR" name="TELEFONO_COLABORADOR" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="correo">Correo *</label>
                                            <input type="email" class="form-control" id="CORREO_COLABORADOR" name="CORREO_COLABORADOR" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="estadoCivil">Estado Civil *</label>
                                            <select class="form-control" id="ESTADO_CIVIL" name="ESTADO_CIVIL" required>
                                                <option value=""></option>
                                                <option value="1">Soltero (a)</option>
                                                <option value="2">Casado (a)</option>
                                                <option value="3">Divorciado (a)</option>
                                                <option value="4">Viudo (a)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label >RFC *</label>
                                            <input type="text" class="form-control" id="RFC_COLABORADOR" name="RFC_COLABORADOR" required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label >Vigencia del INE *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_INE" name="VIGENCIA_INE" required>
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label >Número de Seguridad Social (NSS) *</label>
                                            <input type="number" class="form-control" id="NSS_COLABORADOR" name="NSS_COLABORADOR" required>
                                        </div>

                                        

                                        <div class="col-md-4 mb-3">
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
                                        <div class="col-md-4 mb-3">
                                            <label>Alergias </label>
                                            <input type="text" class="form-control" id="ALERGIAS_COLABORADOR" name="ALERGIAS_COLABORADOR">
                                        </div>
                                        <div class="col-md-12 mb-3 text-center">
                                            <h5><b>Domicilio</b></h5>
                                        </div>  
                                        <div class="col-md-12 mb-3">
                                            <label>Calle, numero, interior / exterior *</label>
                                            <input type="text" class="form-control" id="CALLE_COLABORADOR" name="CALLE_COLABORADOR" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Colonia *</label>
                                            <input type="text" class="form-control" id="COLONIA_COLABORADOR" name="COLONIA_COLABORADOR" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>C.P *</label>
                                            <input type="text" class="form-control" id="CODIGO_POSTAL" name="CODIGO_POSTAL" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Ciudad *</label>
                                            <input type="text" class="form-control" id="CIUDAD_COLABORADOR" name="CIUDAD_COLABORADOR" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Estado *</label>
                                            <select class="form-control" id="ESTADO_COLABORADOR" name="ESTADO_COLABORADOR" required>
                                                <option value="" disabled selected>Selecciona tu estado</option>
                                                <option value="1">Aguascalientes</option>
                                                <option value="2">Baja California</option>
                                                <option value="3">Baja California Sur</option>
                                                <option value="4">Campeche</option>
                                                <option value="5">Chiapas</option>
                                                <option value="6">Chihuahua</option>
                                                <option value="7">Ciudad de México</option>
                                                <option value="8">Coahuila</option>
                                                <option value="9">Colima</option>
                                                <option value="10">Durango</option>
                                                <option value="11">Estado de México</option>
                                                <option value="12">Guanajuato</option>
                                                <option value="13">Guerrero</option>
                                                <option value="14">Hidalgo</option>
                                                <option value="15">Jalisco</option>
                                                <option value="16">Michoacán</option>
                                                <option value="17">Morelos</option>
                                                <option value="18">Nayarit</option>
                                                <option value="19">Nuevo León</option>
                                                <option value="20">Oaxaca</option>
                                                <option value="21">Puebla</option>
                                                <option value="22">Querétaro</option>
                                                <option value="23">Quintana Roo</option>
                                                <option value="24">San Luis Potosí</option>
                                                <option value="25">Sinaloa</option>
                                                <option value="26">Sonora</option>
                                                <option value="27">Tabasco</option>
                                                <option value="28">Tamaulipas</option>
                                                <option value="29">Tlaxcala</option>
                                                <option value="30">Veracruz</option>
                                                <option value="31">Yucatán</option>
                                                <option value="32">Zacatecas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3 text-center">
                                            <h5><b>Información de emergencia</b></h5>
                                        </div>  
                                        <div class="col-md-3 mb-3">
                                            <label>Nombre completo *</label>
                                            <input type="text" class="form-control" id="NOMBRE_EMERGENCIA" name="NOMBRE_EMERGENCIA" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Parentesco *</label>
                                            <input type="text" class="form-control" id="PARENTESCO_EMERGENCIA" name="PARENTESCO_EMERGENCIA" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Teléfono 1 *</label>
                                            <input type="number" class="form-control" id="TELEFONO1_EMERGENCIA" name="TELEFONO1_EMERGENCIA" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Teléfono  2 </label>
                                            <input type="number" class="form-control" id="TELEFONO2_EMERGENCIA" name="TELEFONO2_EMERGENCIA" >
                                        </div>
                                        <div class="col-md-12 mb-3 text-center">
                                            <h5><b>Beneficiario</b></h5>
                                        </div>  
                                        <div class="col-md-3 mb-3">
                                            <label>Nombre completo *</label>
                                            <input type="text" class="form-control" id="NOMBRE_BENEFICIARIO" name="NOMBRE_BENEFICIARIO"required >
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Parentesco *</label>
                                            <input type="text" class="form-control" id="PARENTESCO_BENEFICIARIO" name="PARENTESCO_BENEFICIARIO" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Porcentaje *</label>
                                            <input type="number" class="form-control" id="PORCENTAJE_BENEFICIARIO" name="PORCENTAJE_BENEFICIARIO" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Teléfono  1 </label>

                                            <input type="number" class="form-control" id="TELEFONO1_BENEFICIARIO" name="TELEFONO1_BENEFICIARIO" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Teléfono  2 </label>
                                            <input type="number" class="form-control" id="TELEFONO2_BENEFICIARIO" name="TELEFONO2_BENEFICIARIO" >
                                        </div>             
                            
                            
                                        <div class="col-11 mt-4">
                                            <div class="form-group" style="text-align: right;">
                                            <button type="submit" class="btn btn-success " id="guardarDatosGenerales">Guardar</button>
                                            </div>
                                        </div>              
                                    </form>
                                </div>



                                <div id="informacionacademica"  class="mt-5">
                                    <ol class="breadcrumb mt-5">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Información  Académica</h3>
                                    <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                        Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                                    </button>
                                </ol>
                                    <div class="card-body position-relative">
                                        <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                        <table id="Tablainformacionacademica" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                                        </table>
                                    </div>
                                </div>


                                <div id="experienciacolaborador"  class="mt-5">
                                    <ol class="breadcrumb mt-5">
                                <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-asterisk"></i> &nbsp;Experiencia</h3>
                                <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#" style="margin-left: auto;">
                                    Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                                </button>
                            </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon3" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaexperienciacolaborador" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                                    </table>
                                </div>
                            </div>



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
                        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal" style="margin-left: auto;">
                            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                        </button>
                    </ol>
                    <div class="card-body position-relative">
                        <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tabladocumentosoporte" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>
                </div>








                <!-- Step 8 Recibos de nómina  -->

                <div id="step8-content" style="display: none;">
                    <ol class="breadcrumb mt-5">
                        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pen-fill"></i> &nbsp;Recibos de nómina</h3>
                        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_RECIBOS_NOMINA" style="margin-left: auto;">
                            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
                        </button>
                    </ol>
                    <div class="card-body position-relative">
                        <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tabladocumentosoporte" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>
                </div>


























                </div>
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
                            <option value="1">Currículum Vitae con fotografía</option>
                            <option value="2">Constancias de estudios, títulos académicos, cédula profesional</option>
                            <option value="3">Copia de los cursos y/o certificaciones</option>
                            <option value="4">Copia del INE o pasaporte</option>
                            <option value="5">Copia de la licencia de conducción tipo chofer</option>
                            <option value="6">Copia del número de seguridad social (NSS)</option>
                            <option value="7">Copia del acta de nacimiento*</option>
                            <option value="8">Copia de la CURP</option>
                            <option value="9">Copia del Registro Federal de Contribuyentes (RFC)</option>
                            <option value="10">Copia de la cartilla de servicio militar (hombres)</option>
                            <option value="11">Copia del comprobante de domicilio </option>
                            <option value="12">Dos (2) cartas de recomendación</option>
                            <option value="13">Contrato o caratula del estado de cuenta </option>
                            <option value="14">Otros</option>

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
<!-- MODAL RECIBO DE NOMINA-->
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