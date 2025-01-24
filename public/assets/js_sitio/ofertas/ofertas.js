ID_FORMULARIO_OFERTAS = 0



const ModalDesvinculacion = document.getElementById('miModal_OFERTAS');
ModalDesvinculacion.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_OFERTAS = 0;

    document.getElementById('formularioOFERTAS').reset();

    $('#miModal_OFERTAS .modal-title').html('Ofertas/Cotizaciones');

    $('#RECHAZO').hide(); 
    $('#ACEPTADA').hide();

    var selectize = $('#SOLICITUD_ID')[0].selectize;
    selectize.clear(); 
    selectize.clearOptions(); 
    selectize.addOption({
        value: '',
        text: 'Seleccione una solicitud'
    }); 
});


$(document).ready(function () {
    // Inicializar Selectize
    var selectizeInstance = $('#SOLICITUD_ID').selectize({
        placeholder: 'Seleccione una solicitud',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVA_OFERTA").click(function (e) {
        e.preventDefault();

        $("#miModal_OFERTAS").modal("show");

        var selectize = selectizeInstance[0].selectize;
        selectize.clear(); 
        selectize.clearOptions(); 
        selectize.addOption({
            value: '',
            text: 'Seleccione una solicitud'
        }); 

        $('#RECHAZO').hide(); 
        $('#ACEPTADA').hide();  

        document.getElementById('formularioOFERTAS').reset();
    });
});





$("#guardarOFERTA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioOFERTAS');

    if (formularioValido) {

    if (ID_FORMULARIO_OFERTAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarOFERTA')
            await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_OFERTAS: ID_FORMULARIO_OFERTAS }, 'ofertaSave', 'formularioOFERTAS', 'guardarOFERTA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_FORMULARIO_OFERTAS = data.oferta.ID_FORMULARIO_OFERTAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_OFERTAS').modal('hide')
                    document.getElementById('formularioOFERTAS').reset();
                    Tablaofertas.ajax.reload()
                    $('#NO_SOLICITUD')[0].selectize.clear();



            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarOFERTA')
            await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_OFERTAS: ID_FORMULARIO_OFERTAS }, 'ofertaSave', 'formularioOFERTAS', 'guardarOFERTA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_OFERTAS = data.oferta.ID_FORMULARIO_OFERTAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_OFERTAS').modal('hide')
                    document.getElementById('formularioOFERTAS').reset();
                    Tablaofertas.ajax.reload()
                    $('#NO_SOLICITUD')[0].selectize.clear();


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





var Tablaofertas = $("#Tablaofertas").DataTable({
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
        url: '/Tablaofertas',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaofertas.columns.adjust().draw();
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
        { data: 'NO_SOLICITUD' },
        { data: 'NO_OFERTA' },
        { data: 'FECHA_OFERTA' },
        { 
            data: 'ESTATUS_OFERTA',
            render: function(data, type, row) {
                const colors = {
                    'Aceptada': 'background-color: green; color: white;',
                    'Revision': 'background-color: orange; color: white;',
                    'Rechazada': 'background-color: red; color: white;'
                };

                const isDisabled = (data === 'Aceptada' || data === 'Rechazada') ? 'disabled' : '';

                return `
                    <select class="form-select ESTATUS_OFERTA" 
                            data-id="${row.ID_FORMULARIO_OFERTAS}" 
                            style="${colors[data] || ''}" ${isDisabled}>
                        <option value="" ${!data ? 'selected' : ''} disabled style="background-color: white; color: black;">Seleccione una opción</option>
                        <option value="Aceptada" ${data === 'Aceptada' ? 'selected' : ''} style="background-color: green; color: white;">Aceptada</option>
                        <option value="Revision" ${data === 'Revision' ? 'selected' : ''} style="background-color: orange; color: white;">Revision</option>
                        <option value="Rechazada" ${data === 'Rechazada' ? 'selected' : ''} style="background-color: red; color: white;">Rechazada</option>
                    </select>
                    <textarea class="form-control MOTIVO_RECHAZO d-none" placeholder="Motivo de rechazo..." data-id="${row.ID_FORMULARIO_OFERTAS}" ${isDisabled}>${row.MOTIVO_RECHAZO || ''}</textarea>
                `;
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de solicitud', className: 'all text-center nombre-column' },
        { targets: 2, title: 'N° de Oferta/Cotización', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Fecha', className: 'all text-center' },
        { targets: 4, title: 'Estatus de la oferta', className: 'all text-center' },
        { targets: 5, title: 'Editar', className: 'all text-center' },
        { targets: 6, title: 'Visualizar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablaofertas tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaofertas.row(tr);

    ID_FORMULARIO_OFERTAS = row.data().ID_FORMULARIO_OFERTAS;

    editarDatoTabla(row.data(), 'formularioOFERTAS', 'miModal_OFERTAS', 1);

    var selectize = $('#SOLICITUD_ID')[0].selectize;
    selectize.clear();
    selectize.clearOptions(); 

    if (row.data().SOLICITUDES && row.data().SOLICITUDES.length > 0) {
        row.data().SOLICITUDES.forEach(solicitud => {
            selectize.addOption({
                value: solicitud.ID_FORMULARIO_SOLICITUDES,
                text: `${solicitud.NO_SOLICITUD} (${solicitud.NOMBRE_COMERCIAL_SOLICITUD})`
            });
        });
    }

    var solicitudSeleccionado = row.data().SOLICITUD_ID;
    if (solicitudSeleccionado) {
        selectize.setValue(solicitudSeleccionado); 
    }

    $('#miModal_OFERTAS .modal-title').html(row.data().NO_OFERTA);

    var estatus = row.data().ESTATUS_OFERTA;

    if (estatus === 'Aceptada') {
        $('#ACEPTADA').show();  
        $('#RECHAZO').hide();   
    } else if (estatus === 'Rechazada') {
        $('#RECHAZO').show();   
        $('#ACEPTADA').hide();  
    } else {
        $('#ACEPTADA').hide();  
        $('#RECHAZO').hide();
    }

    $("#miModal_OFERTAS").modal("show");
});




$('#Tablaofertas tbody').on('change', '.ESTATUS_OFERTA', function () {
    const selectedValue = $(this).val();
    const solicitudId = $(this).data('id');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (selectedValue === 'Aceptada') {
        Swal.fire({
            title: 'Datos de Aceptación',
            html: `
                <div class="col-12">
                    <div class="mb-3">
                        <label>Aceptada por:</label>
                        <input type="text" class="form-control" id="SWAL_ACEPTADA_OFERTA" placeholder="Nombre del responsable">
                    </div>
                    <div class="mb-3">
                        <label>Fecha de aceptación:</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" id="SWAL_FECHA_ACEPTACION_OFERTA" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Fecha de firma términos y condiciones:</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" id="SWAL_FECHA_FIRMA_OFERTA" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                // Inicializar los datepickers solo en SweetAlert2
                $('#SWAL_FECHA_ACEPTACION_OFERTA').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'es'
                });
                $('#SWAL_FECHA_FIRMA_OFERTA').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'es'
                });
            },
            preConfirm: () => {
                const aceptadaPor = $('#SWAL_ACEPTADA_OFERTA').val();
                const fechaAceptacion = $('#SWAL_FECHA_ACEPTACION_OFERTA').val();
                const fechaFirma = $('#SWAL_FECHA_FIRMA_OFERTA').val();

                if (!aceptadaPor || !fechaAceptacion || !fechaFirma) {
                    Swal.showValidationMessage('Todos los campos son obligatorios.');
                    return false;
                }

                return { aceptadaPor, fechaAceptacion, fechaFirma };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { aceptadaPor, fechaAceptacion, fechaFirma } = result.value;

                $.ajax({
                    url: '/actualizarEstatusOferta',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ID_FORMULARIO_OFERTAS: solicitudId,
                        ESTATUS_OFERTA: selectedValue,
                        ACEPTADA_OFERTA: aceptadaPor,
                        FECHA_ACEPTACION_OFERTA: fechaAceptacion,
                        FECHA_FIRMA_OFERTA: fechaFirma
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Actualizado', 'El estatus y los datos fueron actualizados correctamente.', 'success').then(() => {
                                Tablaofertas.ajax.reload(); // Recargar la tabla
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Ocurrió un error al actualizar el estatus.', 'error');
                    }
                });
            }
        });
    } else if (selectedValue === 'Rechazada') {
        Swal.fire({
            title: 'Motivo del rechazo',
            input: 'textarea',
            inputPlaceholder: 'Escriba el motivo del rechazo...',
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                const motivoRechazo = result.value;

                $.ajax({
                    url: '/actualizarEstatusOferta',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ID_FORMULARIO_OFERTAS: solicitudId,
                        ESTATUS_OFERTA: selectedValue,
                        MOTIVO_RECHAZO: motivoRechazo
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Actualizado', 'El estatus fue actualizado correctamente.', 'success').then(() => {
                                Tablaofertas.ajax.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Ocurrió un error al actualizar el estatus.', 'error');
                    }
                });
            }
        });
    }
});





