//VARIABLES
ID_CATALOGO_RELACIONESEXTERNAS = 0
Tablarelacionesexterna = null




const ModalArea = document.getElementById('miModal_RELACIONESEXTERNAS')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_RELACIONESEXTERNAS = 0
    document.getElementById('formularioRELACIONESEXTERNAS').reset();
   

})






$("#guardarFormRELACIONESEXTERNAS").click(function (e) {
    e.preventDefault();

    if (ID_CATALOGO_RELACIONESEXTERNAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRELACIONESEXTERNAS')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_RELACIONESEXTERNAS: ID_CATALOGO_RELACIONESEXTERNAS }, 'ExternaSave', 'formularioRELACIONESEXTERNAS', 'guardarFormRELACIONESEXTERNAS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_RELACIONESEXTERNAS = data.externa.ID_CATALOGO_RELACIONESEXTERNAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RELACIONESEXTERNAS').modal('hide')
                    document.getElementById('formularioRELACIONESEXTERNAS').reset();
                    Tablarelacionesexterna.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRELACIONESEXTERNAS')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_RELACIONESEXTERNAS: ID_CATALOGO_RELACIONESEXTERNAS }, 'ExternaSave', 'formularioRELACIONESEXTERNAS', 'guardarFormRELACIONESEXTERNAS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_RELACIONESEXTERNAS = data.externa.ID_CATALOGO_RELACIONESEXTERNAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RELACIONESEXTERNAS').modal('hide')
                    document.getElementById('formularioRELACIONESEXTERNAS').reset();
                    Tablarelacionesexterna.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
    
});


var Tablarelacionesexterna = $("#Tablarelacionesexterna").DataTable({
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
        url: '/Tablarelacionesexterna',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarelacionesexterna.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], // Ordena por la primera columna (ID_CATALOGO_ASESOR) en orden ascendente
    columns: [
        { data: 'ID_CATALOGO_RELACIONESEXTERNAS' },
        { data: 'NOMBRE_RELACIONEXTERNA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Eliminar', className: 'all text-center' }
    ]
});


$('#Tablarelacionesexterna tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablarelacionesexterna.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_RELACIONESEXTERNAS: row.data().ID_CATALOGO_RELACIONESEXTERNAS
    }
    
    eliminarDatoTabla(data, [Tablarelacionesexterna], 'ExternaDelete')

})


$('#Tablarelacionesexterna tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarelacionesexterna.row(tr);
    ID_CATALOGO_RELACIONESEXTERNAS = row.data().ID_CATALOGO_RELACIONESEXTERNAS;


    editarDatoTabla(row.data(), 'formularioRELACIONESEXTERNAS', 'miModal_RELACIONESEXTERNAS');
});


