//VARIABLES
ID_CATALOGO_VACANTE = 0




const ModalArea = document.getElementById('miModal_vacantes')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_VACANTE = 0
    document.getElementById('formularioVACANTES').reset();
   

})






$("#guardarFormvacantes").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioVACANTES'))

    if (formularioValido) {

    if (ID_CATALOGO_VACANTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
    
});


var Tablavacantes = $("#Tablavacantes").DataTable({
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
        url: '/Tablavacantes',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablavacantes.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], 
    columns: [
        { data: 'ID_CATALOGO_VACANTE' },
        { data: 'CATEGORIA_VACANTE' },
        { data: 'DESCRIPCION_VACANTE' },
        { data: 'created_at' },
        { data: 'updated_at' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center nombre-column' },
        {
            targets: 2,
            title: 'Descripción de la vacantes',
            className: 'all text-center descripcion-column',
            render: function(data, type, row, meta) {
                if (type === 'display' && data.length > 100) {
                    return data.substr(0, 500) + '...'; // Muestra solo los primeros 100 caracteres
                }
                return data;
            }
        },
        { targets: 3, title: 'Fecha de publicación', className: 'all text-center' },
        { targets: 4, title: 'Fecha de expiración', className: 'all text-center' },
        { targets: 5, title: 'Editar', className: 'all text-center' },
        { targets: 6, title: 'Eliminar', className: 'all text-center' }
    ]
});


$('#Tablavacantes tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_VACANTE: row.data().ID_CATALOGO_VACANTE
    }
    
    eliminarDatoTabla(data, [Tablavacantes], 'VacanteDelete')

})


$('#Tablavacantes tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);
    ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;

    editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes', 1);

});
