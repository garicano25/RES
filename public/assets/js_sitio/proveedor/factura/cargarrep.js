ID_FORMULARIO_FACTURACION = 0;





const ModalArea = document.getElementById('miModal_factura')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_TIPOINVENTARIO = 0
    document.getElementById('formularioFACTURA').reset();
   
    document.getElementById('SUBIR_REP').value = "0"; 




})


$("#btnGuardarFactura").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioFACTURA'))

    if (formularioValido) {

    if (ID_FORMULARIO_FACTURACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_factura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablacargarrecp.ajax.reload()

            })
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_factura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablacargarrecp.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablacargarrecp = $("#Tablacargarrecp").DataTable({
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
    destroy: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablacargarrecp',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablacargarrecp.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
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
        { data: 'TIPO_FACTURA_FORMATO' },
        { data: 'FOLIO_FISCAL' },
        { data: 'BTN_FACTURA' },
        { data: 'BTN_EDITAR' }
        
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Folio fiscal', className: 'all text-center' },
        { targets: 3, title: 'Visualizar factura', className: 'all text-center' },
        { targets: 4, title: 'Cargar REP', className: 'all text-center' },
    ]
});


$('#Tablacargarrecp').on('click', '.ver-archivo-factura', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarfactura/' + id;
    abrirModal(url, 'Factura');
})



$('#Tablacargarrecp tbody').on('click', 'td>button.CARGARREP', function () {
    var tr = $(this).closest('tr');
    var row = Tablacargarrecp.row(tr);
    ID_FORMULARIO_FACTURACION = row.data().ID_FORMULARIO_FACTURACION;

    editarDatoTabla(row.data(), 'formularioFACTURA', 'miModal_factura');

    document.getElementById('SUBIR_REP').value = "1"; 
    

});

