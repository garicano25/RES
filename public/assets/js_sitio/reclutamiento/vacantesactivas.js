


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
                return meta.row + 1; // Contador que inicia en 1 y se incrementa por cada fila
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
        { targets: 3, title: 'Tipo de vacantwe', className: 'all text-center' },
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
        { targets: 8, title: 'Botones', className: 'all text-center' }
    ]
});
















function TotalPostulantes(idVacante) {
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
                        <div class="row mb-3 mt-5">
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
                                                                <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}" value="si">
                                                                <label class="form-check-label me-3" for="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}">Sí</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}" value="no">
                                                                <label class="form-check-label" for="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}">No</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
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





