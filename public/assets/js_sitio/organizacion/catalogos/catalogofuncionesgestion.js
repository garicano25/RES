//VARIABLES
ID_CATALOGO_FUNCIONESGESTION = 0
Tablafuncionesgestion = null




const ModalArea = document.getElementById('miModal_FUNCIONESGESTION')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_ASESOR = 0
    document.getElementById('formularioFUNCIONESGESTION').reset();
   

})






$("#guardarFormFuncionesgestion").click(function (e) {
    e.preventDefault();

    if (ID_CATALOGO_FUNCIONESGESTION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormFuncionesgestion')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION }, 'GestionSave', 'formularioFUNCIONESGESTION', 'guardarFormFuncionesgestion', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_FUNCIONESGESTION').modal('hide')
                    document.getElementById('formularioFUNCIONESGESTION').reset();
                    Tablafuncionesgestion.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormFuncionesgestion')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION }, 'GestionSave', 'formularioFUNCIONESGESTION', 'guardarFormFuncionesgestion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_FUNCIONESGESTION').modal('hide')
                    document.getElementById('formularioFUNCIONESGESTION').reset();
                    Tablafuncionesgestion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
    
});


var Tablafuncionesgestion = $("#Tablafuncionesgestion").DataTable({
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
        url: '/Tablafuncionesgestion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablafuncionesgestion.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], // Ordena por la primera columna (ID_CATALOGO_ASESOR) en orden ascendente
    columns: [
        { data: 'ID_CATALOGO_FUNCIONESGESTION' },
        { data: 'TIPO_FUNCION_GESTION' },
        { data: 'CATEGORIAS_GESTION' },
        { data: 'DESCRIPCION_FUNCION_GESTION'},
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


$('#Tablafuncionesgestion tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablafuncionesgestion.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_FUNCIONESGESTION: row.data().ID_CATALOGO_FUNCIONESGESTION
    }
    
    eliminarDatoTabla(data, [Tablafuncionesgestion], 'GestionDelete')

})


$('#Tablafuncionesgestion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablafuncionesgestion.row(tr);
    ID_CATALOGO_FUNCIONESGESTION = row.data().ID_CATALOGO_FUNCIONESGESTION;


    editarDatoTabla(row.data(), 'formularioFUNCIONESGESTION', 'miModal_FUNCIONESGESTION',1);
});


document.addEventListener('DOMContentLoaded', function() {
    const especificaRadio = document.getElementById('especifica');
    const genericaRadio = document.getElementById('generica');
    const categoriasSelect = document.getElementById('CATEGORIAS_GESTION');

    // Función para manejar el cambio de estado del select
    function handleRadioChange() {
        console.log('Especifica checked:', especificaRadio.checked);
        console.log('Generica checked:', genericaRadio.checked);

        if (genericaRadio.checked) {
            categoriasSelect.disabled = true;
            console.log('Categorias select disabled');
        } else if (especificaRadio.checked) {
            categoriasSelect.disabled = false;
            console.log('Categorias select enabled');
        }
    }

    especificaRadio.addEventListener('change', handleRadioChange);
    genericaRadio.addEventListener('change', handleRadioChange);

    handleRadioChange(); // Verificar estado inicial
});


