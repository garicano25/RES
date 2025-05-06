
ID_PPT_SELECCION = 0
ID_ENTREVISTA_SELECCION = 0
ID_AUTORIZACION_SELECCION = 0
ID_INTELIGENCIA_SELECCION =0
ID_BURO_SELECCION =0
ID_REFERENCIAS_SELECCION  = 0;
ID_PRUEBAS_SELECCION =0;


var Tablaautorizacion;
var Tablainteligencia;
var Tablaburo;
var Tablareferencia;
var Tablapptseleccion;
var Tablaentrevistaseleccion;
var Tablapruebaconocimientoseleccion;


var curpSeleccionada;  
var categoriaId = null;  





var Tablaseleccion = $("#Tablaseleccion").DataTable({
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
        url: '/Tablaseleccion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaseleccion.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']], 
    columns:[
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'NOMBRE_CATEGORIA' },
         { 
            data: 'POSTULADOS', 
            title: 'Postulados',
            className: 'all text-center',
            render: function(data, type, row) {
                return data ? data : "<span class='text-muted'>Sin postulados</span>";
            }
        },
        { data: 'NUMERO_VACANTE' },
        { data: 'FECHA_EXPIRACION' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre de la vacante', className: 'all text-center clickable' },
        { targets: 2, title: 'Postulados', className: 'all text-center' },
        { targets: 3, title: 'N° de vacante', className: 'all text-center' },
        { targets: 4, title: 'Fecha límite', className: 'all text-center' },
    ]
});











// $('#Tablaseleccion tbody').on('click', 'td.clickable', function() {
//     var tr = $(this).closest('tr');
//     var row = Tablaseleccion.row(tr);

//     if (row.child.isShown()) {
//         row.child.hide();
//         tr.removeClass('shown');
//     } else {
//         Swal.fire({
//             title: 'Consultando información',
//             text: 'Por favor, espere...',
//             allowOutsideClick: false,
//             showConfirmButton: false,
//             didOpen: () => {
//                 Swal.showLoading();
//             }
//         });


//         categoriaId = row.data().CATEGORIA_VACANTE;


//         vacantes_id = row.data().VACANTES_ID;

//         $.ajax({
//             url: '/consultarSeleccion/' + vacantes_id,
//             method: 'GET',
//             success: function(response) {
//                 Swal.close();
                

//                 if (response.data.length === 0) {
//                     Swal.fire('Sin información', 'No hay información relacionada para esta categoría.', 'info');
//                 } else {
//                     var innerTable = `
//                         <table class="table text-center">
//                             <thead class="custom-header">
//                                 <tr>
//                                     <th>#</th>
//                                     <th class="text-center">Nombre Completo</th>
//                                     <th class="text-center">CURP</th>
//                                     <th class="text-center">Contacto</th>
//                                     <th class="text-center">% Inteligencia laboral</th>
//                                     <th class="text-center">% Buró laboral</th>
//                                     <th class="text-center">% PPT</th>
//                                     <th class="text-center">% Referencias laboral</th>
//                                     <th class="text-center">% Pruebas de conocimientos</th>
//                                     <th class="text-center">% Entrevista</th>
//                                     <th class="text-center">% Total</th>
//                                     <th class="text-center">Mostrar</th>
//                                     <th class="text-center">Seleccionar</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                     `;

//                     response.data.forEach(function(item, index) {
//                         var inteligenciaLaboral = item.PORCENTAJE_INTELIGENCIA || '';
//                         var buroLaboral = item.PORCENTAJE_BURO || '';
//                         var ppt = item.PORCENTAJE_PPT || '';
//                         var referenciasLaboral = item.PORCENTAJE_REFERENCIAS || '';
//                         var pruebaConocimiento = item.PORCENTAJE_PRUEBA || '';
//                         var entrevista = item.PORCENTAJE_ENTREVISTA || '';
//                         var total = item.TOTAL || '';

//                         var isComplete =
//                         inteligenciaLaboral !== '**' &&
//                         buroLaboral !== '**' &&
//                         ppt !== '**' &&
//                         referenciasLaboral !== '**' &&
//                         pruebaConocimiento !== '**' &&
//                         entrevista !== '**' &&
//                         total !== '**';
                    
//                         // var isComplete = inteligenciaLaboral && buroLaboral && ppt && referenciasLaboral && pruebaConocimiento && entrevista && total;

//                         innerTable += `
//                                     <tr>
//                                         <td>${index + 1}</td>
//                                         <td>${item.NOMBRE_SELC || ''} ${item.PRIMER_APELLIDO_SELEC || ''} ${item.SEGUNDO_APELLIDO_SELEC || ''}</td>
//                                         <td style="display: none;">${item.DIA_FECHA_SELECT || ''} ${item.MES_FECHA_SELECT || ''} ${item.ANIO_FECHA_SELECT || ''}</td>
//                                         <td class="text-center">${item.CURP || ''}</td>
//                                         <td class="text-center">${item.CORREO_SELEC || ''}<br>${(item.TELEFONO1_SELECT || '') + (item.TELEFONO2_SELECT ? ', ' + item.TELEFONO2_SELECT : '')}</td>
//                                         <td class="text-center">${inteligenciaLaboral}</td>
//                                         <td class="text-center">${buroLaboral}</td>
//                                         <td class="text-center">${ppt}</td>
//                                         <td class="text-center">${referenciasLaboral}</td>
//                                         <td class="text-center">${pruebaConocimiento}</td>
//                                         <td class="text-center">${entrevista}</td>
//                                         <td class="text-center">${total}</td>
//                                         <td class="text-center">
//                                             <button type="button" class="btn btn-primary btn-circle" id="AbrirModalFull" data-bs-toggle="modal" data-bs-target="#FullScreenModal" data-curp="${item.CURP || ''}" data-nombre="${item.NOMBRE_SELC || ''} ${item.PRIMER_APELLIDO_SELEC || ''} ${item.SEGUNDO_APELLIDO_SELEC || ''}">
//                                                 <i class="bi bi-eye-fill"></i>
//                                             </button>
//                                         </td>
//                                         <td class="text-center">
//                                           <button type="button" class="btn btn-success MandarContratacion"
//                                             data-categoria-id="${categoriaId}"
//                                             data-nombre="${item.NOMBRE_SELC || ''}"
//                                             data-primer-apellido="${item.PRIMER_APELLIDO_SELEC || ''}"
//                                             data-segundo-apellido="${item.SEGUNDO_APELLIDO_SELEC || ''}"
//                                             data-dia-fecha="${item.DIA_FECHA_SELECT || ''}"
//                                             data-mes-fecha="${item.MES_FECHA_SELECT || ''}"
//                                             data-anio-fecha="${item.ANIO_FECHA_SELECT || ''}"
//                                             ${isComplete ? '' : 'disabled'}>
//                                             <i class="bi bi-check-square-fill"></i>
//                                         </button>
//                                         </td>
//                                     </tr>
//                                 `;



                       

//                     });

//                     innerTable += `
//                             </tbody>
//                         </table>
//                     `;

//                     row.child(innerTable).show();
//                     tr.addClass('shown');
//                 }
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 Swal.close();
//                 console.error('Error: ', textStatus, errorThrown);
//                 alertErrorAJAX(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }
// });




$('#Tablaseleccion tbody').on('click', 'td.clickable', function() {
    var tr = $(this).closest('tr');
    var row = Tablaseleccion.row(tr);

    $('#Tablaseleccion tbody tr.shown').each(function() {
        var openTr = $(this);
        if (!openTr.is(tr)) { 
            var openRow = Tablaseleccion.row(openTr);
            openRow.child.hide();
            openTr.removeClass('shown');
        }
    });

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        Swal.fire({
            title: 'Consultando información',
            text: 'Por favor, espere...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

           categoriaId = row.data().CATEGORIA_VACANTE;
        vacantes_id = row.data().VACANTES_ID;

        $.ajax({
            url: '/consultarSeleccion/' + vacantes_id,
            method: 'GET',
            success: function(response) {
                Swal.close();

                if (response.data.length === 0) {
                    Swal.fire('Sin información', 'No hay información relacionada para esta categoría.', 'info');
                } else {
                    var innerTable = `
                        <table class="table text-center">
                            <thead class="custom-header">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Nombre Completo</th>
                                    <th class="text-center">CURP</th>
                                    <th class="text-center">Contacto</th>
                                    <th class="text-center">% Inteligencia laboral</th>
                                    <th class="text-center">% Buró laboral</th>
                                    <th class="text-center">% PPT</th>
                                    <th class="text-center">% Referencias laboral</th>
                                    <th class="text-center">% Pruebas de conocimientos</th>
                                    <th class="text-center">% Entrevista</th>
                                    <th class="text-center">% Total</th>
                                    <th class="text-center">Mostrar</th>
                                    <th class="text-center">Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    response.data.forEach(function(item, index) {
                        var inteligenciaLaboral = item.PORCENTAJE_INTELIGENCIA || '';
                        var buroLaboral = item.PORCENTAJE_BURO || '';
                        var ppt = item.PORCENTAJE_PPT || '';
                        var referenciasLaboral = item.PORCENTAJE_REFERENCIAS || '';
                        var pruebaConocimiento = item.PORCENTAJE_PRUEBA || '';
                        var entrevista = item.PORCENTAJE_ENTREVISTA || '';
                        var total = item.TOTAL || '';

                        var isComplete = 
                            inteligenciaLaboral !== '**' && 
                            buroLaboral !== '**' && 
                            ppt !== '**' && 
                            referenciasLaboral !== '**' && 
                            pruebaConocimiento !== '**' && 
                            entrevista !== '**' && 
                            total !== '**';

                        innerTable += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.NOMBRE_SELC || ''} ${item.PRIMER_APELLIDO_SELEC || ''} ${item.SEGUNDO_APELLIDO_SELEC || ''}</td>
                                <td class="text-center">${item.CURP || ''}</td>
                                <td class="text-center">${item.CORREO_SELEC || ''}<br>${(item.TELEFONO1_SELECT || '') + (item.TELEFONO2_SELECT ? ', ' + item.TELEFONO2_SELECT : '')}</td>
                                <td class="text-center">${inteligenciaLaboral}</td>
                                <td class="text-center">${buroLaboral}</td>
                                <td class="text-center">${ppt}</td>
                                <td class="text-center">${referenciasLaboral}</td>
                                <td class="text-center">${pruebaConocimiento}</td>
                                <td class="text-center">${entrevista}</td>
                                <td class="text-center">${total}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-circle" id="AbrirModalFull" data-bs-toggle="modal" data-bs-target="#FullScreenModal" data-curp="${item.CURP || ''}" data-nombre="${item.NOMBRE_SELC || ''} ${item.PRIMER_APELLIDO_SELEC || ''} ${item.SEGUNDO_APELLIDO_SELEC || ''}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success MandarContratacion" 
                                        data-categoria-id="${categoriaId}" 
                                        data-nombre="${item.NOMBRE_SELC || ''}" 
                                        data-primer-apellido="${item.PRIMER_APELLIDO_SELEC || ''}" 
                                        data-segundo-apellido="${item.SEGUNDO_APELLIDO_SELEC || ''}" 
                                        data-dia-fecha="${item.DIA_FECHA_SELECT || ''}" 
                                        data-mes-fecha="${item.MES_FECHA_SELECT || ''}" 
                                        data-anio-fecha="${item.ANIO_FECHA_SELECT || ''}" 
                                        ${isComplete ? '' : 'disabled'}>
                                        <i class="bi bi-check-square-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    innerTable += `
                            </tbody>
                        </table>
                    `;

                    row.child(innerTable).show();
                    tr.addClass('shown');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.close();
                console.error('Error: ', textStatus, errorThrown);
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            }
        });
    }
});



function calcularTotal(inteligencia, buro, ppt, referencias, prueba, entrevista) {
    var total = (parseFloat(inteligencia) * 0.20) +
                (parseFloat(buro) * 0.15) +
                (parseFloat(ppt) * 0.15) +
                (parseFloat(referencias) * 0.10) +
                (parseFloat(prueba) * 0.10) +
                (parseFloat(entrevista) * 0.30);
    
    return Math.round(total);
}




// $(document).on('click', '.MandarContratacion', function() {
//     var button = $(this); 
//     var row = button.closest('tr'); 

//     var curp = row.find('td:eq(3)').text().trim(); 
//     var nombreCompleto = row.find('td:eq(1)').text().trim(); 
//     var fechas = row.find('td:eq(2)').text().trim(); 

//     var nombre = nombreCompleto.split(' ')[0] || ''; 
//     var primerApellido = nombreCompleto.split(' ')[1] || ''; 
//     var segundoApellido = nombreCompleto.split(' ')[2] || ''; 

//     var diaFecha = fechas.split(' ')[0] || ''; 
//     var mesFecha = fechas.split(' ')[1] || ''; 
//     var anioFecha = fechas.split(' ')[2] || ''; 

//     var datos = {
//         CURP: curp,
//         NOMBRE_PC: nombre,
//         PRIMER_APELLIDO_PC: primerApellido,
//         SEGUNDO_APELLIDO_PC: segundoApellido,
//         DIA_FECHA_PC: diaFecha,
//         MES_FECHA_PC: mesFecha,
//         ANIO_FECHA_PC: anioFecha
//     };

//     Swal.fire({
//         title: `¿Está seguro de enviar a pendiente de contratar a ${nombre} ${primerApellido} ${segundoApellido}?`,
//         text: 'Este registro será guardado como pendiente de contratar.',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Sí, guardar',
//         cancelButtonText: 'Cancelar',
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: '/guardarPendiente',
//                 method: 'POST',
//                 data: datos,
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 
//                 },
//                 success: function(response) {
//                     if (response.status === 'success') {
//                         Swal.fire('Éxito', response.message, 'success');
//                         Tablaseleccion.ajax.reload(null, false); 
//                     } else {
//                         Swal.fire('Error', response.message, 'error');
//                     }
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     console.error('Error: ', textStatus, errorThrown);
//                     Swal.fire('Error', 'No se pudo guardar el registro.', 'error');
//                 }
//             });
//         }
//     });
// });




$(document).on('click', '.MandarContratacion', function() {
    var button = $(this);

    // Recuperar valores directamente desde los atributos del botón
    var curp = button.closest('tr').find('td:eq(2)').text().trim(); 
    var nombre = button.data('nombre'); 
    var primerApellido = button.data('primer-apellido'); 
    var segundoApellido = button.data('segundo-apellido'); 
    var diaFecha = button.data('dia-fecha'); 
    var mesFecha = button.data('mes-fecha'); 
    var anioFecha = button.data('anio-fecha'); 
    var vacanteId = button.data('categoria-id'); 

    // Datos a enviar al backend
    var datos = {
        CURP: curp,
        NOMBRE_PC: nombre,
        PRIMER_APELLIDO_PC: primerApellido,
        SEGUNDO_APELLIDO_PC: segundoApellido,
        DIA_FECHA_PC: diaFecha,
        MES_FECHA_PC: mesFecha,
        ANIO_FECHA_PC: anioFecha,
        VACANTE_ID: vacanteId
    };

    Swal.fire({
        title: `¿Está seguro de enviar a pendiente de contratar a ${nombre} ${primerApellido} ${segundoApellido}?`,
        text: 'Este registro será guardado como pendiente de contratar.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/guardarPendiente',
                method: 'POST',
                data: datos,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Éxito', response.message, 'success');
                        Tablaseleccion.ajax.reload(null, false); 
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error: ', textStatus, errorThrown);
                    Swal.fire('Error', 'No se pudo guardar el registro.', 'error');
                }
            });
        }
    });
});




const fullScreenModal = document.getElementById('FullScreenModal');

fullScreenModal.addEventListener('hidden.bs.modal', function (event) {
    const modalsToClose = ['Modal_entrevistas', 'miModal_ppt', 'Modal_pruebas','verPdfModal','pdfModal'];

    modalsToClose.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });
});




$('#FullScreenModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    curpSeleccionada = button.data('curp');  
    nombreTrabajadorSeleccionado = button.data('nombre'); 




 // <!-- ============================================================== -->
// <!-- AUTORIZACION  -->
// <!-- ============================================================== -->

if ($.fn.DataTable.isDataTable('#Tablaautorizacion')) {
    Tablaautorizacion.clear().destroy();
}

Tablaautorizacion = $("#Tablaautorizacion").DataTable({
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
        data: { curp: curpSeleccionada },
        method: 'GET',
        cache: false,
        url: '/Tablaautorizacion',
        beforeSend: function () {
            $('#loadingIcon2').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon2').css('display', 'none');
            Tablaautorizacion.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon2').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'BTN_ARCHIVO', className: 'text-center' }
    ],
    columnDefs: [
        { target: 0, title: '', className: 'all text-center' },  
    ]
});

$('#Tablaautorizacion thead').css('display', 'none');


let currentRequest = null; 
$(document).off('click', '.btn-ver-pdf').on('click', '.btn-ver-pdf', function() {
    const curp = $(this).data('curp');

    resetModal();

    const timestamp = new Date().getTime();

    var pdfModal = new bootstrap.Modal(document.getElementById('verPdfModal'));
    pdfModal.show();

    if (currentRequest && currentRequest.readyState !== 4) {
        currentRequest.abort();
    }

    setTimeout(function() {
        currentRequest = $.ajax({
            url: '/ver-archivo/' + curp + '?t=' + timestamp, 
            method: 'GET',
            success: function(response) {
                $('#pdfIframe1').attr('src', '/ver-archivo/' + curp + '?t=' + timestamp).show(); 
                $('#loadingMessage').hide(); 
            },
            error: function(jqXHR, textStatus) {
                if (textStatus !== 'abort') {
                    $('#loadingMessage').text('Error al cargar el archivo.');
                }
            }
        });
    }, 300); 
});

function resetModal() {
    $('#pdfIframe1').attr('src', '').hide();
    $('#loadingMessage').text('Cargando documento...').show();

    if (currentRequest && currentRequest.readyState !== 4) {
        currentRequest.abort(); 
    }

    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    $('body').css('padding-right', ''); 
}

$('#verPdfModal').on('hidden.bs.modal', function () {
    resetModal();
});

// <!-- ============================================================== -->
// <!-- INTELIGENCIA LABORAL -->
// <!-- ============================================================== -->




if ($.fn.DataTable.isDataTable('#Tablainteligencia')) {
    Tablainteligencia.clear().destroy();
}

Tablainteligencia = $("#Tablainteligencia").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablainteligencia',  
        beforeSend: function () {
            $('#loadingIcon3').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon3').css('display', 'none');
            Tablainteligencia.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon3').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { data: 'RIESGO', className: 'text-center' },  
        { 
            data: 'BTN_COMPETENCIAS'  
        }, 
        { 
            data: 'BTN_COMPLETO'  
        },
        { data: 'BTN_EDITAR', className: 'text-center' } 
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Riesgo', className: 'all text-center' },  
        { target: 2, title: 'Documento Competencias', className: 'all text-center' },  
        { target: 3, title: 'Documento Completo', className: 'all text-center' },  
        { target: 4, title: 'Editar', className: 'all text-center' }
    ]
});


$('#Tablainteligencia').on('click', '.ver-archivo-completo', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }
    var url = '/mostrarcompleto/' + id;
    abrirModal(url, ' Documento completo');
});


// Evento para abrir el modal con CV
$('#Tablainteligencia').on('click', '.ver-archivo-competencias', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarcompetencias/' + id;
    abrirModal(url, 'Documento competencias');
});









$('#Tablainteligencia tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablainteligencia.row(tr);
    ID_INTELIGENCIA_SELECCION = row.data().ID_INTELIGENCIA_SELECCION;
    var data = row.data();
    var form = "formularioINTELIGENCIA";
    
    editarDatoTabla(data, form, 'Modal_inteligencia', 1);
    
    var riesgoPorcentaje = data.RIESGO_PORCENTAJE;  

    document.querySelectorAll('input[name="RIESGO_PORCENTAJE"]').forEach(radio => {
        radio.checked = false;
    });
    document.querySelectorAll('.light').forEach(light => {
        light.classList.remove('active');
    });

    if (riesgoPorcentaje == 40) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="40"]').checked = true;
        document.querySelector('.light.red').classList.add('active');
    } else if (riesgoPorcentaje == 70) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="70"]').checked = true;
        document.querySelector('.light.yellow').classList.add('active');
    } else if (riesgoPorcentaje == 100) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="100"]').checked = true;
        document.querySelector('.light.green').classList.add('active');
    }
});







// <!-- ============================================================== -->
// <!-- BURO LABORAL -->
// <!-- ============================================================== -->




if ($.fn.DataTable.isDataTable('#Tablaburo')) {
    Tablaburo.clear().destroy();
}


Tablaburo = $("#Tablaburo").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablaburo',  
        beforeSend: function () {
            $('#loadingIcon4').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon4').css('display', 'none');
            Tablaburo.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { 
            data: 'BTN_DOCUMENTO'  
        },
        { data: 'BTN_EDITAR', className: 'text-center' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Resultado', className: 'all text-center' },
        { target: 2, title: 'Editar', className: 'all text-center' }
    ]
});



$('#Tablaburo').on('click', '.ver-archivo-buro', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarburo/' + id;
    abrirModal(url, 'Documento Buró');
});








$('#Tablaburo tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaburo.row(tr);
    var data = row.data(); 
    ID_BURO_SELECCION = data.ID_BURO_SELECCION;

    document.getElementById('EXPERIENCIA_BURO').value = data.EXPERIENCIA_BURO || '';
    document.getElementById('EXPERIENCIA_CV').value = data.EXPERIENCIA_CV || '';

    if (data.CEDULA_PROFESIONAL) {
        document.querySelector(`input[name="CEDULA_PROFESIONAL"][value="${data.CEDULA_PROFESIONAL}"]`).checked = true;
        manejarCambioCedula(document.querySelector(`input[name="CEDULA_PROFESIONAL"][value="${data.CEDULA_PROFESIONAL}"]`));
    }

    if (data.LABORALES_DEMANDA) {
        document.querySelector(`input[name="LABORALES_DEMANDA"][value="${data.LABORALES_DEMANDA}"]`).checked = true;
        manejarCambioLaborales(document.querySelector(`input[name="LABORALES_DEMANDA"][value="${data.LABORALES_DEMANDA}"]`), document.getElementById('NUMERO_LABORALES'));
    }

    if (data.JUDICIALES_DEMANDA) {
        document.querySelector(`input[name="JUDICIALES_DEMANDA"][value="${data.JUDICIALES_DEMANDA}"]`).checked = true;
        manejarCambioJudiciales(document.querySelector(`input[name="JUDICIALES_DEMANDA"][value="${data.JUDICIALES_DEMANDA}"]`), document.getElementById('NUMERO_JUDICIALES'));
    }

    manejarCambioExperiencia(document.getElementById('EXPERIENCIA_BURO'), document.getElementById('EXPERIENCIA_CV'));

    editarDatoTabla(data, "formularioBURO", 'Modal_buro', 1);
});





// <!-- ============================================================== -->
// <!-- PPT  -->
// <!-- ============================================================== -->

if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
    Tablapptseleccion.clear().destroy();
}

Tablapptseleccion = $("#Tablapptseleccion").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablapptseleccion',  
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablapptseleccion.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { data: 'NOMBRE_CATEGORIA', className: 'text-center' },
        { data: 'NOMBRE_TRABAJADOR_PPT', className: 'text-center' },
        { data: 'BTN_EDITAR', className: 'text-center' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Nombre categoría', className: 'all text-center' },
        { target: 2, title: 'Nombre del trabajador', className: 'all text-center' },
        { target: 3, title: 'Editar', className: 'all text-center' }
    ]
});


$('#Tablapptseleccion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablapptseleccion.row(tr);
    ID_PPT_SELECCION = row.data().ID_PPT_SELECCION;
    var data = row.data();
    var form = "formularioSeleccionPPT";
    
    $('.desabilitado1','desabilitado','desabilitado2','idioma1','idioma2','idioma3').css('background','#E2EFDA');

    
    editarDatoTabla(data, form, 'miModal_ppt', 1);
    mostrarCursos(data, form);




});



// function mostrarCursos(data,form){
// if ('CURSOS' in data) {
//     if (data.CURSOS.length > 0) { 
//         var cursos = data.CURSOS
//         var count = 1    
    
//         cursos.forEach(function (obj) {
        
        

//         // cumple = obj.CURSO_CUMPLE_PPT.toUpperCase(); 

//         $('#' + form).find(`textarea[id='CURSO${count}_PPT']`).val(obj.CURSO_PPT)
    
        
//     //    $('#' + form).find(`input[id='CURSO${count}_CUMPLE_${cumple}'][value='${obj.CURSO_CUMPLE_PPT}'][type='radio']`).prop('checked', true)


//         if (obj.CURSO_DESEABLE == null) {
            
//             $('#' + form).find(`input[id='CURSO${count}_REQUERIDO_PPT'][type='checkbox']`).prop('checked', true)

//         } else {
            
//             $('#' + form).find(`input[id='CURSO${count}_DESEABLE_PPT'][type='checkbox']`).prop('checked', true)

//             }
            

//               // Marcar checkbox de Requerido o Deseable
//                 if (obj.CURSO_DESEABLE == null) {
//                     $('#' + form).find(`input[id='CURSO${count}_REQUERIDO_PPT'][type='checkbox']`).prop('checked', true);
//                 } else {
//                     $('#' + form).find(`input[id='CURSO${count}_DESEABLE_PPT'][type='checkbox']`).prop('checked', true);
//             }
            

//         count++
//         });


//         cursosTotales = data.CURSOS.length 
//         if (cursosTotales <= 10) {

//         $('#cursoTemasCollapse').collapse('show')


//         } else if (cursosTotales > 10 && cursosTotales <= 20) {
//             $('#cursoTemasCollapse').collapse('show')
//             $('#cursoTemas1Collapse').collapse('show')
            

//         } else if (cursosTotales > 20 && cursosTotales <= 30) {
//             $('#cursoTemasCollapse').collapse('show')
//             $('#cursoTemas1Collapse').collapse('show')
//             $('#cursoTemas2Collapse').collapse('show')


//         } else if (cursosTotales > 30){
            
//             $('.collapse').collapse('show')
        


//         }

//     }
//     }
// }

function mostrarCursos(data, form) {
    if (!('CURSOS' in data) || data.CURSOS.length === 0) return;

    var cursos = data.CURSOS;
    
    cursos.forEach(function (curso, index) {
        const num = index + 1;

        // Textarea del curso
        $('#' + form).find(`#CURSO${num}_PPT`).val(curso.CURSO_PPT);

$('#' + form).find(`input[id='PORCENTAJE_CURSO${num}']`).val(curso.PORCENTAJE_CURSO);

        
        // Radios de Cumple (si/no)
        const cumple = (curso.CURSO_CUMPLE_PPT || '').toLowerCase();
        if (cumple === 'si' || cumple === 'no') {
            const radioId = `#CURSO${num}_CUMPLE_${cumple.toUpperCase()}`;
            $('#' + form).find(`input${radioId}[type='radio']`).prop('checked', true);
        }

        // Checkbox requerido/deseable
        const checkId = curso.CURSO_DESEABLE == null 
                        ? `#CURSO${num}_REQUERIDO_PPT` 
                        : `#CURSO${num}_DESEABLE_PPT`;

        $('#' + form).find(`input${checkId}[type='checkbox']`).prop('checked', true);
    });

    // Mostrar colapsables según el total de cursos
    const total = cursos.length;
    if (total <= 10) {
        $('#cursoTemasCollapse').collapse('show');
    } else if (total <= 20) {
        $('#cursoTemasCollapse, #cursoTemas1Collapse').collapse('show');
    } else if (total <= 30) {
        $('#cursoTemasCollapse, #cursoTemas1Collapse, #cursoTemas2Collapse').collapse('show');
    } else {
        $('.collapse').collapse('show');
    }
}


// <!-- ============================================================== -->
// <!-- REFERENCIA LABORAL -->
// <!-- ============================================================== -->




if ($.fn.DataTable.isDataTable('#Tablareferencia')) {
    Tablareferencia.clear().destroy();
}

Tablareferencia = $("#Tablareferencia").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablareferencia',  
        beforeSend: function () {
            $('#loadingIcon5').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon5').css('display', 'none');
            Tablareferencia.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon5').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
       {
            data: 'REFERENCIAS',
            render: function (data, type, row) {
                if (!data || data.length === 0) {
                    return 'NA'; // Retorna 'NA' si no hay datos
                }
                let referenciasHTML = '';
                data.forEach(function (referencia) {
                    referenciasHTML += '<strong>' + (referencia.NOMBRE_EMPRESA || 'NA') + '</strong><br>' +
                                    'Comentario: ' + (referencia.COMENTARIO || 'NA') + '<br>' +
                                    (referencia.BTN_DOCUMENTO || 'NA') + '<br>';
                });
                return referenciasHTML;
            }
        }   ,
        { 
            data: 'BTN_EDITAR', 
            className: 'text-center'
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Nombre de la empresa y documentos', className: 'all text-center' },
        { target: 2, title: 'Editar', className: 'all text-center' }
    ]
});




$('#Tablareferencia tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferencia.row(tr);
    ID_REFERENCIAS_SELECCION = row.data().ID_REFERENCIAS_SELECCION;
    var data = row.data(); 
    var form = "formularioReferencias";


    editarDatoTabla(data, form, 'Modal_referencias', 1);

    if (data.REFERENCIAS && data.REFERENCIAS.length > 0) {
        cargarReferenciasParaEditar(data.REFERENCIAS); 
    }

    if (data.EXPERIENCIA_LABORAL === 'si') {
        $('#contenedor-empresa').css('display', 'block');
        $('#experiencia_si').prop('checked', true);
    } else {
        $('#contenedor-empresa').css('display', 'none');
        $('#experiencia_no').prop('checked', true);
    }
});




function cargarReferenciasParaEditar(referencias) {
    contenedorInputs.innerHTML = '';
    totalEmpresas = 0;

    referencias.forEach(function(referencia, index) {
        contador++; 
        totalEmpresas++; 

        const cumpleValue = referencia.CUMPLE ? referencia.CUMPLE.trim() : '';
        const comentarioValue = referencia.COMENTARIO ? referencia.COMENTARIO.trim() : ''; 
        console.log("CUMPLE Value:", cumpleValue);
        console.log("COMENTARIO Value:", comentarioValue);

        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-3 text-center">
                <label for="nombreEmpresa">Nombre de la empresa</label>
                <input type="text" name="NOMBRE_EMPRESA[]" class="form-control" value="${referencia.NOMBRE_EMPRESA || ''}">
            </div>
            <div class="col-3 text-center">
                <label for="comentario">Comentario</label>
                <textarea type="text" name="COMENTARIO[]" class="form-control" rows="1">${comentarioValue}</textarea>
            </div>
            <div class="col-1 text-center">
                <label for="cumple">¿Cumple?</label><br>
                <input type="radio" class="form-check-input" name="CUMPLE_${contador}" value="Sí" id="cumple_si_${contador}" ${cumpleValue === 'Sí' ? 'checked' : ''}>
                <label for="cumple_si_${contador}">Sí</label>
                            <br>

                <input type="radio" class="form-check-input" name="CUMPLE_${contador}" value="No" id="cumple_no_${contador}" ${cumpleValue === 'No' ? 'checked' : ''}>
                <label for="cumple_no_${contador}">No</label>
            </div>
            <div class="col-4 text-center">
                <label for="archivoResultado">Cargar documento</label>
                <input type="file" name="ARCHIVO_RESULTADO[]" class="form-control archivo-input" accept=".pdf">
                <span class="errorArchivoResultado text-danger" style="display: none;">Solo se permiten archivos PDF</span>
                <button type="button" class="btn quitarArchivo" style="display: none;">Quitar archivo</button>
            </div>
            <div class="col-1">
                <br>
                <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
            </div>
        `;

        contenedorInputs.appendChild(divInput);

        const cumpleSi = divInput.querySelector(`#cumple_si_${contador}`);
        const cumpleNo = divInput.querySelector(`#cumple_no_${contador}`);

        cumpleSi.addEventListener('change', actualizarPorcentajeCumplimiento);
        cumpleNo.addEventListener('change', actualizarPorcentajeCumplimiento);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function () {
            contenedorInputs.removeChild(divInput);
            totalEmpresas--;
            actualizarPorcentajesReferencias();
        });
    });
}




$('#Tablareferencia').on('click', '.ver-archivo-referencias', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrareferencias/' + id;
    abrirModal(url, 'Archivo de referencias');
});





// <!-- ============================================================== -->
// <!-- PRUEBAS CONOCIMIENTO -->
// <!-- ============================================================== -->





if ($.fn.DataTable.isDataTable('#Tablapruebaconocimientoseleccion')) {
    Tablapruebaconocimientoseleccion.clear().destroy();
}

Tablapruebaconocimientoseleccion = $("#Tablapruebaconocimientoseleccion").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablapruebaconocimientoseleccion',  
        beforeSend: function () {
            $('#loadingIcon7').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon7').css('display', 'none');
            Tablapruebaconocimientoseleccion.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon7').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        {
            data: 'REFERENCIAS',
            render: function (data, type, row) {
                if (!data || data.length === 0) {
                    return 'NA'; 
                }
                let referenciasHTML = '';
                data.forEach(function (referencia) {
                    referenciasHTML += '<strong>' + referencia.TIPO_PRUEBA + '</strong><br>' +
                                    referencia.BTN_DOCUMENTO + '<br>';
                });
                return referenciasHTML;
            },
            className: 'text-center'
        },
        { 
            data: 'BTN_EDITAR', 
            className: 'text-center'
        }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Nombre de la prueba y documento', className: 'all text-center' },
        { target: 2, title: 'Editar', className: 'all text-center' }
    ]
});



$('#Tablapruebaconocimientoseleccion').on('click', '.ver-archivo-pruebas', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarprueba/' + id;
    abrirModal(url, 'Archivo prueba');
});


$('#Tablapruebaconocimientoseleccion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var fila = Tablapruebaconocimientoseleccion.row(tr);
    ID_PRUEBAS_SELECCION = fila.data().ID_PRUEBAS_SELECCION;
    var data = fila.data(); 
    var form = "formularioPruebas";

    editarDatoTabla(data, form, 'Modal_pruebas_concimiento', 1);

    $('#obtenerpruebas').html('');

    cargarPruebasGuardadas(data.REFERENCIAS);

    if (data.REQUIERE_PRUEBAS === 'si') {
        $('#prueba-categoria').css('display', 'block');
        $('#prueba_si').prop('checked', true);
    } else {
        $('#prueba-categoria').css('display', 'none');
        $('#prueba_no').prop('checked', true);
    }

    

     cargarNuevaPrueba(data.ID_PRUEBAS_SELECCION);
});

function cargarPruebasGuardadas(referencias) {
    var pruebasHTML = '';

    referencias.forEach(function(requerimiento) {
        var totalPorcentaje = requerimiento.TOTAL_PORCENTAJE !== undefined ? requerimiento.TOTAL_PORCENTAJE : ''; 

        pruebasHTML += `
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col-4 text-center">
                        <label>Nombre de la prueba</label>
                        <input type="text" name="TIPO_PRUEBA[]" value="${requerimiento.TIPO_PRUEBA}" class="form-control" readonly>
                    </div>
                    
                    <div class="col-3" style="display: none;">
                        <label>Porcentaje asignado</label>
                        <input type="hidden" name="PORCENTAJE_PRUEBA[]" value="${requerimiento.PORCENTAJE_PRUEBA}" class="form-control" readonly>
                        <input type="number" value="${requerimiento.PORCENTAJE_PRUEBA}" class="form-control" readonly>
                    </div>

                    <div class="col-3 text-center">
                        <label>Porcentaje ingresado</label>
                        <input type="number" name="TOTAL_PORCENTAJE[]" value="${totalPorcentaje}" class="form-control" oninput="calcularPorcentajeTotal2()">
                    </div>

                    <div class="col-5 text-center">
                        <label>Cargar documento</label>
                        <input type="file" name="ARCHIVO_RESULTADO[]" class="form-control archivo-input" accept=".pdf">
                        <span class="errorArchivoResultado text-danger" style="display: none;">Solo se permiten archivos PDF</span>
                        <button type="button" class="btn quitarArchivo mt-2" style="display: none;">Quitar archivo</button>
                    </div>
                </div>
            </div>
        `;
    });

    $('#obtenerpruebas').html(pruebasHTML);  
    inicializarEventosPruebas();  
}


function cargarNuevaPrueba(id_prueba_seleccion) {
    if (!categoriaId) {
        Swal.fire('Error', 'No se ha seleccionado ninguna categoría.', 'error');
        return;
    }

    $("#prueba-categoria").show();

    $.ajax({
        url: '/obtenerRequerimientos/' + categoriaId,  
        method: 'GET',
        success: function(response) {
            if (response.data.length > 0) {
                var pruebasHTML = '';

                response.data.forEach(function(nuevaPrueba) {
                    var existePrueba = $('input[name="TIPO_PRUEBA[]"]').filter(function () {
                        return $(this).val() === nuevaPrueba.TIPO_PRUEBA;
                    }).length > 0;

                    if (!existePrueba) {
                        pruebasHTML += `
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <label>Nombre de la prueba</label>
                                        <input type="text" name="TIPO_PRUEBA[]" value="${nuevaPrueba.TIPO_PRUEBA}" class="form-control" readonly>
                                    </div>

                                    <div class="col-3" style="display: none;">
                                        <label>Porcentaje asignado</label>
                                        <input type="number" name="PORCENTAJE_PRUEBA[]" value="${nuevaPrueba.PORCENTAJE}" class="form-control" readonly>
                                    </div>

                                    <div class="col-3 text-center">
                                        <label>Porcentaje ingresado</label>
                                        <input type="number" name="TOTAL_PORCENTAJE[]" class="form-control" oninput="calcularPorcentajeTotal2()">
                                    </div>

                                    <div class="col-5 text-center">
                                        <label>Cargar documento</label>
                                        <input type="file" name="ARCHIVO_RESULTADO[]" class="form-control archivo-input" accept=".pdf">
                                        <span class="errorArchivoResultado text-danger" style="display: none;">Solo se permiten archivos PDF</span>
                                        <button type="button" class="btn quitarArchivo mt-2" style="display: none;">Quitar archivo</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });

                if (pruebasHTML !== '') {
                    $('#obtenerpruebas').append(pruebasHTML);
                }

                inicializarEventosPruebas();  
            } else {
                $('#obtenerpruebas').html('<p>No hay pruebas asociadas a esta categoría.</p>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error', 'No se pudieron cargar las pruebas de conocimiento.', 'error');
        }
    });
}




// <!-- ============================================================== -->
// <!-- ENTREVISTA -->
// <!-- ============================================================== -->




if ($.fn.DataTable.isDataTable('#Tablaentrevistaseleccion')) {
    Tablaentrevistaseleccion.clear().destroy();
}


Tablaentrevistaseleccion = $("#Tablaentrevistaseleccion").DataTable({
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
        data: { curp: curpSeleccionada }, 
        method: 'GET',
        cache: false,
        url: '/Tablaentrevistaseleccion',  
        beforeSend: function () {
            $('#loadingIcon').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon').css('display', 'none');
            Tablaentrevistaseleccion.columns.adjust().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { data: 'COMENTARIO_ENTREVISTA', className: 'text-center' },
        { data: 'PORCENTAJE_ENTREVISTA', className: 'text-center' },

        { data: 'BTN_EDITAR', className: 'text-center' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Comentario de la entrevista', className: 'all text-center' },
        { target: 2, title: '% de la entrevista', className: 'all text-center' },
        { target: 3, title: 'Editar', className: 'all text-center' }
    ]
});


$('#Tablaentrevistaseleccion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaentrevistaseleccion.row(tr);
    ID_ENTREVISTA_SELECCION = row.data().ID_ENTREVISTA_SELECCION;
    var data = row.data();
    var form = "formularioENTREVISTA";
    

    editarDatoTabla(data, form, 'Modal_entrevistas', 1);

});



});



// <!-- ============================================================================================================================ -->
//                                                       <!--  TODOS LOS MODALES -->
// <!-- ============================================================================================================================ -->



// <!-- ============================================================== -->
// <!-- MODAL AUTORIZACION-->
// <!-- ============================================================== -->

$("#nuevo_autorizacion").click(function (e) {
    e.preventDefault();
    $("#Modal_autorizacion").modal("show");
})



document.getElementById('verPdfButton').addEventListener('click', function () {
    const pdfUrl = '/ver-pdf'; 

    document.getElementById('pdfIframe').src = pdfUrl;

    var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    pdfModal.show();
});



const archivoAutorizacion = document.getElementById('ARCHIVO_AUTORIZACION');
const quitarFormatoBtn = document.getElementById('quitarformato');
const errorArchivo = document.getElementById('errorArchivo');

archivoAutorizacion.addEventListener('change', function () {
    if (archivoAutorizacion.files.length > 0) {
        const file = archivoAutorizacion.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            errorArchivo.style.display = 'inline-block';
            quitarFormatoBtn.style.display = 'none'; 
            archivoAutorizacion.value = ''; 
        } else {
            errorArchivo.style.display = 'none';
            quitarFormatoBtn.style.display = 'inline-block'; 
        }
    }
});

quitarFormatoBtn.addEventListener('click', function () {
    archivoAutorizacion.value = '';
    quitarFormatoBtn.style.display = 'none'; 
    errorArchivo.style.display = 'none'; 
});


const ModalAutorizacion = document.getElementById('Modal_autorizacion');
ModalAutorizacion.addEventListener('hidden.bs.modal', event => {
    ID_AUTORIZACION_SELECCION = 0;
    document.getElementById('formularioAUTORIZACION').reset();
    $('.collapse').collapse('hide');
    $('#guardarFormSeleccionAutorizacion').css('display', 'block').prop('disabled', false);


    document.querySelectorAll('#formularioAUTORIZACION [required]').forEach(input => {
        input.removeAttribute('required');
    });
   
});




$("#guardarFormSeleccionAutorizacion").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioAUTORIZACION');

    if (formularioValido) {

        if (ID_AUTORIZACION_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, la información podra ser usada ",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionAutorizacion');
                await ajaxAwaitFormData({ 
                    api: 3, 
                    ID_AUTORIZACION_SELECCION: ID_AUTORIZACION_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioAUTORIZACION', 'guardarFormSeleccionAutorizacion', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_AUTORIZACION_SELECCION = data.autorizacion.ID_AUTORIZACION_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#Modal_autorizacion').modal('hide');
                        document.getElementById('formularioAUTORIZACION').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaautorizacion')) {
                            Tablaautorizacion.ajax.reload(null, false); 
                        }

                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionAutorizacion');
                await ajaxAwaitFormData({ 
                    api: 3, 
                    ID_AUTORIZACION_SELECCION: ID_AUTORIZACION_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioAUTORIZACION', 'guardarFormSeleccionAutorizacion', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_AUTORIZACION_SELECCION = data.autorizacion.ID_AUTORIZACION_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_autorizacion').modal('hide');
                        document.getElementById('formularioAUTORIZACION').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaautorizacion')) {
                            Tablaautorizacion.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});

// <!-- ============================================================== -->
// <!-- MODAL INTELIGENCIA LABORAL-->
// <!-- ============================================================== -->

$("#nuevo_inteligencia").click(function (e) {
    e.preventDefault();
    $("#Modal_inteligencia").modal("show");
})

const archivocompleto = document.getElementById('ARCHIVO_COMPLETO');
const quitarcompletoBtn = document.getElementById('quitarcompleto');
const errorArchivoCompleto = document.getElementById('errorArchivoCompleto');

archivocompleto.addEventListener('change', function () {
    if (archivocompleto.files.length > 0) {
        const file = archivocompleto.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            errorArchivoCompleto.style.display = 'inline-block';
            quitarcompletoBtn.style.display = 'none';
            archivocompleto.value = ''; 
        } else {
            errorArchivoCompleto.style.display = 'none';
            quitarcompletoBtn.style.display = 'inline-block';
        }
    }
});

quitarcompletoBtn.addEventListener('click', function () {
    archivocompleto.value = '';
    quitarcompletoBtn.style.display = 'none';
    errorArchivoCompleto.style.display = 'none';
});


const archivocompetencias = document.getElementById('ARCHIVO_COMPETENCIAS');
const quitarcompetenciasBtn = document.getElementById('quitarcompetencias');
const errorArchivoCompetencias = document.getElementById('errorArchivoCompetencias');

archivocompetencias.addEventListener('change', function () {
    if (archivocompetencias.files.length > 0) {
        const file = archivocompetencias.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            errorArchivoCompetencias.style.display = 'inline-block';
            quitarcompetenciasBtn.style.display = 'none';
            archivocompetencias.value = ''; 
        } else {
            errorArchivoCompetencias.style.display = 'none';
            quitarcompetenciasBtn.style.display = 'inline-block';
        }
    }
});

quitarcompetenciasBtn.addEventListener('click', function () {
    archivocompetencias.value = '';
    quitarcompetenciasBtn.style.display = 'none';
    errorArchivoCompetencias.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="RIESGO_PORCENTAJE"]');
    const lights = document.querySelectorAll('.light');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            lights.forEach(light => {
                light.classList.remove('active');
            });

            if (this.value == '40') {
                document.querySelector('.light.red').classList.add('active');
            } else if (this.value == '70') {
                document.querySelector('.light.yellow').classList.add('active');
            } else if (this.value == '100') {
                document.querySelector('.light.green').classList.add('active');
            }
        });
    });
});


const ModalInteligencia = document.getElementById('Modal_inteligencia');

ModalInteligencia.addEventListener('hidden.bs.modal', event => {
    // Resetear valores
    ID_INTELIGENCIA_SELECCION = 0;
    document.getElementById('formularioINTELIGENCIA').reset();
    $('.collapse').collapse('hide');
    $('#guardarFormSeleccionAutorizacion').css('display', 'block').prop('disabled', false);

    document.querySelectorAll('#formularioINTELIGENCIA [required]').forEach(input => {
        input.removeAttribute('required');
    });

    document.querySelectorAll('input[name="RIESGO_PORCENTAJE"]').forEach(radio => {
        radio.checked = false; 
    });

    document.querySelectorAll('.light').forEach(light => {
        light.classList.remove('active');
    });
});






$("#guardarFormSeleccionInteligencia").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioINTELIGENCIA');

    if (formularioValido) {

        if (ID_INTELIGENCIA_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, la información podra ser usada ",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionInteligencia');
                await ajaxAwaitFormData({ 
                    api: 4, 
                    ID_INTELIGENCIA_SELECCION: ID_INTELIGENCIA_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioINTELIGENCIA', 'guardarFormSeleccionInteligencia', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_INTELIGENCIA_SELECCION = data.inteligencia.ID_INTELIGENCIA_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#Modal_inteligencia').modal('hide');
                        document.getElementById('formularioINTELIGENCIA').reset();


                        if ($.fn.DataTable.isDataTable('#Tablainteligencia')) {
                            Tablainteligencia.ajax.reload(null, false); 
                        }

                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionInteligencia');
                await ajaxAwaitFormData({ 
                    api: 4, 
                    ID_INTELIGENCIA_SELECCION: ID_INTELIGENCIA_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioINTELIGENCIA', 'guardarFormSeleccionInteligencia', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_INTELIGENCIA_SELECCION = data.inteligencia.ID_INTELIGENCIA_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_inteligencia').modal('hide');
                        document.getElementById('formularioINTELIGENCIA').reset();


                        if ($.fn.DataTable.isDataTable('#Tablainteligencia')) {
                            Tablainteligencia.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});

// <!-- ============================================================== -->
// <!-- MODAL BURO LABORAL-->
// <!-- ============================================================== -->





$("#nuevo_buro").click(function (e) {
    e.preventDefault();

    function reiniciarModalAlAbrir() {
        document.getElementById('formularioBURO').reset();

        document.getElementById('PORCENTAJE_TOTAL').value = 0;
        document.getElementById('EXPERIENCIA_BURO').value = '';
        document.getElementById('EXPERIENCIA_CV').value = '';
        document.getElementById('NUMERO_LABORALES').value = '';
        document.getElementById('NUMERO_JUDICIALES').value = '';

        document.querySelectorAll('input[name="CEDULA_PROFESIONAL"]').forEach(radio => radio.checked = false);
        document.querySelectorAll('input[name="LABORALES_DEMANDA"]').forEach(radio => radio.checked = false);
        document.querySelectorAll('input[name="JUDICIALES_DEMANDA"]').forEach(radio => radio.checked = false);

        porcentajeLaborales = 0;
        porcentajeJudiciales = 0;
        porcentajeCedulaSeleccionado = 0;
        porcentajeExperiencia = 0;

        document.getElementById('PORCENTAJE_TOTAL').value = 0;
    }

    reiniciarModalAlAbrir();

    // Mostrar el modal
    $("#Modal_buro").modal("show");
});





const ModalBuro = document.getElementById('Modal_buro');

ModalBuro.addEventListener('hidden.bs.modal', function () {
    
    function reiniciarModalAlCerrar() {
        document.getElementById('formularioBURO').reset();

        document.getElementById('PORCENTAJE_TOTAL').value = 0;
        document.getElementById('EXPERIENCIA_BURO').value = '';
        document.getElementById('EXPERIENCIA_CV').value = '';
        document.getElementById('NUMERO_LABORALES').value = '';
        document.getElementById('NUMERO_JUDICIALES').value = '';

        document.querySelectorAll('input[name="CEDULA_PROFESIONAL"]').forEach(radio => radio.checked = false);
        document.querySelectorAll('input[name="LABORALES_DEMANDA"]').forEach(radio => radio.checked = false);
        document.querySelectorAll('input[name="JUDICIALES_DEMANDA"]').forEach(radio => radio.checked = false);

        porcentajeLaborales = 0;
        porcentajeJudiciales = 0;
        porcentajeCedulaSeleccionado = 0;
        porcentajeExperiencia = 0;

        document.getElementById('PORCENTAJE_TOTAL').value = 0;
    }

    reiniciarModalAlCerrar();
});


const archivoResultado = document.getElementById('ARCHIVO_RESULTADO');
const quitarResultado = document.getElementById('quitarResultado');
const errorArchivoResultado = document.getElementById('errorArchivoResultado');

archivoResultado.addEventListener('change', function () {
    if (archivoResultado.files.length > 0) {
        const file = archivoResultado.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            errorArchivoResultado.style.display = 'inline-block';
            quitarResultado.style.display = 'none';
            archivoResultado.value = ''; 
        } else {
            errorArchivoResultado.style.display = 'none';
            quitarResultado.style.display = 'inline-block';
        }
    }
});

quitarResultado.addEventListener('click', function () {
    archivoResultado.value = '';
    quitarResultado.style.display = 'none';
    errorArchivoResultado.style.display = 'none';
});


let porcentajeLaborales = 0;
let porcentajeJudiciales = 0;
let porcentajeCedulaSeleccionado = 0;
let porcentajeExperiencia = 0;

function actualizarPorcentaje() {
    const porcentajeTotalInput = document.getElementById('PORCENTAJE_TOTAL');
    let porcentajeTotal = porcentajeCedulaSeleccionado + porcentajeExperiencia + porcentajeLaborales + porcentajeJudiciales;
    porcentajeTotalInput.value = porcentajeTotal;
}

function actualizarInputNumero(input, habilitar) {
    input.readOnly = !habilitar;
    if (!habilitar) {
        input.value = ""; 
    }
}

function manejarCambioCedula(radio) {
    const porcentajeCedula = {
        'si': 20,
        'no': 0,
        'exterior': 20
    };
    porcentajeCedulaSeleccionado = porcentajeCedula[radio.value] || 0;
    actualizarPorcentaje();
}

function manejarCambioLaborales(radio, numLaboralesInput) {
    if (radio.value === 'no') {
        actualizarInputNumero(numLaboralesInput, false);
        porcentajeLaborales = 25;
    } else {
        actualizarInputNumero(numLaboralesInput, true);
        porcentajeLaborales = 0;
    }
    actualizarPorcentaje();
}

function manejarCambioJudiciales(radio, numJudicialesInput) {
    if (radio.value === 'no') {
        actualizarInputNumero(numJudicialesInput, false);
        porcentajeJudiciales = 25;
    } else {
        actualizarInputNumero(numJudicialesInput, true);
        porcentajeJudiciales = 0;
    }
    actualizarPorcentaje();
}

function manejarCambioExperiencia(expBuroInput, expCvInput) {
    porcentajeExperiencia = (expBuroInput.value === expCvInput.value && expBuroInput.value !== "") ? 30 : 0;
    actualizarPorcentaje();
}

document.addEventListener('DOMContentLoaded', function () {
    const radiosCedula = document.querySelectorAll('input[name="CEDULA_PROFESIONAL"]');
    const expBuroInput = document.getElementById('EXPERIENCIA_BURO');
    const expCvInput = document.getElementById('EXPERIENCIA_CV');
    const radiosLaborales = document.querySelectorAll('input[name="LABORALES_DEMANDA"]');
    const radiosJudiciales = document.querySelectorAll('input[name="JUDICIALES_DEMANDA"]');
    const numLaboralesInput = document.getElementById('NUMERO_LABORALES');
    const numJudicialesInput = document.getElementById('NUMERO_JUDICIALES');

    radiosCedula.forEach(radio => {
        radio.addEventListener('change', function () {
            manejarCambioCedula(radio);
        });
    });

    radiosLaborales.forEach(radio => {
        radio.addEventListener('change', function () {
            manejarCambioLaborales(radio, numLaboralesInput);
        });
    });

    radiosJudiciales.forEach(radio => {
        radio.addEventListener('change', function () {
            manejarCambioJudiciales(radio, numJudicialesInput);
        });
    });

    expBuroInput.addEventListener('input', function () {
        manejarCambioExperiencia(expBuroInput, expCvInput);
    });

    expCvInput.addEventListener('input', function () {
        manejarCambioExperiencia(expBuroInput, expCvInput);
    });
});






$("#guardarFormSeleccionBuro").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioBURO');

    if (formularioValido) {

        if (ID_BURO_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, la información podra ser usada ",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionBuro');
                await ajaxAwaitFormData({ 
                    api: 5, 
                    ID_BURO_SELECCION: ID_BURO_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioBURO', 'guardarFormSeleccionBuro', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_BURO_SELECCION = data.autorizacion.ID_BURO_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#Modal_buro').modal('hide');
                        document.getElementById('formularioBURO').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaburo')) {
                            Tablaburo.ajax.reload(null, false); 
                        }

                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionEntrevista');
                await ajaxAwaitFormData({ 
                    api: 5, 
                    ID_BURO_SELECCION: ID_BURO_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioBURO', 'guardarFormSeleccionBuro', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_BURO_SELECCION = data.autorizacion.ID_BURO_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_buro').modal('hide');
                        document.getElementById('formularioBURO').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaburo')) {
                            Tablaburo.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});



// <!-- ============================================================== -->
// <!-- MODAL REFERENCIAS LABORALES -->
// <!-- ============================================================== -->

$("#nuevo_experiencia").click(function (e) {
    e.preventDefault();
    $("#Modal_referencias").modal("show");

});

const ModalReferencias = document.getElementById('Modal_referencias');
ModalReferencias.addEventListener('hidden.bs.modal', event => {

    ID_REFERENCIAS_SELECCION  = 0;
    document.getElementById('formularioReferencias').reset();
    $('.collapse').collapse('hide')
    $('#guardarFormSeleccionReferencias').css('display', 'block').prop('disabled', false);


    totalEmpresas = 0;
    empresasCumplen = 0;
    contador = 0;

    resetInputs();

    actualizarPorcentajesReferencias();

    document.getElementById('contenedor-empresa').style.display = 'none';

    document.querySelectorAll('#formularioReferencias [required]').forEach(input => {
        input.removeAttribute('required');
    });
});





let experienciaSi, experienciaNo, contenedorEmpresa, contenedorInputs, contador = 0;
let totalEmpresas = 0;  
let empresasCumplen = 0; 

function initReferenciasLaborales() {
    experienciaSi = document.getElementById('experiencia_si');
    experienciaNo = document.getElementById('experiencia_no');
    contenedorEmpresa = document.getElementById('contenedor-empresa');
    contenedorInputs = document.getElementById('inputs-container');

    toggleContenedorEmpresa();

    experienciaSi.addEventListener('change', toggleContenedorEmpresa);
    experienciaNo.addEventListener('change', toggleContenedorEmpresa);

    const botonAgregar = document.getElementById('botonAgregar');
    botonAgregar.addEventListener('click', function (e) {
        e.preventDefault();
        agregarInput();
    });
}

function toggleContenedorEmpresa() {
    if (experienciaSi.checked) {
        contenedorEmpresa.style.display = 'block';  
    } else {
        contenedorEmpresa.style.display = 'none';   
        resetInputs(); 
    }
}

function resetInputs() {
    while (contenedorInputs.firstChild) {
        contenedorInputs.removeChild(contenedorInputs.firstChild);
    }
    totalEmpresas = 0;  
    empresasCumplen = 0; 
    actualizarPorcentajesReferencias(); 
}

function agregarInput() {
    contador++; 
    totalEmpresas++; 

    const divInput = document.createElement('div');
    divInput.classList.add('form-group', 'row', 'input-container', 'mb-3'); 
    divInput.innerHTML = `
        <div class="col-3 text-center">
            <label for="nombreEmpresa">Nombre de la empresa</label>
            <input type="text" name="NOMBRE_EMPRESA[]" class="form-control">
        </div>
        <div class="col-3 text-center">
            <label for="comentario">Comentario</label>
            <textarea type="text" name="COMENTARIO[]" class="form-control" rows="1"></textarea>
        </div>
        <div class="col-1 text-center">
            <label for="cumple">¿Cumple?</label><br>
            <input type="radio" class="form-check-input" name="CUMPLE_${contador}" value="Sí" id="cumple_si_${contador}"> 
            <label for="cumple_si_${contador}">Sí</label>
            <br>
            <input type="radio" class="form-check-input" name="CUMPLE_${contador}" value="No" id="cumple_no_${contador}">
            <label for="cumple_no_${contador}">No</label>
        </div>
        <div class="col-4 text-center">
            <label for="archivoResultado">Cargar documento</label>
            <input type="file" name="ARCHIVO_RESULTADO[]" class="form-control archivo-input" accept=".pdf">
            <span class="errorArchivoResultado text-danger" style="display: none;">Solo se permiten archivos PDF</span>
            <button type="button" class="btn quitarArchivo" style="display: none;">Quitar archivo</button>
        </div>
        <div class="col-1">
            <br>
            <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
        </div>
    `;

    contenedorInputs.appendChild(divInput);

    const cumpleSi = divInput.querySelector(`#cumple_si_${contador}`);
    const cumpleNo = divInput.querySelector(`#cumple_no_${contador}`);

    cumpleSi.addEventListener('change', actualizarPorcentajeCumplimiento);
    cumpleNo.addEventListener('change', actualizarPorcentajeCumplimiento);

    const botonEliminar = divInput.querySelector('.botonEliminar');
    botonEliminar.addEventListener('click', function () {
        contenedorInputs.removeChild(divInput);
        totalEmpresas--;
        actualizarPorcentajesReferencias();
    });
}

function actualizarPorcentajeCumplimiento() {
    empresasCumplen = 0;

    // Recorremos todos los inputs dinámicos
    for (let i = 1; i <= contador; i++) {
        const radioCumple = document.querySelector(`input[name="CUMPLE_${i}"]:checked`);
        if (radioCumple && radioCumple.value === "Sí") {
            empresasCumplen++;
        }
    }

    actualizarPorcentajesReferencias();
}

function actualizarPorcentajesReferencias() {
    const porcentajeTotalInputs = document.getElementById('PORCENTAJE_TOTAL_REFERENCIAS');

    if (totalEmpresas > 0) {
        const porcentaje = (empresasCumplen / totalEmpresas) * 100;
        porcentajeTotalInputs.value = Math.round(porcentaje); 
    } else {
        porcentajeTotalInputs.value = 0; 
    }
}

// Iniciar todo cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', initReferenciasLaborales);





$("#guardarFormSeleccionReferencias").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioReferencias');

    if (formularioValido) {

        if (ID_REFERENCIAS_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla,  podra usarse",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionReferencias');
                await ajaxAwaitFormData({ 
                    api: 6, 
                    ID_REFERENCIAS_SELECCION: ID_REFERENCIAS_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioReferencias', 'guardarFormSeleccionReferencias', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_REFERENCIAS_SELECCION = data.vacantes.ID_REFERENCIAS_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#Modal_referencias').modal('hide');
                        document.getElementById('formularioReferencias').reset();
                


                        if ($.fn.DataTable.isDataTable('#Tablareferencia')) {
                            Tablareferencia.ajax.reload(null, false); 
                        }




                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionReferencias');
                await ajaxAwaitFormData({ 
                    api: 6, 
                    ID_REFERENCIAS_SELECCION: ID_REFERENCIAS_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioReferencias', 'guardarFormSeleccionReferencias', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_REFERENCIAS_SELECCION = data.vacantes.ID_REFERENCIAS_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_referencias').modal('hide');
                        document.getElementById('formularioReferencias').reset();
                     


                        if ($.fn.DataTable.isDataTable('#Tablareferencia')) {
                            Tablareferencia.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});




// <!-- ============================================================== -->
// <!-- MODAL PRUEBAS DE CONOCIMIENTO -->
// <!-- ============================================================== -->



$("#nueva_prueba_conocimiento").click(function (e) {
    e.preventDefault();

    $('input[name="REQUIERE_PRUEBAS"]').prop('checked', false);

    $("#prueba-categoria").hide();
    
    $("#Modal_pruebas_concimiento").modal("show");

    $('input[name="REQUIERE_PRUEBAS"]').change(function () {
        var seleccion = $(this).val();  
        if (seleccion === 'si') {
            cargarPruebasDeConocimiento(true);  
        } else {
            $("#prueba-categoria").hide();
            $('#obtenerpruebas').html(''); 
        }
    });
});



const Modalpruebas = document.getElementById('Modal_pruebas_concimiento');
Modalpruebas.addEventListener('hidden.bs.modal', event => {

    ID_PRUEBAS_SELECCION  = 0;
    document.getElementById('formularioPruebas').reset();
    $('.collapse').collapse('hide')
    $('#guardarFormSeleccionPruebas').css('display', 'block').prop('disabled', false);

    document.getElementById('prueba-categoria').style.display = 'none';
});







function cargarPruebasDeConocimiento(nuevo = false) {
    if (!categoriaId) {
        Swal.fire('Error', 'No se ha seleccionado ninguna categoría.', 'error');
        return;
    }

    $("#prueba-categoria").show();

    $.ajax({
        url: '/obtenerRequerimientos/' + categoriaId,  
        method: 'GET',
        success: function(response) {
            if (response.data.length > 0) {
                var pruebasHTML = '';

                response.data.forEach(function(requerimiento, index) {
                    if (nuevo) {
                        pruebasHTML += `
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <label>Nombre de la prueba</label>
                                        <input type="text" name="TIPO_PRUEBA[]" value="${requerimiento.TIPO_PRUEBA}" class="form-control" readonly>
                                    </div>

                                    <div class="col-3" style="display: none;">
                                        <label>Porcentaje asignado</label>
                                        <input type="hidden" name="PORCENTAJE_PRUEBA[]" value="${requerimiento.PORCENTAJE}" class="form-control" readonly>
                                        <input type="number" value="${requerimiento.PORCENTAJE}" class="form-control" readonly>
                                    </div>

                                    <div class="col-3 text-center">
                                        <label>Porcentaje ingresado</label>
                                        <input type="number" name="TOTAL_PORCENTAJE[]" class="form-control" oninput="calcularPorcentajeTotal()">
                                    </div>

                                    <div class="col-5 text-center">
                                        <label>Cargar documento</label>
                                        <input type="file" name="ARCHIVO_RESULTADO[]" class="form-control archivo-input" accept=".pdf">
                                        <span class="errorArchivoResultado text-danger" style="display: none;">Solo se permiten archivos PDF</span>
                                        <button type="button" class="btn quitarArchivo mt-2" style="display: none;">Quitar archivo</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });

                if (nuevo) {
                    $('#obtenerpruebas').html(pruebasHTML);  
                } else {
                    $('#obtenerpruebas').append(pruebasHTML);  
                }

                inicializarEventosPruebas();  
            } else {
                $('#obtenerpruebas').html('<p>No hay pruebas asociadas a esta categoría.</p>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Error', 'No se pudieron cargar las pruebas de conocimiento.', 'error');
        }
    });
}



function calcularPorcentajeTotal() {
    var sumaTotal = 0;
    var camposLlenos = false; 

    $('input[name="PORCENTAJE_PRUEBA[]"]').each(function(index) {
        var porcentajePrueba = parseFloat($(this).val()) || 0;  
        var totalPorcentaje = parseFloat($('input[name="TOTAL_PORCENTAJE[]"]').eq(index).val());  

        if (isNaN(totalPorcentaje)) {
            return;
        }

        camposLlenos = true; 

        var porcentajeFinal = porcentajePrueba;  

        if (totalPorcentaje === 100) {
            porcentajeFinal = porcentajePrueba;  
        } else if (totalPorcentaje >= 60 && totalPorcentaje <= 79) {
            porcentajeFinal = (porcentajePrueba * 0.70);  
        } else if (totalPorcentaje < 60) {
            porcentajeFinal = (porcentajePrueba * 0.50);  
        }

        sumaTotal += porcentajeFinal;
    });

    if (!camposLlenos) {
        $('#porcentajeTotalPrueba').val('');
    } else {
        $('#porcentajeTotalPrueba').val(Math.round(sumaTotal));  
    }
}





function inicializarEventosPruebas() {
    $('.archivo-input').on('change', function () {
        var archivo = $(this).val();
        if (archivo) {
            $(this).siblings('.quitarArchivo').show();  
        }
    });

    $('.quitarArchivo').on('click', function () {
        $(this).siblings('.archivo-input').val('');  
        $(this).hide();  
    });

    $('.archivo-input').on('change', function () {
        var archivo = $(this).val();
        var extension = archivo.split('.').pop().toLowerCase();
        if (extension !== 'pdf') {
            $(this).siblings('.errorArchivoResultado').show(); 
            $(this).val('');  
            $(this).siblings('.quitarArchivo').hide();  
        } else {
            $(this).siblings('.errorArchivoResultado').hide(); 
        }
    });
}





$("#guardarFormSeleccionPruebas").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioPruebas');

    if (formularioValido) {

        if (ID_PRUEBAS_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla,  podra usarse",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionReferencias');
                await ajaxAwaitFormData({ 
                    api: 7, 
                    ID_PRUEBAS_SELECCION: ID_PRUEBAS_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioPruebas', 'guardarFormSeleccionPruebas', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_PRUEBAS_SELECCION = data.vacantes.ID_PRUEBAS_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para  usarse', null, null, 1500);
                        $('#Modal_pruebas_concimiento').modal('hide');
                        document.getElementById('formularioPruebas').reset();
                


                        if ($.fn.DataTable.isDataTable('#Tablapruebaconocimientoseleccion')) {
                            Tablapruebaconocimientoseleccion.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
                        }




                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionReferencias');
                await ajaxAwaitFormData({ 
                    api: 7, 
                    ID_PRUEBAS_SELECCION: ID_PRUEBAS_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioPruebas', 'guardarFormSeleccionPruebas', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_PRUEBAS_SELECCION = data.vacantes.ID_PRUEBAS_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_pruebas_concimiento').modal('hide');
                        document.getElementById('formularioReferencias').reset();
                     


                        if ($.fn.DataTable.isDataTable('#Tablapruebaconocimientoseleccion')) {
                            Tablapruebaconocimientoseleccion.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});





// <!-- ============================================================== -->
// <!-- MODAL ENTREVISTA -->
// <!-- ============================================================== -->

$("#nueva_entrevista").click(function (e) {
    e.preventDefault();
    $("#Modal_entrevistas").modal("show");
})






const ModalEntrevista = document.getElementById('Modal_entrevistas');
ModalEntrevista.addEventListener('hidden.bs.modal', event => {

    ID_ENTREVISTA_SELECCION = 0;
    document.getElementById('formularioENTREVISTA').reset();

    $('.collapse').collapse('hide');
   
    $('#guardarFormSeleccionEntrevista').css('display', 'block').prop('disabled', false);



    // // Remueve la clase 'validar' y cualquier otra clase que desees de todos los inputs
    // $('#formularioENTREVISTA input').each(function() {
    //     $(this).removeClass('validar'); 
    // });
   

});


  $("#guardarFormSeleccionEntrevista").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioENTREVISTA');

    if (formularioValido) {

        if (ID_ENTREVISTA_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, la información podra ser usada ",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionEntrevista');
                await ajaxAwaitFormData({ 
                    api: 2, 
                    ID_ENTREVISTA_SELECCION: ID_ENTREVISTA_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioENTREVISTA', 'guardarFormSeleccionEntrevista', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_ENTREVISTA_SELECCION = data.entrevista.ID_ENTREVISTA_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#Modal_entrevistas').modal('hide');
                        document.getElementById('formularioENTREVISTA').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaentrevistaseleccion')) {
                            Tablaentrevistaseleccion.ajax.reload(null, false); 
                        }

                    }, 300);

                });

            }, 1);

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionEntrevista');
                await ajaxAwaitFormData({ 
                    api: 2, 
                    ID_ENTREVISTA_SELECCION: ID_ENTREVISTA_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioENTREVISTA', 'guardarFormSeleccionEntrevista', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {

                    setTimeout(() => {
                        ID_ENTREVISTA_SELECCION = data.entrevista.ID_ENTREVISTA_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#Modal_entrevistas').modal('hide');
                        document.getElementById('formularioENTREVISTA').reset();


                        if ($.fn.DataTable.isDataTable('#Tablaentrevistaseleccion')) {
                            Tablaentrevistaseleccion.ajax.reload(null, false); 
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});



// <!-- ============================================================== -->
// <!--MODAL  PPT  -->
// <!-- ============================================================== -->



$("#nuevo_ppt").click(function (e) {
    e.preventDefault();

    $("#NOMBRE_TRABAJADOR_PPT").val(nombreTrabajadorSeleccionado);


    $('.desabilitado1').css('background','#E2EFDA');
    $("#miModal_ppt").modal("show");
});


const ModalArea = document.getElementById('miModal_ppt');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_PPT_SELECCION = 0;
    document.getElementById('formularioSeleccionPPT').reset();
    $('.collapse').collapse('hide');
    $('#guardarFormSeleccionPPT').css('display', 'block').prop('disabled', false);
    
    document.querySelectorAll('#formularioSeleccionPPT [required]').forEach(input => {
        input.removeAttribute('required');
    });


    document.getElementById('NOMBRE_TRABAJADOR_PPT').value = '';

});


// Solo seleccionar una opcion de word,excel,power point
$('.word').on('change', function() {
    if ($(this).is(':checked')) {
        $('.word').not(this).prop('checked', false);
    }
});

$('.excel').on('change', function() {
    if ($(this).is(':checked')) {
        $('.excel').not(this).prop('checked', false);
    }
});

$('.power').on('change', function() {
    if ($(this).is(':checked')) {
        $('.power').not(this).prop('checked', false);
    }
});

//Solo seleccionar una opcion de los idomas 

$('.idioma1').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma1').not(this).prop('checked', false);
    }
});


$('.idioma2').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma2').not(this).prop('checked', false);
    }
});

$('.idioma3').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma3').not(this).prop('checked', false);
    }
});


// Habilidades y competencias funcionales
$('.innovacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.innovacion').not(this).prop('checked', false);
    }
});

$('.pasion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.pasion').not(this).prop('checked', false);
    }
});

$('.servicio').on('change', function() {
    if ($(this).is(':checked')) {
        $('.servicio').not(this).prop('checked', false);
    }
});

$('.comunicacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.comunicacion').not(this).prop('checked', false);
    }
});

$('.trabajo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.trabajo').not(this).prop('checked', false);
    }
});

$('.integridad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.integridad').not(this).prop('checked', false);
    }    
});

$('.responsabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.responsabilidad').not(this).prop('checked', false);
    }
});

$('.adaptabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.adaptabilidad').not(this).prop('checked', false);
    }
});
$('.liderazgo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.liderazgo').not(this).prop('checked', false);
    }
});

$('.decisiones').on('change', function() {
    if ($(this).is(':checked')) {
        $('.decisiones').not(this).prop('checked', false);
    }
});

$('#miModal_ppt').on('shown.bs.modal', function () {
    $(this).find('input, select, textarea').each(function() {
        if ($(this).hasClass('desabilitado') || 
            $(this).hasClass('desabilitado1') || 
            $(this).hasClass('desabilitado2') || 
            $(this).hasClass('idioma1') || 
            $(this).hasClass('idioma2') || 
            $(this).hasClass('idioma3')) {

            $(this).prop('required', false);

        } else {
            if ($(this).attr('type') === 'text' || $(this).is('textarea')) {
                $(this).prop('readonly', true); 
                $(this).prop('required', false);

            } else if ($(this).is('select')) {
                $(this).css({
                    'pointer-events': 'none',
                    'background-color': '#e9ecef',
                    'cursor': 'not-allowed'
                });
            } else if ($(this).attr('type') === 'radio' || $(this).attr('type') === 'checkbox') {
                $(this).css({
                    'pointer-events': 'none',
                    'cursor': 'not-allowed'
                });
            }
        }
    });
});


document.getElementById('DEPARTAMENTO_AREA_ID').addEventListener('change', function() {
    let departamentoAreaId = this.value;

    if (departamentoAreaId) {
        Swal.fire({
            title: 'Consultando información',
            text: 'Por favor, espere...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`/consultarformppt/${departamentoAreaId}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();

                let formulario = data.formulario;


               
                let nombreTrabajador = document.getElementById('NOMBRE_TRABAJADOR_PPT').value;



                if (document.getElementById('AREA_TRABAJADOR_PPT')) {
                    document.getElementById('AREA_TRABAJADOR_PPT').value = formulario.AREA_TRABAJADOR_PPT || '';
                }
                
                if (document.getElementById('PROPOSITO_FINALIDAD_PPT')) {
                    document.getElementById('PROPOSITO_FINALIDAD_PPT').value = formulario.PROPOSITO_FINALIDAD_PPT || '';
                }
                          
              
                if (document.getElementById('EDAD_PPT')) {
                    document.getElementById('EDAD_PPT').value = formulario.EDAD_PPT || '';
                }
                
                if (document.getElementById('EDAD_CUMPLE_PPT')) {
                    document.getElementById('EDAD_CUMPLE_PPT').value = formulario.EDAD_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('GENERO_PPT')) {
                    document.getElementById('GENERO_PPT').value = formulario.GENERO_PPT || '';
                }
                
                if (document.getElementById('GENERO_CUMPLE_PPT')) {
                    document.getElementById('GENERO_CUMPLE_PPT').value = formulario.GENERO_CUMPLE_PPT || '';
                }

                // Otros campos
                if (document.getElementById('ESTADO_CIVIL_PPT')) {
                    document.getElementById('ESTADO_CIVIL_PPT').value = formulario.ESTADO_CIVIL_PPT || '';
                }

                if (document.getElementById('ESTADO_CIVIL_CUMPLE_PPT')) {
                    document.getElementById('ESTADO_CIVIL_CUMPLE_PPT').value = formulario.ESTADO_CIVIL_CUMPLE_PPT || '';
                }

                if (document.getElementById('NACIONALIDAD_PPT')) {
                    document.getElementById('NACIONALIDAD_PPT').value = formulario.NACIONALIDAD_PPT || '';
                }

                if (document.getElementById('NACIONALIDAD_CUMPLE_PPT')) {
                    document.getElementById('NACIONALIDAD_CUMPLE_PPT').value = formulario.NACIONALIDAD_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('DISCAPACIDAD_PPT')) {
                    document.getElementById('DISCAPACIDAD_PPT').value = formulario.DISCAPACIDAD_PPT || '';
                }
                
                if (document.getElementById('DISCAPACIDAD_CUMPLE_PPT')) {
                    document.getElementById('DISCAPACIDAD_CUMPLE_PPT').value = formulario.DISCAPACIDAD_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('CUAL_PPT')) {
                    document.getElementById('CUAL_PPT').value = formulario.CUAL_PPT || '';
                }
                
                if (document.getElementById('SECUNDARIA_PPT')) {
                    document.getElementById('SECUNDARIA_PPT').value = formulario.SECUNDARIA_PPT || '';
                }
                
                if (document.getElementById('SECUNDARIA_CUMPLE_PPT')) {
                    document.getElementById('SECUNDARIA_CUMPLE_PPT').value = formulario.SECUNDARIA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('TECNICA_PPT')) {
                    document.getElementById('TECNICA_PPT').value = formulario.TECNICA_PPT || '';
                }
                
                if (document.getElementById('TECNICA_CUMPLE_PPT')) {
                    document.getElementById('TECNICA_CUMPLE_PPT').value = formulario.TECNICA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('TECNICO_PPT')) {
                    document.getElementById('TECNICO_PPT').value = formulario.TECNICO_PPT || '';
                }
                
                if (document.getElementById('TECNICO_CUMPLE_PPT')) {
                    document.getElementById('TECNICO_CUMPLE_PPT').value = formulario.TECNICO_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('UNIVERSITARIO_PPT')) {
                    document.getElementById('UNIVERSITARIO_PPT').value = formulario.UNIVERSITARIO_PPT || '';
                }
                
                if (document.getElementById('UNIVERSITARIO_CUMPLE_PPT')) {
                    document.getElementById('UNIVERSITARIO_CUMPLE_PPT').value = formulario.UNIVERSITARIO_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('SITUACION_PPT')) {
                    document.getElementById('SITUACION_PPT').value = formulario.SITUACION_PPT || '';
                }
                
                if (document.getElementById('SITUACION_CUMPLE_PPT')) {
                    document.getElementById('SITUACION_CUMPLE_PPT').value = formulario.SITUACION_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('CEDULA_PPT')) {
                    document.getElementById('CEDULA_PPT').value = formulario.CEDULA_PPT || '';
                }
                
                if (document.getElementById('CEDULA_CUMPLE_PPT')) {
                    document.getElementById('CEDULA_CUMPLE_PPT').value = formulario.CEDULA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA1_PPT')) {
                    document.getElementById('AREA1_PPT').value = formulario.AREA1_PPT || '';
                }
                
                if (document.getElementById('AREA1_CUMPLE_PPT')) {
                    document.getElementById('AREA1_CUMPLE_PPT').value = formulario.AREA1_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA2_PPT')) {
                    document.getElementById('AREA2_PPT').value = formulario.AREA2_PPT || '';
                }
                
                if (document.getElementById('AREA2_CUMPLE_PPT')) {
                    document.getElementById('AREA2_CUMPLE_PPT').value = formulario.AREA2_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA3_PPT')) {
                    document.getElementById('AREA3_PPT').value = formulario.AREA3_PPT || '';
                }
                
                if (document.getElementById('AREA3_CUMPLE_PPT')) {
                    document.getElementById('AREA3_CUMPLE_PPT').value = formulario.AREA3_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA4_PPT')) {
                    document.getElementById('AREA4_PPT').value = formulario.AREA4_PPT || '';
                }
                
                if (document.getElementById('AREA4_CUMPLE_PPT')) {
                    document.getElementById('AREA4_CUMPLE_PPT').value = formulario.AREA4_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA_REQUERIDA_PPT')) {
                    document.getElementById('AREA_REQUERIDA_PPT').value = formulario.AREA_REQUERIDA_PPT || '';
                }
                
                if (document.getElementById('AREA_CONOCIMIENTO_PPT')) {
                    document.getElementById('AREA_CONOCIMIENTO_PPT').value = formulario.AREA_CONOCIMIENTO_PPT || '';
                }
                
                if (document.querySelector(`input[name="EGRESADO_ESPECIALIDAD_PPT"][value="${formulario.EGRESADO_ESPECIALIDAD_PPT}"]`)) {
                    document.querySelector(`input[name="EGRESADO_ESPECIALIDAD_PPT"][value="${formulario.EGRESADO_ESPECIALIDAD_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('GRADUADO_ESPECIALIDA_PPT')) {
                    document.getElementById('GRADUADO_ESPECIALIDA_PPT').value = formulario.GRADUADO_ESPECIALIDA_PPT || '';
                }
                
                if (document.getElementById('ESPECIALIDAD_CUMPLE_PPT')) {
                    document.getElementById('ESPECIALIDAD_CUMPLE_PPT').value = formulario.ESPECIALIDAD_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREAREQUERIDA_CONOCIMIENTO_PPT')) {
                    document.getElementById('AREAREQUERIDA_CONOCIMIENTO_PPT').value = formulario.AREAREQUERIDA_CONOCIMIENTO_PPT || '';
                }
                

                if (document.querySelector(`input[name="EGRESADO_MAESTRIA_PPT"][value="${formulario.EGRESADO_MAESTRIA_PPT}"]`)) {
                    document.querySelector(`input[name="EGRESADO_MAESTRIA_PPT"][value="${formulario.EGRESADO_MAESTRIA_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('GRADUADO_MAESTRIA_PPT')) {
                    document.getElementById('GRADUADO_MAESTRIA_PPT').value = formulario.GRADUADO_MAESTRIA_PPT || '';
                }
                
                if (document.getElementById('MAESTRIA_CUMPLE_PPT')) {
                    document.getElementById('MAESTRIA_CUMPLE_PPT').value = formulario.MAESTRIA_CUMPLE_PPT || '';
                }
                
                if (document.querySelector(`input[name="EGRESADO_DOCTORADO_PPT"][value="${formulario.EGRESADO_DOCTORADO_PPT}"]`)) {
                    document.querySelector(`input[name="EGRESADO_DOCTORADO_PPT"][value="${formulario.EGRESADO_DOCTORADO_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('GRADUADO_DOCTORADO_PPT')) {
                    document.getElementById('GRADUADO_DOCTORADO_PPT').value = formulario.GRADUADO_DOCTORADO_PPT || '';
                }
                

                if (document.getElementById('DOCTORADO_CUMPLE_PPT')) {
                    document.getElementById('DOCTORADO_CUMPLE_PPT').value = formulario.DOCTORADO_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('AREA_CONOCIMIENTO_TRABAJADOR_PPT')) {
                    document.getElementById('AREA_CONOCIMIENTO_TRABAJADOR_PPT').value = formulario.AREA_CONOCIMIENTO_TRABAJADOR_PPT || '';
                }
                
                if (document.querySelector(`input[name="WORD_APLICA_PPT"][value="${formulario.WORD_APLICA_PPT}"]`)) {
                    document.querySelector(`input[name="WORD_APLICA_PPT"][value="${formulario.WORD_APLICA_PPT}"]`).checked = true;
                }

                if (document.querySelector(`input[name="WORD_CUMPLE_PPT"][value="${formulario.WORD_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="WORD_CUMPLE_PPT"][value="${formulario.WORD_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('WORD_BAJO_PPT')) {
                    document.getElementById('WORD_BAJO_PPT').checked = formulario.WORD_BAJO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('WORD_MEDIO_PPT')) {
                    document.getElementById('WORD_MEDIO_PPT').checked = formulario.WORD_MEDIO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('WORD_ALTO_PPT')) {
                    document.getElementById('WORD_ALTO_PPT').checked = formulario.WORD_ALTO_PPT === 'X' ? true : false;
                }

            
                if (document.querySelector(`input[name="EXCEL_APLICA_PPT"][value="${formulario.EXCEL_APLICA_PPT}"]`)) {
                    document.querySelector(`input[name="EXCEL_APLICA_PPT"][value="${formulario.EXCEL_APLICA_PPT}"]`).checked = true;
                }

                if (document.getElementById('EXCEL_BAJO_PPT')) {
                    document.getElementById('EXCEL_BAJO_PPT').checked = formulario.EXCEL_BAJO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('EXCEL_MEDIO_PPT')) {
                    document.getElementById('EXCEL_MEDIO_PPT').checked = formulario.EXCEL_MEDIO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('EXCEL_ALTO_PPT')) {
                    document.getElementById('EXCEL_ALTO_PPT').checked = formulario.EXCEL_ALTO_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="EXCEL_CUMPLE_PPT"][value="${formulario.EXCEL_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="EXCEL_CUMPLE_PPT"][value="${formulario.EXCEL_CUMPLE_PPT}"]`).checked = true;
                }


                if (document.querySelector(`input[name="POWER_APLICA_PPT"][value="${formulario.POWER_APLICA_PPT}"]`)) {
                    document.querySelector(`input[name="POWER_APLICA_PPT"][value="${formulario.POWER_APLICA_PPT}"]`).checked = true;
                }

                if (document.getElementById('POWER_BAJO_PPT')) {
                    document.getElementById('POWER_BAJO_PPT').checked = formulario.POWER_BAJO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('POWER_MEDIO_PPT')) {
                    document.getElementById('POWER_MEDIO_PPT').checked = formulario.POWER_MEDIO_PPT === 'X' ? true : false;
                }

                if (document.getElementById('POWER_ALTO_PPT')) {
                    document.getElementById('POWER_ALTO_PPT').checked = formulario.POWER_ALTO_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="POWER_CUMPLE_PPT"][value="${formulario.POWER_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="POWER_CUMPLE_PPT"][value="${formulario.POWER_CUMPLE_PPT}"]`).checked = true;
                }

                if (document.getElementById('NOMBRE_IDIOMA1_PPT')) {
                    document.getElementById('NOMBRE_IDIOMA1_PPT').value = formulario.NOMBRE_IDIOMA1_PPT || '';
                }

                if (document.querySelector(`input[name="APLICA_IDIOMA1_PPT"][value="${formulario.APLICA_IDIOMA1_PPT}"]`)) {
                    document.querySelector(`input[name="APLICA_IDIOMA1_PPT"][value="${formulario.APLICA_IDIOMA1_PPT}"]`).checked = true;
                }

                if (document.getElementById('BASICO_IDIOMA1_PPT')) {
                    document.getElementById('BASICO_IDIOMA1_PPT').checked = formulario.BASICO_IDIOMA1_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INTERMEDIO_IDIOMA1_PPT')) {
                    document.getElementById('INTERMEDIO_IDIOMA1_PPT').checked = formulario.INTERMEDIO_IDIOMA1_PPT === 'X' ? true : false;
                }

                if (document.getElementById('AVANZADO_IDIOMA1_PPT')) {
                    document.getElementById('AVANZADO_IDIOMA1_PPT').checked = formulario.AVANZADO_IDIOMA1_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="IDIOMA1_CUMPLE_PPT"][value="${formulario.IDIOMA1_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="IDIOMA1_CUMPLE_PPT"][value="${formulario.IDIOMA1_CUMPLE_PPT}"]`).checked = true;
                }


                if (document.getElementById('NOMBRE_IDIOMA2_PPT')) {
                    document.getElementById('NOMBRE_IDIOMA2_PPT').value = formulario.NOMBRE_IDIOMA2_PPT || '';
                }

                if (document.querySelector(`input[name="APLICA_IDIOMA2_PPT"][value="${formulario.APLICA_IDIOMA2_PPT}"]`)) {
                    document.querySelector(`input[name="APLICA_IDIOMA2_PPT"][value="${formulario.APLICA_IDIOMA2_PPT}"]`).checked = true;
                }

                if (document.getElementById('BASICO_IDIOMA2_PPT')) {
                    document.getElementById('BASICO_IDIOMA2_PPT').checked = formulario.BASICO_IDIOMA2_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INTERMEDIO_IDIOMA2_PPT')) {
                    document.getElementById('INTERMEDIO_IDIOMA2_PPT').checked = formulario.INTERMEDIO_IDIOMA2_PPT === 'X' ? true : false;
                }

                if (document.getElementById('AVANZADO_IDIOMA2_PPT')) {
                    document.getElementById('AVANZADO_IDIOMA2_PPT').checked = formulario.AVANZADO_IDIOMA2_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="IDIOMA2_CUMPLE_PPT"][value="${formulario.IDIOMA2_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="IDIOMA2_CUMPLE_PPT"][value="${formulario.IDIOMA2_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('NOMBRE_IDIOMA3_PPT')) {
                    document.getElementById('NOMBRE_IDIOMA3_PPT').value = formulario.NOMBRE_IDIOMA3_PPT || '';
                }

                if (document.querySelector(`input[name="APLICA_IDIOMA3_PPT"][value="${formulario.APLICA_IDIOMA3_PPT}"]`)) {
                    document.querySelector(`input[name="APLICA_IDIOMA3_PPT"][value="${formulario.APLICA_IDIOMA3_PPT}"]`).checked = true;
                }

                if (document.getElementById('BASICO_IDIOMA3_PPT')) {
                    document.getElementById('BASICO_IDIOMA3_PPT').checked = formulario.BASICO_IDIOMA3_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INTERMEDIO_IDIOMA3_PPT')) {
                    document.getElementById('INTERMEDIO_IDIOMA3_PPT').checked = formulario.INTERMEDIO_IDIOMA3_PPT === 'X' ? true : false;
                }

                if (document.getElementById('AVANZADO_IDIOMA3_PPT')) {
                    document.getElementById('AVANZADO_IDIOMA3_PPT').checked = formulario.AVANZADO_IDIOMA3_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="IDIOMA3_CUMPLE_PPT"][value="${formulario.IDIOMA3_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="IDIOMA3_CUMPLE_PPT"][value="${formulario.IDIOMA3_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('EXPERIENCIA_LABORAL_GENERAL_PPT')) {
                    document.getElementById('EXPERIENCIA_LABORAL_GENERAL_PPT').value = formulario.EXPERIENCIA_LABORAL_GENERAL_PPT || '';
                }
                
                if (document.getElementById('EXPERIENCIAGENERAL_CUMPLE_PPT')) {
                    document.getElementById('EXPERIENCIAGENERAL_CUMPLE_PPT').value = formulario.EXPERIENCIAGENERAL_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('CANTIDAD_EXPERIENCIA_PPT')) {
                    document.getElementById('CANTIDAD_EXPERIENCIA_PPT').value = formulario.CANTIDAD_EXPERIENCIA_PPT || '';
                }
                
                if (document.getElementById('CANTIDAD_EXPERIENCIA_CUMPLE_PPT')) {
                    document.getElementById('CANTIDAD_EXPERIENCIA_CUMPLE_PPT').value = formulario.CANTIDAD_EXPERIENCIA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('EXPERIENCIA_ESPECIFICA_PPT')) {
                    document.getElementById('EXPERIENCIA_ESPECIFICA_PPT').value = formulario.EXPERIENCIA_ESPECIFICA_PPT || '';
                }
                
                if (document.getElementById('EXPERIENCIA_ESPECIFICA_CUMPLE_PPT')) {
                    document.getElementById('EXPERIENCIA_ESPECIFICA_CUMPLE_PPT').value = formulario.EXPERIENCIA_ESPECIFICA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO1')) {
                    document.getElementById('PUESTO1').checked = formulario.PUESTO1 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO2')) {
                    document.getElementById('PUESTO2').checked = formulario.PUESTO2 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO3')) {
                    document.getElementById('PUESTO3').checked = formulario.PUESTO3 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO4')) {
                    document.getElementById('PUESTO4').checked = formulario.PUESTO4 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO5')) {
                    document.getElementById('PUESTO5').checked = formulario.PUESTO5 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO6')) {
                    document.getElementById('PUESTO6').checked = formulario.PUESTO6 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO7')) {
                    document.getElementById('PUESTO7').checked = formulario.PUESTO7 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO8')) {
                    document.getElementById('PUESTO8').checked = formulario.PUESTO8 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO9')) {
                    document.getElementById('PUESTO9').checked = formulario.PUESTO9 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO10')) {
                    document.getElementById('PUESTO10').checked = formulario.PUESTO10 === 'X' ? true : false;
                }

                if (document.getElementById('PUESTO1_NOMBRE')) {
                    document.getElementById('PUESTO1_NOMBRE').value = formulario.PUESTO1_NOMBRE || '';
                }
                
                
                if (document.getElementById('PUESTO1_CUMPLE_PPT')) {
                    document.getElementById('PUESTO1_CUMPLE_PPT').value = formulario.PUESTO1_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO2_NOMBRE')) {
                    document.getElementById('PUESTO2_NOMBRE').value = formulario.PUESTO2_NOMBRE || '';
                }
                
                
                if (document.getElementById('PUESTO2_CUMPLE_PPT')) {
                    document.getElementById('PUESTO2_CUMPLE_PPT').value = formulario.PUESTO2_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO3_NOMBRE')) {
                    document.getElementById('PUESTO3_NOMBRE').value = formulario.PUESTO3_NOMBRE || '';
                }
                

                if (document.getElementById('PUESTO3_CUMPLE_PPT')) {
                    document.getElementById('PUESTO3_CUMPLE_PPT').value = formulario.PUESTO3_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO4_NOMBRE')) {
                    document.getElementById('PUESTO4_NOMBRE').value = formulario.PUESTO4_NOMBRE || '';
                }
                
               
                if (document.getElementById('PUESTO4_CUMPLE_PPT')) {
                    document.getElementById('PUESTO4_CUMPLE_PPT').value = formulario.PUESTO4_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO5_NOMBRE')) {
                    document.getElementById('PUESTO5_NOMBRE').value = formulario.PUESTO5_NOMBRE || '';
                }
                
               
                
                if (document.getElementById('PUESTO5_CUMPLE_PPT')) {
                    document.getElementById('PUESTO5_CUMPLE_PPT').value = formulario.PUESTO5_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO6_NOMBRE')) {
                    document.getElementById('PUESTO6_NOMBRE').value = formulario.PUESTO6_NOMBRE || '';
                }
                
               
                
                if (document.getElementById('PUESTO6_CUMPLE_PPT')) {
                    document.getElementById('PUESTO6_CUMPLE_PPT').value = formulario.PUESTO6_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO7_NOMBRE')) {
                    document.getElementById('PUESTO7_NOMBRE').value = formulario.PUESTO7_NOMBRE || '';
                }
                
               
                
                if (document.getElementById('PUESTO7_CUMPLE_PPT')) {
                    document.getElementById('PUESTO7_CUMPLE_PPT').value = formulario.PUESTO7_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO8_NOMBRE')) {
                    document.getElementById('PUESTO8_NOMBRE').value = formulario.PUESTO8_NOMBRE || '';
                }
                
               
                
                if (document.getElementById('PUESTO8_CUMPLE_PPT')) {
                    document.getElementById('PUESTO8_CUMPLE_PPT').value = formulario.PUESTO8_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO9_NOMBRE')) {
                    document.getElementById('PUESTO9_NOMBRE').value = formulario.PUESTO9_NOMBRE || '';
                }
              
                
                if (document.getElementById('PUESTO9_CUMPLE_PPT')) {
                    document.getElementById('PUESTO9_CUMPLE_PPT').value = formulario.PUESTO9_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('PUESTO10_NOMBRE')) {
                    document.getElementById('PUESTO10_NOMBRE').value = formulario.PUESTO10_NOMBRE || '';
                }
                
               
                
                if (document.getElementById('PUESTO10_CUMPLE_PPT')) {
                    document.getElementById('PUESTO10_CUMPLE_PPT').value = formulario.PUESTO10_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('TIEMPO_EXPERIENCIA_PPT')) {
                    document.getElementById('TIEMPO_EXPERIENCIA_PPT').value = formulario.TIEMPO_EXPERIENCIA_PPT || '';
                }
                
                if (document.getElementById('TIEMPO_EXPERIENCIA_CUMPLE_PPT')) {
                    document.getElementById('TIEMPO_EXPERIENCIA_CUMPLE_PPT').value = formulario.TIEMPO_EXPERIENCIA_CUMPLE_PPT || '';
                }
                
                if (document.getElementById('INNOVACION_REQUERIDA_PPT')) {
                    document.getElementById('INNOVACION_REQUERIDA_PPT').checked = formulario.INNOVACION_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INNOVACION_DESEABLE_PPT')) {
                    document.getElementById('INNOVACION_DESEABLE_PPT').checked = formulario.INNOVACION_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INNOVACION_NO_REQUERIDA_PPT')) {
                    document.getElementById('INNOVACION_NO_REQUERIDA_PPT').checked = formulario.INNOVACION_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="INNOVACION_CUMPLE_PPT"][value="${formulario.INNOVACION_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="INNOVACION_CUMPLE_PPT"][value="${formulario.INNOVACION_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('PASION_REQUERIDA_PPT')) {
                    document.getElementById('PASION_REQUERIDA_PPT').checked = formulario.PASION_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('PASION_DESEABLE_PPT')) {
                    document.getElementById('PASION_DESEABLE_PPT').checked = formulario.PASION_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('PASION_NO_REQUERIDA_PPT')) {
                    document.getElementById('PASION_NO_REQUERIDA_PPT').checked = formulario.PASION_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="PASION_CUMPLE_PPT"][value="${formulario.PASION_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="PASION_CUMPLE_PPT"][value="${formulario.PASION_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('SERVICIO_CLIENTE_REQUERIDA_PPT')) {
                    document.getElementById('SERVICIO_CLIENTE_REQUERIDA_PPT').checked = formulario.SERVICIO_CLIENTE_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('SERVICIO_CLIENTE_DESEABLE_PPT')) {
                    document.getElementById('SERVICIO_CLIENTE_DESEABLE_PPT').checked = formulario.SERVICIO_CLIENTE_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('SERVICIO_CLIENTE_NO_REQUERIDA_PPT')) {
                    document.getElementById('SERVICIO_CLIENTE_NO_REQUERIDA_PPT').checked = formulario.SERVICIO_CLIENTE_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="SERVICIO_CLIENTE_CUMPLE_PPT"][value="${formulario.SERVICIO_CLIENTE_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="SERVICIO_CLIENTE_CUMPLE_PPT"][value="${formulario.SERVICIO_CLIENTE_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('COMUNICACION_EFICAZ_REQUERIDA_PPT')) {
                    document.getElementById('COMUNICACION_EFICAZ_REQUERIDA_PPT').checked = formulario.COMUNICACION_EFICAZ_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('COMUNICACION_EFICAZ_DESEABLE_PPT')) {
                    document.getElementById('COMUNICACION_EFICAZ_DESEABLE_PPT').checked = formulario.COMUNICACION_EFICAZ_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('COMUNICACION_EFICAZ_NO_REQUERIDA_PPT')) {
                    document.getElementById('COMUNICACION_EFICAZ_NO_REQUERIDA_PPT').checked = formulario.COMUNICACION_EFICAZ_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="COMUNICACION_EFICAZ_CUMPLE_PPT"][value="${formulario.COMUNICACION_EFICAZ_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="COMUNICACION_EFICAZ_CUMPLE_PPT"][value="${formulario.COMUNICACION_EFICAZ_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('TRABAJO_EQUIPO_REQUERIDA_PPT')) {
                    document.getElementById('TRABAJO_EQUIPO_REQUERIDA_PPT').checked = formulario.TRABAJO_EQUIPO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('TRABAJO_EQUIPO_DESEABLE_PPT')) {
                    document.getElementById('TRABAJO_EQUIPO_DESEABLE_PPT').checked = formulario.TRABAJO_EQUIPO_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('TRABAJO_EQUIPO_NO_REQUERIDA_PPT')) {
                    document.getElementById('TRABAJO_EQUIPO_NO_REQUERIDA_PPT').checked = formulario.TRABAJO_EQUIPO_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="TRABAJO_EQUIPO_CUMPLE_PPT"][value="${formulario.TRABAJO_EQUIPO_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="TRABAJO_EQUIPO_CUMPLE_PPT"][value="${formulario.TRABAJO_EQUIPO_CUMPLE_PPT}"]`).checked = true;
                }


                if (document.getElementById('INTEGRIDAD_REQUERIDA_PPT')) {
                    document.getElementById('INTEGRIDAD_REQUERIDA_PPT').checked = formulario.INTEGRIDAD_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INTEGRIDAD_DESEABLE_PPT')) {
                    document.getElementById('INTEGRIDAD_DESEABLE_PPT').checked = formulario.INTEGRIDAD_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('INTEGRIDAD_NO_REQUERIDA_PPT')) {
                    document.getElementById('INTEGRIDAD_NO_REQUERIDA_PPT').checked = formulario.INTEGRIDAD_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="INTEGRIDAD_CUMPLE_PPT"][value="${formulario.INTEGRIDAD_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="INTEGRIDAD_CUMPLE_PPT"][value="${formulario.INTEGRIDAD_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT')) {
                    document.getElementById('RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT').checked = formulario.RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('RESPONSABILIDAD_SOCIAL_DESEABLE_PPT')) {
                    document.getElementById('RESPONSABILIDAD_SOCIAL_DESEABLE_PPT').checked = formulario.RESPONSABILIDAD_SOCIAL_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT')) {
                    document.getElementById('RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT').checked = formulario.RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT"][value="${formulario.RESPONSABILIDAD_SOCIAL_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT"][value="${formulario.RESPONSABILIDAD_SOCIAL_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('ADAPTABILIDAD_REQUERIDA_PPT')) {
                    document.getElementById('ADAPTABILIDAD_REQUERIDA_PPT').checked = formulario.ADAPTABILIDAD_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('ADAPTABILIDAD_DESEABLE_PPT')) {
                    document.getElementById('ADAPTABILIDAD_DESEABLE_PPT').checked = formulario.ADAPTABILIDAD_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('ADAPTABILIDAD_NO_REQUERIDA_PPT')) {
                    document.getElementById('ADAPTABILIDAD_NO_REQUERIDA_PPT').checked = formulario.ADAPTABILIDAD_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="ADAPTABILIDAD_CUMPLE_PPT"][value="${formulario.ADAPTABILIDAD_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="ADAPTABILIDAD_CUMPLE_PPT"][value="${formulario.ADAPTABILIDAD_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('LIDERAZGO_REQUERIDA_PPT')) {
                    document.getElementById('LIDERAZGO_REQUERIDA_PPT').checked = formulario.LIDERAZGO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('LIDERAZGO_DESEABLE_PPT')) {
                    document.getElementById('LIDERAZGO_DESEABLE_PPT').checked = formulario.LIDERAZGO_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('LIDERAZGO_NO_REQUERIDA_PPT')) {
                    document.getElementById('LIDERAZGO_NO_REQUERIDA_PPT').checked = formulario.LIDERAZGO_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="LIDERAZGO_CUMPLE_PPT"][value="${formulario.LIDERAZGO_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="LIDERAZGO_CUMPLE_PPT"][value="${formulario.LIDERAZGO_CUMPLE_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('TOMA_DECISIONES_REQUERIDA_PPT')) {
                    document.getElementById('TOMA_DECISIONES_REQUERIDA_PPT').checked = formulario.TOMA_DECISIONES_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.getElementById('TOMA_DECISIONES_DESEABLE_PPT')) {
                    document.getElementById('TOMA_DECISIONES_DESEABLE_PPT').checked = formulario.TOMA_DECISIONES_DESEABLE_PPT === 'X' ? true : false;
                }

                if (document.getElementById('TOMA_DECISIONES_NO_REQUERIDA_PPT')) {
                    document.getElementById('TOMA_DECISIONES_NO_REQUERIDA_PPT').checked = formulario.TOMA_DECISIONES_NO_REQUERIDA_PPT === 'X' ? true : false;
                }

                if (document.querySelector(`input[name="TOMA_DECISIONES_CUMPLE_PPT"][value="${formulario.TOMA_DECISIONES_CUMPLE_PPT}"]`)) {
                    document.querySelector(`input[name="TOMA_DECISIONES_CUMPLE_PPT"][value="${formulario.TOMA_DECISIONES_CUMPLE_PPT}"]`).checked = true;
                }

                if (document.querySelector(`input[name="DISPONIBILIDAD_VIAJAR_PPT"][value="${formulario.DISPONIBILIDAD_VIAJAR_PPT}"]`)) {
                    document.querySelector(`input[name="DISPONIBILIDAD_VIAJAR_PPT"][value="${formulario.DISPONIBILIDAD_VIAJAR_PPT}"]`).checked = true;
                }

                                
                if (document.querySelector(`input[name="REQUIERE_PASAPORTE_PPT"][value="${formulario.REQUIERE_PASAPORTE_PPT}"]`)) {
                    document.querySelector(`input[name="REQUIERE_PASAPORTE_PPT"][value="${formulario.REQUIERE_PASAPORTE_PPT}"]`).checked = true;
                }

                                
                if (document.querySelector(`input[name="REQUIERE_VISA_PPT"][value="${formulario.REQUIERE_VISA_PPT}"]`)) {
                    document.querySelector(`input[name="REQUIERE_VISA_PPT"][value="${formulario.REQUIERE_VISA_PPT}"]`).checked = true;
                }

                                
                if (document.querySelector(`input[name="REQUIERE_LICENCIA_PPT"][value="${formulario.REQUIERE_LICENCIA_PPT}"]`)) {
                    document.querySelector(`input[name="REQUIERE_LICENCIA_PPT"][value="${formulario.REQUIERE_LICENCIA_PPT}"]`).checked = true;
                }

                if (document.querySelector(`input[name="CAMBIO_RESIDENCIA_PPT"][value="${formulario.CAMBIO_RESIDENCIA_PPT}"]`)) {
                    document.querySelector(`input[name="CAMBIO_RESIDENCIA_PPT"][value="${formulario.CAMBIO_RESIDENCIA_PPT}"]`).checked = true;
                }

                
                if (document.getElementById('DISPONIBILIDAD_VIAJAR_OPCION_PPT')) {
                    document.getElementById('DISPONIBILIDAD_VIAJAR_OPCION_PPT').value = formulario.DISPONIBILIDAD_VIAJAR_OPCION_PPT || '';
                }
                
                if (document.getElementById('DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE')) {
                    document.getElementById('DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE').value = formulario.DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE || '';
                }
                
                if (document.getElementById('REQUIEREPASAPORTE_OPCION_PPT')) {
                    document.getElementById('REQUIEREPASAPORTE_OPCION_PPT').value = formulario.REQUIEREPASAPORTE_OPCION_PPT || '';
                }
                
                if (document.getElementById('REQUIEREPASAPORTE_OPCION_CUMPLE')) {
                    document.getElementById('REQUIEREPASAPORTE_OPCION_CUMPLE').value = formulario.REQUIEREPASAPORTE_OPCION_CUMPLE || '';
                }
                
                if (document.getElementById('REQUIERE_VISA_OPCION_PPT')) {
                    document.getElementById('REQUIERE_VISA_OPCION_PPT').value = formulario.REQUIERE_VISA_OPCION_PPT || '';
                }
                
                if (document.getElementById('REQUIEREVISA_OPCION_CUMPLE')) {
                    document.getElementById('REQUIEREVISA_OPCION_CUMPLE').value = formulario.REQUIEREVISA_OPCION_CUMPLE || '';
                }
                
                if (document.getElementById('REQUIERELICENCIA_OPCION_PPT')) {
                    document.getElementById('REQUIERELICENCIA_OPCION_PPT').value = formulario.REQUIERELICENCIA_OPCION_PPT || '';
                }
                
                if (document.getElementById('REQUIERELICENCIA_OPCION_CUMPLE')) {
                    document.getElementById('REQUIERELICENCIA_OPCION_CUMPLE').value = formulario.REQUIERELICENCIA_OPCION_CUMPLE || '';
                }
                
                if (document.getElementById('CAMBIORESIDENCIA_OPCION_PPT')) {
                    document.getElementById('CAMBIORESIDENCIA_OPCION_PPT').value = formulario.CAMBIORESIDENCIA_OPCION_PPT || '';
                }
                
                if (document.getElementById('CAMBIORESIDENCIA_OPCION_CUMPLE')) {
                    document.getElementById('CAMBIORESIDENCIA_OPCION_CUMPLE').value = formulario.CAMBIORESIDENCIA_OPCION_CUMPLE || '';
                }
                
                if (document.getElementById('OBSERVACIONES_PPT')) {
                    document.getElementById('OBSERVACIONES_PPT').value = formulario.OBSERVACIONES_PPT || '';
                }
                if (document.getElementById('ELABORADO_NOMBRE_PPT')) {
                    document.getElementById('ELABORADO_NOMBRE_PPT').value = formulario.ELABORADO_NOMBRE_PPT || '';
                }
                
                if (document.getElementById('ELABORADO_FIRMA_PPT')) {
                    document.getElementById('ELABORADO_FIRMA_PPT').value = formulario.ELABORADO_FIRMA_PPT || '';
                }
                
                if (document.getElementById('ELABORADO_FECHA_PPT')) {
                    document.getElementById('ELABORADO_FECHA_PPT').value = formulario.ELABORADO_FECHA_PPT || '';
                }
                
                if (document.getElementById('REVISADO_NOMBRE_PPT')) {
                    document.getElementById('REVISADO_NOMBRE_PPT').value = formulario.REVISADO_NOMBRE_PPT || '';
                }
                
                if (document.getElementById('REVISADO_FIRMA_PPT')) {
                    document.getElementById('REVISADO_FIRMA_PPT').value = formulario.REVISADO_FIRMA_PPT || '';
                }
                
                if (document.getElementById('REVISADO_FECHA_PPT')) {
                    document.getElementById('REVISADO_FECHA_PPT').value = formulario.REVISADO_FECHA_PPT || '';
                }
                
                if (document.getElementById('AUTORIZADO_NOMBRE_PPT')) {
                    document.getElementById('AUTORIZADO_NOMBRE_PPT').value = formulario.AUTORIZADO_NOMBRE_PPT || '';
                }
                
                if (document.getElementById('AUTORIZADO_FIRMA_PPT')) {
                    document.getElementById('AUTORIZADO_FIRMA_PPT').value = formulario.AUTORIZADO_FIRMA_PPT || '';
                }
                
                if (document.getElementById('AUTORIZADO_FECHA_PPT')) {
                    document.getElementById('AUTORIZADO_FECHA_PPT').value = formulario.AUTORIZADO_FECHA_PPT || '';
                }
                                

                document.getElementById('NOMBRE_TRABAJADOR_PPT').value = nombreTrabajador;




                // I. Características generales
                    if (document.getElementById('SUMA_CARACTERISTICAS')) {
                        document.getElementById('SUMA_CARACTERISTICAS').value = formulario.SUMA_CARACTERISTICAS || '';
                    }
                    if (document.getElementById('PORCENTAJE_EDAD')) {
                        document.getElementById('PORCENTAJE_EDAD').value = formulario.PORCENTAJE_EDAD || '';
                    }
                    if (document.getElementById('PORCENTAJE_GENERO')) {
                        document.getElementById('PORCENTAJE_GENERO').value = formulario.PORCENTAJE_GENERO || '';
                    }
                    if (document.getElementById('PORCENTAJE_ESTADOCIVIL')) {
                        document.getElementById('PORCENTAJE_ESTADOCIVIL').value = formulario.PORCENTAJE_ESTADOCIVIL || '';
                    }
                    if (document.getElementById('PORCENTAJE_NACIONALIDAD')) {
                        document.getElementById('PORCENTAJE_NACIONALIDAD').value = formulario.PORCENTAJE_NACIONALIDAD || '';
                    }
                    if (document.getElementById('PORCENTAJE_DISCAPACIDAD')) {
                        document.getElementById('PORCENTAJE_DISCAPACIDAD').value = formulario.PORCENTAJE_DISCAPACIDAD || '';
                    }

                    // II. Formación académica
                    if (document.getElementById('SUMA_FORMACION')) {
                        document.getElementById('SUMA_FORMACION').value = formulario.SUMA_FORMACION || '';
                    }
                    if (document.getElementById('PORCENTAJE_SECUNDARIA')) {
                        document.getElementById('PORCENTAJE_SECUNDARIA').value = formulario.PORCENTAJE_SECUNDARIA || '';
                    }
                    if (document.getElementById('PORCENTAJE_MEDIASUPERIOR')) {
                        document.getElementById('PORCENTAJE_MEDIASUPERIOR').value = formulario.PORCENTAJE_MEDIASUPERIOR || '';
                    }
                    if (document.getElementById('PORCENTAJE_TECNICOSUPERIOR')) {
                        document.getElementById('PORCENTAJE_TECNICOSUPERIOR').value = formulario.PORCENTAJE_TECNICOSUPERIOR || '';
                    }
                    if (document.getElementById('PORCENTAJE_UNIVERSITARIO')) {
                        document.getElementById('PORCENTAJE_UNIVERSITARIO').value = formulario.PORCENTAJE_UNIVERSITARIO || '';
                    }
                    if (document.getElementById('PORCENTAJE_SITUACIONACADEMICA')) {
                        document.getElementById('PORCENTAJE_SITUACIONACADEMICA').value = formulario.PORCENTAJE_SITUACIONACADEMICA || '';
                    }
                    if (document.getElementById('PORCENTAJE_CEDULA')) {
                        document.getElementById('PORCENTAJE_CEDULA').value = formulario.PORCENTAJE_CEDULA || '';
                    }
                    if (document.getElementById('PORCENTAJE_AREA1')) {
                        document.getElementById('PORCENTAJE_AREA1').value = formulario.PORCENTAJE_AREA1 || '';
                    }
                    if (document.getElementById('PORCENTAJE_AREA2')) {
                        document.getElementById('PORCENTAJE_AREA2').value = formulario.PORCENTAJE_AREA2 || '';
                    }
                    if (document.getElementById('PORCENTAJE_AREA3')) {
                        document.getElementById('PORCENTAJE_AREA3').value = formulario.PORCENTAJE_AREA3 || '';
                    }
                    if (document.getElementById('PORCENTAJE_AREA4')) {
                        document.getElementById('PORCENTAJE_AREA4').value = formulario.PORCENTAJE_AREA4 || '';
                    }
                    if (document.getElementById('PORCENTAJE_ESPECIALIDAD')) {
                        document.getElementById('PORCENTAJE_ESPECIALIDAD').value = formulario.PORCENTAJE_ESPECIALIDAD || '';
                    }
                    if (document.getElementById('PORCENTAJE_MAESTRIA')) {
                        document.getElementById('PORCENTAJE_MAESTRIA').value = formulario.PORCENTAJE_MAESTRIA || '';
                    }
                    if (document.getElementById('PORCENTAJE_DOCTORADO')) {
                        document.getElementById('PORCENTAJE_DOCTORADO').value = formulario.PORCENTAJE_DOCTORADO || '';
                    }

                    // III. Conocimientos adicionales
                    if (document.getElementById('SUMA_CONOCIMIENTO')) {
                        document.getElementById('SUMA_CONOCIMIENTO').value = formulario.SUMA_CONOCIMIENTO || '';
                    }
                    if (document.getElementById('PORCENTAJE_WORD')) {
                        document.getElementById('PORCENTAJE_WORD').value = formulario.PORCENTAJE_WORD || '';
                    }
                    if (document.getElementById('PORCENTAJE_EXCEL')) {
                        document.getElementById('PORCENTAJE_EXCEL').value = formulario.PORCENTAJE_EXCEL || '';
                    }
                    if (document.getElementById('PORCENTAJE_POWERPOINT')) {
                        document.getElementById('PORCENTAJE_POWERPOINT').value = formulario.PORCENTAJE_POWERPOINT || '';
                    }
                    if (document.getElementById('PORCENTAJE_IDIOMA1')) {
                        document.getElementById('PORCENTAJE_IDIOMA1').value = formulario.PORCENTAJE_IDIOMA1 || '';
                    }
                    if (document.getElementById('PORCENTAJE_IDIOMA2')) {
                        document.getElementById('PORCENTAJE_IDIOMA2').value = formulario.PORCENTAJE_IDIOMA2 || '';
                    }
                    if (document.getElementById('PORCENTAJE_IDIOMA3')) {
                        document.getElementById('PORCENTAJE_IDIOMA3').value = formulario.PORCENTAJE_IDIOMA3 || '';
                    }

                    // IV. Cursos
                    if (document.getElementById('SUMA_CURSOS')) {
                        document.getElementById('SUMA_CURSOS').value = formulario.SUMA_CURSOS || '';
                    }

                    // V. Experiencia
                    if (document.getElementById('SUMA_EXPERIENCIA')) {
                        document.getElementById('SUMA_EXPERIENCIA').value = formulario.SUMA_EXPERIENCIA || '';
                    }
                    if (document.getElementById('PORCENTAJE_EXPERIENCIAGENERAL')) {
                        document.getElementById('PORCENTAJE_EXPERIENCIAGENERAL').value = formulario.PORCENTAJE_EXPERIENCIAGENERAL || '';
                    }
                    if (document.getElementById('PORCENTAJE_CANTIDADTOTAL')) {
                        document.getElementById('PORCENTAJE_CANTIDADTOTAL').value = formulario.PORCENTAJE_CANTIDADTOTAL || '';
                    }
                    if (document.getElementById('PORCENTAJE_EXPERIENCIAESPECIFICA')) {
                        document.getElementById('PORCENTAJE_EXPERIENCIAESPECIFICA').value = formulario.PORCENTAJE_EXPERIENCIAESPECIFICA || '';
                    }
                    if (document.getElementById('PORCENTAJE_INDIQUEXPERIENCIA')) {
                        document.getElementById('PORCENTAJE_INDIQUEXPERIENCIA').value = formulario.PORCENTAJE_INDIQUEXPERIENCIA || '';
                    }

                    // VI. Habilidades y competencias funcionales
                    if (document.getElementById('SUMA_HABILIDADES')) {
                        document.getElementById('SUMA_HABILIDADES').value = formulario.SUMA_HABILIDADES || '';
                    }
                    if (document.getElementById('PORCENTAJE_INNOVACION')) {
                        document.getElementById('PORCENTAJE_INNOVACION').value = formulario.PORCENTAJE_INNOVACION || '';
                    }
                    if (document.getElementById('PORCENTAJE_PASION')) {
                        document.getElementById('PORCENTAJE_PASION').value = formulario.PORCENTAJE_PASION || '';
                    }
                    if (document.getElementById('PORCENTAJE_SERVICIO_CLIENTE')) {
                        document.getElementById('PORCENTAJE_SERVICIO_CLIENTE').value = formulario.PORCENTAJE_SERVICIO_CLIENTE || '';
                    }
                    if (document.getElementById('PORCENTAJE_COMUNICACION_EFICAZ')) {
                        document.getElementById('PORCENTAJE_COMUNICACION_EFICAZ').value = formulario.PORCENTAJE_COMUNICACION_EFICAZ || '';
                    }
                    if (document.getElementById('PORCENTAJE_TRABAJO_EQUIPO')) {
                        document.getElementById('PORCENTAJE_TRABAJO_EQUIPO').value = formulario.PORCENTAJE_TRABAJO_EQUIPO || '';
                    }
                    if (document.getElementById('PORCENTAJE_INTEGRIDAD')) {
                        document.getElementById('PORCENTAJE_INTEGRIDAD').value = formulario.PORCENTAJE_INTEGRIDAD || '';
                    }
                    if (document.getElementById('PORCENTAJE_RESPONSABILIDAD_SOCIAL')) {
                        document.getElementById('PORCENTAJE_RESPONSABILIDAD_SOCIAL').value = formulario.PORCENTAJE_RESPONSABILIDAD_SOCIAL || '';
                    }
                    if (document.getElementById('PORCENTAJE_ADAPTABILIDAD')) {
                        document.getElementById('PORCENTAJE_ADAPTABILIDAD').value = formulario.PORCENTAJE_ADAPTABILIDAD || '';
                    }
                    if (document.getElementById('PORCENTAJE_LIDERAZGO')) {
                        document.getElementById('PORCENTAJE_LIDERAZGO').value = formulario.PORCENTAJE_LIDERAZGO || '';
                    }
                    if (document.getElementById('PORCENTAJE_TOMA_DECISIONES')) {
                        document.getElementById('PORCENTAJE_TOMA_DECISIONES').value = formulario.PORCENTAJE_TOMA_DECISIONES || '';
                    }



             let cursos = data.cursos;

             let openAccordion1 = false;
             let openAccordion2 = false;
             let openAccordion3 = false;
             let openAccordion4 = false;

             cursos.forEach((curso, index) => {
                 if (index < 10) {
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;
                    document.getElementById(`PORCENTAJE_CURSO${index + 1}`).value = curso.PORCENTAJE_CURSO || '';

                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion1 = true;
                     }
                 } else if (index >= 10 && index < 20) {
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;
                    document.getElementById(`PORCENTAJE_CURSO${index + 1}`).value = curso.PORCENTAJE_CURSO || '';


                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion2 = true;
                     }
                 } else if (index >= 20 && index < 30) {
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;
                    document.getElementById(`PORCENTAJE_CURSO${index + 1}`).value = curso.PORCENTAJE_CURSO || '';


                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion3 = true;
                     }
                 } else if (index >= 30 && index < 40) {
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;
                    document.getElementById(`PORCENTAJE_CURSO${index + 1}`).value = curso.PORCENTAJE_CURSO || '';

                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion4 = true;
                     }
                 }
             });

             if (openAccordion1) {
                 var accordion1 = new bootstrap.Collapse(document.getElementById('cursoTemasCollapse'), {
                     toggle: true
                 });
             }
             if (openAccordion2) {
                 var accordion2 = new bootstrap.Collapse(document.getElementById('cursoTemas1Collapse'), {
                     toggle: true
                 });
             }
             if (openAccordion3) {
                 var accordion3 = new bootstrap.Collapse(document.getElementById('cursoTemas2Collapse'), {
                     toggle: true
                 });
             }
             if (openAccordion4) {
                 var accordion4 = new bootstrap.Collapse(document.getElementById('cursoTemas3Collapse'), {
                     toggle: true
                 });
             }
         })
         .catch(error => {
             Swal.close();
             console.error('Error al obtener los datos:', error);
         });
 }
});




// $("#guardarFormSeleccionPPT").click(function (e) {
//     e.preventDefault();

//     formularioValido = validarFormularioV1('formularioSeleccionPPT');

//     if (formularioValido) {

//                 const brechasFormacion = obtenerBrechasFormacion();
//                 const brechasHabilidades = obtenerBrechasHabilidades();
//                 const brechasConocimientos = obtenerBrechasConocimientos();
//                 const brechasExperiencia = obtenerBrechasExperiencia();
//                 const brechasCursos = obtenerBrechasCursos();

//                 // OBTENER SUMA TOTAL ACTUAL Y CALCULAR FALTANTE
//                 const inputSuma = document.getElementById("SUMA_TOTAL");
//                 const sumaTotal = parseFloat(inputSuma?.value || 0);
//                 const faltante = 100 - sumaTotal;

//                 // MOSTRAR EN CONSOLA
//                 console.log("-- Brechas por Formación --");
//                 console.log(brechasFormacion.brechas);

//                 console.log("-- Brechas por Habilidades --");
//                 console.log(brechasHabilidades.brechas);

//                 console.log("-- Brechas por Conocimientos --");
//                 console.log(brechasConocimientos.brechas);

//                 console.log("-- Brechas por Experiencia --");
//                 console.log(brechasExperiencia.brechas);

//                 console.log("-- Brechas por Cursos --");
//                 console.log(brechasCursos.brechas);

//         console.log("-- Porcentaje restante para 100%: " + faltante.toFixed(1) + "%");
        


//         if (ID_PPT_SELECCION == 0) {

//             alertMensajeConfirm({
//                 title: "¿Desea guardar la información?",
//                 text: "Al guardarla, se usará para la creación del PPT",
//                 icon: "question",
//             }, async function () {

//                 await loaderbtn('guardarFormSeleccionPPT');
//                 await ajaxAwaitFormData({
//                     api: 1,
//                     ID_PPT_SELECCION: ID_PPT_SELECCION,
//                     CURP: curpSeleccionada
//                 }, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', { callbackAfter: true, callbackBefore: true }, () => {

//                     Swal.fire({
//                         icon: 'info',
//                         title: 'Espere un momento',
//                         text: 'Estamos guardando la información',
//                         showConfirmButton: false
//                     });

//                     $('.swal2-popup').addClass('ld ld-breath');

//                 }, function (data) {

//                     setTimeout(() => {
//                         ID_PPT_SELECCION = data.PPT.ID_PPT_SELECCION;
//                         alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para hacer uso del PPT', null, null, 1500);
//                         $('#miModal_ppt').modal('hide');
//                         document.getElementById('formularioSeleccionPPT').reset();

//                         if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
//                             Tablapptseleccion.ajax.reload(null, false);
//                         }

//                         // Mostrar la brecha en consola si se requiere también después del guardado
//                         console.log("Brecha de competencias guardadas:", brecha);

//                     }, 300);
//                 });

//             }, 1);

//         } else {

//             alertMensajeConfirm({
//                 title: "¿Desea editar la información de este formulario?",
//                 text: "Al guardarla, se editará la información del PPT",
//                 icon: "question",
//             }, async function () {

//                 await loaderbtn('guardarFormSeleccionPPT');
//                 await ajaxAwaitFormData({
//                     api: 1,
//                     ID_PPT_SELECCION: ID_PPT_SELECCION,
//                     CURP: curpSeleccionada
//                 }, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', { callbackAfter: true, callbackBefore: true }, () => {

//                     Swal.fire({
//                         icon: 'info',
//                         title: 'Espere un momento',
//                         text: 'Estamos guardando la información',
//                         showConfirmButton: false
//                     });

//                     $('.swal2-popup').addClass('ld ld-breath');

//                 }, function (data) {

//                     setTimeout(() => {
//                         ID_PPT_SELECCION = data.PPT.ID_PPT_SELECCION;
//                         alertMensaje('success', 'Información editada correctamente', 'Información guardada');
//                         $('#miModal_ppt').modal('hide');
//                         document.getElementById('formularioSeleccionPPT').reset();

//                         if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
//                             Tablapptseleccion.ajax.reload(null, false);
//                         }

//                         console.log("Brecha de competencias editadas:", brecha);

//                     }, 300);
//                 });

//             }, 1);
//         }

//     } else {
//         alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
//     }
// });







$("#guardarFormSeleccionPPT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioSeleccionPPT');

    if (formularioValido) {
        // Obtener todas las brechas
        const brechasFormacion = obtenerBrechasFormacion();
        const brechasHabilidades = obtenerBrechasHabilidades();
        const brechasConocimientos = obtenerBrechasConocimientos();
        const brechasExperiencia = obtenerBrechasExperiencia();
        const brechasCursos = obtenerBrechasCursos();

        const inputSuma = document.getElementById("SUMA_TOTAL");
        const sumaTotal = parseFloat(inputSuma?.value || 0);
        const porcentajeFaltante = Math.max(0, (100 - sumaTotal).toFixed(1));

        const brecha = {
            formacion: brechasFormacion.brechasDetalladas,
            habilidades: brechasHabilidades.brechasDetalladas,
            conocimientos: brechasConocimientos.brechasDetalladas,
            experiencia: brechasExperiencia.brechasDetalladas,
            cursos: brechasCursos.brechasDetalladas
        };

        

        const datosEnvio = {
            api: 1,
            ID_PPT_SELECCION: ID_PPT_SELECCION,
            CURP: curpSeleccionada,
            NOMBRE_BRECHA: nombreTrabajadorSeleccionado,
            PORCENTAJE_FALTANTE: porcentajeFaltante,
            BRECHA_JSON: JSON.stringify(brecha)
        };

        if (ID_PPT_SELECCION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usará para la creación del PPT",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormSeleccionPPT');
                await ajaxAwaitFormData(datosEnvio, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', {
                    callbackAfter: true,
                    callbackBefore: true
                }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_PPT_SELECCION = data.PPT.ID_PPT_SELECCION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para hacer uso del PPT', null, null, 1500);
                        $('#miModal_ppt').modal('hide');
                        document.getElementById('formularioSeleccionPPT').reset();

                        if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
                            Tablapptseleccion.ajax.reload(null, false);
                        }

                        console.log("Brecha de competencias guardadas:", brecha);
                    }, 300);
                });
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editará la información del PPT",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormSeleccionPPT');
                await ajaxAwaitFormData(datosEnvio, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', {
                    callbackAfter: true,
                    callbackBefore: true
                }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_PPT_SELECCION = data.PPT.ID_PPT_SELECCION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#miModal_ppt').modal('hide');
                        document.getElementById('formularioSeleccionPPT').reset();

                        if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
                            Tablapptseleccion.ajax.reload(null, false);
                        }

                        console.log("Brecha de competencias editadas:", brecha);
                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});





//  document.addEventListener("DOMContentLoaded", function () {
//     const radioButtons = document.querySelectorAll(
//         "input[name='EDAD_CUMPLE_PPT'], input[name='GENERO_CUMPLE_PPT'], input[name='ESTADO_CIVIL_CUMPLE_PPT'], input[name='NACIONALIDAD_CUMPLE_PPT']"
//     );

//     const selectRadioPairs = [
//         { select: "SECUNDARIA_PPT", radio: "SECUNDARIA_CUMPLE_PPT" },
//         { select: "TECNICA_PPT", radio: "TECNICA_CUMPLE_PPT" },
//         { select: "TECNICO_PPT", radio: "TECNICO_CUMPLE_PPT" },
//         { select: "UNIVERSITARIO_PPT", radio: "UNIVERSITARIO_CUMPLE_PPT" },
//         { select: "SITUACION_PPT", radio: "SITUACION_CUMPLE_PPT" },
//         { select: "CEDULA_PPT", radio: "CEDULA_CUMPLE_PPT" },
//         { select: "AREA1_PPT", radio: "AREA1_CUMPLE_PPT" },
//         { select: "AREA2_PPT", radio: "AREA2_CUMPLE_PPT" },
//         { select: "AREA3_PPT", radio: "AREA3_CUMPLE_PPT" },
//         { select: "AREA4_PPT", radio: "AREA4_CUMPLE_PPT" },
//         { radio: "ESPECIALIDAD_CUMPLE_PPT", dependentRadios: ["EGRESADO_ESPECIALIDAD_PPT"] },
//         { radio: "MAESTRIA_CUMPLE_PPT", dependentRadios: ["EGRESADO_MAESTRIA_PPT"] },
//         { radio: "DOCTORADO_CUMPLE_PPT", dependentRadios: ["EGRESADO_DOCTORADO_PPT"] },
//     ];

//     const tools = [
//         { aplica: "WORD_APLICA_PPT", cumple: "WORD_CUMPLE_PPT", peso: 1.5 },
//         { aplica: "EXCEL_APLICA_PPT", cumple: "EXCEL_CUMPLE_PPT", peso: 1.5 },
//         { aplica: "POWER_APLICA_PPT", cumple: "POWER_CUMPLE_PPT", peso: 3 },
//     ];

//     const idiomas = [
//         { aplica: "APLICA_IDIOMA1_PPT", cumple: "IDIOMA1_CUMPLE_PPT", peso: 1.3333 },
//         { aplica: "APLICA_IDIOMA2_PPT", cumple: "IDIOMA2_CUMPLE_PPT", peso: 1.3333 },
//         { aplica: "APLICA_IDIOMA3_PPT", cumple: "IDIOMA3_CUMPLE_PPT", peso: 1.3333 },
//     ];

//     const cursosContainer = document.querySelectorAll("textarea[name='CURSO_PPT[]']");
//     const pesoTotalCursos = 25;

//       const competencias = [
//         { name: "INNOVACION", peso: 6 / 8 },
//         { name: "PASION", peso: 6 / 8 },
//         { name: "SERVICIO_CLIENTE", peso: 6 / 8 },
//         { name: "COMUNICACION_EFICAZ", peso: 6 / 8 },
//         { name: "TRABAJO_EQUIPO", peso: 6 / 8 },
//         { name: "INTEGRIDAD", peso: 6 / 8 },
//         { name: "RESPONSABILIDAD_SOCIAL", peso: 6 / 8 },
//         { name: "ADAPTABILIDAD", peso: 6 / 8 },
//         { name: "LIDERAZGO", peso: 2 },
//         { name: "TOMA_DECISIONES", peso: 2 },
//     ];



//     const requisitosMovilidad = [
//         { name: "DISPONIBILIDAD_VIAJAR_PPT", cumple: "DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE" },
//         { name: "REQUIERE_PASAPORTE_PPT", cumple: "REQUIEREPASAPORTE_OPCION_CUMPLE" },
//         { name: "REQUIERE_VISA_PPT", cumple: "REQUIEREVISA_OPCION_CUMPLE" },
//         { name: "REQUIERE_LICENCIA_PPT", cumple: "REQUIERELICENCIA_OPCION_CUMPLE" },
//         { name: "CAMBIO_RESIDENCIA_PPT", cumple: "CAMBIORESIDENCIA_OPCION_CUMPLE" },
//     ];



//     const experienciaGeneralRadio = document.querySelectorAll("input[name='EXPERIENCIAGENERAL_CUMPLE_PPT']");
//     const experienciaEspecificaRadio = document.querySelectorAll("input[name='EXPERIENCIA_ESPECIFICA_CUMPLE_PPT']");
//     const puestosContainer = document.querySelectorAll("select.puesto");
//     const pesoEspecifica = 7;

//     const pesoTotal20 = 20;
//     const pesoTotal6 = 6;
//     const pesoTotalIdiomas = 4;
//     const totalInput = document.getElementById("SUMA_TOTAL");


     
//   function calcularSumaTotal() {
//     let sumaTotal = 0;

//         let puntosRequisitosMovilidad = 0;
//         let puntosDatosGenerales = 0;
//         let radiosGeneralesSeleccionados = 0;

//         const movilidadAplica = requisitosMovilidad.filter(({ name }) => {
//             const aplica = document.querySelector(`input[name='${name}']:checked`);
//             return aplica?.value === "si";
//         });

//         const alMenosUnRequisitoAplica = movilidadAplica.length > 0;

//         const requisitosCumplen = requisitosMovilidad.filter(({ name, cumple }) => {
//             const aplica = document.querySelector(`input[name='${name}']:checked`);
//             const cumpleOK = document.querySelector(`input[name='${cumple}']:checked`);
//             return aplica?.value === "si" && cumpleOK?.value === "si";
//         });

//         const requisitosValidos = requisitosCumplen.length;

//         const pesoRadioGeneral = alMenosUnRequisitoAplica ? 1.25 : 2.5;

//         radioButtons.forEach((radio) => {
//             if (radio.checked && radio.value === "si") {
//                 sumaTotal += pesoRadioGeneral;
//                 puntosDatosGenerales += pesoRadioGeneral;
//                 radiosGeneralesSeleccionados++;
//             }
//         });

// if (requisitosValidos > 0) {
//     const pesoPorRequisito = 5 / requisitosValidos;
//     requisitosCumplen.forEach(({ name, cumple }) => {
//         const aplica = document.querySelector(`input[name='${name}']:checked`);
//         const cumpleOK = document.querySelector(`input[name='${cumple}']:checked`);
//         if (aplica?.value === "si" && cumpleOK?.value === "si") {
//             sumaTotal += pesoPorRequisito;
//             puntosRequisitosMovilidad += pesoPorRequisito;
//         }
//     });
// }



//     const seccionesValidas = selectRadioPairs.filter(({ select, dependentRadios }) => {
//         if (select) {
//             const selectElement = document.getElementById(select);
//             if (!selectElement || selectElement.value === "0" || selectElement.value === "Seleccione una opción") {
//                 return false;
//             }
//         }

//         if (dependentRadios) {
//             const algunoMarcado = dependentRadios.some(depRadioName => {
//                 const radio = document.querySelector(`input[name='${depRadioName}']:checked`);
//                 return radio && radio.value === "si";
//             });
//             if (!algunoMarcado) return false;
//         }

//         return true;
//     });

//     const pesoPorSeccion = seccionesValidas.length > 0 ? pesoTotal20 / seccionesValidas.length : 0;

//     seccionesValidas.forEach(({ radio }) => {
//         const radios = document.getElementsByName(radio);
//         radios.forEach((r) => {
//             if (r.checked && r.value === "si") {
//                 sumaTotal += pesoPorSeccion;
//             }
//         });
//     });

//     // Herramientas
//     let validTools = 0;
//     tools.forEach(({ aplica, cumple, peso }) => {
//         const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//         const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//         if (aplicaElement && aplicaElement.value === "si") {
//             validTools++;
//             if (cumpleElement && cumpleElement.value === "si") {
//                 sumaTotal += peso;
//             }
//         }
//     });

//     if (validTools < tools.length && validTools > 0) {
//         const adjustedWeight = pesoTotal6 / validTools;
//         tools.forEach(({ aplica, cumple, peso }) => {
//             const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//             const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//             if (aplicaElement && aplicaElement.value === "si") {
//                 if (cumpleElement && cumpleElement.value === "si") {
//                     sumaTotal += adjustedWeight - peso;
//                 }
//             }
//         });
//     }

//     // Idiomas
//     let validIdiomas = 0;
//     idiomas.forEach(({ aplica, cumple, peso }) => {
//         const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//         const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//         if (aplicaElement && aplicaElement.value === "si") {
//             validIdiomas++;
//             if (cumpleElement && cumpleElement.value === "si") {
//                 sumaTotal += peso;
//             }
//         }
//     });

//     if (validIdiomas < idiomas.length && validIdiomas > 0) {
//         const adjustedWeight = pesoTotalIdiomas / validIdiomas;
//         idiomas.forEach(({ aplica, cumple, peso }) => {
//             const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//             const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//             if (aplicaElement && aplicaElement.value === "si") {
//                 if (cumpleElement && cumpleElement.value === "si") {
//                     sumaTotal += adjustedWeight - peso;
//                 }
//             }
//         });
//     }

//     // Cursos
//     const cursosValidos = Array.from(cursosContainer).filter((curso) => {
//         const id = curso.id.match(/\d+/)[0];
//         const radioSi = document.querySelector(`input[name='CURSO_CUMPLE_PPT[${id}]']:checked`);
//         return curso.value.trim() !== "" && radioSi && radioSi.value === "si";
//     });

//     const pesoPorCurso = cursosValidos.length > 0 ? pesoTotalCursos / cursosValidos.length : 0;
//     cursosValidos.forEach(() => {
//         sumaTotal += pesoPorCurso;
//     });

//     // Experiencia específica
//     const especificaSi = document.querySelector("input[name='EXPERIENCIA_ESPECIFICA_CUMPLE_PPT']:checked");
//     if (especificaSi && especificaSi.value === "si") {
//         sumaTotal += pesoEspecifica;
//     }

//     // Experiencia general y otras
//     const experienciaRadios = [
//         "EXPERIENCIAGENERAL_CUMPLE_PPT",
//         "CANTIDAD_EXPERIENCIA_CUMPLE_PPT",
//         "TIEMPO_EXPERIENCIA_CUMPLE_PPT"
//     ];

//     experienciaRadios.forEach(name => {
//         const radioSi = document.querySelector(`input[name='${name}']:checked`);
//         if (radioSi && radioSi.value === "si") {
//             sumaTotal += 6;
//         }
//     });

//     // Competencias
//     competencias.forEach(({ name, peso }) => {
//         const requerido = document.getElementById(`${name}_REQUERIDA_PPT`);
//         const deseable = document.getElementById(`${name}_DESEABLE_PPT`);
//         const cumpleSi = document.getElementById(`${name}_CUMPLE_SI`);

//         if ((requerido && requerido.checked) || (deseable && deseable.checked)) {
//             if (cumpleSi && cumpleSi.checked) {
//                 sumaTotal += peso;
//             }
//         }
//     });

//     // Resultado final
//     totalInput.value = Math.round(sumaTotal);
// }

     
//     // --- Eventos ---
//     radioButtons.forEach((radio) => {
//         radio.addEventListener("change", calcularSumaTotal);
//     });

//     cursosContainer.forEach((curso) => {
//         curso.addEventListener("input", calcularSumaTotal);
//         const id = curso.id.match(/\d+/)[0];
//         const radioElements = document.querySelectorAll(`input[name='CURSO_CUMPLE_PPT[${id}]']`);
//         radioElements.forEach((radio) => {
//             radio.addEventListener("change", calcularSumaTotal);
//         });
//     });

//     experienciaEspecificaRadio.forEach((radio) => {
//         radio.addEventListener("change", calcularSumaTotal);
//     });

//     experienciaGeneralRadio.forEach((radio) => {
//         radio.addEventListener("change", calcularSumaTotal);
//     });
     
//      ["CANTIDAD_EXPERIENCIA_CUMPLE_PPT", "TIEMPO_EXPERIENCIA_CUMPLE_PPT"].forEach(name => {
//         const radios = document.querySelectorAll(`input[name='${name}']`);
//         radios.forEach((radio) => {
//             radio.addEventListener("change", calcularSumaTotal);
//         });
//      });
     
//      selectRadioPairs.forEach(({ radio }) => {
//         const radioElements = document.getElementsByName(radio);
//         radioElements.forEach((radio) => {
//             radio.addEventListener("change", calcularSumaTotal);
//         });
//     });

//     puestosContainer.forEach((puesto) => {
//         puesto.addEventListener("change", calcularSumaTotal);
//         const id = puesto.id.match(/\d+/)[0];
//         const radioElements = document.querySelectorAll(`input[name='PUESTO${id}_CUMPLE_PPT']`);
//         radioElements.forEach((radio) => {
//             radio.addEventListener("change", calcularSumaTotal);
//         });
//     });

//     tools.forEach(({ aplica, cumple }) => {
//         const aplicaElements = document.getElementsByName(aplica);
//         const cumpleElements = document.getElementsByName(cumple);

//         aplicaElements.forEach((aplicaElement) => {
//             aplicaElement.addEventListener("change", calcularSumaTotal);
//         });

//         cumpleElements.forEach((cumpleElement) => {
//             cumpleElement.addEventListener("change", calcularSumaTotal);
//         });
//     });

//     idiomas.forEach(({ aplica, cumple }) => {
//         const aplicaElements = document.getElementsByName(aplica);
//         const cumpleElements = document.getElementsByName(cumple);

//         aplicaElements.forEach((aplicaElement) => {
//             aplicaElement.addEventListener("change", calcularSumaTotal);
//         });

//         cumpleElements.forEach((cumpleElement) => {
//             cumpleElement.addEventListener("change", calcularSumaTotal);
//         });
//     });



//      competencias.forEach(({ name }) => {
//         const requerido = document.getElementById(`${name}_REQUERIDA_PPT`);
//         const deseable = document.getElementById(`${name}_DESEABLE_PPT`);
//         const cumpleSi = document.getElementById(`${name}_CUMPLE_SI`);
//         const cumpleNo = document.getElementById(`${name}_CUMPLE_NO`);

//         [requerido, deseable, cumpleSi, cumpleNo].forEach((element) => {
//             if (element) {
//                 element.addEventListener("change", calcularSumaTotal);
//             }
//         });
//      });
    
//     requisitosMovilidad.forEach(({ name, cumple }) => {
//         const radios = document.querySelectorAll(`input[name='${name}'], input[name='${cumple}']`);
//         radios.forEach((radio) => {
//             radio.addEventListener("change", calcularSumaTotal);
//         });
//     });
    
    
    
     
// document.addEventListener("input", (e) => {
//     if (e.target.matches("input[type='radio'], select")) {
//         setTimeout(() => {
//             calcularSumaTotal();
//         }, 0);
//     }
// });



// });


// SUMA DE SELECCION

document.addEventListener("DOMContentLoaded", function () {
    const caracteristicas = [
        { radioName: 'EDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_EDAD' },
        { radioName: 'GENERO_CUMPLE_PPT', inputId: 'PORCENTAJE_GENERO' },
        { radioName: 'ESTADO_CIVIL_CUMPLE_PPT', inputId: 'PORCENTAJE_ESTADOCIVIL' },
        { radioName: 'NACIONALIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_NACIONALIDAD' },
        { radioName: 'DISCAPACIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_DISCAPACIDAD' },
    ];

    const formacion = [
        { radioName: 'SECUNDARIA_CUMPLE_PPT', inputId: 'PORCENTAJE_SECUNDARIA' },
        { radioName: 'TECNICA_CUMPLE_PPT', inputId: 'PORCENTAJE_MEDIASUPERIOR' },
        { radioName: 'TECNICO_CUMPLE_PPT', inputId: 'PORCENTAJE_TECNICOSUPERIOR' },
        { radioName: 'UNIVERSITARIO_CUMPLE_PPT', inputId: 'PORCENTAJE_UNIVERSITARIO' },
        { radioName: 'SITUACION_CUMPLE_PPT', inputId: 'PORCENTAJE_SITUACIONACADEMICA' },
        { radioName: 'CEDULA_CUMPLE_PPT', inputId: 'PORCENTAJE_CEDULA' },
        { radioName: 'AREA1_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA1' },
        { radioName: 'AREA2_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA2' },
        { radioName: 'AREA3_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA3' },
        { radioName: 'AREA4_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA4' },
        { radioName: 'ESPECIALIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_ESPECIALIDAD' },
        { radioName: 'MAESTRIA_CUMPLE_PPT', inputId: 'PORCENTAJE_MAESTRIA' },
        { radioName: 'DOCTORADO_CUMPLE_PPT', inputId: 'PORCENTAJE_DOCTORADO' },
    ];

    const conocimientos = [
        { radioName: 'WORD_CUMPLE_PPT', inputId: 'PORCENTAJE_WORD' },
        { radioName: 'EXCEL_CUMPLE_PPT', inputId: 'PORCENTAJE_EXCEL' },
        { radioName: 'POWER_CUMPLE_PPT', inputId: 'PORCENTAJE_POWERPOINT' },
        { radioName: 'IDIOMA1_CUMPLE_PPT', inputId: 'PORCENTAJE_IDIOMA1' },
        { radioName: 'IDIOMA2_CUMPLE_PPT', inputId: 'PORCENTAJE_IDIOMA2' },
        { radioName: 'IDIOMA3_CUMPLE_PPT', inputId: 'PORCENTAJE_IDIOMA3' },
    ];

    const experiencia = [
        { radioName: 'EXPERIENCIAGENERAL_CUMPLE_PPT', inputId: 'PORCENTAJE_EXPERIENCIAGENERAL' },
        { radioName: 'CANTIDAD_EXPERIENCIA_CUMPLE_PPT', inputId: 'PORCENTAJE_CANTIDADTOTAL' },
        { radioName: 'EXPERIENCIA_ESPECIFICA_CUMPLE_PPT', inputId: 'PORCENTAJE_EXPERIENCIAESPECIFICA' },
        { radioName: 'TIEMPO_EXPERIENCIA_CUMPLE_PPT', inputId: 'PORCENTAJE_INDIQUEXPERIENCIA' },
    ];

    const habilidades = [
        { radioName: 'INNOVACION_CUMPLE_PPT', inputId: 'PORCENTAJE_INNOVACION' },
        { radioName: 'PASION_CUMPLE_PPT', inputId: 'PORCENTAJE_PASION' },
        { radioName: 'SERVICIO_CLIENTE_CUMPLE_PPT', inputId: 'PORCENTAJE_SERVICIO_CLIENTE' },
        { radioName: 'COMUNICACION_EFICAZ_CUMPLE_PPT', inputId: 'PORCENTAJE_COMUNICACION_EFICAZ' },
        { radioName: 'TRABAJO_EQUIPO_CUMPLE_PPT', inputId: 'PORCENTAJE_TRABAJO_EQUIPO' },
        { radioName: 'INTEGRIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_INTEGRIDAD' },
        { radioName: 'RESPONSABILIDAD_SOCIAL_CUMPLE_PPT', inputId: 'PORCENTAJE_RESPONSABILIDAD_SOCIAL' },
        { radioName: 'ADAPTABILIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_ADAPTABILIDAD' },
        { radioName: 'LIDERAZGO_CUMPLE_PPT', inputId: 'PORCENTAJE_LIDERAZGO' },
        { radioName: 'TOMA_DECISIONES_CUMPLE_PPT', inputId: 'PORCENTAJE_TOMA_DECISIONES' },
    ];

    function sumarCampos(campos) {
        let suma = 0;
        campos.forEach(({ radioName, inputId }) => {
            const radioSi = document.querySelector(`input[name="${radioName}"][value="si"]`);
            const input = document.getElementById(inputId);
            if (radioSi && radioSi.checked && input && input.value !== '') {
                const valor = parseFloat(input.value);
                if (!isNaN(valor)) {
                    suma += valor;
                }
            }
        });
        return suma;
    }

    function sumarCursos() {
        let suma = 0;
        for (let i = 1; i <= 40; i++) {
            const radioSi = document.querySelector(`input[name="CURSO_CUMPLE_PPT[${i}]"][value="si"]`);
            const input = document.getElementById(`PORCENTAJE_CURSO${i}`);
            if (radioSi && radioSi.checked && input && input.value !== '') {
                const valor = parseFloat(input.value);
                if (!isNaN(valor)) {
                    suma += valor;
                }
            }
        }
        return suma;
    }

    function calcularSumas() {
        const sumaCaracteristicas = sumarCampos(caracteristicas);
        const sumaFormacion = sumarCampos(formacion);
        const sumaConocimientos = sumarCampos(conocimientos);
        const sumaExperiencia = sumarCampos(experiencia);
        const sumaHabilidades = sumarCampos(habilidades);
        const sumaCursos = sumarCursos();

        const sumaTotal = sumaCaracteristicas + sumaFormacion + sumaConocimientos + sumaExperiencia + sumaHabilidades + sumaCursos;

        const mostrar = (v) => Number.isInteger(v) ? v : v.toFixed(1);

        const setVal = (id, valor) => {
            const el = document.getElementById(id);
            if (el) el.value = mostrar(valor);
        };

        setVal('SUMA_CARACTERISTICAS_SELECCION', sumaCaracteristicas);
        setVal('SUMA_FORMACION_SELECCION', sumaFormacion);
        setVal('SUMA_CONOCIMIENTO_SELECCION', sumaConocimientos);
        setVal('SUMA_EXPERIENCIA_SELECCION', sumaExperiencia);
        setVal('SUMA_HABILIDADES_SELECCION', sumaHabilidades);
        setVal('SUMA_CURSOS_SELECCION', sumaCursos);
        setVal('SUMA_TOTAL', sumaTotal);
    }

    document.querySelectorAll('input[type="radio"], input[type="text"]').forEach(input => {
        input.addEventListener('change', calcularSumas);
        input.addEventListener('keyup', calcularSumas);
    });
});


// SUMA DE OBTENER BRECHA





// function obtenerBrechaCompetencias() {
//     const brechas = [];
//     const brechasDetalladas = [];

//     const totalActualInput = document.getElementById("SUMA_TOTAL");
//     const sumaTotal = parseFloat(totalActualInput?.value || 0);



//     const selectRadioPairs = [
//         { select: "SECUNDARIA_PPT", radio: "SECUNDARIA_CUMPLE_PPT" },
//         { select: "TECNICA_PPT", radio: "TECNICA_CUMPLE_PPT" },
//         { select: "TECNICO_PPT", radio: "TECNICO_CUMPLE_PPT" },
//         { select: "UNIVERSITARIO_PPT", radio: "UNIVERSITARIO_CUMPLE_PPT" },
//         { select: "SITUACION_PPT", radio: "SITUACION_CUMPLE_PPT" },
//         { select: "CEDULA_PPT", radio: "CEDULA_CUMPLE_PPT" },
//         { select: "AREA1_PPT", radio: "AREA1_CUMPLE_PPT" },
//         { select: "AREA2_PPT", radio: "AREA2_CUMPLE_PPT" },
//         { select: "AREA3_PPT", radio: "AREA3_CUMPLE_PPT" },
//         { select: "AREA4_PPT", radio: "AREA4_CUMPLE_PPT" },
//         { radio: "ESPECIALIDAD_CUMPLE_PPT", dependentRadios: ["EGRESADO_ESPECIALIDAD_PPT"] },
//         { radio: "MAESTRIA_CUMPLE_PPT", dependentRadios: ["EGRESADO_MAESTRIA_PPT"] },
//         { radio: "DOCTORADO_CUMPLE_PPT", dependentRadios: ["EGRESADO_DOCTORADO_PPT"] },
//     ];

//     const tools = [
//         { aplica: "WORD_APLICA_PPT", cumple: "WORD_CUMPLE_PPT", nombre: "Word" },
//         { aplica: "EXCEL_APLICA_PPT", cumple: "EXCEL_CUMPLE_PPT", nombre: "Excel" },
//         { aplica: "POWER_APLICA_PPT", cumple: "POWER_CUMPLE_PPT", nombre: "Power Point"},
//     ];

//     const idiomas = [
//         { aplica: "APLICA_IDIOMA1_PPT", cumple: "IDIOMA1_CUMPLE_PPT", nombre: "IDIOMA1" },
//         { aplica: "APLICA_IDIOMA2_PPT", cumple: "IDIOMA2_CUMPLE_PPT", nombre: "IDIOMA2" },
//         { aplica: "APLICA_IDIOMA3_PPT", cumple: "IDIOMA3_CUMPLE_PPT", nombre: "IDIOMA3" },
//     ];

//     const competencias = [
//         { name: "INNOVACION", mensaje: "Innovación" },
//         { name: "PASION", mensaje: "Pasión" },
//         { name: "SERVICIO_CLIENTE", mensaje: "Servicio (Orientación al cliente)" },
//         { name: "COMUNICACION_EFICAZ", mensaje: "Comunicación eficaz" },
//         { name: "TRABAJO_EQUIPO", mensaje: "Trabajo en equipo" },
//         { name: "INTEGRIDAD", mensaje: "Integridad" },
//         { name: "RESPONSABILIDAD_SOCIAL", mensaje: "Responsabilidad social"},
//         { name: "ADAPTABILIDAD", mensaje: "Adaptabilidad a los cambios del entorno" },
//         { name: "LIDERAZGO", mensaje: "Liderazgo" },
//         { name: "TOMA_DECISIONES", mensaje: "Toma de decisiones" },
//     ];

//     // Calcular los valores faltantes utilizando la misma lógica que el cálculo principal
//     let sumaTotalCalculada = 0;
//     let brechasPorCategoria = {};

//     // Verifica si hay requisitos de movilidad aplicables
//     const movilidadAplica = requisitosMovilidad.filter(({ name }) => {
//         const aplica = document.querySelector(`input[name='${name}']:checked`);
//         return aplica?.value === "si";
//     });

//     const alMenosUnRequisitoAplica = movilidadAplica.length > 0;

//     // Para datos generales (edad, género, etc.)
//     const radioButtons = document.querySelectorAll(
//         "input[name='EDAD_CUMPLE_PPT'], input[name='GENERO_CUMPLE_PPT'], input[name='ESTADO_CIVIL_CUMPLE_PPT'], input[name='NACIONALIDAD_CUMPLE_PPT']"
//     );

//     const pesoRadioGeneral = alMenosUnRequisitoAplica ? 1.25 : 2.5;
//     let puntosDatosGenerales = 0;
//     let radiosGeneralesSeleccionados = 0;

//     radioButtons.forEach((radio) => {
//         if (radio.checked && radio.value === "si") {
//             sumaTotalCalculada += pesoRadioGeneral;
//             puntosDatosGenerales += pesoRadioGeneral;
//             radiosGeneralesSeleccionados++;
//         }
//     });

//     // Para requisitos de movilidad
//     let puntosRequisitosMovilidad = 0;
//     if (alMenosUnRequisitoAplica) {
//         const requisitosCumplen = movilidadAplica.filter(({ name, cumple }) => {
//             const cumpleOK = document.querySelector(`input[name='${cumple}']:checked`);
//             return cumpleOK?.value === "si";
//         });

//         const requisitosNoCompletados = movilidadAplica.filter(({ name, cumple }) => {
//             const cumpleOK = document.querySelector(`input[name='${cumple}']:checked`);
//             return !cumpleOK || cumpleOK.value !== "si";
//         });

   
//     }

//     // CAMBIO IMPORTANTE: Esta función verifica si un select tiene un valor válido
//     function tieneValorValido(selectId) {
//         const select = document.getElementById(selectId);
//         if (!select) return false;
        
//         // Verificar que tenga un valor seleccionado válido
//         if (select.value === "" || 
//             select.value === "0" || 
//             select.value === "Seleccione una opción" || 
//             select.selectedIndex <= 0) {
//             return false;
//         }
        
//         // Verificar que el texto seleccionado no sea un placeholder
//         const selectedText = select.options[select.selectedIndex].text;
//         if (selectedText === "Seleccione una opción" || 
//             selectedText === "Área" || 
//             selectedText === "" || 
//             selectedText.includes("Seleccione")) {
//             return false;
//         }
        
//         return true;
//     }

//     // CAMBIO IMPORTANTE: Esta función verifica si un radio tiene un valor seleccionado
//     function radioTieneValor(radioName) {
//         const radio = document.querySelector(`input[name='${radioName}']:checked`);
//         return radio !== null;
//     }

//     // Para escolaridad - Filtrar correctamente las secciones válidas
//     // Solo consideramos secciones donde el select tiene un valor válido o los radios dependientes están marcados
//     const seccionesValidas = selectRadioPairs.filter(({ select, radio, dependentRadios }) => {
//         // Si tiene un select, verificar que tenga valor válido
//         if (select) {
//             if (!tieneValorValido(select)) {
//                 return false;
//             }
//         }
        
//         // Si tiene radio dependientes, verificar que al menos uno esté marcado
//         if (dependentRadios) {
//             const algunoMarcado = dependentRadios.some(depRadioName => {
//                 const radio = document.querySelector(`input[name='${depRadioName}']:checked`);
//                 return radio && radio.value === "si";
//             });
//             if (!algunoMarcado) return false;
//         }
        
//         // Verificar que el radio principal tenga algún valor seleccionado
//         if (radio && !radioTieneValor(radio)) {
//             return false;
//         }
        
//         return true;
//     });

//     const pesoPorSeccion = seccionesValidas.length > 0 ? 20 / seccionesValidas.length : 0;
//     const pesoPorSeccionRedondeado = parseFloat(pesoPorSeccion.toFixed(2));
    
//     // Procesamos solo las secciones válidas
//     seccionesValidas.forEach(({ select, radio, dependentRadios }) => {
//         const cumple = document.querySelector(`input[name='${radio}']:checked`)?.value === "si";
        
//         if (cumple) {
//             sumaTotalCalculada += pesoPorSeccion;
//         } else {
//             // Solo agregamos brechas para secciones que no cumplen pero son válidas
//             let msg = "";
//             let skipBrecha = false;
            
//             switch (radio) {
//                 case "SECUNDARIA_CUMPLE_PPT":
//                     // Solo si el select de secundaria tiene valor
//                     if (tieneValorValido("SECUNDARIA_PPT")) {
//                         msg = "Falta por cumplir con la secundaria";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "TECNICA_CUMPLE_PPT":
//                     if (tieneValorValido("TECNICA_PPT")) {
//                         msg = "Falta por concluir el bachillerato";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "TECNICO_CUMPLE_PPT":
//                     if (tieneValorValido("TECNICO_PPT")) {
//                         msg = "Falta cumplir con Técnico superior";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "UNIVERSITARIO_CUMPLE_PPT":
//                     if (tieneValorValido("UNIVERSITARIO_PPT")) {
//                         msg = "Falta cumplir con la Carrera universitaria";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "SITUACION_CUMPLE_PPT":
//                     if (tieneValorValido("SITUACION_PPT")) {
//                         const texto = document.getElementById("SITUACION_PPT").options[document.getElementById("SITUACION_PPT").selectedIndex].text;
//                         msg = `Falta por cumplir con ${texto}`;
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "CEDULA_CUMPLE_PPT":
//                     if (tieneValorValido("CEDULA_PPT")) {
//                         msg = "Falta por cumplir con la Cédula profesional";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "AREA1_CUMPLE_PPT":
//                 case "AREA2_CUMPLE_PPT":
//                 case "AREA3_CUMPLE_PPT":
//                 case "AREA4_CUMPLE_PPT":
//                     const areaSelectId = select; // Ej: "AREA1_PPT"
//                     if (tieneValorValido(areaSelectId)) {
//                         const areaText = document.getElementById(areaSelectId).options[document.getElementById(areaSelectId).selectedIndex].text;
//                         msg = `Falta por cumplir con el Área de conocimientos: ${areaText}`;
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "ESPECIALIDAD_CUMPLE_PPT":
//                     // Verificamos si alguno de los radios dependientes está marcado como "si"
//                     if (dependentRadios && dependentRadios.some(name => document.querySelector(`input[name='${name}']:checked`)?.value === "si")) {
//                         msg = "Falta Estudios de posgrado requeridos: Especialidad";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "MAESTRIA_CUMPLE_PPT":
//                     if (dependentRadios && dependentRadios.some(name => document.querySelector(`input[name='${name}']:checked`)?.value === "si")) {
//                         msg = "Falta Estudios de posgrado requeridos: Maestría";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 case "DOCTORADO_CUMPLE_PPT":
//                     if (dependentRadios && dependentRadios.some(name => document.querySelector(`input[name='${name}']:checked`)?.value === "si")) {
//                         msg = "Falta Estudios de posgrado requeridos: Doctorado";
//                     } else {
//                         skipBrecha = true;
//                     }
//                     break;
//                 default:
//                     skipBrecha = true;
//             }
            
//             // Solo agregamos la brecha si no debe saltarse
//             if (!skipBrecha && msg) {
//                 brechasDetalladas.push({ mensaje: msg, porcentaje: pesoPorSeccionRedondeado });
//                 brechas.push(`${msg} (${pesoPorSeccionRedondeado}%)`);
//             }
//         }
//     });

//     // Para herramientas
//     let validTools = 0;
//     const toolsCumplen = [];
//     const toolsNoCumplen = [];

//     tools.forEach(({ aplica, cumple, nombre, peso }) => {
//         const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//         const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//         if (aplicaElement && aplicaElement.value === "si") {
//             validTools++;
//             if (cumpleElement && cumpleElement.value === "si") {
//                 sumaTotalCalculada += peso;
//                 toolsCumplen.push({ aplica, cumple, nombre, peso });
//             } else {
//                 toolsNoCumplen.push({ aplica, cumple, nombre, peso });
//             }
//         }
//     });

//     // Ajustar pesos si es necesario
//     if (validTools < tools.length && validTools > 0) {
//         const adjustedWeight = 6 / validTools;
//         const ajusteDePeso = adjustedWeight - tools[0].peso; // Difference to add per tool
        
//         toolsCumplen.forEach(() => {
//             sumaTotalCalculada += ajusteDePeso;
//         });
        
//         // Actualizar las brechas para herramientas no cumplidas
//         toolsNoCumplen.forEach(({ nombre, peso }) => {
//             const pesoPorHerramienta = parseFloat((6 / validTools).toFixed(2));
//             brechasDetalladas.push({ mensaje: `Falta por cumplir con el programa ${nombre}`, porcentaje: pesoPorHerramienta });
//             brechas.push(`Falta por cumplir con el programa ${nombre} (${pesoPorHerramienta}%)`);
//         });
//     } else {
//         // Si no hay ajuste, usar el peso original
//         toolsNoCumplen.forEach(({ nombre, peso }) => {
//             const pesoRedondeado = parseFloat(peso.toFixed(2));
//             brechasDetalladas.push({ mensaje: `Falta por cumplir con el programa ${nombre}`, porcentaje: pesoRedondeado });
//             brechas.push(`Falta por cumplir con el programa ${nombre} (${pesoRedondeado}%)`);
//         });
//     }

//     // Para idiomas
//     let validIdiomas = 0;
//     const idiomasCumplen = [];
//     const idiomasNoCumplen = [];

//     idiomas.forEach(({ aplica, cumple, nombre }) => {
//         const aplicaElement = document.querySelector(`input[name='${aplica}']:checked`);
//         const cumpleElement = document.querySelector(`input[name='${cumple}']:checked`);

//         if (aplicaElement && aplicaElement.value === "si") {
//             validIdiomas++;
//             if (cumpleElement && cumpleElement.value === "si") {
//                 const pesoPorIdioma = 4 / validIdiomas; // Use the dynamic weight
//                 sumaTotalCalculada += pesoPorIdioma;
//                 idiomasCumplen.push({ aplica, cumple, nombre });
//             } else {
//                 idiomasNoCumplen.push({ aplica, cumple, nombre });
//             }
//         }
//     });

//     // Ajustar y agregar brechas para idiomas
//     if (validIdiomas > 0) {
//         const pesoPorIdioma = parseFloat((4 / validIdiomas).toFixed(2));
//         idiomasNoCumplen.forEach(({ nombre }) => {
//             const nombreIdioma = document.getElementById(`NOMBRE_${nombre}_PPT`)?.value || nombre;
//             brechasDetalladas.push({ mensaje: `Falta por cumplir con el idioma: ${nombreIdioma}`, porcentaje: pesoPorIdioma });
//             brechas.push(`Falta por cumplir con el idioma: ${nombreIdioma} (${pesoPorIdioma}%)`);
//         });
//     }

//     // Para experiencia general y otros aspectos
//     const experienciaRadios = [
//         { name: "EXPERIENCIAGENERAL_CUMPLE_PPT", texto: "Falta por cumplir con la experiencia laboral general requerida" },
//         { name: "CANTIDAD_EXPERIENCIA_CUMPLE_PPT", texto: "Falta por cumplir con la cantidad total de años de experiencia laboral" },
//         { name: "TIEMPO_EXPERIENCIA_CUMPLE_PPT", texto: "Falta por cumplir con el tiempo de experiencia específica requerido para el cargo" }
//         { name: "EXPERIENCIA_ESPECIFICA_CUMPLE_PPT", texto: "Falta por cumplir con la experiencia laboral específica requerida" }

//     ];

//     experienciaRadios.forEach(({ name, texto }) => {
//         const radioSi = document.querySelector(`input[name='${name}']:checked`);
//         if (radioSi && radioSi.value === "si") {
//             sumaTotalCalculada += 6;
//         } else {
//             brechasDetalladas.push({ mensaje: texto, porcentaje: 6.00 });
//             brechas.push(`${texto} (6.00%)`);
//         }
//     });

//     // Para experiencia específica
//     const expEsp = document.querySelector("input[name='EXPERIENCIA_ESPECIFICA_CUMPLE_PPT']:checked");
//     if (expEsp && expEsp.value === "si") {
//         sumaTotalCalculada += 7;
//     } else {
//         brechasDetalladas.push({ mensaje: "Falta por cumplir con la experiencia laboral específica requerida"});
//         brechas.push("Falta por cumplir con la experiencia laboral específica requerida (7.00%)");
//     }

    

//     // Para cursos
//     const cursosContainer = document.querySelectorAll("textarea[name='CURSO_PPT[]']");
//     const cursosValidos = Array.from(cursosContainer).filter((curso) => {
//         return curso.value.trim() !== "";
//     });
    
//     const cursosCumplen = cursosValidos.filter((curso) => {
//         const id = curso.id.match(/\d+/)[0];
//         const radioSi = document.querySelector(`input[name='CURSO_CUMPLE_PPT[${id}]']:checked`);
//         return radioSi && radioSi.value === "si";
//     });
    
//     const cursosNoCumplen = cursosValidos.filter((curso) => {
//         const id = curso.id.match(/\d+/)[0];
//         const radioSi = document.querySelector(`input[name='CURSO_CUMPLE_PPT[${id}]']:checked`);
//         return !radioSi || radioSi.value !== "si";
//     });
    
//     const pesoPorCurso = cursosValidos.length > 0 ? 25 / cursosValidos.length : 0;
//     const pesoPorCursoRedondeado = parseFloat(pesoPorCurso.toFixed(2));
    
//     cursosCumplen.forEach(() => {
//         sumaTotalCalculada += pesoPorCurso;
//     });
    
//     cursosNoCumplen.forEach((curso) => {
//         brechasDetalladas.push({ mensaje: `Falta por cumplir con el curso: ${curso.value.trim()}`, porcentaje: pesoPorCursoRedondeado });
//         brechas.push(`Falta por cumplir con el curso: ${curso.value.trim()} (${pesoPorCursoRedondeado}%)`);
//     });

 
    
//     // Suma de todos los porcentajes de brecha actuales
//     const sumaDeBrechas = brechasDetalladas.reduce((sum, item) => sum + item.porcentaje, 0);
    
//     // Solo normalizar si hay brechas y la suma no es 0
//     if (brechasDetalladas.length > 0 && sumaDeBrechas > 0) {
//         // Aplicar un factor de ajuste para que la suma de las brechas sea igual al porcentaje faltante
//         const factorDeAjuste = porcentajeFaltante / sumaDeBrechas;
        
//         // Calcular el total después del ajuste para verificar si es necesario redistribuir
//         let totalAjustado = 0;
        
//         // Ajustar todos los porcentajes con valores redondeados
//         brechasDetalladas.forEach(item => {
//             // Calcular y redondear el nuevo porcentaje
//             const nuevoValor = item.porcentaje * factorDeAjuste;
//             item.porcentaje = parseFloat(nuevoValor.toFixed(2));
//             totalAjustado += item.porcentaje;
            
//             // Actualizar el mensaje correspondiente en 'brechas'
//             const indiceBrecha = brechas.findIndex(b => b.startsWith(item.mensaje));
//             if (indiceBrecha !== -1) {
//                 brechas[indiceBrecha] = `${item.mensaje} (${item.porcentaje}%)`;
//             }
//         });
        
//         // Verificar si hay diferencia por redondeo y ajustar al último elemento si es necesario
//         const diferencia = porcentajeFaltante - totalAjustado;
//         if (Math.abs(diferencia) > 0.01 && brechasDetalladas.length > 0) {
//             // Ajustar el último elemento para compensar la diferencia de redondeo
//             const ultimoElemento = brechasDetalladas[brechasDetalladas.length - 1];
//             ultimoElemento.porcentaje = parseFloat((ultimoElemento.porcentaje + diferencia).toFixed(2));
            
//             // Actualizar el mensaje correspondiente
//             const indiceUltimaBrecha = brechas.findIndex(b => b.startsWith(ultimoElemento.mensaje));
//             if (indiceUltimaBrecha !== -1) {
//                 brechas[indiceUltimaBrecha] = `${ultimoElemento.mensaje} (${ultimoElemento.porcentaje}%)`;
//             }
//         }
//     }

//     return {
//         brechas,
//         brechasDetalladas,
//         porcentajeFaltante
//     };
// }


///  FUNCION PARA SUMAR LAS PRUEBAS DE CONOCIMIENTO 
function calcularPorcentajeTotal2() {
    var porcentajeGuardado = parseFloat($('#porcentajeTotalPrueba').val()) || 0;  
    var sumaNuevas = 0;  
    var totalNuevas = 0;  
    var camposLlenos = false; 

    $('input[name="TOTAL_PORCENTAJE[]"]').each(function() {
        var nuevoPorcentaje = parseFloat($(this).val()) || 0;

        if (!isNaN(nuevoPorcentaje) && nuevoPorcentaje > 0) {  
            sumaNuevas += nuevoPorcentaje;
            totalNuevas++;  
        }
    });

    var porcentajeFinal = porcentajeGuardado; 
    if (totalNuevas > 0) {
        porcentajeFinal = sumaNuevas / totalNuevas;  
    }

    $('#porcentajeTotalPrueba').val(Math.round(porcentajeFinal));  
}



function obtenerBrechasHabilidades() {
    const habilidades = [
        { radioName: 'INNOVACION_CUMPLE_PPT', inputId: 'PORCENTAJE_INNOVACION', mensaje: 'Falta por cumplir con la competencia: Innovación' },
        { radioName: 'PASION_CUMPLE_PPT', inputId: 'PORCENTAJE_PASION', mensaje: 'Falta por cumplir con la competencia: Pasión' },
        { radioName: 'SERVICIO_CLIENTE_CUMPLE_PPT', inputId: 'PORCENTAJE_SERVICIO_CLIENTE', mensaje: 'Falta por cumplir con la competencia: Servicio (Orientación al cliente)' },
        { radioName: 'COMUNICACION_EFICAZ_CUMPLE_PPT', inputId: 'PORCENTAJE_COMUNICACION_EFICAZ', mensaje: 'Falta por cumplir con la competencia: Comunicación eficaz' },
        { radioName: 'TRABAJO_EQUIPO_CUMPLE_PPT', inputId: 'PORCENTAJE_TRABAJO_EQUIPO', mensaje: 'Falta por cumplir con la competencia: Trabajo en equipo' },
        { radioName: 'INTEGRIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_INTEGRIDAD', mensaje: 'Falta por cumplir con la competencia: Integridad' },
        { radioName: 'RESPONSABILIDAD_SOCIAL_CUMPLE_PPT', inputId: 'PORCENTAJE_RESPONSABILIDAD_SOCIAL', mensaje: 'Falta por cumplir con la competencia: Responsabilidad social' },
        { radioName: 'ADAPTABILIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_ADAPTABILIDAD', mensaje: 'Falta por cumplir con la competencia: Adaptabilidad a los cambios del entorno' },
        { radioName: 'LIDERAZGO_CUMPLE_PPT', inputId: 'PORCENTAJE_LIDERAZGO', mensaje: 'Falta por cumplir con la competencia: Liderazgo' },
        { radioName: 'TOMA_DECISIONES_CUMPLE_PPT', inputId: 'PORCENTAJE_TOMA_DECISIONES', mensaje: 'Falta por cumplir con la competencia: Toma de decisiones' }
    ];

    const brechas = [];
    const brechasDetalladas = [];

    habilidades.forEach(({ radioName, inputId, mensaje }) => {
        const radio = document.querySelector(`input[name='${radioName}']:checked`);
        const input = document.getElementById(inputId);

        if (radio && radio.value === "no" && input && input.value !== "") {
            const porcentaje = parseFloat(input.value);
            if (!isNaN(porcentaje) && porcentaje > 0) {
                brechasDetalladas.push({
                    mensaje,
                    porcentaje
                });

                brechas.push(`${mensaje}, porcentaje: ${porcentaje}%`);
            }
        }
    });

    return {
        brechas,
        brechasDetalladas
    };
}



function obtenerBrechasFormacion() {
    const formacion = [
        { radioName: 'SECUNDARIA_CUMPLE_PPT', inputId: 'PORCENTAJE_SECUNDARIA', mensaje: 'Falta por cumplir con la secundaria' },
        { radioName: 'TECNICA_CUMPLE_PPT', inputId: 'PORCENTAJE_MEDIASUPERIOR', mensaje: 'Falta por concluir el bachillerato' },
        { radioName: 'TECNICO_CUMPLE_PPT', inputId: 'PORCENTAJE_TECNICOSUPERIOR', mensaje: 'Falta cumplir con Técnico superior' },
        { radioName: 'UNIVERSITARIO_CUMPLE_PPT', inputId: 'PORCENTAJE_UNIVERSITARIO', mensaje: 'Falta cumplir con la Carrera universitaria' },
        { radioName: 'SITUACION_CUMPLE_PPT', inputId: 'PORCENTAJE_SITUACIONACADEMICA', mensaje: 'Falta por cumplir con la situación académica' },
        { radioName: 'CEDULA_CUMPLE_PPT', inputId: 'PORCENTAJE_CEDULA', mensaje: 'Falta por cumplir con la Cédula profesional' },
        { radioName: 'AREA1_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA1', selectId: 'AREA1_PPT' },
        { radioName: 'AREA2_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA2', selectId: 'AREA2_PPT' },
        { radioName: 'AREA3_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA3', selectId: 'AREA3_PPT' },
        { radioName: 'AREA4_CUMPLE_PPT', inputId: 'PORCENTAJE_AREA4', selectId: 'AREA4_PPT' },
        { radioName: 'ESPECIALIDAD_CUMPLE_PPT', inputId: 'PORCENTAJE_ESPECIALIDAD', mensaje: 'Falta Estudios de posgrado requeridos: Especialidad' },
        { radioName: 'MAESTRIA_CUMPLE_PPT', inputId: 'PORCENTAJE_MAESTRIA', mensaje: 'Falta Estudios de posgrado requeridos: Maestría' },
        { radioName: 'DOCTORADO_CUMPLE_PPT', inputId: 'PORCENTAJE_DOCTORADO', mensaje: 'Falta Estudios de posgrado requeridos: Doctorado' }
    ];

    const brechas = [];
    const brechasDetalladas = [];

    formacion.forEach(({ radioName, inputId, mensaje, selectId }) => {
        const radio = document.querySelector(`input[name='${radioName}']:checked`);
        const cumple = radio?.value === 'si';

        const input = document.getElementById(inputId);
        const porcentaje = parseFloat(input?.value || "0");

        if (!cumple && porcentaje > 0) {
            let textoBrecha = mensaje;

            if (selectId) {
                const select = document.getElementById(selectId);
                if (select && select.selectedIndex > 0) {
                    const seleccionado = select.options[select.selectedIndex].text;
                    textoBrecha = `Falta por cumplir con el Área de conocimientos: ${seleccionado}`;
                } else {
                    return; // Saltar si el área no está seleccionada correctamente
                }
            }

            brechasDetalladas.push({
                mensaje: textoBrecha,
                porcentaje // sin redondear
            });

            brechas.push(`${textoBrecha}, porcentaje: ${porcentaje}%`);
        }
    });

    return {
        brechas,
        brechasDetalladas
    };
}





function obtenerBrechasConocimientos() {
    const conocimientos = [
        {
            radioName: 'WORD_CUMPLE_PPT',
            inputId: 'PORCENTAJE_WORD',
            mensaje: 'Falta por cumplir con el programa Word'
        },
        {
            radioName: 'EXCEL_CUMPLE_PPT',
            inputId: 'PORCENTAJE_EXCEL',
            mensaje: 'Falta por cumplir con el programa Excel'
        },
        {
            radioName: 'POWER_CUMPLE_PPT',
            inputId: 'PORCENTAJE_POWERPOINT',
            mensaje: 'Falta por cumplir con el programa Power Point'
        },
        {
            radioName: 'IDIOMA1_CUMPLE_PPT',
            inputId: 'PORCENTAJE_IDIOMA1',
            mensaje: () => {
                const nombre = document.getElementById('NOMBRE_IDIOMA1_PPT')?.value.trim();
                return `Falta por cumplir con el idioma: ${nombre || 'Idioma 1'}`;
            }
        },
        {
            radioName: 'IDIOMA2_CUMPLE_PPT',
            inputId: 'PORCENTAJE_IDIOMA2',
            mensaje: () => {
                const nombre = document.getElementById('NOMBRE_IDIOMA2_PPT')?.value.trim();
                return `Falta por cumplir con el idioma: ${nombre || 'Idioma 2'}`;
            }
        },
        {
            radioName: 'IDIOMA3_CUMPLE_PPT',
            inputId: 'PORCENTAJE_IDIOMA3',
            mensaje: () => {
                const nombre = document.getElementById('NOMBRE_IDIOMA3_PPT')?.value.trim();
                return `Falta por cumplir con el idioma: ${nombre || 'Idioma 3'}`;
            }
        }
    ];

    const brechas = [];
    const brechasDetalladas = [];

    conocimientos.forEach(({ radioName, inputId, mensaje }) => {
        const radio = document.querySelector(`input[name='${radioName}']:checked`);
        const input = document.getElementById(inputId);
        const porcentaje = parseFloat(input?.value || 0);
        const cumple = radio?.value === 'si';

        if (!cumple && porcentaje > 0) {
            const texto = typeof mensaje === 'function' ? mensaje() : mensaje;

            brechasDetalladas.push({
                mensaje: texto,
                porcentaje
            });

            brechas.push(`${texto}, porcentaje: ${porcentaje}%`);
        }
    });

    return {
        brechas,
        brechasDetalladas
    };
}




function obtenerBrechasExperiencia() {
    const experiencia = [
        {
            radioName: 'EXPERIENCIAGENERAL_CUMPLE_PPT',
            inputId: 'PORCENTAJE_EXPERIENCIAGENERAL',
            mensaje: 'Falta por cumplir con la experiencia laboral general requerida'
        },
        {
            radioName: 'CANTIDAD_EXPERIENCIA_CUMPLE_PPT',
            inputId: 'PORCENTAJE_CANTIDADTOTAL',
            mensaje: 'Falta por cumplir con la cantidad total de años de experiencia laboral'
        },
        {
            radioName: 'EXPERIENCIA_ESPECIFICA_CUMPLE_PPT',
            inputId: 'PORCENTAJE_EXPERIENCIAESPECIFICA',
            mensaje: 'Falta por cumplir con la experiencia laboral específica requerida'
        },
        {
            radioName: 'TIEMPO_EXPERIENCIA_CUMPLE_PPT',
            inputId: 'PORCENTAJE_INDIQUEXPERIENCIA',
            mensaje: 'Falta por cumplir con el tiempo de experiencia específica requerida para el cargo'
        },
    ];

    const brechas = [];
    const brechasDetalladas = [];

    experiencia.forEach(({ radioName, inputId, mensaje }) => {
        const radio = document.querySelector(`input[name='${radioName}']:checked`);
        const input = document.getElementById(inputId);
        const porcentaje = parseFloat(input?.value || 0);
        const cumple = radio?.value === 'si';

        if (!cumple && porcentaje > 0) {
            brechasDetalladas.push({
                mensaje,
                porcentaje
            });

            brechas.push(`${mensaje}, porcentaje: ${porcentaje}%`);
        }
    });

    return {
        brechas,
        brechasDetalladas
    };
}




function obtenerBrechasCursos() {
    const brechas = [];
    const brechasDetalladas = [];

    for (let i = 1; i <= 40; i++) {
        const textarea = document.getElementById(`CURSO${i}_PPT`);
        const radio = document.querySelector(`input[name="CURSO_CUMPLE_PPT[${i}]"]:checked`);
        const input = document.getElementById(`PORCENTAJE_CURSO${i}`);

        const nombreCurso = textarea?.value.trim();
        const porcentaje = parseFloat(input?.value || "0");

        if (nombreCurso && (!radio || radio.value !== "si") && porcentaje > 0) {
            const mensaje = `Falta por cumplir con el curso: ${nombreCurso}`;

            brechasDetalladas.push({
                mensaje,
                porcentaje // sin redondeo
            });

            brechas.push(`${mensaje}, porcentaje: ${porcentaje}%`);
        }
    }

    return {
        brechas,
        brechasDetalladas
    };
}
