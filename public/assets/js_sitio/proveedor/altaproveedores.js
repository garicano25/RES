



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
    const botonAgregarContacto = document.getElementById('botonrefernecias');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarReferencias();
    });

    function agregarReferencias() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generareferencias', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12 mb-3">
                <label class="form-label">Nombre de la empresa *</label>
                <input type="text" class="form-control" name="NOMBRE_EMPRESA" required>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Nombre/Cargo *</label>
                <input type="text" class="form-control" name="NOMBRE_CARGO" required>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Producto y/o servicio suministrado *</label>
                <input type="text" class="form-control" name="PRODUCTO_SERVICIO" required>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Desde *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="DESDE" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Hasta *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="HASTA" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar certificación<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.referenciasdiv');
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