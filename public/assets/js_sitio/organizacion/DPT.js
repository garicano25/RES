//VARIABLES
ID_FORMULARIO_DPT = 0
var cargos = [];
var gestion = [];



const ModalArea = document.getElementById('miModal_DPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_DPT = 0
    document.getElementById('formularioDPT').reset();
    $('#formularioDPT input').prop('disabled', false);
    $('#formularioDPT textarea').prop('disabled', false);
    $('#formularioDPT select').prop('disabled', false);
    
    $('.collapse').collapse('hide')
    
    $('#guardarFormDPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormDPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormDPT').css('display', 'none').prop('disabled', true);


})


TablaDPT = $("#TablaDPT").DataTable({
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
        url: '/TablaDPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaDPT.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'ID_FORMULARIO_DPT' },
        { data: 'DEPARTAMENTOS_AREAS_ID', name: 'DEPARTAMENTOS_AREAS_ID' }, // Utiliza el nombre correcto 'DEPARTAMENTOS_AREAS_ID'
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_DPT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
        
        
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre categoría', className: 'all' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Autorizado por', className: 'all text-center' },
        { target: 5, title: 'DPT', className: 'all text-center' },
        { target: 6, title: 'Editar', className: 'all text-center' },
        { target: 7, title: 'Eliminar', className: 'all text-center' },



    ]
})
$("#guardarFormDPT").click(function (e) {
    e.preventDefault();


                var cargos = [];
                $(".generarcargo").each(function() {
                    var cargojs = {
                        'FUNCIONES_CARGO_DPT': $(this).find("input[name='FUNCIONES_CLAVE_CARGO_DPT']").val(),
                    }
                    cargos.push(cargojs);

                });

                var gestion = [];
                $(".generargestion").each(function() {
                    var gestionjs = {
                        'FUNCIONES_GESTION_DPT': $(this).find("input[name='FUNCIONES_CLAVE_GESTION_DPT']").val(),
                    }
                    gestion.push(gestionjs);
                });


    if (ID_FORMULARIO_DPT == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se usara para la creación del DPT",
            icon: "question",
        },async function () { 
            
            data={api: 1,
                        ID_FORMULARIO_DPT:ID_FORMULARIO_DPT,
                        CARGOS:JSON.stringify(cargos),
                        GESTION:JSON.stringify(gestion),


            }
            await loaderbtn('guardarFormDPT')
            await ajaxAwaitFormData(data, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
        
            
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                
                setTimeout(() => {
                    
                    ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del DPT',null,null,1500)
                    $('#miModal_DPT').modal('hide')
                    document.getElementById('formularioDPT').reset();
                    TablaDPT.ajax.reload()
                    
                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
        alertMensajeConfirm({
        title: "¿Desea editar la información de este formulario?",
        text: "Al guardarla, se editara la información del DPT",
        icon: "question",
    },async function () { 

        await loaderbtn('guardarFormDPT')
        await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT }, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento',
                text: 'Estamos guardando la información',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            setTimeout(() => {

                
                ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT
                alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                 $('#miModal_DPT').modal('hide')
                document.getElementById('formularioDPT').reset();
                TablaDPT.ajax.reload()


            }, 300);  
        })
    }, 1)
}

});







$('#TablaDPT tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaDPT.row(tr);
    ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT;


    editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1);
});






// $('#TablaDPT tbody').on('click', 'td>button.REVISAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#revisarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })


// $('#TablaDPT tbody').on('click', 'td>button.AUTORIZAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#AutorizarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })

// $('#revisarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea marcar como revisado este DPT?",
//         text: "Al revisarlo, pasara hacer autorizado ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/revisarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la revisión',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


// $('#AutorizarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea autorizar el DPT?",
//         text: "Al autorizarlo, podra hacer uso del DPT ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/autorizarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la autorización',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


// $('#TablaDPT tbody').on('click', 'td>button.DPT', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

   
//        alertMensajeConfirm({
//         title: "¿Desea visualizar el formato DPT?",
//         text: "Confirma para continuar ",
//         icon: "question",
//     }, function () { 

// 		window.open("/makeExcelDPT/" + ID_FORMULARIO_DPT);
           
        
//     }, 1)

// })


































document.addEventListener("DOMContentLoaded", function() {
    const botonAgregar = document.getElementById('botonagregarcargo');
    botonAgregar.addEventListener('click', botonagregarcargo);
    
    function botonagregarcargo() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcargo', 'm-3');
        divContacto.innerHTML = `
        <div class="row mb-3">
        
        <div class="col-10">
        <input type="text" class="form-control" name="FUNCIONES_CLAVE_CARGO_DPT" id="FUNCIONES_CLAVE_CARGO_DPT" required>
        </div>
        <div class="col-1">
        <button type="button" class="btn btn-danger botonEliminarContacto"><i class="bi bi-trash"></i></i></button>  
        </div>
        </div>
        `;
        const contenedor = document.getElementById('funciones-responsabilidades-cargo');
        contenedor.appendChild(divContacto);
        
        const botonEliminar = divContacto.querySelector('.botonEliminarContacto');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divContacto);
        });
    }
});




document.addEventListener("DOMContentLoaded", function() {
    const botonAgregar = document.getElementById('botonagregargestion');
    botonAgregar.addEventListener('click', botonagregargestion);
    
    function botonagregargestion() {
        const divGestion = document.createElement('div');
        divGestion.classList.add('row', 'generargestion', 'm-3');
        divGestion.innerHTML = `
        <div class="row mb-3">
        
        <div class="col-10">
        
        <input type="text" class="form-control" name="FUNCIONES_CLAVE_GESTION_DPT" id="FUNCIONES_CLAVE_GESTION_DPT" required>
        
        </div>
        <div class="col-1">
        <button type="button" class="btn btn-danger botonEliminarContacto"><i class="bi bi-trash"></i></i></button>
        
        </div>
        </div>
        `;
        const contenedor = document.getElementById('funciones-responsabilidades-gestion');
        contenedor.appendChild(divGestion);
        
        const botonEliminar = divGestion.querySelector('.botonEliminarContacto');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divGestion);
        });
    }
});





