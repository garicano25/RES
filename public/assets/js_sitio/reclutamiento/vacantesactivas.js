


var Tablapostulaciones = $("#Tablapostulaciones").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
    info: false,
    paging: true,
    searching: true,
    filtering: true,
    scrollY: '65vh',
    scrollCollapse: true,
    responsive: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablapostulaciones',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablapostulaciones.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'LUGAR_VACANTE' },
        { data: 'LA_VACANTES_ES' },
        { data: 'DESCRIPCION_VACANTE' },
        { 
            data: 'created_at',
            render: function(data, type, row) {
                return data.split(' ')[0]; 
            }
        },
        { data: 'FECHA_EXPIRACION' },
        { data: 'TOTAL_POSTULANTES' }, 
        { data: null,
            render: function (data, type, row) {
                return row.BTN_VISUALIZAR;
            }
        }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center' },
        { targets: 3, title: 'Tipo de vacante', className: 'all text-center' },
        {
            targets: 4,
            title: 'Descripción de la vacantes',
            className: 'all text-center descripcion-column',
            render: function(data, type, row, meta) {
                if (type === 'display' && data.length > 100) {
                    return data.substr(0, 201) + '...'; 
                }
                return data;
            }
        },
        { targets: 5, title: 'Fecha de publicación', className: 'all text-center' },
        { targets: 6, title: 'Fecha de expiración', className: 'all text-center' },
        { targets: 7, title: 'Total de postulaciones', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' }
    ]
});






$(document).ready(function() {
    $('#Tablapostulaciones tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablapostulaciones.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_vacantes');

        ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;
        editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes',1);
        cargarRequerimientos(row.data().REQUERIMIENTO);

        $('#botonAgregar').prop('disabled', true);

    });

    $('#miModal_vacantes').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_vacantes');
    });
});




function cargarRequerimientos(requerimientos) {
    const contenedor = document.getElementById('inputs-container');
    contenedor.innerHTML = ''; 

    requerimientos.forEach(function(requerimiento) {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-8  text-center">
                <label></label>
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" value="${requerimiento.NOMBRE_REQUERIMINETO}" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-2 text-center">
                <label>%</label>
                <input type="number" name="PORCENTAJE[]" class="form-control" value="${requerimiento.PORCENTAJE}">
            </div>
            <div class="col-2">
                <label>Eliminar</label>

                <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
            </div>
        `;
        contenedor.appendChild(divInput);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divInput);
        });
    });
}




// Función para mostrar la información de los postulantes
function TotalPostulantes(idVacante, categoriaVacante) {
    Swal.fire({
        title: 'Consultando información',
        text: 'Por favor, espere...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '/informacionpostulantes/' + idVacante,
        method: 'GET',
        success: function(response) {
            Swal.close();

            if (response.postulantes.length > 0) {
                let content = '';

                response.postulantes.forEach((personalInfo, index) => {
                    let postulanteCard = `
                        <div class="row mb-3 mt-5" data-curp="${personalInfo.CURP_CV}">
                            <div class="col-md-4 d-flex flex-column justify-content-start">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Información Personal</h5>
                                        <p class="card-text"><strong>Nombre:</strong> ${personalInfo.NOMBRE_CV} ${personalInfo.PRIMER_APELLIDO_CV} ${personalInfo.SEGUNDO_APELLIDO_CV}</p>
                                        <p class="card-text"><strong>Correo:</strong> ${personalInfo.CORREO_CV}</p>
                                        <p class="card-text"><strong>Teléfonos:</strong> ${personalInfo.TELEFONO1}, ${personalInfo.TELEFONO2}</p>
                                    </div>
                                </div>
                                <div class="card flex-grow-1">
                                    <div class="card-body">
                                        <h5 class="card-title">Requerimientos de la Vacante</h5>
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;"></th>
                                                    <th style="width: 30%; text-align: right;">Cumple</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${response.requerimientos.map((req, i) => `
                                                <tr>
                                                    <td><strong>${i + 1}. ${req.NOMBRE_REQUERIMINETO}</strong></td>
                                                    <td class="text-right">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}" value="${req.PORCENTAJE}" onchange="actualizarTotal('${personalInfo.CURP_CV}')">
                                                                <label class="form-check-label me-3" for="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}">Sí</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}" value="0" onchange="actualizarTotal('${personalInfo.CURP_CV}')">
                                                                <label class="form-check-label me-3" for="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}">No</label>
                                                            </div>
                                                            <span class="ms-3"><strong>${req.PORCENTAJE}%</strong></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span><strong>Total cumplimiento:</strong></span>
                                            <span id="total-cumplimiento-${personalInfo.CURP_CV}" class="total-porcentaje-circle">0%</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-success" onclick="seleccionarPostulante('${idVacante}', '${personalInfo.CURP_CV}', '${personalInfo.NOMBRE_CV}', '${personalInfo.PRIMER_APELLIDO_CV}', '${personalInfo.SEGUNDO_APELLIDO_CV}', '${personalInfo.CORREO_CV}', '${personalInfo.TELEFONO1}', '${personalInfo.TELEFONO2}', '${categoriaVacante}')">Preselección</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card h-100">
                                    <div class="card-body p-0">
                                        <iframe src="/reclutamiento/cv/${personalInfo.CURP_CV}" width="100%" height="100%" style="border: none;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    content += postulanteCard;
                });

                $('#modalContent').html(content);

                var myModal = new bootstrap.Modal(document.getElementById('modalFullScreen'), {
                    keyboard: true
                });
                myModal.show();
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'No hay registros',
                    text: 'No se encontraron postulantes para esta vacante.',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al consultar la información. Por favor, inténtelo de nuevo.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}

function actualizarTotal(curp) {
    const radios = document.querySelectorAll(`input[name^="req-"][name$="${curp}"]:checked`);
    let total = 0;

    radios.forEach(radio => {
        total += parseInt(radio.value) || 0;
    });

    const totalSpan = document.getElementById(`total-cumplimiento-${curp}`);
    totalSpan.textContent = `${total}%`;

    if (total >= 90) {
        totalSpan.style.backgroundColor = 'green';
    } else if (total >= 80 && total < 90) {
        totalSpan.style.backgroundColor = 'orange';
    } else {
        totalSpan.style.backgroundColor = 'red';
    }
}

function seleccionarPostulante(vacantesId, curp, nombre, primerApellido, segundoApellido, correo, telefono1, telefono2, categoriaVacante) {
    const totalCumplimiento = document.getElementById(`total-cumplimiento-${curp}`).textContent.replace('%', '');

    Swal.fire({
        title: '¿Estás seguro?',
        text: `Estás a punto de preseleccionar a ${nombre} ${primerApellido} ${segundoApellido}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seleccionar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento',
                text: 'Estamos guardando la información',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    $('.swal2-popup').addClass('ld ld-breath');
                }
            });

            $.ajax({
                url: '/guardarSeleccion',
                method: 'POST',
                data: {
                    VACANTES_ID: vacantesId,
                    CATEGORIA_VACANTE: categoriaVacante,
                    CURP: curp,
                    NOMBRE_SELC: nombre,
                    PRIMER_APELLIDO_SELEC: primerApellido,
                    SEGUNDO_APELLIDO_SELEC: segundoApellido,
                    CORREO_SELEC: correo,
                    TELEFONO1_SELECT: telefono1,
                    TELEFONO2_SELECT: telefono2,
                    PORCENTAJE: totalCumplimiento  
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close(); 

                    Swal.fire({
                        icon: 'success',
                        title: 'Seleccionado',
                        text: 'El postulante ha sido seleccionado y guardado exitosamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        const postulanteCard = document.querySelector(`#modalContent div[data-curp="${curp}"]`);
                        
                        if (postulanteCard) {

                            postulanteCard.classList.add('fade-out');

                            setTimeout(() => {
                                postulanteCard.remove();

                                if (document.querySelectorAll('#modalContent .row.mb-3.mt-5').length === 0) {
                                    $('#modalFullScreen').modal('hide');
                                }

                                Tablapostulaciones.ajax.reload(null, false); 
                            }, 500); 
                        } else {
                            console.error(`Elemento con CURP ${curp} no encontrado.`);
                        }
                    });
                },
                error: function(error) {
                    Swal.close(); 

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al guardar la selección. Por favor, inténtelo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}



