@extends('principal.maestraproveedores')

@section('contenido')


<style>
    body {
        font-family: 'Maven Pro', Arial, sans-serif;
        /* Aplicar la fuente Maven Pro */
        /* background-color: #007DBA; */
    }

    .card {
        max-width: 800px;
        margin: 20px auto;
        border: 2px solid #007DBA;
    }

    .card-img-top {
        display: block;
        margin: 0 auto;
        width: 50%;
        height: auto;
    }


    #contador {
        font-size: 12px;
        color: gray;
    }

    /* #mensaje {
        margin-top: 5px;
        color: red;  
    } */


    #mensaje {
        font-size: 0.9em;
        color: green;
    }

    #error {
        font-size: 0.9em;
        color: red;
    }

    .modal-header img {
        position: absolute;
        right: 10px;
        top: 10px;
        max-height: 50px;
    }

    .modal-footer {
        justify-content: center;
    }

    .modal-content {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(16, 16, 16, 0.958);
    }

    .modal-body {
        font-size: 1rem;
    }

    .modal-backdrop.show {
        opacity: 1;
    }

    .modal-backdrop {
        background-color: rgba(16, 16, 16, 0.963);
    }

    .btn-light.btn-sm {
        background-color: white;
        color: black;
        border: 1px solid #ced4da;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .btn-light.btn-sm:hover {
        background-color: #e2e6ea;
    }

    .text-danger {
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .add-button {
        padding: 5px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .add-button i {
        margin-right: 5px;
    }

    .small-checkbox {
        width: 20px;
        height: 20px;
    }
</style>




<div class="card" id="formulario_servicio" style="display: block">
    <img src="/assets/images/rip_logocolores.png" class="card-img-top" alt="Imagen superior">

    {{-- <img src="/assets/images/Colorancho.png" class="card-img-top" alt="Imagen superior"> --}}
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="formularioDIRECTORIO">
            {!! csrf_field() !!}



            <input type="hidden" class="form-control" id="ID_FORMULARIO_DIRECTORIO" name="ID_FORMULARIO_DIRECTORIO" value="0">


            <div class="col-12">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label>Tipo de Persona *</label>
                        <select class="form-control" name="TIPO_PERSONA_ALTA" id="TIPO_PERSONA_ALTA" required>
                            <option value="" selected disabled></option>
                            <option value="1">Nacional</option>
                            <option value="2">Extranjero</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Razón Social *</label>
                        <input type="text" class="form-control" name="RAZON_SOCIAL_ALTA" id="RAZON_SOCIAL_ALTA" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Representante Legal *</label>
                        <input type="text" class="form-control" name="REPRESENTANTE_LEGAL_ALTA" id="REPRESENTANTE_LEGAL_ALTA" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>R.F.C *</label>
                        <input type="text" class="form-control" name="RFC_ALTA" id="RFC_ALTA" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Régimen *</label>
                        <input type="text" class="form-control" name="REGIMEN_ALTA" id="REGIMEN_ALTA" required>
                    </div>


                    <div class="mb-3 text-center">
                        <h4><b>Datos generales</b></label>
                    </div>


                    <div class="col-3 mb-3">
                        <label>Código Postal *</label>
                        <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Tipo de Vialidad *</label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA" required>
                    </div>
                    <div class="col-5 mb-3">
                        <label>Nombre de la Vialidad *</label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA" required>
                    </div>

                    <div class="col-3 mb-3">
                        <label>Número Exterior</label>
                        <input type="number" class="form-control" name="NUMERO_EXTERIOR_EMPRESA" id="NUMERO_EXTERIOR_EMPRESA">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_EMPRESA" id="NUMERO_INTERIOR_EMPRESA">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la colonia *</label>
                        <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA" required>
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Localidad *</label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del municipio o demarcación territorial *</label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Entidad Federativa *</label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>País *</label>
                        <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA" required>
                    </div>

                    <div class="col-6 mb-3">
                        <label>Entre Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_EMPRESA" id="ENTRE_CALLE_EMPRESA">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Y Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE2_EMPRESA" id="ENTRE_CALLE2_EMPRESA">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del titular *</label>
                        <input type="text" class="form-control" name="NOMBRE_TITULAR_ALTA" id="NOMBRE_TITULAR_ALTA">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Correo electrónico *</label>
                        <input type="text" class="form-control" name="CORRE_TITULAR_ALTA" id="CORRE_TITULAR_ALTA">
                    </div>





                    <div class="mb-3 text-center">
                        <h4><b>Actividad económica</b></label>
                    </div>



                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="ACTIVIDAD_ECONOMICA" id="VENTA_PRODUCTOS" required>
                            <label class="form-check-label">Ventas de productos</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="ACTIVIDAD_ECONOMICA" id="VENTA_SERVICIOS">
                            <label class="form-check-label">Venta de servicios</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="ACTIVIDAD_ECONOMICA" id="OTROS_ACTIVIDAD" onclick="cualactividad()">
                            <label class="form-check-label">Otros</label>
                        </div>
                    </div>

                    <div id="CUAL_ACTIVIAD" class="col-12 mb-3" style="display: none;">
                        <label>Cuál</label>
                        <input type="text" class="form-control" name="CUAL_ACTVIDAD_ECONOMICA" id="CUAL_ACTVIDAD_ECONOMICA">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Actividad comercial</label>
                        <input type="text" class="form-control" name="ACTVIDAD_COMERCIAL" id="ACTVIDAD_COMERCIAL" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="me-3">Descuentos que ofrece</label>
                    </div>

                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PAGO" required>
                            <label class="form-check-label">Por pronto pago</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_VOLUMEN">
                            <label class="form-check-label">Por volumen</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PROMOCION">
                            <label class="form-check-label">Promociones</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="OTROS_DESCUENTO" onclick="cualdescuentos()">
                            <label class="form-check-label">Otros</label>
                        </div>
                    </div>

                    <div id="CUAL_DESCUENTOS" class="col-12 mb-3" style="display: none;">
                        <label>Cuál</label>
                        <input type="text" class="form-control" name="CUAL_DESCUENTOS_ECONOMICA" id="CUAL_DESCUENTOS_ECONOMICA">
                    </div>



                    <div class="mb-3 text-center">
                        <h4><b>Información para pago/depósito/transferencia interbancaria</b></label>
                    </div>




                    <div class="col-4 mb-3">
                        <label>Nombre del Banco *</label>
                        <input type="text" class="form-control" name="NOMBRE_BANCO" id="NOMBRE_BANCO" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>No. De Cuenta *</label>
                        <input type="number" class="form-control" name="NUMERO_CUENTA" id="NUMERO_CUENTA" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Tipo *</label>
                        <select class="form-control" name="TIPO_CUENTA" id="TIPO_CUENTA" required>
                            <option value="" selected disabled></option>
                            <option value="1">Ahorros</option>
                            <option value="2">Empresarial</option>
                            <option value="3">Cheques</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>CLABE interbancaria *</label>
                        <input type="number" class="form-control" name="CLABE_INTERBANCARIA" id="CLABE_INTERBANCARIA" required>
                    </div>



                    <div class="col-4 mb-3">
                        <label>Ciudad *</label>
                        <input type="text" class="form-control" name="CIUDAD_CUENTA" id="CIUDAD_CUENTA" required>
                    </div>

                    <div class="col-4 mb-3">
                        <label>País *</label>
                        <input type="text" class="form-control" name="PAIS_CUENTA" id="PAIS_CUENTA" required>
                    </div>


                    <div class="col-4 mb-3">
                        <label>Correo electrónico *</label>
                        <input type="text" class="form-control" name="CORREO_CUENTA" id="CORREO_CUENTA" required>
                    </div>


                    <div class="mb-3 text-center">
                        <h4><b>Certificaciones y acreditaciones</b></label>
                    </div>

                    <div class="col-12 mb-3 d-flex align-items-center">
                        <label class="me-3">¿Dispone de un sistema de aseguramiento de la calidad certificado o alguna acreditación?</label>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="ASEGURAMIENTO_CALIDAD" id="NO" value="NO">
                            <label class="form-check-label" for="NO">NO</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="ASEGURAMIENTO_CALIDAD" id="SI" value="SI">
                            <label class="form-check-label" for="SI">SI</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agrega certificación</label>
                                    <button id="botoncertificacion" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="certificaciondiv mt-4"></div>
                        </div>
                    </div>



                    <div class="mb-3 text-center">
                        <h4><b>Referencia comerciales</b></label>
                    </div>


                    <div class="col-12 mb-3 text-center">
                        <label class="me-3">Relacione a continuación referencias comerciales de empresas con quienes haya trabajado recientemente</label>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agrega referencias</label>
                                    <button id="botonrefernecias" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="referenciasdiv mt-4"></div>
                        </div>
                    </div>


                    <div class="mb-3 text-center">
                        <h4><b>Información adicional</b></label>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">¿Usted o la compañía tiene vínculos familiares hasta en tercer grado de consanguinidad con personal que labora en las compañías Results In Performance? O cualquier tipo de vínculo puede ser personal o laboral que pueda generar un conflicto de interés?</label>
                        <div class="form-check d-inline-block me-3">
                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_SI" value="SI">
                            <label class="form-check-label" for="VINCULO_SI">Si</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_NO" value="NO">
                            <label class="form-check-label" for="VINCULO_NO">No</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Si su respuesta anterior es afirmativa, describa cuál:</label>
                        <input type="text" class="form-control" name="DESCRIPCION_VINCULO">
                    </div>
                    <div class="col-12 mb-3 d-flex align-items-center">
                        <label class="me-3">¿La empresa que representa ofrece servicios directos como proveedor/contratista/subcontratista a PEMEX?</label>
                    </div>
                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="SI" value="SI">
                            <label class="form-check-label" for="SI">Si</label>
                        </div>
                        <input type="text" class="form-control me-3" name="NUMERO_PROVEEDOR" placeholder="No. de proveedor">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="NO" value="NO">
                            <label class="form-check-label" for="NO">No</label>
                        </div>
                    </div>






                </div>
            </div>




            <div class="col-12 text-center">
                <div class="col-md-6 mx-auto">
                    <button type="submit" id="guardarDIRECTORIO" class="btn btn-success w-100">
                        Guardar
                    </button>
                </div>
            </div>


        </form>
    </div>
</div>



<section id="sectionFinalizado" class="container  mt-5 d-none justify-content-center " style="height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card text-center" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 10px;">
                <div class="card-header" style="background-color: #88bd23; color: #fff; font-weight: bold; border-radius: 12px 12px 0 0;">
                    <h6 class="card-title m-0" style="font-size: 1.5rem; font-weight: bold; color: #ffffff;">
                        <i class="fa fa-check-circle" style="color: #ffffff;"></i>
                        Información guardada correctamente
                    </h6>
                </div>
                <div class="card-body">
                    <p class="lead mt-3 mb-3">
                        <i class="fa fa-check-circle" style="color: #88bd23;"></i>
                        Su información ha sido guardada exitosamente.
                    </p>
                    <a href="https://results-in-performance.com/" class="btn" style="background-color: #28a745; color: #fff; padding: 10px 20px; font-size: 1.2rem; font-weight: bold; border-radius: 5px; text-decoration: none;">
                        Regresar
                    </a>
                </div>
                <div class="card-footer text-muted" style="background-color: #009bcf; color: #fff; font-weight: bold; border-radius: 0 0 12px 12px;">
                    <h6 class="card-title m-0" style="font-size: 1rem; font-weight: bold; color: #ffffff;">
                        Results In Performance
                    </h6>
                </div>
            </div>
        </div>
    </div>
</section>











<script src="/assets/js_sitio/proveedor/altaproveedores.js"></script>





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