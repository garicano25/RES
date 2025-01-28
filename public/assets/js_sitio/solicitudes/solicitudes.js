//VARIABLES
ID_FORMULARIO_SOLICITUDES = 0




const ModalArea = document.getElementById('miModal_SOLICITUDES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_SOLICITUDES = 0
    document.getElementById('formularioSOLICITUDES').reset();
   
    $('#miModal_SOLICITUDES .modal-title').html('Solicitudes');



    const fields = [
        'CONTACTO_OFERTA',
        'CARGO_OFERTA',
        'TELEFONO_OFERTA',
        'CELULAR_OFERTA',
        'CORREO_OFERTA',
    ];

    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.disabled = false; 
            field.required = true; 
            field.value = ''; 
        }
    });

    const radios = document.querySelectorAll('input[name="DIRIGE_OFERTA"]');
    radios.forEach(radio => {
        radio.checked = false; 
    });



})





$("#guardarSOLICITUD").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioSOLICITUDES');

    if (formularioValido) {

    if (ID_FORMULARIO_SOLICITUDES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarSOLICITUD')
            await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES }, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_SOLICITUDES').modal('hide')
                    document.getElementById('formularioSOLICITUDES').reset();
                    Tablasolicitudes.ajax.reload()


            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarSOLICITUD')
            await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES }, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_SOLICITUDES').modal('hide')
                    document.getElementById('formularioSOLICITUDES').reset();
                    Tablasolicitudes.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablasolicitudes = $("#Tablasolicitudes").DataTable({
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
        url: '/Tablasolicitudes',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablasolicitudes.columns.adjust().draw();
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
        { 
            data: 'TIPO_SOLICITUD',
            render: function(data, type, row) {
                if (data === '1') {
                    return 'Pasiva';
                } else if (data === '2') {
                    return 'Activa';
                } else {
                    return data; 
                }
            }
        },
        { data: 'NOMBRE_COMERCIAL_SOLICITUD' },
        { data: 'FECHA_SOLICITUD' },
        { 
            data: 'ESTATUS_SOLICITUD',
            render: function(data, type, row) {
                // Renderizar el select
                const colors = {
                    'Aceptada': 'background-color: green; color: white;',
                    'Revisión': 'background-color: orange; color: white;',
                    'Rechazada': 'background-color: red; color: white;'
                };

                // Habilitar el select solo si el estatus es "Revision"
                const isDisabled = (data === 'Aceptada' || data === 'Rechazada') ? 'disabled' : '';

                return `
                    <select class="form-select ESTATUS_SOLICITUD" 
                            data-id="${row.ID_FORMULARIO_SOLICITUDES}" 
                            style="${colors[data] || ''}" ${isDisabled}>
                        <option value="" ${!data ? 'selected' : ''} disabled style="background-color: white; color: black;">Seleccione una opción</option>
                        <option value="Aceptada" ${data === 'Aceptada' ? 'selected' : ''} style="background-color: green; color: white;">Aceptada</option>
                        <option value="Revisión" ${data === 'Revisión' ? 'selected' : ''} style="background-color: orange; color: white;">Revisión</option>
                        <option value="Rechazada" ${data === 'Rechazada' ? 'selected' : ''} style="background-color: red; color: white;">Rechazada</option>
                    </select>
                    <textarea class="form-control MOTIVO_RECHAZO d-none" placeholder="Motivo de rechazo..." data-id="${row.ID_FORMULARIO_SOLICITUDES}" ${isDisabled}>${row.MOTIVO_RECHAZO || ''}</textarea>
                `;
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_CORREO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de solicitud', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Tipo de solicitud', className: 'all text-center' },
        { targets: 3, title: 'Nombre comercial <br> de la empresa', className: 'all text-center' },
        { targets: 4, title: 'Fecha', className: 'all text-center' },
        { targets: 5, title: 'Estatus de la solicitud', className: 'all text-center' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
        { targets: 7, title: 'Visualizar', className: 'all text-center' },
        { targets: 8, title: 'Enviar correo', className: 'all text-center' },
        { targets: 9, title: 'Activo', className: 'all text-center' }
    ]
});






$('#Tablasolicitudes tbody').on('change', '.ESTATUS_SOLICITUD', function () {
    const selectedValue = $(this).val(); 
    const solicitudId = $(this).data('id'); 
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); 

    if (selectedValue === 'Rechazada') {
        Swal.fire({
            title: 'Motivo del rechazo',
            input: 'textarea',
            inputPlaceholder: 'Escriba el motivo del rechazo...',
            inputAttributes: {
                'aria-label': 'Escriba el motivo del rechazo...'
            },
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            preConfirm: (motivo) => {
                if (!motivo) {
                    Swal.showValidationMessage('El motivo del rechazo es obligatorio');
                }
                return motivo;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const motivoRechazo = result.value;

                // Enviar datos al servidor
                $.ajax({
                    url: '/actualizarEstatusSolicitud',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ID_FORMULARIO_SOLICITUDES: solicitudId,
                        ESTATUS_SOLICITUD: selectedValue,
                        MOTIVO_RECHAZO: motivoRechazo
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Actualizado',
                                'El estatus y el motivo fueron actualizados correctamente.',
                                'success'
                            ).then(() => {
                                Tablasolicitudes.ajax.reload(); 
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
    } else {
        Swal.fire({
            title: 'Confirmar cambio',
            text: '¿Está seguro de cambiar el estatus?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/actualizarEstatusSolicitud',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ID_FORMULARIO_SOLICITUDES: solicitudId,
                        ESTATUS_SOLICITUD: selectedValue,
                        MOTIVO_RECHAZO: null 
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Actualizado',
                                'El estatus fue actualizado correctamente.',
                                'success'
                            ).then(() => {
                                Tablasolicitudes.ajax.reload();
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




$('#Tablasolicitudes tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudes.row(tr);
    ID_FORMULARIO_SOLICITUDES = row.data().ID_FORMULARIO_SOLICITUDES;

    editarDatoTabla(row.data(), 'formularioSOLICITUDES', 'miModal_SOLICITUDES', 1);

    $('#miModal_SOLICITUDES .modal-title').html(row.data().NOMBRE_COMERCIAL_SOLICITUD);

    if (row.data().DIRIGE_OFERTA === 0) {
        const fields = [
            'CONTACTO_OFERTA',
            'CARGO_OFERTA',
            'TELEFONO_OFERTA',
            'CELULAR_OFERTA',
            'CORREO_OFERTA',
        ];

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.disabled = true; 
                field.required = false; 
            }
        });
    }

    const rechazoDiv = document.getElementById('RECHAZO');
    const motivoRechazoTextarea = document.getElementById('MOTIVO_RECHAZO');
    const motivoRechazo = row.data().MOTIVO_RECHAZO || ''; 

    if (motivoRechazo.trim().length > 0) { 
        rechazoDiv.style.display = 'block'; 
        motivoRechazoTextarea.value = motivoRechazo; 
    } else {
        rechazoDiv.style.display = 'none'; 
        motivoRechazoTextarea.value = ''; 
    }
});




$(document).ready(function() {
    $('#Tablasolicitudes tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablasolicitudes.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_SOLICITUDES');

        ID_FORMULARIO_SOLICITUDES = row.data().ID_FORMULARIO_SOLICITUDES;
        editarDatoTabla(row.data(), 'formularioSOLICITUDES', 'miModal_SOLICITUDES',1);
        $('#miModal_SOLICITUDES .modal-title').html(row.data().NOMBRE_COMERCIAL_SOLICITUD);
        
    if (row.data().DIRIGE_OFERTA === 0) {
        const fields = [
            'CONTACTO_OFERTA',
            'CARGO_OFERTA',
            'TELEFONO_OFERTA',
            'CELULAR_OFERTA',
            'CORREO_OFERTA',
        ];

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.disabled = true; 
                field.required = false; 
            }
        });
    }

    const rechazoDiv = document.getElementById('RECHAZO');
    const motivoRechazoTextarea = document.getElementById('MOTIVO_RECHAZO');
    const motivoRechazo = row.data().MOTIVO_RECHAZO || ''; 

    if (motivoRechazo.trim().length > 0) { 
        rechazoDiv.style.display = 'block'; 
        motivoRechazoTextarea.value = motivoRechazo; 
    } else {
        rechazoDiv.style.display = 'none'; 
        motivoRechazoTextarea.value = ''; 
    }

    });

    $('#miModal_SOLICITUDES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_SOLICITUDES');
    });
});




$('#Tablasolicitudes tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudes.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_SOLICITUDES: row.data().ID_FORMULARIO_SOLICITUDES
    };

    eliminarDatoTabla(data, [Tablasolicitudes], 'solicitudDelete');
});


function handleRadioChange() {
  const isMismoContacto = document.getElementById('mismoContacto').checked;

  const fields = [
    'CONTACTO_OFERTA',
    'CARGO_OFERTA',
    'TELEFONO_OFERTA',
    'CELULAR_OFERTA',
    'CORREO_OFERTA',
  ];

  fields.forEach((fieldId) => {
    const field = document.getElementById(fieldId);

    field.value = '';

    if (isMismoContacto) {
      const sourceFieldId = fieldId.replace('_OFERTA', '_SOLICITUD');
      const sourceField = document.getElementById(sourceFieldId);
      field.value = sourceField ? sourceField.value : '';
      field.required = true;
      field.disabled = false;
    } else {
      field.required = false;
      field.disabled = true;
    }
  });
}
