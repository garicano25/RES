//VARIABLES
ID_CATALOGO_FUNCIONESCARGO = 0
Tablaafuncionescargo = null




const ModalArea = document.getElementById('miModal_FUNCIONESCARGO')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_FUNCIONESCARGO = 0
    document.getElementById('formularioFUNCIONESCARGO').reset();
   

})






$("#guardarFormFuncionescargo").click(function (e) {
    e.preventDefault();

    if (ID_CATALOGO_FUNCIONESCARGO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormFuncionescargo')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESCARGO: ID_CATALOGO_FUNCIONESCARGO }, 'CargoSave', 'formularioFUNCIONESCARGO', 'guardarFormFuncionescargo', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_FUNCIONESCARGO = data.cargo.ID_CATALOGO_FUNCIONESCARGO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_FUNCIONESCARGO').modal('hide')
                    document.getElementById('formularioFUNCIONESCARGO').reset();
                    Tablaafuncionescargo.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormFuncionescargo')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESCARGO: ID_CATALOGO_FUNCIONESCARGO }, 'CargoSave', 'formularioFUNCIONESCARGO', 'guardarFormFuncionescargo', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_FUNCIONESCARGO = data.cargo.ID_CATALOGO_FUNCIONESCARGO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_FUNCIONESCARGO').modal('hide')
                    document.getElementById('formularioFUNCIONESCARGO').reset();
                     Tablaafuncionescargo.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
    
});


var Tablaafuncionescargo = $("#Tablaafuncionescargo").DataTable({
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
        url: '/Tablaafuncionescargo',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaafuncionescargo.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], 
    columns: [
        { data: 'ID_CATALOGO_FUNCIONESCARGO' },
        { data: 'TIPO_FUNCION_CARGO' },
        { data: 'CATEGORIAS_CARGO' },
        { data: 'DESCRIPCION_FUNCION_CARGO'},
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Tipo de función', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre de la categoría', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Descrición', className: 'all text-center descripcion-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Eliminar', className: 'all text-center' }
    ]
});


$('#Tablaafuncionescargo tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablaafuncionescargo.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_FUNCIONESCARGO: row.data().ID_CATALOGO_FUNCIONESCARGO
    }
    
    eliminarDatoTabla(data, [Tablaafuncionescargo], 'CargoDelete')

})


$('#Tablaafuncionescargo tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaafuncionescargo.row(tr);
    ID_CATALOGO_FUNCIONESCARGO = row.data().ID_CATALOGO_FUNCIONESCARGO;


    editarDatoTabla(row.data(), 'formularioFUNCIONESCARGO', 'miModal_FUNCIONESCARGO',1);
});


document.addEventListener('DOMContentLoaded', function() {
    const especificaRadio = document.getElementById('especifica');
    const genericaRadio = document.getElementById('generica');
    const categoriasSelect = document.getElementById('CATEGORIAS_CARGO');

    // Función para manejar el cambio de estado del select
    function handleRadioChange() {
        if (genericaRadio.checked) {
            categoriasSelect.disabled = true;
        } else if (especificaRadio.checked) {
            categoriasSelect.disabled = false;
        }
    }

    // Asignar la función al evento change de los radios
    especificaRadio.addEventListener('change', handleRadioChange);
    genericaRadio.addEventListener('change', handleRadioChange);

    // Ejecutar la función al cargar la página para establecer el estado inicial
    handleRadioChange();
});
