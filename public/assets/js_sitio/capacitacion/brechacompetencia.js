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








// $('#Tablabrecha tbody').on('click', 'td>button.EDITAR', function () {
//     var tr = $(this).closest('tr');
//     var row = Tablabrecha.row(tr);
//     ID_BRECHA_COMPETENCIAS = row.data().ID_BRECHA_COMPETENCIAS;

//     editarDatoTabla(row.data(), 'formularioBRECHA', 'miModal_BRECHA', 1);

//     const brechasJson = JSON.parse(row.data().BRECHA_JSON || '{}');

//     let totalBrechas = 0;
//     let listaBrechasHtml = '';

//     const secciones = {
//         formacion: "Formación",
//         habilidades: "Habilidades",
//         conocimientos: "Conocimientos",
//         experiencia: "Experiencia",
//         cursos: "Cursos"
//     };

//     Object.entries(secciones).forEach(([clave, titulo]) => {
//         const brechas = brechasJson[clave] || [];

//         if (brechas.length > 0) {
//             totalBrechas += brechas.length;

         
//             listaBrechasHtml += brechas.map(item => `
//                 <div class="fila-brecha">
//                     <div class="mensaje-brecha">${item.mensaje}</div>
//                     <div class="porcentaje-brecha">${parseFloat(item.porcentaje).toFixed(1)}%</div>
//                 </div>
//             `).join('');
//         }
//     });

//     $('#listaBrechas').html(listaBrechasHtml || '<em>No hay brechas registradas</em>');
//     $('#contadorBrechas').text(`Total de brechas: ${totalBrechas}`);
// });

$('#Tablabrecha tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablabrecha.row(tr);
    ID_BRECHA_COMPETENCIAS = row.data().ID_BRECHA_COMPETENCIAS;

    editarDatoTabla(row.data(), 'formularioBRECHA', 'miModal_BRECHA', 1);

    const brechasJson = JSON.parse(row.data().BRECHA_JSON || '{}');

    let totalBrechas = 0;
    let listaBrechasHtml = '';
    let todasLasBrechas = [];

    // Recopilar todas las brechas en un solo array
    const secciones = {
        formacion: "Formación",
        habilidades: "Habilidades",
        conocimientos: "Conocimientos",
        experiencia: "Experiencia",
        cursos: "Cursos"
    };

    // Simplemente recopilamos todas las brechas sin clasificar
    Object.entries(secciones).forEach(([clave, titulo]) => {
        const brechas = brechasJson[clave] || [];
        
        brechas.forEach(item => {
            if (item && item.mensaje && item.porcentaje) {
                todasLasBrechas.push(item);
                totalBrechas++;
            }
        });
    });

    // Si no hay brechas, mostrar mensaje
    if (totalBrechas === 0) {
        listaBrechasHtml = '<div class="sin-brechas">No hay brechas registradas</div>';
    } else {
        // Generar HTML para todas las brechas en un solo listado
        todasLasBrechas.forEach((item, index) => {
            const porcentaje = parseFloat(item.porcentaje).toFixed(1);
            let claseColor = 'porcentaje-bajo';
            
            if (porcentaje > 3.0) {
                claseColor = 'porcentaje-alto';
            } else if (porcentaje > 1.5) {
                claseColor = 'porcentaje-medio';
            }
            
            listaBrechasHtml += `
                <div class="brecha-item" id="brecha-${index}">
                    <div class="brecha-header">
                        <div class="mensaje-brecha"> ${item.mensaje}</div>
                        <div class="porcentaje-brecha ${claseColor}">${porcentaje}%</div>
                    </div>
                    <div class="brecha-content">
                        <button type="button" class="btn-plan" data-brecha-id="${index}" onclick="/* Función futura para añadir plan */">
                            <i class="fas fa-plus-circle me-1"></i> Plan de cumplimiento (próximamente)
                        </button>
                    </div>
                </div>
            `;
        });
    }

    $('#listaBrechas').html(listaBrechasHtml);
    $('#contadorBrechas').text(`${totalBrechas}`);
});




