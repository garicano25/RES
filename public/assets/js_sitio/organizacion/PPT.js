//VARIABLES
ID_FORMULARIO_PPT = 0




const ModalArea = document.getElementById('miModal_PPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_PPT = 0
    document.getElementById('formularioPPT').reset();
    $('#formularioPPT input').prop('disabled', false);
    $('#formularioPPT textarea').prop('disabled', false);
    $('#formularioPPT select').prop('disabled', false);
    
    $('.collapse').collapse('hide')
    
    $('#guardarFormPPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormPPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormPPT').css('display', 'none').prop('disabled', true);


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
        { data: 'DEPARTAMENTO_AREA_ID' },
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
        { target: 1, title: 'Nombre categoría', className: 'all' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Autorizado por', className: 'all text-center' },
        { target: 5, title: 'Acción', className: 'all text-center' },
        { target: 6, title: 'PPT', className: 'all text-center' },
        { target: 7, title: 'Editar', className: 'all text-center' },
        { target: 8, title: 'Eliminar', className: 'all text-center' },


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
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
        
                // Swal.fire({
                //     title: "Espere un momento!",
                //     text: "Estamos guardando la información.",
                //     imageUrl: "/assets/images/Gif.gif",
                //     imageWidth: 350,
                //     imageHeight: 305,
                //     imageAlt: "Loader Gif",
                //     showConfirmButton: false,

                // });

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del PPT',null,null, 1500)
                     $('#miModal_PPT').modal('hide')
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
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_PPT').modal('hide')
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
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)
    
  
})


$('#TablaPPT tbody').on('click', 'td>button.REVISAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#revisarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})


$('#TablaPPT tbody').on('click', 'td>button.AUTORIZAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#AutorizarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})

$('#revisarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea marcar como revisado este PPT?",
        text: "Al revisarlo, pasara hacer autorizado ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/revisarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la revisión',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#AutorizarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea autorizar el PPT?",
        text: "Al autorizarlo, podra hacer uso del PPT ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/autorizarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la autorización',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#TablaPPT tbody').on('click', 'td>button.PPT', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato PPT?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelPPT/" + ID_FORMULARIO_PPT);
           
        
    }, 1)

})

