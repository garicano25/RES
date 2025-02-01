//VARIABLES
ID_FORMULARIO_SOLICITUDES = 0



$("#NUEVA_SOLICITUD").click(function (e) {
    e.preventDefault();


       
    $('#formularioSOLICITUDES').each(function(){
        this.reset();
    });

    $(".observacionesdiv").empty();
    $(".contactodiv").empty();


    $("#miModal_SOLICITUDES").modal("show");



   
});




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
        

        var observacion = [];
        $(".generarobervaciones").each(function() {
            var observaciones = {
                'OBSERVACIONES': $(this).find("textarea[name='OBSERVACIONES']").val()
            };
            observacion.push(observaciones);
        });

        var contactos = [];
            $(".generarcontacto").each(function() {
                var contacto = {
                    'CONTACTO_SOLICITUD': $(this).find("input[name='CONTACTO_SOLICITUD']").val(),
                    'CARGO_SOLICITUD': $(this).find("input[name='CARGO_SOLICITUD").val(),
                    'TELEFONO_SOLICITUD': $(this).find("input[name='TELEFONO_SOLICITUD']").val(),
                    'CELULAR_SOLICITUD': $(this).find("input[name='CELULAR_SOLICITUD']").val(),
                    'CORREO_SOLICITUD': $(this).find("input[name='CORREO_SOLICITUD']").val()
                };
                contactos.push(contacto);
            });


    
        const requestData = {
            api: 1,
            ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES,
            OBSERVACIONES_SOLICITUD: JSON.stringify(observacion),
            CONTACTOS_JSON: JSON.stringify(contactos) 

        };

        if (ID_FORMULARIO_SOLICITUDES == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarSOLICITUD');
                await ajaxAwaitFormData(requestData, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    
                    ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                         $('#miModal_SOLICITUDES').modal('hide')
                        document.getElementById('formularioSOLICITUDES').reset();
                        Tablasolicitudes.ajax.reload()
    
    
                })
                
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarSOLICITUD');
                await ajaxAwaitFormData(requestData, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    
                    setTimeout(() => {
    
                        ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                         $('#miModal_SOLICITUDES').modal('hide')
                        document.getElementById('formularioSOLICITUDES').reset();
                        Tablasolicitudes.ajax.reload()
    
    
                    }, 300);  
                })
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});





// $("#guardarSOLICITUD").click(function (e) {
//     e.preventDefault();

//     formularioValido = validarFormularioV1('formularioSOLICITUDES');

//     if (formularioValido) {

//     if (ID_FORMULARIO_SOLICITUDES == 0) {
        
//         alertMensajeConfirm({
//             title: "¿Desea guardar la información?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarSOLICITUD')
//             await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES }, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
                
//             }, function (data) {
                    
//                 ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
//                     alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
//                      $('#miModal_SOLICITUDES').modal('hide')
//                     document.getElementById('formularioSOLICITUDES').reset();
//                     Tablasolicitudes.ajax.reload()


//             })
            
            
            
//         }, 1)
        
//     } else {
//             alertMensajeConfirm({
//             title: "¿Desea editar la información de este formulario?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarSOLICITUD')
//             await ajaxAwaitFormData({ api: 1,ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES }, 'solicitudSave', 'formularioSOLICITUDES', 'guardarSOLICITUD', { callbackAfter: true, callbackBefore: true }, () => {
//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
        
//             }, function (data) {
                    
//                 setTimeout(() => {

//                     ID_FORMULARIO_SOLICITUDES = data.solicitud.ID_FORMULARIO_SOLICITUDES
//                     alertMensaje('success', 'Información editada correctamente', 'Información guardada')
//                      $('#miModal_SOLICITUDES').modal('hide')
//                     document.getElementById('formularioSOLICITUDES').reset();
//                     Tablasolicitudes.ajax.reload()


//                 }, 300);  
//             })
//         }, 1)
//     }

// } else {
//     alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

// }
    
// });



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

    
    $(".observacionesdiv").empty(); 
    obtenerObservaciones(row); 

    $(".contactodiv").empty();
    obtenerContactos(row);

    editarDatoTabla(row.data(), 'formularioSOLICITUDES', 'miModal_SOLICITUDES', 1);

    $('#miModal_SOLICITUDES .modal-title').html(row.data().NOMBRE_COMERCIAL_SOLICITUD);

     const fields = [
    'CONTACTO_OFERTA',
    'CARGO_OFERTA',
    'TELEFONO_OFERTA',
    'CELULAR_OFERTA',
    'CORREO_OFERTA',
    ];

        const dirigeOferta = Number(row.data().DIRIGE_OFERTA);

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);

            if (field) {
                field.toggleAttribute('disabled', dirigeOferta === 0);
                field.toggleAttribute('required', dirigeOferta !== 0);
            } else {
                console.warn(` El campo ${fieldId} no existe en el DOM.`);
            }
        });

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

        $(".observacionesdiv").empty(); 
        obtenerObservaciones(row); 

    $(".contactodiv").empty();
    obtenerContactos(row);

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





document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarDoc = document.getElementById('botonAgregarobservaciones');
    botonAgregarDoc.addEventListener('click', function () {
        agregarobservaciones();
    });

    function agregarobservaciones() {
        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generarobervaciones', 'mb-3');
        divDocumentoOfi.innerHTML = `
        
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Observación</label>
                <textarea class="form-control"  name="OBSERVACIONES" rows="2"></textarea>
              </div>
            </div>

            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarObservacion">Eliminar observación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.observacionesdiv');
        contenedor.appendChild(divDocumentoOfi);

        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarObservacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    }


});





function obtenerObservaciones(data) {
    let row = data.data().OBSERVACIONES_SOLICITUD;
    var observaciones = JSON.parse(row);

    $.each(observaciones, function (index, contacto) {
        var observa = contacto.OBSERVACIONES;
     

        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generarobervaciones', 'mb-3');
        divDocumentoOfi.innerHTML = `
         
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Observación</label>
<textarea class="form-control" name="OBSERVACIONES" rows="2">${observa}</textarea>
              </div>
            </div>
            
            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarObservacion">Eliminar observación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.observacionesdiv');
        contenedor.appendChild(divDocumentoOfi);

      
        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarObservacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    });

}




document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botonAgregarcontacto');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarContacto();
    });

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcontacto', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="CONTACTO_SOLICITUD" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cargo *</label>
                        <input type="text" class="form-control" name="CARGO_SOLICITUD" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono y Extensión </label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Celular *</label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" required>
                    </div>
                </div>
            </div>

            <br>
            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar contacto <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.contactodiv');
        contenedor.appendChild(divContacto);

        // Evento para eliminar contacto
        const botonEliminar = divContacto.querySelector('.botonEliminarContacto');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    }
});



function obtenerContactos(data) {
    let row = data.data().CONTACTOS_JSON;
    var contactos = JSON.parse(row);

    $.each(contactos, function (index, contacto) {
        var nombre = contacto.CONTACTO_SOLICITUD;
        var cargo = contacto.CARGO_SOLICITUD;
        var telefono = contacto.TELEFONO_SOLICITUD;
        var celular = contacto.CELULAR_SOLICITUD;
        var correo = contacto.CORREO_SOLICITUD;

        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcontacto', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="CONTACTO_SOLICITUD" value="${nombre}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cargo *</label>
                        <input type="text" class="form-control" name="CARGO_SOLICITUD" value="${cargo}" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono y Extensión </label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD" value="${telefono}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Celular *</label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" value="${celular}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" value="${correo}" required>
                    </div>
                </div>
            </div>

            <br>
            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar contacto <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.contactodiv');
        contenedor.appendChild(divContacto);

        // Evento para eliminar contacto
        const botonEliminar = divContacto.querySelector('.botonEliminarContacto');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    });
}



document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarDomicilio = document.getElementById('botonAgregardomicilio');

    botonAgregarDomicilio.addEventListener('click', function () {
        agregarDomicilio();
    });

    function agregarDomicilio() {
        const divDomicilio = document.createElement('div');
        divDomicilio.classList.add('row', 'generardireccion', 'mb-3');
        divDomicilio.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de Domicilio *</label>
                        <input type="text" class="form-control" name="TIPO_DOMICILIO" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Código Postal *</label>
                        <input type="text" class="form-control" name="CODIGO_POSTAL" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">País *</label>
                        <input type="text" class="form-control" name="PAIS" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <input type="text" class="form-control" name="ESTADO" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Municipio *</label>
                        <input type="text" class="form-control" name="MUNICIPIO" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ciudad *</label>
                        <input type="text" class="form-control" name="CIUDAD" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Colonia *</label>
                        <input type="text" class="form-control" name="COLONIA" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Calle *</label>
                        <input type="text" class="form-control" name="CALLE" required>
                    </div>
                </div>
            </div>

            <br>
            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarDomicilio">Eliminar dirección <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.direcciondiv');
        contenedor.appendChild(divDomicilio);

        const botonEliminar = divDomicilio.querySelector('.botonEliminarDomicilio');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDomicilio);
        });
    }
});



function handleServicioChange() {
    const empresaDatosDiv = document.getElementById('empresaDatos');
    const servicioParaTercero = document.getElementById('servicioParaTercero').checked;

    if (servicioParaTercero) {
        empresaDatosDiv.style.display = 'block';
    } else {
        empresaDatosDiv.style.display = 'none';

        const inputs = empresaDatosDiv.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = ''; 
        });
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const botonVerificacion = document.getElementById('botonVerificacion');

    botonVerificacion.addEventListener('click', function () {
        agregarVerificacion();
    });

    function agregarVerificacion() {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');
        divVerificacion.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Verificado en *</label>
                        <input type="text" class="form-control" name="VERIFICADO_EN" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subir Evidencia (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="EVIDENCIA_VERIFICACION" accept=".pdf" required>
                            <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar verificación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.verifiacionesdiv');
        contenedor.appendChild(divVerificacion);

        const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divVerificacion);
        });

        const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
        const inputArchivo = divVerificacion.querySelector('input[name="EVIDENCIA_VERIFICACION"]');

        botonEliminarArchivo.addEventListener('click', function () {
            inputArchivo.value = ''; 
        });
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const btnVerificacion = document.getElementById("btnVerificacion");
    const verificacionClienteDiv = document.getElementById("VERIFICACION_CLIENTE");
    const inputVerificacionEstado = document.getElementById("inputVerificacionEstado");

    btnVerificacion.addEventListener("click", function () {
        let estadoActual = parseInt(inputVerificacionEstado.value, 10);
        let nuevoEstado = estadoActual === 0 ? 1 : 0;

        inputVerificacionEstado.value = nuevoEstado;

        verificacionClienteDiv.style.display = nuevoEstado === 1 ? "block" : "none";

        if (nuevoEstado === 1) {
            btnVerificacion.classList.remove("btn-info");
            btnVerificacion.classList.add("btn-success");
        } else {
            btnVerificacion.classList.remove("btn-success");
            btnVerificacion.classList.add("btn-info");
        }
    });
});
