
ID_PPT_SELECCION = 0
ID_ENTREVISTA_SELECCION = 0
ID_AUTORIZACION_SELECCION = 0
var Tablapptseleccion;
var Tablaentrevistaseleccion;
var Tablaautorizacion;
var curpSeleccionada;  



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
        { data: 'NUMERO_VACANTE' },
        { data: 'FECHA_EXPIRACION' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center clickable' },
        { targets: 2, title: 'N° de vacante', className: 'all text-center' },
        { targets: 3, title: 'Fecha límite', className: 'all text-center' },
    ]
});







$('#Tablaseleccion tbody').on('click', 'td.clickable', function() {
    var tr = $(this).closest('tr');
    var row = Tablaseleccion.row(tr);

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

        var categoriaId = row.data().CATEGORIA_VACANTE;
        $.ajax({
            url: '/consultarSeleccion/' + categoriaId,
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
                                    <th class="text-center">% Entrevista</th>
                                    <th class="text-center">% PPT</th>
                                    <th class="text-center">% Pruebas</th>
                                    <th class="text-center">Mostrar</th>
                                    <th class="text-center">Seleccionar</th>

                                </tr>
                            </thead>
                            <tbody>
                    `;

                    response.data.forEach(function(item, index) {
                        innerTable += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.NOMBRE_SELC} ${item.PRIMER_APELLIDO_SELEC} ${item.SEGUNDO_APELLIDO_SELEC}</td>
                                <td class="text-center">${item.CURP}</td>
                                <td class="text-center">${item.CORREO_SELEC}<br>${item.TELEFONO1_SELECT}, ${item.TELEFONO2_SELECT}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-circle" id="AbrirModalFull" data-bs-toggle="modal" data-bs-target="#FullScreenModal" data-curp="${item.CURP}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                </td>
                                 <td class="text-center">
                                    <button type="button" class="btn btn-success  id="MandarContratacion">
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
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            }
        });
    }
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
        { 
            data: 'ARCHIVO_ENTREVISTA',
            render: function (data, type, row) {
                return '<button class="btn btn-danger btn-custom rounded-pill pdf-button"data-pdf="/' + data + '"> <i class="bi bi-filetype-pdf"></i></button>';
            },
            className: 'text-center'
        },
        { data: 'BTN_EDITAR', className: 'text-center' }
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all text-center' },
        { target: 1, title: 'Comentario de la entrevista', className: 'all text-center' },
        { target: 2, title: 'Evidencia', className: 'all text-center' },
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
    

    editarDatoTabla(data, form, 'miModal_ppt', 1);
    mostrarCursos(data, form);

});



function mostrarCursos(data,form){

//RECORREMOS LOS CURSOS SI ES QUE EXISTE
if ('CURSOS' in data) {
    if (data.CURSOS.length > 0) { 
        var cursos = data.CURSOS
        var count = 1    
    
        // Supongamos que 'data' es el array que contiene los objetos de datos
        cursos.forEach(function (obj) {
        
        

        // cumple = obj.CURSO_CUMPLE_PPT.toUpperCase(); 

        $('#' + form).find(`textarea[id='CURSO${count}_PPT']`).val(obj.CURSO_PPT)
    
        
    //    $('#' + form).find(`input[id='CURSO${count}_CUMPLE_${cumple}'][value='${obj.CURSO_CUMPLE_PPT}'][type='radio']`).prop('checked', true)


        if (obj.CURSO_DESEABLE == null) {
            
            $('#' + form).find(`input[id='CURSO${count}_REQUERIDO_PPT'][type='checkbox']`).prop('checked', true)

        } else {
            
            $('#' + form).find(`input[id='CURSO${count}_DESEABLE_PPT'][type='checkbox']`).prop('checked', true)

        }

        count++
        });


        cursosTotales = data.CURSOS.length 
        if (cursosTotales <= 10) {

        $('#cursoTemasCollapse').collapse('show')


        } else if (cursosTotales > 10 && cursosTotales <= 20) {
            $('#cursoTemasCollapse').collapse('show')
            $('#cursoTemas1Collapse').collapse('show')
            

        } else if (cursosTotales > 20 && cursosTotales <= 30) {
            $('#cursoTemasCollapse').collapse('show')
            $('#cursoTemas1Collapse').collapse('show')
            $('#cursoTemas2Collapse').collapse('show')


        } else if (cursosTotales > 30){
            
            $('.collapse').collapse('show')
        


        }

    }
    }
}





});



// <!-- ============================================================== -->
// <!-- ABRIR  TODOS LOS MODALES -->
// <!-- ============================================================== -->



$("#nuevo_autorizacion").click(function (e) {
    e.preventDefault();
    $("#Modal_autorizacion").modal("show");
})


$("#nueva_entrevista").click(function (e) {
    e.preventDefault();
    $("#Modal_entrevistas").modal("show");
})


$("#nuevo_ppt").click(function (e) {
    e.preventDefault();

    $('.desabilitado1').css('background','#E2EFDA');
    $("#miModal_ppt").modal("show");
})



// <!-- ============================================================== -->
// <!-- MODAL AUTORIZACION-->
// <!-- ============================================================== -->

document.getElementById('verPdfButton').addEventListener('click', function () {
    const pdfUrl = '/ver-pdf'; 

    document.getElementById('pdfIframe').src = pdfUrl;

    var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    pdfModal.show();
});


// Seleccionamos los elementos
const archivoAutorizacion = document.getElementById('ARCHIVO_AUTORIZACION');
const quitarFormatoBtn = document.getElementById('quitarformato');

archivoAutorizacion.addEventListener('change', function () {
    if (archivoAutorizacion.files.length > 0) {
        quitarFormatoBtn.style.display = 'inline-block';
    }
});

quitarFormatoBtn.addEventListener('click', function () {
    archivoAutorizacion.value = '';
    quitarFormatoBtn.style.display = 'none';
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

    formularioValido = validarFormulario($('#formularioAUTORIZACION'));

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
                            Tablaautorizacion.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
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
// <!-- MODAL ENTREVISTA -->
// <!-- ============================================================== -->


const ModalEntrevista = document.getElementById('Modal_entrevistas');
ModalEntrevista.addEventListener('hidden.bs.modal', event => {
    ID_ENTREVISTA_SELECCION = 0;
    document.getElementById('formularioENTREVISTA').reset();
    $('.collapse').collapse('hide');
    $('#guardarFormSeleccionEntrevista').css('display', 'block').prop('disabled', false);


    document.querySelectorAll('#formularioENTREVISTA [required]').forEach(input => {
        input.removeAttribute('required');
    });
   
});




  $("#guardarFormSeleccionEntrevista").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioENTREVISTA'));

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
                            Tablaentrevistaseleccion.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
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

const ModalArea = document.getElementById('miModal_ppt');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_PPT_SELECCION = 0;
    document.getElementById('formularioSeleccionPPT').reset();
    $('.collapse').collapse('hide');
    $('#guardarFormSeleccionPPT').css('display', 'block').prop('disabled', false);
    
    document.querySelectorAll('#formularioSeleccionPPT [required]').forEach(input => {
        input.removeAttribute('required');
    });
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
            // Acciones específicas para los elementos que NO tienen las clases
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


                if (document.getElementById('NOMBRE_TRABAJADOR_PPT')) {
                    document.getElementById('NOMBRE_TRABAJADOR_PPT').value = formulario.NOMBRE_TRABAJADOR_PPT || '';
                }
                
                if (document.getElementById('AREA_TRABAJADOR_PPT')) {
                    document.getElementById('AREA_TRABAJADOR_PPT').value = formulario.AREA_TRABAJADOR_PPT || '';
                }
                
                if (document.getElementById('PROPOSITO_FINALIDAD_PPT')) {
                    document.getElementById('PROPOSITO_FINALIDAD_PPT').value = formulario.PROPOSITO_FINALIDAD_PPT || '';
                }
                


                // document.getElementById('NOMBRE_TRABAJADOR_PPT').value = formulario.NOMBRE_TRABAJADOR_PPT || '';
                // document.getElementById('AREA_TRABAJADOR_PPT').value = formulario.AREA_TRABAJADOR_PPT || '';
                // document.getElementById('PROPOSITO_FINALIDAD_PPT').value = formulario.PROPOSITO_FINALIDAD_PPT || '';
              
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
                                

             // Rellenar los campos de los cursos
             let cursos = data.cursos;

             // Variables para rastrear si los acordeones necesitan abrirse
             let openAccordion1 = false;
             let openAccordion2 = false;
             let openAccordion3 = false;
             let openAccordion4 = false;

             // Para rellenar los cursos en los acordeones
             cursos.forEach((curso, index) => {
                 if (index < 10) {
                     // Primer acordeón (1-10)
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;

                     // Si algún curso tiene datos, abre el acordeón 1
                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion1 = true;
                     }
                 } else if (index >= 10 && index < 20) {
                     // Segundo acordeón (11-20)
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;

                     // Si algún curso tiene datos, abre el acordeón 2
                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion2 = true;
                     }
                 } else if (index >= 20 && index < 30) {
                     // Tercer acordeón (21-30)
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;

                     // Si algún curso tiene datos, abre el acordeón 3
                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion3 = true;
                     }
                 } else if (index >= 30 && index < 40) {
                     // Cuarto acordeón (31-40)
                     document.getElementById(`CURSO${index + 1}_PPT`).value = curso.CURSO_PPT || '';
                     document.getElementById(`CURSO${index + 1}_REQUERIDO_PPT`).checked = curso.CURSO_REQUERIDO === 'X' ? true : false;
                     document.getElementById(`CURSO${index + 1}_DESEABLE_PPT`).checked = curso.CURSO_DESEABLE === 'X' ? true : false;

                     // Si algún curso tiene datos, abre el acordeón 4
                     if (curso.CURSO_PPT || curso.CURSO_REQUERIDO || curso.CURSO_DESEABLE) {
                         openAccordion4 = true;
                     }
                 }
             });

             // Abre los acordeones que tienen datos
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


$("#guardarFormSeleccionPPT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioSeleccionPPT'));

    if (formularioValido) {

        if (ID_PPT_SELECCION == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usará para la creación del PPT",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarFormSeleccionPPT');
                await ajaxAwaitFormData({ 
                    api: 1, 
                    ID_PPT_SELECCION: ID_PPT_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', { callbackAfter: true, callbackBefore: true }, () => {

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
                        // Tablapptseleccion.ajax.reload();


                        if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
                            Tablapptseleccion.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
                        }




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
                await ajaxAwaitFormData({ 
                    api: 1, 
                    ID_PPT_SELECCION: ID_PPT_SELECCION, 
                    CURP: curpSeleccionada 
                }, 'SeleccionSave', 'formularioSeleccionPPT', 'guardarFormSeleccionPPT', { callbackAfter: true, callbackBefore: true }, () => {

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
                        // Tablapptseleccion.ajax.reload();


                        if ($.fn.DataTable.isDataTable('#Tablapptseleccion')) {
                            Tablapptseleccion.ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
                        }

                    }, 300);
                });

            }, 1);
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});















