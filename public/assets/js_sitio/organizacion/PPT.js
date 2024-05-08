//VARIABLES
ID_FORMULARIO_PPT = 0




const ModalArea = document.getElementById('miModal_PPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
  
    ID_FORMULARIO_PPT = 0
})




//INICIAMOS LA TABLA DE LAS AREAS
TablaPPT = $("#TablaPPT").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
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
        url: '/TablaPPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaPPT.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'ID_FORMULARIO_PPT' },
        { data: 'NOMBRE_PUESTO_PPT' },
        { data: 'NOMBRE_TRABAJADOR_PPT' },
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_ACCION' },
        { data: 'BTN_PPT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
        
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Puesto', className: 'all' },
        { target: 2, title: 'Trabajador', className: 'all' },
        { target: 3, title: 'Elaborado por', className: 'all text-center' },
        { target: 4, title: 'Revisado por', className: 'all text-center' },
        { target: 5, title: 'Autorizado por', className: 'all text-center' },
        { target: 6, title: 'Accion', className: 'all text-center' },
        { target: 7, title: 'PPT', className: 'all text-center' },
        { target: 8, title: 'Editar', className: 'all text-center' },
        { target: 9, title: 'Eliminar', className: 'all text-center' },


    ]
})




$("#guardarFormPPT").click(function (e) {
    e.preventDefault();

    if (ID_FORMULARIO_PPT == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se usara para la creación del PPT",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del PPT')
                     $('miModal_PPT').modal('hide')
                    document.getElementById('formularioPPT').reset();
                    TablaPPT.ajax.reload()

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información del PPT",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('miModal_PPT').modal('hide')
                    document.getElementById('formularioPPT').reset();
                    TablaPPT.ajax.reload()

                    

                }, 300);  
            })
        }, 1)
    }
    
});


$('#TablaPPT tbody').on('click', 'td>button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT')

  
})