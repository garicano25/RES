//VARIABLES
ID_CATALOGO_ASESOR = 0




const ModalArea = document.getElementById('miModal_ASESORES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_ASESOR = 0
    document.getElementById('formularioASESOR').reset();
   

})






$("#guardarFormASESOR").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioASESOR'))

    if (formularioValido) {

    if (ID_CATALOGO_ASESOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormASESOR')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_ASESOR: ID_CATALOGO_ASESOR }, 'asesorSave', 'formularioASESOR', 'guardarFormASESOR', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_ASESOR = data.asesor.ID_CATALOGO_ASESOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_ASESORES').modal('hide')
                    document.getElementById('formularioASESOR').reset();
                    Tablaasesores.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormASESOR')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_ASESOR: ID_CATALOGO_ASESOR }, 'asesorSave', 'formularioASESOR', 'guardarFormASESOR', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_ASESOR = data.asesor.ID_CATALOGO_ASESOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_ASESORES').modal('hide')
                    document.getElementById('formularioASESOR').reset();
                    Tablaasesores.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablaasesores = $("#Tablaasesores").DataTable({
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
        url: '/Tablaasesores',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaasesores.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], // Ordena por la primera columna (ID_CATALOGO_ASESOR) en orden ascendente
    columns: [
        { data: 'ID_CATALOGO_ASESOR' },
        { data: 'NOMBRE_ASESOR' },
        { data: 'DESCRIPCION_ASESOR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Inactivo', className: 'all text-center' }
    ]
});


$('#Tablaasesores tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablaasesores.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_ASESOR: row.data().ID_CATALOGO_ASESOR
    }
    
    eliminarDatoTabla(data, [Tablaasesores], 'asesorDelete')

})


$('#Tablaasesores tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaasesores.row(tr);
    ID_CATALOGO_ASESOR = row.data().ID_CATALOGO_ASESOR;

    editarDatoTabla(row.data(), 'formularioASESOR', 'miModal_ASESORES',1);
});



$(document).ready(function() {
    $('#Tablaasesores tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaasesores.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_ASESORES');

        ID_CATALOGO_ASESOR = row.data().ID_CATALOGO_ASESOR;
        editarDatoTabla(row.data(), 'formularioASESOR', 'miModal_ASESORES',1);
    });

    $('#miModal_ASESORES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_ASESORES');
    });
});

function hacerSoloLectura(data, modalSelector) {
    var formElements = $(modalSelector).find(':input, select');

    formElements.each(function() {
        if ($(this).is(':checkbox') || $(this).is(':radio') || $(this).is('select')) {
            $(this).prop('disabled', true);
        } else {
            $(this).prop('disabled', true);
        }
    });

    $(modalSelector).find('button').hide();

    for (var key in data) {
        if (data.hasOwnProperty(key)) {
            var element = $(modalSelector).find('[name="' + key + '"]');
            if (element.length) {
                if (element.is(':radio') || element.is(':checkbox')) {
                    element.prop('checked', data[key]);
                } else {
                    element.val(data[key]);
                }
            }
        }
    }
}

function resetFormulario(modalSelector) {
    var form = $(modalSelector).find('form')[0];
    if (form) {
        form.reset();
    }

    var formElements = $(modalSelector).find(':input, select');
    formElements.each(function() {
        $(this).prop('disabled', false);
        $(this).prop('disabled', false);
    });

    $(modalSelector).find('button').show();
}