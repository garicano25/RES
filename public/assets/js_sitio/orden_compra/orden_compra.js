


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
        { data: 'NO_PO' },
        { data: 'NO_MR' },
        { data: 'ESTADO_BADGE' }, 
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° PO', className: 'all text-center' },
        { targets: 2, title: 'N° MR', className: 'all text-center' },
        { targets: 3, title: 'Estado', className: 'all text-center' }, 
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },

    ]
});




$("#guardarPO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioPO'))

    if (formularioValido) {

    if (ID_FORMULARIO_PO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarPO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PO: ID_FORMULARIO_PO }, 'PoSave', 'formularioPO', 'guardarPO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

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
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PO: ID_FORMULARIO_PO }, 'PoSave', 'formularioPO', 'guardarPO', { callbackAfter: true, callbackBefore: true }, () => {
        
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
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





$('#Tablaordencompra tbody').on('click', 'td>button.EDITAR', function () {
    const tr = $(this).closest('tr');
    const row = Tablaordencompra.row(tr);
    const data = row.data();
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
        $('#SOLICITADO_POR').val('No se ha solicitado una aprobación');
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
        $('#APROBADO_POR').val('No se ha solicitado una aprobación');
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


    

 $('#tabla-productos-body').empty();
    $('#subtotal_general').val('');

    let materiales = [];
    try {
        materiales = JSON.parse(data.MATERIALES_JSON || '[]');
    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }

    let subtotal = 0;

    materiales.forEach((mat) => {
        const descripcion = mat.DESCRIPCION || '';
        const cantidad = parseFloat(mat.CANTIDAD_ || 0);
        const unitario = parseFloat(mat.PRECIO_UNITARIO || 0);
        const total = cantidad * unitario;

        subtotal += total;

        const filaHTML = `
            <tr>
                <td>${descripcion}</td>
                <td>${cantidad}</td>
                <td>$ ${unitario.toFixed(2)}</td>
                <td>$ ${total.toFixed(2)}</td>
            </tr>`;
        $('#tabla-productos-body').append(filaHTML);
    });

    $('#SUBTOTAL').val(subtotal.toFixed(2));




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


    

 $('#tabla-productos-body').empty();
    $('#subtotal_general').val('');

    let materiales = [];
    try {
        materiales = JSON.parse(data.MATERIALES_JSON || '[]');
    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }

    let subtotal = 0;

    materiales.forEach((mat) => {
        const descripcion = mat.DESCRIPCION || '';
        const cantidad = parseFloat(mat.CANTIDAD_ || 0);
        const unitario = parseFloat(mat.PRECIO_UNITARIO || 0);
        const total = cantidad * unitario;

        subtotal += total;

        const filaHTML = `
            <tr>
                <td>${descripcion}</td>
                <td>${cantidad}</td>
                <td>$ ${unitario.toFixed(2)}</td>
                <td>$ ${total.toFixed(2)}</td>
            </tr>`;
        $('#tabla-productos-body').append(filaHTML);
    });

    $('#SUBTOTAL').val(subtotal.toFixed(2));


      
    
    
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




