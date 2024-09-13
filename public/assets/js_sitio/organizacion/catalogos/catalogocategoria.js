//VARIABLES
ID_CATALOGO_CATEGORIA = 0




const ModalArea = document.getElementById('miModal_categoria')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_CATEGORIA = 0
    document.getElementById('formularioCATEGORIAS').reset();
   
    $('#miModal_categoria .modal-title').html('Nueva Categoría');


})






$("#guardarFormcategorias").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCATEGORIAS'))

    if (formularioValido) {

    if (ID_CATALOGO_CATEGORIA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormcategorias')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_CATEGORIA: ID_CATALOGO_CATEGORIA }, 'CategoriaSave', 'formularioCATEGORIAS', 'guardarFormcategorias', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_CATEGORIA = data.categoria.ID_CATALOGO_CATEGORIA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_categoria').modal('hide')
                    document.getElementById('formularioCATEGORIAS').reset();
                    Tablacategoria.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormcategorias')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_CATEGORIA: ID_CATALOGO_CATEGORIA }, 'CategoriaSave', 'formularioCATEGORIAS', 'guardarFormcategorias', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_CATEGORIA = data.categoria.ID_CATALOGO_CATEGORIA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_categoria').modal('hide')
                    document.getElementById('formularioCATEGORIAS').reset();
                    Tablacategoria.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
    } else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablacategoria = $("#Tablacategoria").DataTable({
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
        url: '/Tablacategoria',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacategoria.columns.adjust().draw();
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
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'LUGAR_CATEGORIA' },
        { data: 'PROPOSITO_CATEGORIA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Propósito o finalidad de la categoría', className: 'all text-center' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});


$('#Tablacategoria tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablacategoria.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_CATEGORIA: row.data().ID_CATALOGO_CATEGORIA
    }
    
    eliminarDatoTabla(data, [Tablacategoria], 'CategoriaDelete')



})


$('#Tablacategoria tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacategoria.row(tr);
    ID_CATALOGO_CATEGORIA = row.data().ID_CATALOGO_CATEGORIA;

    editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_categoria', 1);

    $('#miModal_categoria .modal-title').html(row.data().NOMBRE_CATEGORIA);


});



$(document).ready(function() {
    $('#Tablacategoria tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacategoria.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_categoria');

        ID_CATALOGO_CATEGORIA = row.data().ID_CATALOGO_CATEGORIA;
        editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_categoria',1);

        $('#miModal_categoria .modal-title').html(row.data().NOMBRE_CATEGORIA);


    });

    $('#miModal_categoria').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_categoria');
    });
});

