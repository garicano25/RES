
//VARIABLES GLOBALES
var ID_CATALOGO_JERARQUIA = 0


Tablajerarquia = null




    const Modaljerarquia = document.getElementById('miModal_JERARQUIA');

    Modaljerarquia.addEventListener('hidden.bs.modal', event => {
        ID_CATALOGO_JERARQUIA = 0;
        document.getElementById('formularioJERARQUIA').reset();   
    });

  





$("#guardarFormJERARQUIA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioJERARQUIA'))

    if (formularioValido) {

    if (ID_CATALOGO_JERARQUIA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormJERARQUIA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_JERARQUIA: ID_CATALOGO_JERARQUIA }, 'jerarquiaSave', 'formularioJERARQUIA', 'guardarFormJERARQUIA', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_CATALOGO_JERARQUIA = data.jerarquia.ID_CATALOGO_JERARQUIA
                    alertMensaje('success','Información guardada correctamente',null)
                     $('#miModal_JERARQUIA').modal('hide')
                    document.getElementById('formularioJERARQUIA').reset();
                    Tablajerarquia.ajax.reload()

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormJERARQUIA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_JERARQUIA: ID_CATALOGO_JERARQUIA }, 'jerarquiaSave', 'formularioJERARQUIA', 'guardarFormJERARQUIA', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_JERARQUIA = data.jerarquia.ID_CATALOGO_JERARQUIA
                    alertMensaje('success','Información guardada correctamente',null )
                     $('#miModal_JERARQUIA').modal('hide')
                    document.getElementById('formularioJERARQUIA').reset();
                    Tablajerarquia.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablajerarquia = $("#Tablajerarquia").DataTable({
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
        url: '/Tablajerarquia',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablajerarquia.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], // Ordena por la primera columna (ID_CATALOGO_JERARQUIA) en orden ascendente
    columns: [
        { data: 'ID_CATALOGO_JERARQUIA' },
        { data: 'NOMBRE_JERARQUIA' },
        { data: 'DESCRIPCION_JERARQUIA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Inactivo', className: 'all text-center' }
    ]
});



$('#Tablajerarquia tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablajerarquia.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_JERARQUIA: row.data().ID_CATALOGO_JERARQUIA
    }
    
    eliminarDatoTabla(data, [Tablajerarquia], 'jerarquiaDelete')

})


$('#Tablajerarquia tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablajerarquia.row(tr);
    ID_CATALOGO_JERARQUIA = row.data().ID_CATALOGO_JERARQUIA;


    editarDatoTabla(row.data(), 'formularioJERARQUIA', 'miModal_JERARQUIA');
});




