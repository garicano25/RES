//VARIABLES
ID_CATALOGO_EXPERIENCIA = 0




const ModalArea = document.getElementById('miModal_EXPERIENCIA')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_EXPERIENCIA = 0
    document.getElementById('formularioEXPERIENCIA').reset();
   
    $('#miModal_EXPERIENCIA .modal-title').html('Nuevo puesto requerido');

})






$("#guardarFormEXPERIENCIA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioEXPERIENCIA'))

    if (formularioValido) {

    if (ID_CATALOGO_EXPERIENCIA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormEXPERIENCIA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_EXPERIENCIA: ID_CATALOGO_EXPERIENCIA }, 'PuestoSave', 'formularioEXPERIENCIA', 'guardarFormEXPERIENCIA', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_EXPERIENCIA = data.puesto.ID_CATALOGO_EXPERIENCIA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_EXPERIENCIA').modal('hide')
                    document.getElementById('formularioEXPERIENCIA').reset();
                    Tablaexperiencia.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormEXPERIENCIA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_EXPERIENCIA: ID_CATALOGO_EXPERIENCIA }, 'PuestoSave', 'formularioEXPERIENCIA', 'guardarFormEXPERIENCIA', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_EXPERIENCIA = data.puesto.ID_CATALOGO_EXPERIENCIA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_EXPERIENCIA').modal('hide')
                    document.getElementById('formularioEXPERIENCIA').reset();
                    Tablaexperiencia.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablaexperiencia = $("#Tablaexperiencia").DataTable({
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
        url: '/Tablaexperiencia',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaexperiencia.columns.adjust().draw();
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
                return meta.row + 1; // Contador que inicia en 1 y se incrementa por cada fila
            }
        },
        { data: 'NOMBRE_PUESTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablaexperiencia tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaexperiencia.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_EXPERIENCIA: row.data().ID_CATALOGO_EXPERIENCIA
    };

    eliminarDatoTabla(data, [Tablaexperiencia], 'PuestoDelete');
});




$('#Tablaexperiencia tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaexperiencia.row(tr);
    ID_CATALOGO_EXPERIENCIA = row.data().ID_CATALOGO_EXPERIENCIA;

    editarDatoTabla(row.data(), 'formularioEXPERIENCIA', 'miModal_EXPERIENCIA');
     $('#miModal_EXPERIENCIA .modal-title').html(row.data().NOMBRE_PUESTO);
});



$(document).ready(function() {
    $('#Tablaexperiencia tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaexperiencia.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_EXPERIENCIA');

        ID_CATALOGO_EXPERIENCIA = row.data().ID_CATALOGO_EXPERIENCIA;
        editarDatoTabla(row.data(), 'formularioEXPERIENCIA', 'miModal_EXPERIENCIA',1);

         $('#miModal_EXPERIENCIA .modal-title').html(row.data().NOMBRE_PUESTO);
    });

    $('#miModal_EXPERIENCIA').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_EXPERIENCIA');
    });
});
