ID_FORMULARIO_DIRECTORIO = 0









$("#guardarDIRECTORIO").click(async function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDIRECTORIO'));

    if (formularioValido) {

        var servicios = [];
        $(".generarservicio").each(function() {
            var servicio = {
                'NOMBRE_SERVICIO': $(this).find("input[name='NOMBRE_SERVICIO']").val()
            };
            servicios.push(servicio);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_DIRECTORIO: ID_FORMULARIO_DIRECTORIO,
            SERVICIOS_JSON: JSON.stringify(servicios)
        };

        if (ID_FORMULARIO_DIRECTORIO == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información guardada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'block';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);

        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información editada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'none';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});






document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botonAgregarservicio');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarContacto();
    });

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarservicio', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="NOMBRE_SERVICIO" required>
                    </div>
                </div>
            </div>
    
          
    
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar servicio<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.serviciodiv');
        contenedor.appendChild(divContacto);
    
        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    
    }
    
});





























