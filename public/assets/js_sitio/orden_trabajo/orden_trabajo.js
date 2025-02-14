

//VARIABLES
ID_FORMULARIO_ORDEN = 0




const Modalorden = document.getElementById('miModal_OT')
Modalorden.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_ORDEN = 0
    document.getElementById('formularioOT').reset();
      var selectize = $('#OFERTA_ID')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");

})




$(document).ready(function () {
    var selectizeInstance = $('#OFERTA_ID').selectize({
        placeholder: 'Seleccione una oferta',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVA_OT").click(function (e) {
        e.preventDefault();

        $("#miModal_OT").modal("show");

        // Resetear el formulario
        document.getElementById('formularioOT').reset();

        // Resetear Selectize
        var selectize = selectizeInstance[0].selectize;
        selectize.clear();
        selectize.setValue(""); 
    });
});








$("#guardarOT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioOT'))

    if (formularioValido) {

    if (ID_FORMULARIO_ORDEN == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarOT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ORDEN: ID_FORMULARIO_ORDEN }, 'otSave', 'formularioOT', 'guardarOT', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_ORDEN = data.orden.ID_FORMULARIO_ORDEN
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_OT').modal('hide')
                    document.getElementById('formularioOT').reset();
                    Tablaordentrabajo.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarOT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ORDEN: ID_FORMULARIO_ORDEN }, 'otSave', 'formularioOT', 'guardarOT', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_ORDEN = data.orden.ID_FORMULARIO_ORDEN
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_OT').modal('hide')
                    document.getElementById('formularioOT').reset();
                    Tablaordentrabajo.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





var Tablaordentrabajo = $("#Tablaordentrabajo").DataTable({
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
        url: '/Tablaordentrabajo',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaordentrabajo.columns.adjust().draw();
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
        { data: 'NO_OFERTA' },
        { data: 'NO_ORDEN_CONFIRMACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° de cotización', className: 'all text-center nombre-column' },
        { targets: 2, title: 'N° de OT', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablaordentrabajo tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaordentrabajo.row(tr);
    ID_FORMULARIO_ORDEN = row.data().ID_FORMULARIO_ORDEN;

    editarDatoTabla(row.data(), 'formularioOT', 'miModal_OT', 1);

    var selectize = $('#OFERTA_ID')[0].selectize;

    if (row.data().OFERTA_ID) {
        try {
            let ofertaArray = JSON.parse(row.data().OFERTA_ID); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear OFERTA_ID:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }
});


