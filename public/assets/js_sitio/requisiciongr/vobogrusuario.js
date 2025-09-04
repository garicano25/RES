var TablaVoBoGRusuarios = $("#TablaVoBoGRusuarios").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'Todos']
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
        method: 'GET',
        cache: false,
        url: '/TablaVoBoGRusuarios',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            TablaVoBoGRusuarios.columns.adjust().draw();
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
        { data: 'NO_RECEPCION' },
        { data: 'TOTAL_PRODUCTOS' },
        { data: 'BTN_EDITAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'No. Recepción', className: 'all text-center' },
        { targets: 2, title: 'Productos', className: 'all text-center' },
        { targets: 3, title: 'Editar', className: 'all text-center' }
    ]
});





$(document).on('click', '.EDITAR', function () {
    let idGR = $(this).data('id');

    $.get('/ConsultarProductosVoBo/' + idGR, function (resp) {
        if (resp.ok) {
            let contenedor = $("#contenedorProductosVoBo");
            contenedor.empty();

            resp.detalle.forEach(det => {
                contenedor.append(`
                    <div class="border rounded p-3 mb-2 bg-light">
                        <p><b>${det.DESCRIPCION}</b></p>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" value="${det.CANTIDAD_ACEPTADA}" readonly>
                            </div>
                            <div class="col-6">
                                <label>Cantidad Aceptada por Usuario</label>
                                <input type="number" class="form-control" 
                                    name="CANTIDAD_ACEPTADA_USUARIO[${det.ID_DETALLE}]" 
                                    value="${det.CANTIDAD_ACEPTADA_USUARIO ?? ''}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label>Cumple lo especificado</label>
                                <select class="form-control" name="CUMPLE_ESPECIFICADO_USUARIO[${det.ID_DETALLE}]">
                                    <option value="">Seleccione</option>
                                    <option value="Sí" ${det.CUMPLE_ESPECIFICADO_USUARIO == "Sí" ? "selected" : ""}>Sí</option>
                                    <option value="No" ${det.CUMPLE_ESPECIFICADO_USUARIO == "No" ? "selected" : ""}>No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Comentario especificación</label>
                                <textarea class="form-control" name="COMENTARIO_CUMPLE_USUARIO[${det.ID_DETALLE}]">${det.COMENTARIO_CUMPLE_USUARIO ?? ''}</textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label>Estado del B o S</label>
                                <select class="form-control" name="ESTADO_BS_USUARIO[${det.ID_DETALLE}]">
                                    <option value="">Seleccione</option>
                                    <option value="BUEN_ESTADO" ${det.ESTADO_BS_USUARIO == "BUEN_ESTADO" ? "selected" : ""}>En buen estado</option>
                                    <option value="MAL_ESTADO" ${det.ESTADO_BS_USUARIO == "MAL_ESTADO" ? "selected" : ""}>Mal estado</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Comentario Estado</label>
                                <textarea class="form-control" name="COMENTARIO_ESTADO_USUARIO[${det.ID_DETALLE}]">${det.COMENTARIO_ESTADO_USUARIO ?? ''}</textarea>
                            </div>
                        </div>
                    </div>
                `);
            });

            $("#ID_GR_VOBO").val(idGR);
            $("#modalVoBo").modal("show");
        } else {
            Swal.fire('Error', 'No se pudieron cargar los productos', 'error');
        }
    });
});




$(document).on("click", "#btnGuardarVoBoGR", function(e) {
    e.preventDefault();

    let formData = $("#formVoBo").serialize(); // serializamos el form completo

    $.ajax({
        url: '/guardarVoBoUsuario',
        method: 'POST',
        data: formData,
        beforeSend: function () {
            Swal.fire({
                title: 'Guardando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(resp) {
            Swal.close();
            if (resp.ok) {
                Swal.fire('Éxito', resp.msg, 'success');
                $("#modalVoBo").modal("hide");
                TablaVoBoGRusuarios.ajax.reload(); // recargar tabla
            } else {
                Swal.fire('Error', resp.msg, 'error');
            }
        },
        error: function(xhr) {
            Swal.close();
            Swal.fire('Error', 'Ocurrió un problema al guardar', 'error');
        }
    });
});

