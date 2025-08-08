


ID_FORMULARIO_PO = 0


var Tablaordencompra = $("#Tablaordencompra").DataTable({
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
        url: '/Tablaordencompra',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaordencompra.columns.adjust().draw();
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
        // { data: 'NO_PO' },
        {
            data: 'NO_PO',
            render: function (data, type, row) {
                return `<button class="btn btn-link ver-revisiones-po" data-revisiones='${JSON.stringify(row.REVISIONES || [])}'>${data}</button>`;
            }
        },     
        { data: 'FECHA_EMISION' },
        { data: 'PROVEEDORES' },
        { data: 'NO_MR' },
        {
            data: 'MOTIVO_REVISION_PO',
            render: function (data, type, row) {
                return data && data.trim() !== '' ? data : 'Revisión inicial';
            }
        },
        { data: 'ESTADO_BADGE' }, 
        { data: 'DESCARGA_PO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° PO', className: 'all text-center' },
        { targets: 2, title: 'Fecha PO', className: 'all text-center' },
        { targets: 3, title: 'Proveedor', className: 'all text-center' },
        { targets: 4, title: 'N° MR', className: 'all text-center' },
        { targets: 5, title: 'Motivo de la revisión', className: 'text-center' },
        { targets: 6, title: 'Estado', className: 'all text-center' }, 
        { targets: 7, title: 'Descargar PO', className: 'all text-center' },
        { targets: 8, title: 'Editar', className: 'all text-center' },
        { targets: 9, title: 'Visualizar', className: 'all text-center' },

    ]
});



$("#Tablaordencompra tbody").on("click", ".ver-revisiones-po", function () {
    let btn = $(this);
    let tr = btn.closest("tr");
    let row = Tablaordencompra.row(tr);
    let revisiones = btn.data("revisiones");

    if (!revisiones.length) {
        alertToast("No hay revisiones anteriores para esta orden de compra.", "warning", 3000);
        return;
    }

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass("shown");
        btn.removeClass("opened");
    } else {
        btn.addClass("opened");

        let html = `<table class="table table-sm table-bordered w-100 mb-0">
                        <thead>
                            <tr>
                                <th>Versión</th>
                                <th>N° PO</th>
                                <th>N° MR</th>
                                <th>Motivo de la revisión</th>
                                <th>Visualizar</th>
                            </tr>
                        </thead>
                        <tbody>`;

        revisiones.forEach(rev => {
            html += `<tr class="bg-light">
                        <td>${rev.REVISION_PO || '0'}</td>
                        <td>${rev.NO_PO}</td>
                        <td>${rev.NO_MR}</td>

                          <td>${rev.MOTIVO_REVISION_PO  || 'Revisión inicial' }</td>
                      <td>
                        <button class="btn btn-primary btn-sm EDITAR" 
                            data-id="${rev.ID_FORMULARIO_PO}"
                            data-revision='${JSON.stringify(rev)}'>
                            <i class="bi bi-pencil-square"></i> Visualizar
                        </button>
                    </td>
                    </tr>`;
        });

        html += `</tbody></table>`;

        row.child(html).show();
        tr.addClass("shown");
    }
});





$("#guardarPO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioPO'))

    if (formularioValido) {

        var servicios = [];
        $(".material-item").each(function() {
            var servicio = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD_': $(this).find("input[name='CANTIDAD_']").val(),
                'PRECIO_UNITARIO': $(this).find("input[name='PRECIO_UNITARIO']").val()
               
            };
            servicios.push(servicio);
        });

        const requestData = {
                api: 1,
                ID_FORMULARIO_PO: ID_FORMULARIO_PO,
                MATERIALES_JSON: JSON.stringify(servicios)


            };

        if (ID_FORMULARIO_PO == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podra usar",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarPO')
                await ajaxAwaitFormData( requestData, 'PoSave', 'formularioPO', 'guardarPO', { callbackAfter: true, callbackBefore: true }, () => {
            
                

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        

                    ID_FORMULARIO_PO = data.compra.ID_FORMULARIO_PO
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                        $('#miModal_PO').modal('hide')
                        document.getElementById('formularioPO').reset();
                        Tablaordencompra.ajax.reload()

            
                })
                
                
                
            }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarPO')
            await ajaxAwaitFormData(requestData, 'PoSave', 'formularioPO', 'guardarPO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_PO = data.compra.ID_FORMULARIO_PO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_PO').modal('hide')
                    document.getElementById('formularioPO').reset();
                    Tablaordencompra.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





// $('#Tablaordencompra tbody').on('click', 'td>button.EDITAR', function () {
//     const tr = $(this).closest('tr');
//     const row = Tablaordencompra.row(tr);
//     const data = row.data();
//     ID_FORMULARIO_PO = data.ID_FORMULARIO_PO;


    
//     $('#NO_PO').val(data.NO_PO);
//     $('#NO_MR').val(data.NO_MR);
//     $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO);
//     $('#SUBTOTAL').val(data.SUBTOTAL);
//     $('#IVA').val(data.IVA);
//     $('#IMPORTE').val(data.IMPORTE);
//     $('#FECHA_EMISION').val(data.FECHA_EMISION);
//     $('#FECHA_ENTREGA').val(data.FECHA_ENTREGA);
//     $('#SOLICITAR_AUTORIZACION').val(data.SOLICITAR_AUTORIZACION);
//     $('#REQUIERE_COMENTARIO').val(data.REQUIERE_COMENTARIO);
//     $('#COMENTARIO_SOLICITUD').val(data.COMENTARIO_SOLICITUD);
//     $('#FECHA_APROBACION').val(data.FECHA_APROBACION);
//     $('#FECHA_SOLCITIUD').val(data.FECHA_SOLCITIUD || '');
    
//     if (data.USUARIO_ID) {
//         $.ajax({
//             url: `/obtenerNombreUsuario/${data.USUARIO_ID}`,
//             method: 'GET',
//             success: function (response) {
//                 $('#SOLICITADO_POR').val(response.nombre_completo);
//             },
//             error: function () {
//                 $('#SOLICITADO_POR').val('');
//             }
//         });
//     } else {
//         $('#SOLICITADO_POR').val('No se ha solicitado una aprobación');
//     }
    
//     if (data.APROBO_ID) {
//         $.ajax({
//             url: `/obtenerNombreUsuario/${data.APROBO_ID}`,
//             method: 'GET',
//             success: function (response) {
//                 $('#APROBADO_POR').val(response.nombre_completo);
//             },
//             error: function () {
//                 $('#APROBADO_POR').val('');
//             }
//         });
//     } else {
//         $('#APROBADO_POR').val('No se ha solicitado una aprobación');
//     }
    

//     $('#ESTADO_APROBACION').val(data.ESTADO_APROBACION || '');
//     $('#MOTIVO_RECHAZO').val(data.MOTIVO_RECHAZO || '');
//     togglerechazo();
    
//     verificarEstadoAprobacion();

//     if (data.REQUIERE_COMENTARIO === 'Sí') {
//         $('#COMENTARIO_SOLICITUD_PO').show();
//     } else {
//         $('#COMENTARIO_SOLICITUD_PO').hide();
//         }


//     const porcentaje = data.PORCENTAJE_IVA;
//     $(`input[name="PORCENTAJE_IVA"][value="${porcentaje}"]`).prop('checked', true);


//     $(".materialesdiv").empty();

//     if (data.MATERIALES_JSON) {
//         cargarMaterialesDesdeJSON(data.MATERIALES_JSON);
//     }
    
//     $('#miModal_PO').modal('show');
// });



$('#Tablaordencompra tbody').on('click', 'td>button.EDITAR', function () {
    const tr = $(this).closest('tr');
    const row = Tablaordencompra.row(tr);

    let data;

    const estado = $('#ESTADO_APROBACION').val();


    if (row.data()) {
        data = row.data();
        $('#guardarPO').show();
        $('#crearREVISION').show();

            if (estado === 'Aprobada' || estado === 'Rechazada') {
                    $('#guardarPO').hide();
                    $('#crearREVISION').show();
            } else {
                    $('#guardarPO').show();
                    $('#crearREVISION').hide();
            }

    } else {

        data = $(this).data('revision');
        
        $('#guardarPO').hide();
        $('#crearREVISION').hide();

          if (estado === 'Aprobada' || estado === 'Rechazada') {
                  $('#guardarPO').hide();
                  $('#crearREVISION').hide();
          } else {
                  $('#guardarPO').hide();
                  $('#crearREVISION').hide();
          }

    }

    ID_FORMULARIO_PO = data.ID_FORMULARIO_PO;

    $('#NO_PO').val(data.NO_PO);
    $('#NO_MR').val(data.NO_MR);
    $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO);
    $('#SUBTOTAL').val(data.SUBTOTAL);
    $('#IVA').val(data.IVA);
    $('#IMPORTE').val(data.IMPORTE);
    $('#FECHA_EMISION').val(data.FECHA_EMISION);
    $('#FECHA_ENTREGA').val(data.FECHA_ENTREGA);
    $('#SOLICITAR_AUTORIZACION').val(data.SOLICITAR_AUTORIZACION);
    $('#REQUIERE_COMENTARIO').val(data.REQUIERE_COMENTARIO);
    $('#COMENTARIO_SOLICITUD').val(data.COMENTARIO_SOLICITUD);
    $('#FECHA_APROBACION').val(data.FECHA_APROBACION);
    $('#FECHA_SOLCITIUD').val(data.FECHA_SOLCITIUD || '');
    $('#ESTADO_APROBACION').val(data.ESTADO_APROBACION || '');
    $('#MOTIVO_RECHAZO').val(data.MOTIVO_RECHAZO || '');




        


    togglerechazo();
    verificarEstadoAprobacion();

    if (data.REQUIERE_COMENTARIO === 'Sí') {
        $('#COMENTARIO_SOLICITUD_PO').show();
    } else {
        $('#COMENTARIO_SOLICITUD_PO').hide();
    }

    const porcentaje = data.PORCENTAJE_IVA;
    $(`input[name="PORCENTAJE_IVA"][value="${porcentaje}"]`).prop('checked', true);

    if (data.USUARIO_ID) {
        $.get(`/obtenerNombreUsuario/${data.USUARIO_ID}`, function (res) {
            $('#SOLICITADO_POR').val(res.nombre_completo);
        }).fail(() => $('#SOLICITADO_POR').val(''));
    } else {
        $('#SOLICITADO_POR').val('No se ha solicitado una aprobación');
    }

    if (data.APROBO_ID) {
        $.get(`/obtenerNombreUsuario/${data.APROBO_ID}`, function (res) {
            $('#APROBADO_POR').val(res.nombre_completo);
        }).fail(() => $('#APROBADO_POR').val(''));
    } else {
        $('#APROBADO_POR').val('No se ha solicitado una aprobación');
    }

    $(".materialesdiv").empty();

    if (data.MATERIALES_JSON) {
        cargarMaterialesDesdeJSON(data.MATERIALES_JSON);
    }

    $('#miModal_PO .modal-title').html(data.NO_PO);
    $('#miModal_PO').modal('show');
});



function actualizarIVAeImporte() {
    const subtotal = parseFloat($('#SUBTOTAL').val()) || 0;
    const porcentajeIVA = parseFloat($('input[name="PORCENTAJE_IVA"]:checked').val()) || 0;

    const iva = subtotal * porcentajeIVA;
    const total = subtotal + iva;

    $('#IVA').val(iva.toFixed(2));
    $('#IMPORTE').val(total.toFixed(2));
}


$('input[name="PORCENTAJE_IVA"]').on('change', function () {
    actualizarIVAeImporte();
});


$(document).ready(function() {

    $('#Tablaordencompra tbody').on('click', 'td>button.VISUALIZAR', function () {
        const tr = $(this).closest('tr');
    const row = Tablaordencompra.row(tr);
    const data = row.data();
    ID_FORMULARIO_PO = data.ID_FORMULARIO_PO;
        
    hacerSoloLectura(row.data(), '#miModal_PO');

      
        
    $('#NO_PO').val(data.NO_PO);
    $('#NO_MR').val(data.NO_MR);
    $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO);


    $('#SUBTOTAL').val(data.SUBTOTAL);
    $('#IVA').val(data.IVA);
    $('#IMPORTE').val(data.IMPORTE);

    $('#FECHA_EMISION').val(data.FECHA_EMISION);
    $('#FECHA_ENTREGA').val(data.FECHA_ENTREGA);
    $('#SOLICITAR_AUTORIZACION').val(data.SOLICITAR_AUTORIZACION);
    $('#REQUIERE_COMENTARIO').val(data.REQUIERE_COMENTARIO);
    $('#COMENTARIO_SOLICITUD').val(data.COMENTARIO_SOLICITUD);
        
    $('#FECHA_APROBACION').val(data.FECHA_APROBACION);
    $('#FECHA_SOLCITIUD').val(data.FECHA_SOLCITIUD || '');
    
        
    $('#USUARIO_ID').val(data.USUARIO_ID);


    if (data.USUARIO_ID) {
        $.ajax({
            url: `/obtenerNombreUsuario/${data.USUARIO_ID}`,
            method: 'GET',
            success: function (response) {
                $('#SOLICITADO_POR').val(response.nombre_completo);
            },
            error: function () {
                $('#SOLICITADO_POR').val('');
            }
        });
    } else {
        $('#SOLICITADO_POR').val('');
    }
    
    if (data.APROBO_ID) {
        $.ajax({
            url: `/obtenerNombreUsuario/${data.APROBO_ID}`,
            method: 'GET',
            success: function (response) {
                $('#APROBADO_POR').val(response.nombre_completo);
            },
            error: function () {
                $('#APROBADO_POR').val('');
            }
        });
    } else {
    }
    
        
        
    $('#ESTADO_APROBACION').val(data.ESTADO_APROBACION || '');
    $('#MOTIVO_RECHAZO').val(data.MOTIVO_RECHAZO || '');
    togglerechazo();
    
    

        verificarEstadoAprobacion();
        
        
    if (data.REQUIERE_COMENTARIO === 'Sí') {
        $('#COMENTARIO_SOLICITUD_PO').show();
    } else {
        $('#COMENTARIO_SOLICITUD_PO').hide();
        }
        

    const porcentaje = data.PORCENTAJE_IVA;
    $(`input[name="PORCENTAJE_IVA"][value="${porcentaje}"]`).prop('checked', true);


    
          
    $(".materialesdiv").empty();

    if (data.MATERIALES_JSON) {
        cargarMaterialesDesdeJSON(data.MATERIALES_JSON);
    }

      
    
    
        $('#miModal_PO').modal('show');
        
    });

    $('#miModal_PO').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_PO');
    });
});



$('#REQUIERE_COMENTARIO').on('change', function () {
    const valor = $(this).val();
    if (valor === 'Sí') {
        $('#COMENTARIO_SOLICITUD_PO').show();
    } else {
        $('#COMENTARIO_SOLICITUD_PO').hide();
        $('#COMENTARIO_SOLICITUD').val(''); 
    }
});



function togglerechazo() {
    const valor = $('#ESTADO_APROBACION').val();
    if (valor === 'Rechazada') {
        $('#motivo-rechazoa').show();
    } else {
        $('#motivo-rechazoa').hide();
        $('#MOTIVO_RECHAZO').val('');
    }
}

$('#ESTADO_APROBACION').on('change', togglerechazo);



function verificarEstadoAprobacion() {
    const estado = $('#ESTADO_APROBACION').val();
    if (estado === 'Aprobada' || estado === 'Rechazada') {
        $('#APROBACION_HOJA').show();
    } else {
        $('#APROBACION_HOJA').hide();
    }
}

$('#ESTADO_APROBACION').on('change', verificarEstadoAprobacion);





function cargarMaterialesDesdeJSON(serviciosJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    try {
        const servicios = typeof serviciosJson === 'string' ? JSON.parse(serviciosJson) : serviciosJson;

        servicios.forEach(servicio => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('row', 'material-item', 'mt-1');

            divMaterial.innerHTML = `
                <div class="col-6">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control" name="DESCRIPCION" value="${servicio.DESCRIPCION}" required>
                </div>
                <div class="col-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" step="any" class="form-control cantidad-input" name="CANTIDAD_" value="${servicio.CANTIDAD_}" required>
                </div>
                <div class="col-2">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" step="any" class="form-control precio-input" name="PRECIO_UNITARIO" value="${servicio.PRECIO_UNITARIO}" required>
                </div>
                <div class="col-2">
                    <label class="form-label">Total</label>
                    <input type="text" class="form-control total-input" name="TOTAL" readonly>
                </div>
                <div class="col-12 mt-4">
                    <div class="form-group" style="text-align: center;">
                        <button type="button" class="btn btn-danger botonEliminarMaterial">Eliminar <i class="bi bi-trash-fill"></i></button>
                    </div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);

            const cantidadInput = divMaterial.querySelector('.cantidad-input');
            const precioInput = divMaterial.querySelector('.precio-input');
            const totalInput = divMaterial.querySelector('.total-input');

            function calcularYActualizarTotal() {
                const cantidad = parseFloat(cantidadInput.value) || 0;
                const precio = parseFloat(precioInput.value) || 0;
                const total = cantidad * precio;
                totalInput.value = total.toFixed(2);
                
                actualizarSubtotal();         
                actualizarIVAeImporte();       
            }

            calcularYActualizarTotal();

            cantidadInput.addEventListener('input', calcularYActualizarTotal);
            precioInput.addEventListener('input', calcularYActualizarTotal);

            // Botón eliminar
            const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
            botonEliminar.addEventListener('click', function () {
                contenedorMateriales.removeChild(divMaterial);
                actualizarSubtotal();       
                actualizarIVAeImporte();    
            });
            
        });

        actualizarSubtotal();

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}



function actualizarSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.total-input').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    document.getElementById('SUBTOTAL').value = subtotal.toFixed(2);
}




const Modallrevision = document.getElementById('modalMotivoRevision') 
Modallrevision.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_PO = 0
    document.getElementById('motivoRevisionInput').value = '';
   

})



$("#crearREVISION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioPO');

    if (formularioValido) {
        $("#modalMotivoRevision").modal("show");
    } else {
        Swal.fire("Error", "Por favor, complete todos los campos del formulario.", "error");
    }
});

$("#confirmarMotivoRevision").click(function () {
    let motivoRevision = $("#motivoRevisionInput").val().trim();

    if (motivoRevision === "") {
        Swal.fire("Error", "El motivo de la revisión es obligatorio.", "error");
        return;
    }

    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: 'PoSave', 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            api: 3, 
            ID_FORMULARIO_PO: ID_FORMULARIO_PO,
            MOTIVO_REVISION_PO: motivoRevision,
            _token: csrfToken 
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
                ID_FORMULARIO_PO = response.compra.ID_FORMULARIO_PO;

                $("#modalMotivoRevision").modal("hide");
                $("#miModal_PO").modal("hide");

                Swal.fire(
                    "Revisión Creada",
                    "Se ha generado una nueva versión de la oferta.",
                    "success"
                ).then(() => {
                    Tablaordencompra.ajax.reload(); 
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


//// DESCARGAR PFD PO

$(document).on('click', '.pdf-button', function () {
    const id = $(this).data('id');
    if (id) {
        window.open(`/generarPDFPO/${id}`, '_blank');
    }
});
