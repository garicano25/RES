ID_FORMULARIO_OFERTAS = 0

let ofertaNueva = false;

const ModalDesvinculacion = document.getElementById('miModal_OFERTAS');
ModalDesvinculacion.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_OFERTAS = 0;

    document.getElementById('formularioOFERTAS').reset();
    $('#miModal_OFERTAS .modal-title').html('Ofertas/Cotizaciones');

    $('#RECHAZO').hide(); 
    $('#ACEPTADA').hide();

    var selectize = $('#SOLICITUD_ID')[0].selectize;

    selectize.clear();


    document.getElementById("TIEMPO_OFERTA").value = ""; 
        ofertaNueva = false;

});



const Modallinea = document.getElementById('modalMotivoRevision') 
Modallinea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_OFERTAS = 0
    document.getElementById('motivoRevisionInput').value = '';
   

})





$(document).ready(function () {
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


        $('#RECHAZO').hide(); 
        $('#ACEPTADA').hide();  

        document.getElementById('formularioOFERTAS').reset();

        $(".observacionesdiv").empty();

    document.getElementById('crearREVISION').style.display = 'none';

        
        ofertaNueva = true;
    });
});



$("#guardarOFERTA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioOFERTAS');

    if (formularioValido) {
        

        var observacion = [];
        $(".generarobervaciones").each(function() {
            var observaciones = {
                'OBSERVACIONES': $(this).find("textarea[name='OBSERVACIONES']").val()
            };
            observacion.push(observaciones);
        });

        

    
        const requestData = {
            api: 1,
            ID_FORMULARIO_OFERTAS: ID_FORMULARIO_OFERTAS,
            OBSERVACIONES_OFERTA: JSON.stringify(observacion)


        };

        if (ID_FORMULARIO_OFERTAS == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarOFERTA');
                await ajaxAwaitFormData(requestData, 'ofertaSave', 'formularioOFERTAS', 'guardarOFERTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    
                    ID_FORMULARIO_OFERTAS = data.oferta.ID_FORMULARIO_OFERTAS
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                        $('#miModal_OFERTAS').modal('hide')
                        document.getElementById('formularioOFERTAS').reset();
                    Tablaofertas.ajax.reload()
                    $('#NO_SOLICITUD')[0].selectize.clear();

    
    
                })
                
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarOFERTA');
                await ajaxAwaitFormData(requestData, 'ofertaSave', 'formularioOFERTAS', 'guardarOFERTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

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
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});











// var Tablaofertas = $("#Tablaofertas").DataTable({
//     language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
//     lengthChange: true,
//     lengthMenu: [
//         [10, 25, 50, -1],
//         [10, 25, 50, 'All']
//     ],
//     info: false,
//     paging: true,
//     searching: true,
//     filtering: true,
//     scrollY: '65vh',
//     scrollCollapse: true,
//     responsive: true,
//     ajax: {
//         dataType: 'json',
//         data: {},
//         method: 'GET',
//         cache: false,
//         url: '/Tablaofertas',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             Tablaofertas.columns.adjust().draw();
//             ocultarCarga();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     order: [[0, 'asc']], 
//     columns: [
//         { 
//             data: null,
//             render: function(data, type, row, meta) {
//                 return meta.row + 1; 
//             }
//         },
//         { data: 'REVISION_OFERTA' },

//         {
//             data: null,
//             render: function(data, type, row) {
//                 return `${row.NO_SOLICITUD} - ${row.NOMBRE_COMERCIAL_SOLICITUD}`;
//             }
//         },
//         { data: 'NO_OFERTA' },

//         { 
//             data: 'FECHA_OFERTA',
//             render: function(data, type, row) {
//                 let diasRestantes = calcularDiasRestantes(row.FECHA_OFERTA, row.DIAS_VALIDACION_OFERTA);
//                 return `${row.FECHA_OFERTA} <span style="font-weight:bold;">(${diasRestantes})</span>`;
//             }
//         },

//         { 
//             data: 'ESTATUS_OFERTA',
//             render: function(data, type, row) {
//                 const colors = {
//                     'Aceptada': 'background-color: green; color: white;',
//                     'Revisión': 'background-color: orange; color: white;',
//                     'Rechazada': 'background-color: red; color: white;'
//                 };

//                 const isDisabled = (data === 'Aceptada' || data === 'Rechazada') ? 'disabled' : '';

//                 return `
//                     <select class="form-select ESTATUS_OFERTA" 
//                             data-id="${row.ID_FORMULARIO_OFERTAS}" 
//                             style="${colors[data] || ''}" ${isDisabled}>
//                         <option value="" ${!data ? 'selected' : ''} disabled style="background-color: white; color: black;">Seleccione una opción</option>
//                         <option value="Aceptada" ${data === 'Aceptada' ? 'selected' : ''} style="background-color: green; color: white;">Aceptada</option>
//                         <option value="Revisión" ${data === 'Revisión' ? 'selected' : ''} style="background-color: orange; color: white;">Revisión</option>
//                         <option value="Rechazada" ${data === 'Rechazada' ? 'selected' : ''} style="background-color: red; color: white;">Rechazada</option>
//                     </select>
//                     <textarea class="form-control MOTIVO_RECHAZO d-none" placeholder="Motivo de rechazo..." data-id="${row.ID_FORMULARIO_OFERTAS}" ${isDisabled}>${row.MOTIVO_RECHAZO || ''}</textarea>
//                 `;
//             }
//         },
//         { data: 'BTN_DOCUMENTO', className: 'text-center' },
//         { data: 'BTN_EDITAR' },
//         { data: 'BTN_VISUALIZAR' },
//         { data: 'BTN_ELIMINAR' }
//     ],
//     columnDefs: [
//         { targets: 0, title: '#', className: 'all text-center' },
//         { targets: 1, title: 'Versión', className: 'all text-center nombre-column' },
//         { targets: 2, title: 'N° de solicitud', className: 'all text-center nombre-column' },
//         { targets: 3, title: 'N° de Oferta/Cotización', className: 'all text-center nombre-column' },
//         { targets: 4, title: 'Fecha (Días Restantes)', className: 'all text-center nombre-column' }, 
//         { targets: 5, title: 'Estatus de la oferta', className: 'all text-center nombre-column' },
//         { targets: 6, title: 'Cotización', className: 'all text-center nombre-column' },
//         { targets: 7, title: 'Editar', className: 'all text-center' },
//         { targets: 8, title: 'Visualizar', className: 'all text-center' },
//         { targets: 9, title: 'Activo', className: 'all text-center' }
//     ]
// });




var Tablaofertas = $("#Tablaofertas").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
    info: false,
    paging: true,
    searching: true,
    scrollY: '65vh',
    scrollCollapse: true,
    responsive: true,
    ajax: {
        dataType: 'json',
        method: 'GET',
        url: '/Tablaofertas',
        beforeSend: function () { mostrarCarga(); },
        complete: function () { Tablaofertas.columns.adjust().draw(); ocultarCarga(); },
        error: function (jqXHR, textStatus, errorThrown) { alertErrorAJAX(jqXHR, textStatus, errorThrown); },
        dataSrc: 'data'
    },
    order: [[1, 'asc']],
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
        { data: 'REVISION_OFERTA' },
        { data: null, render: function(data, type, row) { return `${row.NO_SOLICITUD} - ${row.NOMBRE_COMERCIAL_SOLICITUD}`; } },
        { 
            data: 'NO_OFERTA',
            render: function(data, type, row) {
                return `<button class="btn btn-link ver-revisiones" data-revisiones='${JSON.stringify(row.REVISIONES || [])}'>${data}</button>`;
            }
        },
        {
            data: 'FECHA_OFERTA',
            render: function(data, type, row) {
                let diasRestantes = calcularDiasRestantes(row.FECHA_OFERTA, row.DIAS_VALIDACION_OFERTA);
                return `${row.FECHA_OFERTA} <span style="font-weight:bold;">(${diasRestantes})</span>`;
            }
        },
          
        { 
            data: 'ESTATUS_OFERTA',
            render: function(data, type, row) {
                const colors = { 'Aceptada': 'background-color: green; color: white;', 'Revisión': 'background-color: orange; color: white;', 'Rechazada': 'background-color: red; color: white;' };
                const isDisabled = (data === 'Aceptada' || data === 'Rechazada') ? 'disabled' : '';
                return `<select class="form-select ESTATUS_OFERTA" data-id="${row.ID_FORMULARIO_OFERTAS}" style="${colors[data] || ''}" ${isDisabled}>
                        <option value="Aceptada" ${data === 'Aceptada' ? 'selected' : ''}>Aceptada</option>
                        <option value="Revisión" ${data === 'Revisión' ? 'selected' : ''}>Revisión</option>
                        <option value="Rechazada" ${data === 'Rechazada' ? 'selected' : ''}>Rechazada</option>
                    </select>`;
            }
        },
        { data: 'MOTIVO_REVISION_OFERTA' },
        { data: 'BTN_DOCUMENTO', className: 'text-center' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'text-center' },
        { targets: 1, title: 'Versión', className: 'text-center' },
        { targets: 2, title: 'N° de solicitud', className: 'text-center' },
        { targets: 3, title: 'N° de Oferta/Cotización', className: 'text-center' },
        { targets: 4, title: 'Fecha', className: 'text-center' },
        { targets: 5, title: 'Estatus de la oferta', className: 'text-center' },
        { targets: 6, title: 'Motivo de la revisión', className: 'text-center' },
        { targets: 7, title: 'Cotización', className: 'text-center' },
        { targets: 8, title: 'Editar', className: 'text-center' },
        { targets: 9, title: 'Visualizar', className: 'text-center' },
        { targets: 10, title: 'Activo', className: 'text-center' }
    ]
});

$("#Tablaofertas tbody").on("click", ".ver-revisiones", function () {
    let btn = $(this);
    let tr = btn.closest("tr");
    let row = Tablaofertas.row(tr);
    let revisiones = btn.data("revisiones");

    if (!revisiones.length) {
        alertToast("No hay revisiones anteriores para esta oferta.", "warning", 3000);
        return;
    }

    // Si la fila ya está expandida, la contraemos
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass("shown");
        btn.removeClass("opened");
    } else {
        btn.addClass("opened");

        // Construcción de la tabla de revisiones dentro de la misma DataTable
        let revisionesHtml = `<table class="table table-sm table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Versión</th>
                                        <th>N° de Solicitud</th>
                                        <th>N° de Oferta</th>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                         <th>Motivo de la revisión</th>
                                        <th>Documento</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>`;

        revisiones.forEach((rev) => {
            revisionesHtml += `<tr class="bg-light">
                                    <td>${rev.REVISION_OFERTA}</td>
                                    <td>${rev.NO_SOLICITUD} - ${rev.NOMBRE_COMERCIAL_SOLICITUD}</td>
                                    <td>${rev.NO_OFERTA}</td>
                                    <td>${rev.FECHA_OFERTA}</td>
                                    <td><span class="badge bg-secondary">${rev.ESTATUS_OFERTA}</span></td>
                                    <td>${rev.MOTIVO_REVISION_OFERTA}</td>
                                    <td>${rev.BTN_DOCUMENTO}</td>

                                    <td>
                                        <button class="btn btn-primary btn-sm EDITAR" 
                                            data-id="${rev.ID_FORMULARIO_OFERTAS}"
                                            data-revision='${JSON.stringify(rev)}'>
                                            <i class="bi bi-pencil-square"></i> Visualizar
                                        </button>
                                    </td>
                                </tr>`;
        });

        revisionesHtml += `</tbody></table>`;

        row.child(revisionesHtml).show();
        tr.addClass("shown");
    }
});











$('#Tablaofertas').on('click', '.ver-archivo-cotizacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablaofertas.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = 'Cotización';
    var url = '/mostrarcotizacion/' + id;
    
    abrirModal(url, nombreDocumento);
});




function calcularDiasRestantes(fechaOferta, diasValidacion) {
    if (!fechaOferta || !diasValidacion) return "N/A";

    let fechaInicio = new Date(fechaOferta);
    
    let fechaVencimiento = new Date(fechaInicio);
    fechaVencimiento.setDate(fechaVencimiento.getDate() + parseInt(diasValidacion));

    let hoy = new Date();

    let diasTotales = Math.ceil((fechaVencimiento - fechaInicio) / (1000 * 60 * 60 * 24));
    let diasTranscurridos = diasTotales - Math.ceil((fechaVencimiento - hoy) / (1000 * 60 * 60 * 24));
    
    diasTranscurridos = Math.max(diasTranscurridos, 0);
    let porcentaje = (diasTranscurridos / diasTotales) * 100;

    let color = "green"; 
    if (porcentaje >= 60 && porcentaje < 80) {
        color = "orange"; 
    } else if (porcentaje >= 80) {
        color = "red"; 
    }

    // Si ya ha vencido
    if (hoy >= fechaVencimiento) {
        return `<span style="color: red; font-weight: bold;">Expirado</span>`;
    }

    let diasRestantes = Math.ceil((fechaVencimiento - hoy) / (1000 * 60 * 60 * 24));

    return `<span style="color: ${color}; font-weight: bold;">${diasRestantes} días</span>`;
}








// $('#Tablaofertas tbody').on('click', 'td>button.EDITAR', function () {
//     var tr = $(this).closest('tr');
//     var row = Tablaofertas.row(tr);

//     ID_FORMULARIO_OFERTAS = row.data().ID_FORMULARIO_OFERTAS;

//     editarDatoTabla(row.data(), 'formularioOFERTAS', 'miModal_OFERTAS', 1);

//     var selectize = $('#SOLICITUD_ID')[0].selectize;
//     selectize.clear(); 

//     var solicitudSeleccionado = row.data().SOLICITUD_ID;

//     if (solicitudSeleccionado) {
//         selectize.addOption({
//             value: solicitudSeleccionado,
//             text: `${row.data().NO_SOLICITUD} (${row.data().NOMBRE_COMERCIAL_SOLICITUD})`
//         });
//         selectize.setValue(solicitudSeleccionado); 
//     }

//     if (row.data().SOLICITUDES && row.data().SOLICITUDES.length > 0) {
//         row.data().SOLICITUDES.forEach(solicitud => {
//             if (solicitud.ID_FORMULARIO_SOLICITUDES !== solicitudSeleccionado) {
//                 selectize.addOption({
//                     value: solicitud.ID_FORMULARIO_SOLICITUDES,
//                     text: `${solicitud.NO_SOLICITUD} (${solicitud.NOMBRE_COMERCIAL_SOLICITUD})`
//                 });
//             }
//         });
//     }

//     selectize.refreshOptions(false); 

//     $(".observacionesdiv").empty();
//     obtenerObservaciones(row);

//     $('#miModal_OFERTAS .modal-title').html(row.data().NO_OFERTA);

//     var estatus = row.data().ESTATUS_OFERTA;
//     if (estatus === 'Aceptada') {
//         $('#ACEPTADA').show();
//         $('#RECHAZO').hide();
//     } else if (estatus === 'Rechazada') {
//         $('#RECHAZO').show();
//         $('#ACEPTADA').hide();
//     } else {
//         $('#ACEPTADA').hide();
//         $('#RECHAZO').hide();
//     }

//     $("#miModal_OFERTAS").modal("show");
// });


$('#Tablaofertas tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaofertas.row(tr);

    // Verifica si el botón de editar está en la tabla principal o en una revisión
    var rowData;
    if (row.data()) {
        // Es una fila de la tabla principal
        rowData = row.data();
    } else {
        // Es una revisión dentro de `row.child()`, obtenemos los datos de `data-revision`
        rowData = JSON.parse($(this).attr('data-revision'));
    }

    ID_FORMULARIO_OFERTAS = rowData.ID_FORMULARIO_OFERTAS;

    editarDatoTabla(rowData, 'formularioOFERTAS', 'miModal_OFERTAS', 1);

    var selectize = $('#SOLICITUD_ID')[0].selectize;
    selectize.clear(); 

    var solicitudSeleccionado = rowData.SOLICITUD_ID;

    if (solicitudSeleccionado) {
        selectize.addOption({
            value: solicitudSeleccionado,
            text: `${rowData.NO_SOLICITUD} (${rowData.NOMBRE_COMERCIAL_SOLICITUD})`
        });
        selectize.setValue(solicitudSeleccionado); 
    }

    if (rowData.SOLICITUDES && rowData.SOLICITUDES.length > 0) {
        rowData.SOLICITUDES.forEach(solicitud => {
            if (solicitud.ID_FORMULARIO_SOLICITUDES !== solicitudSeleccionado) {
                selectize.addOption({
                    value: solicitud.ID_FORMULARIO_SOLICITUDES,
                    text: `${solicitud.NO_SOLICITUD} (${solicitud.NOMBRE_COMERCIAL_SOLICITUD})`
                });
            }
        });
    }

    selectize.refreshOptions(false); 

    $(".observacionesdiv").empty();
    obtenerObservaciones(rowData);

    $('#miModal_OFERTAS .modal-title').html(rowData.NO_OFERTA);

    var estatus = rowData.ESTATUS_OFERTA;
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






$(document).ready(function() {
    $('#Tablaofertas tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaofertas.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_OFERTAS');

      


         ID_FORMULARIO_OFERTAS = row.data().ID_FORMULARIO_OFERTAS;

    editarDatoTabla(row.data(), 'formularioOFERTAS', 'miModal_OFERTAS', 1);

    var selectize = $('#SOLICITUD_ID')[0].selectize;
    selectize.clear();

    var solicitudSeleccionado = row.data().SOLICITUD_ID;

    if (solicitudSeleccionado) {
        selectize.addOption({
            value: solicitudSeleccionado,
            text: `${row.data().NO_SOLICITUD} (${row.data().NOMBRE_COMERCIAL_SOLICITUD})`
        });
        selectize.setValue(solicitudSeleccionado); 
    }

    if (row.data().SOLICITUDES && row.data().SOLICITUDES.length > 0) {
        row.data().SOLICITUDES.forEach(solicitud => {
            if (solicitud.ID_FORMULARIO_SOLICITUDES !== solicitudSeleccionado) {
                selectize.addOption({
                    value: solicitud.ID_FORMULARIO_SOLICITUDES,
                    text: `${solicitud.NO_SOLICITUD} (${solicitud.NOMBRE_COMERCIAL_SOLICITUD})`
                });
            }
        });
    }

    selectize.refreshOptions(false); 

    $(".observacionesdiv").empty();
    obtenerObservaciones(row);

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
        

        
    });

    $('#miModal_OFERTAS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_OFERTAS');
    });
});





$('#Tablaofertas tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaofertas.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_OFERTAS: row.data().ID_FORMULARIO_OFERTAS
    };

    eliminarDatoTabla(data, [Tablaofertas], 'ofertaDelete');
});



$('#Tablaofertas tbody').on('change', '.ESTATUS_OFERTA', function () {
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
                            Swal.fire(
                                'Actualizado',
                                'El estatus y el motivo fueron actualizados correctamente.',
                                'success'
                            ).then(() => {
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
                    url: '/actualizarEstatusOferta',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ID_FORMULARIO_OFERTAS: solicitudId,
                        ESTATUS_OFERTA: selectedValue,
                        MOTIVO_RECHAZO: null 
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Actualizado',
                                'El estatus fue actualizado correctamente.',
                                'success'
                            ).then(() => {
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
    let row = data.data().OBSERVACIONES_OFERTA;
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
    document.querySelectorAll(".botonEliminarArchivo").forEach(boton => {
        boton.addEventListener("click", function () {
            const inputArchivo = this.previousElementSibling;
            if (inputArchivo && inputArchivo.type === "file") {
                inputArchivo.value = ""; 
            }
        });
    });
});




function parseFecha(fechaStr) {
    if (!fechaStr) return null;
    let fechaLimpia = fechaStr.split(" ")[0]; 
    let partes = fechaLimpia.split("-");
    if (partes.length === 3) {
        return new Date(partes[0], partes[1] - 1, partes[2]); 
    }
    return null;
}

function calcularDias() {
    if (!ofertaNueva) return; 

    const fechaOfertaInput = document.getElementById("FECHA_OFERTA");
    const tiempoOfertaInput = document.getElementById("TIEMPO_OFERTA");
    const solicitudSelect = document.getElementById("SOLICITUD_ID");

    const fechaOferta = fechaOfertaInput.value.trim();
    const solicitudId = solicitudSelect.value; 

    if (!solicitudId || !fechaOferta) {
        tiempoOfertaInput.value = "";
        return;
    }

    const fechaSolicitud = solicitudesFechas[solicitudId];

    if (!fechaSolicitud) {
        tiempoOfertaInput.value = "";
        return;
    }

    const fechaSolicitudDate = parseFecha(fechaSolicitud);
    const fechaOfertaDate = parseFecha(fechaOferta);

    if (fechaSolicitudDate && fechaOfertaDate) {
        const diferenciaTiempo = fechaOfertaDate - fechaSolicitudDate;
        const diasDiferencia = Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
        tiempoOfertaInput.value = diasDiferencia >= 0 ? diasDiferencia : 0;
    } else {
        tiempoOfertaInput.value = "";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const fechaOfertaInput = document.getElementById("FECHA_OFERTA");
    const solicitudSelect = document.getElementById("SOLICITUD_ID");

    fechaOfertaInput.addEventListener("change", function () {
        if (ofertaNueva) calcularDias();
    });

    solicitudSelect.addEventListener("change", function () {
        if (ofertaNueva) calcularDias();
    });
});

$(document).ready(function () {
    $(".mydatepicker")
        .datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        })
        .on("changeDate", function () {
            if (ofertaNueva) calcularDias();
        });
});



$("#crearREVISION").click(function (e) {
    e.preventDefault();

    // Validar si el formulario está completo antes de continuar
    formularioValido = validarFormularioV1('formularioOFERTAS');

    if (formularioValido) {
        // Mostrar el modal para ingresar el motivo de la revisión
        $("#modalMotivoRevision").modal("show");
    } else {
        Swal.fire("Error", "Por favor, complete todos los campos del formulario.", "error");
    }
});

// Cuando el usuario confirme el motivo en el modal
$("#confirmarMotivoRevision").click(function () {
    let motivoRevision = $("#motivoRevisionInput").val().trim();

    if (motivoRevision === "") {
        Swal.fire("Error", "El motivo de la revisión es obligatorio.", "error");
        return;
    }

    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: 'ofertaSave', // Ruta del backend
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            api: 2, // API para crear revisiones
            ID_FORMULARIO_OFERTAS: ID_FORMULARIO_OFERTAS,
            MOTIVO_REVISION_OFERTA: motivoRevision, // 🔥 Se envía el motivo
            _token: csrfToken // 🔥 Agregar CSRF Token
        },
        beforeSend: function () {
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento',
                text: 'Estamos creando la revisión...',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        },
        success: function (response) {
            if (response.code === 1) {
                ID_FORMULARIO_OFERTAS = response.oferta.ID_FORMULARIO_OFERTAS;

                // Cerrar los modales
                $("#modalMotivoRevision").modal("hide");
                $("#miModal_OFERTAS").modal("hide");

                // Mostrar alerta de éxito
                Swal.fire(
                    "Revisión Creada",
                    "Se ha generado una nueva versión de la oferta.",
                    "success"
                ).then(() => {
                    Tablaofertas.ajax.reload(); // Recargar la tabla después de éxito
                });

            } else {
                Swal.fire("Error", "Error al crear la revisión.", "error");
            }
        },
        error: function () {
            Swal.fire("Error", "Ocurrió un error en la petición AJAX.", "error");
        }
    });
});

