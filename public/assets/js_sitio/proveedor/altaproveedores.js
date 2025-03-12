



 function cualactividad() {
        var otrosCheckbox = document.getElementById('OTROS_ACTIVIDAD');
        var actividadDiv = document.getElementById('CUAL_ACTIVIAD');
        actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}
    



 function cualdescuentos() {
        var otrosCheckbox = document.getElementById('OTROS_DESCUENTO');
        var actividadDiv = document.getElementById('CUAL_DESCUENTOS');
        actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}
    


// $("#guardarDIRECTORIO").click(async function (e) {
//     e.preventDefault();

//     formularioValido = validarFormulario($('#formularioDIRECTORIO'));

//     if (formularioValido) {

//         var servicios = [];
//         $(".generarservicio").each(function() {
//             var servicio = {
//                 'NOMBRE_SERVICIO': $(this).find("input[name='NOMBRE_SERVICIO']").val()
//             };
//             servicios.push(servicio);
//         });

//         const requestData = {
//             api: 1,
//             ID_FORMULARIO_DIRECTORIO: ID_FORMULARIO_DIRECTORIO,
//             SERVICIOS_JSON: JSON.stringify(servicios)
//         };

//         if (ID_FORMULARIO_DIRECTORIO == 0) {
//             alertMensajeConfirm({
//                 title: "¿Desea guardar la información?",
//                 text: "Al guardarla, se podrá usar",
//                 icon: "question",
//             }, async function () {
//                 await loaderbtn('guardarDIRECTORIO');
//                 await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

//                     Swal.fire({
//                         icon: 'info',
//                         title: 'Espere un momento',
//                         text: 'Estamos guardando la información',
//                         showConfirmButton: false
//                     });

//                     $('.swal2-popup').addClass('ld ld-breath');

//                 }, function (data) {
//                     ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Información guardada correctamente',
//                         confirmButtonText: 'OK',
//                     }).then(() => {
//                         document.getElementById('formulario_servicio').style.display = 'none';
//                         document.getElementById('nav_var').style.display = 'block';

//                         const sectionFinalizado = document.getElementById('sectionFinalizado');
//                         sectionFinalizado.classList.remove('d-none');
//                         sectionFinalizado.classList.add('d-flex');

//                         document.getElementById('formularioDIRECTORIO').reset();
//                         ID_FORMULARIO_DIRECTORIO = 0;
//                     });
//                 });
//             }, 1);

//         } else {
//             alertMensajeConfirm({
//                 title: "¿Desea editar la información de este formulario?",
//                 text: "Al guardarla, se podrá usar",
//                 icon: "question",
//             }, async function () {
//                 await loaderbtn('guardarDIRECTORIO');
//                 await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

//                     Swal.fire({
//                         icon: 'info',
//                         title: 'Espere un momento',
//                         text: 'Estamos guardando la información',
//                         showConfirmButton: false
//                     });

//                     $('.swal2-popup').addClass('ld ld-breath');

//                 }, function (data) {
//                     ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Información editada correctamente',
//                         confirmButtonText: 'OK',
//                     }).then(() => {
//                         document.getElementById('formulario_servicio').style.display = 'none';
//                         document.getElementById('nav_var').style.display = 'none';

//                         const sectionFinalizado = document.getElementById('sectionFinalizado');
//                         sectionFinalizado.classList.remove('d-none');
//                         sectionFinalizado.classList.add('d-flex');

//                         document.getElementById('formularioDIRECTORIO').reset();
//                         ID_FORMULARIO_DIRECTORIO = 0;
//                     });
//                 });
//             }, 1);
//         }
//     } else {
//         alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
//     }
// });



document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botoncertificacion');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarAcreditacion();
    });

    function agregarAcreditacion() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generaracreditacion', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-6 mb-3">
                <label class="form-label">Norma/Versión *</label>
                <input type="text" class="form-control" name="NORMA_VERSION" required>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Alcance de la certificación *</label>
                <input type="text" class="form-control" name="ALCANCE_CERTIFICACION" required>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Entidad certificadora *</label>
                <input type="text" class="form-control" name="ENTIDAD_CERTIFICADORA" required>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Desde *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="EMISION_DOCUMENTO" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Hasta *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="VENCIMIENTO_DOCUMENTO" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Subir archivo (PDF) *</label>
                <input type="file" class="form-control" name="DOCUMENTO_CERTIFICACION" accept=".pdf" required>
            </div>
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar certificación<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.certificaciondiv');
        contenedor.appendChild(divContacto);
    
        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    }
    
    $(document).on('focus', '.mydatepicker', function () {
        if (!$(this).data('datepicker')) {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es',
            });
        }
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botoncuentas');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarReferencias();
    });

    function agregarReferencias() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generareferencias', 'mb-3');
        divContacto.innerHTML = `
           
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
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Ahorros</option>
                            <option value="2">Empresarial</option>
                            <option value="3">Cheques</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>CLABE interbancaria *</label>
                        <input type="number" class="form-control" name="CLABE_INTERBANCARIA" id="CLABE_INTERBANCARIA" required>
                    </div>



                    <div class="col-6 mb-3">
                        <label>Ciudad *</label>
                        <input type="text" class="form-control" name="CIUDAD_CUENTA" id="CIUDAD_CUENTA" required>
                    </div>

                    <div class="col-6 mb-3">
                        <label>País *</label>
                        <input type="text" class="form-control" name="PAIS_CUENTA" id="PAIS_CUENTA" required>
                    </div>
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar cuenta<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.cuentasdiv');
        contenedor.appendChild(divContacto);
    
        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    }
    
    $(document).on('focus', '.mydatepicker', function () {
        if (!$(this).data('datepicker')) {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es',
            });
        }
    });
}); 







document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA_ALTA");
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";
        } else if (this.value === "2") {
            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";
        }
    });
});



document.addEventListener("DOMContentLoaded", function() {
    fetch('/obtener-datos-proveedor')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error);
            return;
        }

        document.getElementById("TIPO_PERSONA_ALTA").value = data.TIPO_PERSONA_ALTA;
        document.getElementById("RAZON_SOCIAL_ALTA").value = data.RAZON_SOCIAL_ALTA;
        document.getElementById("RFC_ALTA").value = data.RFC_ALTA;

        if (data.TIPO_PERSONA_ALTA == "1") {
            // Mostrar div de domicilio nacional
            document.getElementById("DOMICILIO_NACIONAL").style.display = "block";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "none";

            document.getElementById("CODIGO_POSTAL").value = data.CODIGO_POSTAL;
            document.getElementById("TIPO_VIALIDAD_EMPRESA").value = data.TIPO_VIALIDAD_EMPRESA;
            document.getElementById("NOMBRE_VIALIDAD_EMPRESA").value = data.NOMBRE_VIALIDAD_EMPRESA;
            document.getElementById("NUMERO_EXTERIOR_EMPRESA").value = data.NUMERO_EXTERIOR_EMPRESA;
            document.getElementById("NUMERO_INTERIOR_EMPRESA").value = data.NUMERO_INTERIOR_EMPRESA;
            document.getElementById("NOMBRE_COLONIA_EMPRESA").value = data.NOMBRE_COLONIA_EMPRESA;
            document.getElementById("NOMBRE_LOCALIDAD_EMPRESA").value = data.NOMBRE_LOCALIDAD_EMPRESA;
            document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = data.NOMBRE_MUNICIPIO_EMPRESA;
            document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = data.NOMBRE_ENTIDAD_EMPRESA;
            document.getElementById("PAIS_EMPRESA").value = data.PAIS_EMPRESA;
            document.getElementById("ENTRE_CALLE_EMPRESA").value = data.ENTRE_CALLE_EMPRESA;
            document.getElementById("ENTRE_CALLE2_EMPRESA").value = data.ENTRE_CALLE2_EMPRESA;
        } else if (data.TIPO_PERSONA_ALTA == "2") {
            // Mostrar div de domicilio extranjero
            document.getElementById("DOMICILIO_NACIONAL").style.display = "none";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "block";

            document.getElementById("DOMICILIO_EXTRANJERO").value = data.DOMICILIO_EXTRANJERO;
            document.getElementById("CODIGO_EXTRANJERO").value = data.CODIGO_EXTRANJERO;
            document.getElementById("CIUDAD_EXTRANJERO").value = data.CIUDAD_EXTRANJERO;
            document.getElementById("ESTADO_EXTRANJERO").value = data.ESTADO_EXTRANJERO;
            document.getElementById("PAIS_EXTRANJERO").value = data.PAIS_EXTRANJERO;
            document.getElementById("DEPARTAMENTO_EXTRANJERO").value = data.DEPARTAMENTO_EXTRANJERO;
        }
    })
    .catch(error => console.error('Error al obtener los datos:', error));
});