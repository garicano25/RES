//VARIABLES
ID_BRECHA_COMPETENCIAS = 0




const ModalArea = document.getElementById('miModal_BRECHA')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_BRECHA_COMPETENCIAS = 0
    document.getElementById('formularioBRECHA').reset();
   



})






// $("#guardarDOCUMENTO").click(function (e) {
//     e.preventDefault();

//     formularioValido = validarFormulario($('#formularioDOCUMENTOS'))

//     if (formularioValido) {

//     if (ID_BRECHA_COMPETENCIAS == 0) {
        
//         alertMensajeConfirm({
//             title: "¿Desea guardar la información?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarDOCUMENTO')
//             await ajaxAwaitFormData({ api: 1, ID_BRECHA_COMPETENCIAS: ID_BRECHA_COMPETENCIAS }, 'DocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
        
                
//             }, function (data) {
                    

//                     ID_BRECHA_COMPETENCIAS = data.documento.ID_BRECHA_COMPETENCIAS
//                     alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
//                      $('#miModal_documentos').modal('hide')
//                     document.getElementById('formularioDOCUMENTOS').reset();
//                     Tablabrecha.ajax.reload()

           
                
                
//             })
            
            
            
//         }, 1)
        
//     } else {
//             alertMensajeConfirm({
//             title: "¿Desea editar la información de este formulario?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarDOCUMENTO')
//             await ajaxAwaitFormData({ api: 1, ID_BRECHA_COMPETENCIAS: ID_BRECHA_COMPETENCIAS }, 'DocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTO', { callbackAfter: true, callbackBefore: true }, () => {
        
//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
        
                
//             }, function (data) {
                    
//                 setTimeout(() => {

                    
//                     ID_BRECHA_COMPETENCIAS = data.documento.ID_BRECHA_COMPETENCIAS
//                     alertMensaje('success', 'Información editada correctamente', 'Información guardada')
//                      $('#miModal_documentos').modal('hide')
//                     document.getElementById('formularioDOCUMENTOS').reset();
//                     Tablabrecha.ajax.reload()


//                 }, 300);  
//             })
//         }, 1)
//     }

// } else {
//     alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

// }
    
// });



var Tablabrecha = $("#Tablabrecha").DataTable({
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
        url: '/Tablabrecha',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabrecha.columns.adjust().draw();
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
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_BRECHA' },
        { data: 'CURP' },
        { data: 'PORCENTAJE_FALTANTE' },
        { data: 'BTN_EDITAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
        { targets: 2, title: 'CURP', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Porcentaje faltante', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
    ]
});








$('#Tablabrecha tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablabrecha.row(tr);
    ID_BRECHA_COMPETENCIAS = row.data().ID_BRECHA_COMPETENCIAS;

    editarDatoTabla(row.data(), 'formularioBRECHA', 'miModal_BRECHA', 1);

    const brechas = JSON.parse(row.data().BRECHA_JSON || '[]');
    const listaBrechas = brechas.map(item => `<li>${item}</li>`).join('');
    const totalBrechas = brechas.length;

    $('#listaBrechas').html(`<ul>${listaBrechas}</ul>`);
});






