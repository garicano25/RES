//VARIABLES
ID_CATALOGO_MOTIVOVACANTE = 0




const ModalArea = document.getElementById('miModal_MOTIVOVACANTE')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_MOTIVOVACANTE = 0
    document.getElementById('formularioMOTIVOVACANTE').reset();
   

})






$("#guardarFormMOTIVOVACANTE").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioMOTIVOVACANTE'))

    if (formularioValido) {

    if (ID_CATALOGO_MOTIVOVACANTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormMOTIVOVACANTE')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_MOTIVOVACANTE: ID_CATALOGO_MOTIVOVACANTE }, 'MotivoSave', 'formularioMOTIVOVACANTE', 'guardarFormMOTIVOVACANTE', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_MOTIVOVACANTE = data.motivo.ID_CATALOGO_MOTIVOVACANTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_MOTIVOVACANTE').modal('hide')
                    document.getElementById('formularioMOTIVOVACANTE').reset();
                    Tablamotivovacante.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormMOTIVOVACANTE')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_MOTIVOVACANTE: ID_CATALOGO_MOTIVOVACANTE }, 'MotivoSave', 'formularioMOTIVOVACANTE', 'guardarFormMOTIVOVACANTE', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_MOTIVOVACANTE = data.motivo.ID_CATALOGO_MOTIVOVACANTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_MOTIVOVACANTE').modal('hide')
                    document.getElementById('formularioMOTIVOVACANTE').reset();
                    Tablamotivovacante.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablamotivovacante = $("#Tablamotivovacante").DataTable({
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
        url: '/Tablamotivovacante',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamotivovacante.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], 
    columns: [
        { data: 'ID_CATALOGO_MOTIVOVACANTE' },
        { data: 'NOMBRE_MOTIVO_VACANTE' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Inactivo', className: 'all text-center' }
    ]
});


$('#Tablamotivovacante tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablamotivovacante.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_MOTIVOVACANTE: row.data().ID_CATALOGO_MOTIVOVACANTE
    }
    
    eliminarDatoTabla(data, [Tablamotivovacante], 'MotivoDelete')

})


$('#Tablamotivovacante tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamotivovacante.row(tr);
    ID_CATALOGO_MOTIVOVACANTE = row.data().ID_CATALOGO_MOTIVOVACANTE;


    editarDatoTabla(row.data(), 'formularioMOTIVOVACANTE', 'miModal_MOTIVOVACANTE');
});





$(document).ready(function() {
    $('#Tablamotivovacante tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamotivovacante.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_MOTIVOVACANTE');

        ID_CATALOGO_MOTIVOVACANTE = row.data().ID_CATALOGO_MOTIVOVACANTE;
        editarDatoTabla(row.data(), 'formularioMOTIVOVACANTE', 'miModal_MOTIVOVACANTE',1);
    });

    $('#miModal_MOTIVOVACANTE').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_MOTIVOVACANTE');
    });
});
