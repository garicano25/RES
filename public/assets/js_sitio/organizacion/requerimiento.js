//VARIABLES
ID_FORMULARO_REQUERIMIENTO = 0
Tablarequerimiento = null




const ModalArea = document.getElementById('miModal_REQUERIMIENTO')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARO_REQUERIMIENTO = 0
    document.getElementById('formularioRP').reset();
   

})






$("#guardarFormRP").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioRP'))

    if (formularioValido) {

    if (ID_FORMULARO_REQUERIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARO_REQUERIMIENTO: ID_FORMULARO_REQUERIMIENTO }, 'RequerimientoSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARO_REQUERIMIENTO = data.requerimiento.ID_FORMULARO_REQUERIMIENTO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_REQUERIMIENTO').modal('hide')
                    document.getElementById('formularioRP').reset();
                    Tablarequerimiento.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARO_REQUERIMIENTO: ID_FORMULARO_REQUERIMIENTO }, 'RequerimientoSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARO_REQUERIMIENTO = data.requerimiento.ID_FORMULARO_REQUERIMIENTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_REQUERIMIENTO').modal('hide')
                    document.getElementById('formularioRP').reset();
                    Tablarequerimiento.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablarequerimiento = $("#Tablarequerimiento").DataTable({
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
        url: '/Tablarequerimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarequerimiento.columns.adjust().draw();
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
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'PRIORIDAD_RP' },
        { data: 'TIPO_VACANTE_RP' },
        { data: 'MOTIVO_VACANTE_RP' },
        { data: 'BTN_RP' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Categoría', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Prioridad', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Tipo de vacante', className: 'all text-center' },
        { targets: 4, title: 'Motivo', className: 'all text-center' },
        { targets: 5, title: 'Descargar', className: 'all text-center' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablarequerimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequerimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARO_REQUERIMIENTO: row.data().ID_FORMULARO_REQUERIMIENTO
    };

    eliminarDatoTabla(data, [Tablarequerimiento], 'RequerimientoDelete');
});





$('#Tablarequerimiento tbody').on('click', 'td>button.EDITAR', function () {


    var tr = $(this).closest('tr');
    var row = Tablarequerimiento.row(tr);
    ID_FORMULARO_REQUERIMIENTO = row.data().ID_FORMULARO_REQUERIMIENTO

    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioRP', 'miModal_REQUERIMIENTO', 1)
    
  
})




$('#Tablarequerimiento tbody').on('click', 'td>button.RP', function () {


    var tr = $(this).closest('tr');
    var row = Tablarequerimiento.row(tr);
    ID_FORMULARO_REQUERIMIENTO = row.data().ID_FORMULARO_REQUERIMIENTO

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato Requisición de personal ?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelRP/" + ID_FORMULARO_REQUERIMIENTO);
           
        
    }, 1)

})




