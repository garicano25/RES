//VARIABLES
ID_FORMULARIO_SOLICITUDES = 0



$("#NUEVA_SOLICITUD").click(function (e) {
    e.preventDefault();


       
    $('#formularioSOLICITUDES').each(function(){
        this.reset();
    });

    $(".observacionesdiv").empty();
    $(".contactodiv").empty();
    $(".direcciondiv").empty();
    $(".verifiacionesdiv").empty();

    $("#miModal_SOLICITUDES").modal("show");




   
});




const ModalArea = document.getElementById('miModal_SOLICITUDES');

ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_SOLICITUDES = 0;
    document.getElementById('formularioSOLICITUDES').reset();

    $('#miModal_SOLICITUDES .modal-title').html('Solicitudes');

    const fields = [
        'CONTACTO_OFERTA',
        'CARGO_OFERTA',
        'TELEFONO_OFERTA',
        'CELULAR_OFERTA',
        'CORREO_OFERTA',
        'EXTENSION_OFERTA'
    ];

    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.disabled = false; 
            field.required = false; 
            field.value = ''; 
        }
    });

    const radios = document.querySelectorAll('input[name="SERVICIO_TERCERO"]');
    radios.forEach(radio => {
        radio.checked = false;
    });

    document.getElementById('empresaDatos').style.display = 'none';


});





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
                        'CORREO_SOLICITUD': $(this).find("input[name='CORREO_SOLICITUD']").val(),
                        'EXTENSION_SOLICITUD': $(this).find("input[name='EXTENSION_SOLICITUD']").val()

                        
                    };
                    contactos.push(contacto);
                });

            var direcciones = [];
                    $(".generardireccion").each(function() {
                        var direccion = {
                            'TIPO_DOMICILIO': $(this).find("input[name='TIPO_DOMICILIO']").val(),
                            'CODIGO_POSTAL_DOMICILIO': $(this).find("input[name='CODIGO_POSTAL_DOMICILIO']").val(),
                            'TIPO_VIALIDAD_DOMICILIO': $(this).find("input[name='TIPO_VIALIDAD_DOMICILIO']").val(),
                            'NOMBRE_VIALIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_VIALIDAD_DOMICILIO']").val(),
                            'NUMERO_EXTERIOR_DOMICILIO': $(this).find("input[name='NUMERO_EXTERIOR_DOMICILIO']").val(),
                            'NUMERO_INTERIOR_DOMICILIO': $(this).find("input[name='NUMERO_INTERIOR_DOMICILIO']").val(),
                            'NOMBRE_COLONIA_DOMICILIO': $(this).find("select[name='NOMBRE_COLONIA_DOMICILIO']").val(),
                            'NOMBRE_LOCALIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_LOCALIDAD_DOMICILIO']").val(),
                            'NOMBRE_MUNICIPIO_DOMICILIO': $(this).find("input[name='NOMBRE_MUNICIPIO_DOMICILIO']").val(),
                            'NOMBRE_ENTIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_ENTIDAD_DOMICILIO']").val(),
                            'PAIS_CONTRATACION_DOMICILIO': $(this).find("input[name='PAIS_CONTRATACION_DOMICILIO']").val(),
                            'ENTRE_CALLE_DOMICILIO': $(this).find("input[name='ENTRE_CALLE_DOMICILIO']").val(),
                            'ENTRE_CALLE_2_DOMICILIO': $(this).find("input[name='ENTRE_CALLE_2_DOMICILIO']").val()
                        };
                        direcciones.push(direccion);
                    });


        
            const requestData = {
                api: 1,
                ID_FORMULARIO_SOLICITUDES: ID_FORMULARIO_SOLICITUDES,
                OBSERVACIONES_SOLICITUD: JSON.stringify(observacion),
                CONTACTOS_JSON: JSON.stringify(contactos),
                DIRECCIONES_JSON: JSON.stringify(direcciones) 


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
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información esta lista para usarse', null, null, 1500)
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
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
        { data: 'NO_SOLICITUD' },
        { 
            data: 'TIPO_SOLICITUD',
            render: function(data) {
                return data === '1' ? 'Pasiva' : data === '2' ? 'Activa' : data;
            }
        },
        { data: 'NOMBRE_COMERCIAL_SOLICITUD' },
        { data: 'FECHA_SOLICITUD' },
        {
            data: 'ESTATUS_SOLICITUD',
            render: function(data, type, row) {
                const colors = {
                    'Aceptada': 'background-color: green; color: white;',
                    'Revisión': 'background-color: orange; color: white;',
                    'Rechazada': 'background-color: red; color: white;'
                };

                if (row.PROCEDE_COTIZAR === null || row.PROCEDE_COTIZAR === undefined) {
                    return `
                        <select class="form-select ESTATUS_SOLICITUD" 
                                data-id="${row.ID_FORMULARIO_SOLICITUDES}" 
                                disabled>
                            <option value="" selected disabled style="background-color: white; color: black;">No disponible</option>
                        </select>
                    `;
                }

                if (row.PROCEDE_COTIZAR == 0) {
                    data = 'Rechazada';
                }

                const isDisabled = (data === 'Aceptada' || data === 'Rechazada' || row.PROCEDE_COTIZAR == 0) ? 'disabled' : '';

                return `
                    <select class="form-select ESTATUS_SOLICITUD" 
                            data-id="${row.ID_FORMULARIO_SOLICITUDES}" 
                            style="${colors[data] || ''}" ${isDisabled}>
                        <option value="" ${!data ? 'selected' : ''} disabled style="background-color: white; color: black;">Seleccione una opción</option>
                        <option value="Aceptada" ${data === 'Aceptada' ? 'selected' : ''} style="background-color: green; color: white;">Aceptada</option>
                        <option value="Revisión" ${data === 'Revisión' ? 'selected' : ''} style="background-color: orange; color: white;">Revisión</option>
                        <option value="Rechazada" ${data === 'Rechazada' ? 'selected' : ''} style="background-color: red; color: white;">Rechazada</option>
                    </select>
                `;
            }
        },
        {
            data: null,
            render: function(data, type, row) {
                if (row.PROCEDE_COTIZAR == 1) {
                    return '<span class="badge bg-success" title="Revisión concluida">Revisión concluida</span>';
                } else if (row.SOLICITAR_VERIFICACION == 1) {
                    return '<span class="badge bg-warning text-dark" title="Revisión en proceso">Revisión en proceso</span>';
                } else if (row.PROCEDE_COTIZAR == 0) {
                    return `<span class="badge bg-danger" title="El cliente fue rechazado">Cliente rechazado</span>
                            <br><small class="text-muted">Motivo: ${row.MOTIVO_COTIZACION || 'No especificado'}</small>`;
                }
                return '<span class="badge bg-secondary">No sea solicitado una verificación</span>';
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_CORREO' },
        { data: 'BTN_ELIMINAR' }
    ],
    createdRow: function(row, data) {
        if (data.PROCEDE_COTIZAR == 1) {
            $(row).css("background-color", "#d4edda"); 
            $(row).attr("title", "La revisión ha concluido");
            $(row).tooltip();
        } else if (data.SOLICITAR_VERIFICACION == 1) {
            $(row).css("background-color", "#fff3cd"); 
            $(row).attr("title", "La revisión está en proceso");
            $(row).tooltip();
        } else if (data.PROCEDE_COTIZAR == 0) {
            $(row).css("background-color", "#f8d7da"); 
            $(row).attr("title", `Cliente rechazado: ${data.MOTIVO_COTIZACION || 'No especificado'}`);
            $(row).tooltip();
        }
    },
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de solicitud', className: 'all text-center' },
        { targets: 2, title: 'Tipo de solicitud', className: 'all text-center' },
        { targets: 3, title: 'Nombre comercial', className: 'all text-center' },
        { targets: 4, title: 'Fecha', className: 'all text-center' },
        { targets: 5, title: 'Estatus', className: 'all text-center' },
        { targets: 6, title: 'Estado de verificación', className: 'all text-center' },
        { targets: 7, title: 'Editar', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },
        { targets: 9, title: 'Correo', className: 'all text-center' },
        { targets: 10, title: 'Activo', className: 'all text-center' }
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
    var data = row.data(); 


    ID_FORMULARIO_SOLICITUDES = row.data().ID_FORMULARIO_SOLICITUDES;

    $(".observacionesdiv").empty();
    obtenerObservaciones(row);

    editarDatoTabla(row.data(), 'formularioSOLICITUDES', 'miModal_SOLICITUDES', 1);
    $('#miModal_SOLICITUDES .modal-title').html(row.data().NOMBRE_COMERCIAL_SOLICITUD);

    const servicioTercero = Number(row.data().SERVICIO_TERCERO);
    if (servicioTercero === 1) {
        document.getElementById('empresaDatos').style.display = 'block';
        document.getElementById('servicioParaTercero').checked = true;
    } else {
        document.getElementById('empresaDatos').style.display = 'none';
        document.getElementById('servicioPropio').checked = true;
    }

   


    const rfcEditado = row.data().RFC_SOLICITUD || '';

        // Limpiar antes de cargar nuevos datos
        const selectorDireccion = document.getElementById('SELECTOR_DIRECCION');
        selectorDireccion.innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';

        const selectorContacto = document.getElementById('SELECTOR_CONTACTO');
        selectorContacto.innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';

        window.contactosGuardados = []; // Limpiar contactos previos

        if (rfcEditado !== '') {
            fetch(`/buscarCliente?rfc=${encodeURIComponent(rfcEditado)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Llenar selector de direcciones
                        if (data.data.DIRECCIONES && data.data.DIRECCIONES.length > 0) {
                            data.data.DIRECCIONES.forEach((direccion) => {
                                const option = document.createElement('option');
                                option.value = direccion.direccion;
                                option.text = `${direccion.tipo}: ${direccion.direccion}`;
                                selectorDireccion.appendChild(option);
                            });
                        }

                        // Llenar selector de contactos
                        if (data.data.CONTACTOS && data.data.CONTACTOS.length > 0) {
                            data.data.CONTACTOS.forEach((contacto, index) => {
                                const option = document.createElement('option');
                                option.value = index;
                                option.text = contacto.CONTACTO_SOLICITUD;
                                selectorContacto.appendChild(option);
                            });

                            window.contactosGuardados = data.data.CONTACTOS;
                        }
                    } else {
                        // Si no encontró, ya están vacíos desde antes
                        console.warn('Cliente no encontrado al editar');
                    }
                })
                .catch(error => {
                    console.error('Error al buscar el cliente:', error);
                });
        }

            
    

    
     if (row.data().CODIGO_POSTAL) {
        fetch(`/codigo-postal/${row.data().CODIGO_POSTAL}`)
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
    $(".observacionesdiv").empty();
    obtenerObservaciones(row);

    editarDatoTabla(row.data(), 'formularioSOLICITUDES', 'miModal_SOLICITUDES', 1);
    $('#miModal_SOLICITUDES .modal-title').html(row.data().NOMBRE_COMERCIAL_SOLICITUD);

  

    const servicioTercero = Number(row.data().SERVICIO_TERCERO);
    if (servicioTercero === 1) {
        document.getElementById('empresaDatos').style.display = 'block';
        document.getElementById('servicioParaTercero').checked = true;
    } else {
        document.getElementById('empresaDatos').style.display = 'none';
        document.getElementById('servicioPropio').checked = true;
    }


     if (row.data().CODIGO_POSTAL) {
        fetch(`/codigo-postal/${row.data().CODIGO_POSTAL}`)
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




function limpiarCamposOferta() {
    const fields = [
        'CONTACTO_OFERTA', 'CARGO_OFERTA', 'TELEFONO_OFERTA',
        'EXTENSION_OFERTA', 'CELULAR_OFERTA', 'CORREO_OFERTA'
    ];

    fields.forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        field.value = '';
        field.disabled = true;
    });
}



function actualizarOpcionesContacto() {
    const seleccionContacto = document.getElementById('seleccionContacto');
    seleccionContacto.innerHTML = '<option value="">Seleccione un contacto</option>';

    const contactos = document.querySelectorAll('.generarcontacto');
    contactos.forEach((contacto, index) => {
        const nombreInput = contacto.querySelector('input[name="CONTACTO_SOLICITUD"]');
        const nombre = nombreInput ? nombreInput.value : `Contacto ${index + 1}`;

        const option = document.createElement('option');
        option.value = index;
        option.textContent = nombre;
        seleccionContacto.appendChild(option);
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













document.addEventListener("input", function (event) {
    if (event.target.matches("input[name='CODIGO_POSTAL_DOMICILIO']")) {
        let codigoPostalInput = event.target;
        let codigoPostal = codigoPostalInput.value.trim();

        if (codigoPostal.length === 5) {
            fetch(`/codigo-postal/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;
                        
                        let contenedor = codigoPostalInput.closest(".generardireccion");

                        let coloniaSelect = contenedor.querySelector("select[name='NOMBRE_COLONIA_DOMICILIO']");
                        let municipioInput = contenedor.querySelector("input[name='NOMBRE_MUNICIPIO_DOMICILIO']");
                        let entidadInput = contenedor.querySelector("input[name='NOMBRE_ENTIDAD_DOMICILIO']");

                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        municipioInput.value = response.municipio || "No disponible";
                        entidadInput.value = response.estado || "No disponible";

                    } else {
                        alert("Código postal no encontrado");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                    alert("Hubo un error al consultar la API.");
                });
        }
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








$(document).ready(function() {
    $("#SOLICITAR_VERIFICACION").click(function() {
        var idFormulario = ID_FORMULARIO_SOLICITUDES; 

        if (idFormulario > 0) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Se solicitará la verificación de esta solicitud.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, solicitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'actualizarSolicitud', 
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), 
                            ID_FORMULARIO_SOLICITUDES: idFormulario,
                            SOLICITAR_VERIFICACION: 1
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Verificación solicitada',
                                    text: 'Se ha actualizado el estado correctamente',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                $('#miModal_SOLICITUDES').modal('hide');

                                Tablasolicitudes.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo actualizar el estado'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema en la actualización'
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se ha encontrado un formulario válido'
            });
        }
    });
});


$(document).ready(function() {
    $("input[name='PROCEDE_COTIZAR']").change(function() {
        if ($("#procedeno").is(":checked")) {
            
        } else {
            $("textarea[name='MOTIVO_COTIZACION']").val(''); 
        }
    });
});





document.addEventListener('DOMContentLoaded', function() {
    const rfcInput = document.getElementById('RFC_SOLICITUD');

    rfcInput.addEventListener('blur', function() {
        const rfc = rfcInput.value.trim();

        if (rfc !== '') {
            fetch(`/buscarCliente?rfc=${encodeURIComponent(rfc)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('RAZON_SOCIAL_SOLICITUD').value = data.data.RAZON_SOCIAL_CLIENTE || '';
                        document.getElementById('NOMBRE_COMERCIAL_SOLICITUD').value = data.data.NOMBRE_COMERCIAL_CLIENTE || '';
                        document.getElementById('REPRESENTANTE_LEGAL_SOLICITUD').value = data.data.REPRESENTANTE_LEGAL_CLIENTE || '';

                        const giroSelect = document.getElementById('GIRO_EMPRESA_SOLICITUD');
                        if (giroSelect) {
                            const option = giroSelect.querySelector(`option[value="${data.data.GIRO_EMPRESA_CLIENTE}"]`);
                            if (option) {
                                giroSelect.value = data.data.GIRO_EMPRESA_CLIENTE;
                            } else {
                                giroSelect.value = '0';
                            }
                        }

                        // Llenar selector de direcciones
                        const selectorDireccion = document.getElementById('SELECTOR_DIRECCION');
                        selectorDireccion.innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';
                        if (data.data.DIRECCIONES && data.data.DIRECCIONES.length > 0) {
                            data.data.DIRECCIONES.forEach((direccion) => {
                                const option = document.createElement('option');
                                option.value = direccion.direccion;
                                option.text = `${direccion.tipo}: ${direccion.direccion}`;
                                selectorDireccion.appendChild(option);
                            });
                        }

                        // Llenar selector de contactos
                        const selectorContacto = document.getElementById('SELECTOR_CONTACTO');
                        selectorContacto.innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';
                        if (data.data.CONTACTOS && data.data.CONTACTOS.length > 0) {
                            data.data.CONTACTOS.forEach((contacto, index) => {
                                const option = document.createElement('option');
                                option.value = index; // Guardamos el índice
                                option.text = contacto.CONTACTO_SOLICITUD;
                                selectorContacto.appendChild(option);
                            });

                            // Guardar contactos en memoria para acceso rápido
                            window.contactosGuardados = data.data.CONTACTOS;
                        }

                    } else {
                        limpiarCampos();
                        alert('Cliente no encontrado');
                    }
                })
                .catch(error => {
                    console.error('Error al buscar el cliente:', error);
                });
        }
    });

    const selectorDireccion = document.getElementById('SELECTOR_DIRECCION');
    selectorDireccion.addEventListener('change', function() {
        document.getElementById('DIRECCION_SOLICITUDES').value = selectorDireccion.value;
    });

    const selectorContacto = document.getElementById('SELECTOR_CONTACTO');
    selectorContacto.addEventListener('change', function() {
        const selectedIndex = selectorContacto.value;
        const contacto = window.contactosGuardados[selectedIndex];

        if (contacto) {
            document.getElementById('TITULO_CONTACTO_SOLICITUD').value = contacto.TITULO_CONTACTO_SOLICITUD || '';
            document.getElementById('CONTACTO_SOLICITUD').value = contacto.CONTACTO_SOLICITUD || '';
            document.getElementById('CARGO_SOLICITUD').value = contacto.CARGO_SOLICITUD || '';
            document.getElementById('TELEFONO_SOLICITUD').value = contacto.TELEFONO_SOLICITUD || '';
            document.getElementById('EXTENSION_SOLICITUD').value = contacto.EXTENSION_SOLICITUD || '';
            document.getElementById('CELULAR_SOLICITUD').value = contacto.CELULAR_SOLICITUD || '';
            document.getElementById('CORREO_SOLICITUD').value = contacto.CORREO_SOLICITUD || '';
        }
    });

    function limpiarCampos() {
        document.getElementById('RAZON_SOCIAL_SOLICITUD').value = '';
        document.getElementById('NOMBRE_COMERCIAL_SOLICITUD').value = '';
        document.getElementById('REPRESENTANTE_LEGAL_SOLICITUD').value = '';
        document.getElementById('GIRO_EMPRESA_SOLICITUD').value = '0';
        document.getElementById('SELECTOR_DIRECCION').innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';
        document.getElementById('DIRECCION_SOLICITUDES').value = '';
        document.getElementById('SELECTOR_CONTACTO').innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';
        window.contactosGuardados = [];
    }
});