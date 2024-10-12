//VARIABLES GLOBALES
var curpSeleccionada; 


// ID DE LOS FORMULARIOS 
ID_FORMULARIO_CONTRATACION = 0;
ID_DOCUMENTO_SOPORTE = 0;




// TABLAS
var Tabladocumentosoporte;
var tablaDocumentosCargada = false; 

Tablacontratacion = null










$('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
});


$(document).ready(function() {
    $("#contratos-tab").click(function () {
        $('#datosgenerales-tab').closest('li').css("display", 'none');
    });
});



$(document).ready(function() {
    $("#boton_nuevo_contrato").click(function () {
        
        ID_FORMULARIO_CONTRATACION = 0;


        $(".div_trabajador_nombre").html('NOMBRE DEL COLABORADOR');


        $('#datosgenerales-tab').closest('li').css("display", 'block');
        
        // $('.multisteps-form__progress-btn').not('#step1').css("display", 'none');
        

        // $('#step1-content').css("display", 'block'); 
        // $('#step2-content, #step3-content, #step4-content, #step5-content, #step6-content, #step7-content, #step8-content').css("display", 'none'); // Ocultar los demás steps

        $( "#informacionacademica" ).css('display', 'none');
        $( "#experienciacolaborador" ).css('display', 'none');


        $( "#step2" ).css('display', 'none');
        $( "#step2-content" ).css('display', 'none');

      
        $( "#step3" ).css('display', 'none');
        $( "#step3-content" ).css('display', 'none');

      
        $( "#step4" ).css('display', 'none');
        $( "#step4-content" ).css('display', 'none');

      
        $( "#step5" ).css('display', 'none');
        $( "#step5-content" ).css('display', 'none');

      
        $( "#step6" ).css('display', 'none');
        $( "#step6-content" ).css('display', 'none');

      
        $( "#step7" ).css('display', 'none');
        $( "#step7-content" ).css('display', 'none');

      
        $( "#step8" ).css('display', 'none');
        $( "#step8-content" ).css('display', 'none');

      



        $('#datosgenerales-tab').tab('show'); 

        var drEvent = $('#FOTO_USUARIO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove': 'Quitar',
                'error': 'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });

        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();  
        drEvent.clearElement();  

        // Borrar el formulario
        $('#FormularioCONTRATACION').each(function(){
            this.reset();
        });
    });
});








$("#guardarDatosGenerales").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('FormularioCONTRATACION');

    if (formularioValido) {
        if (ID_FORMULARIO_CONTRATACION == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTRATACION: ID_FORMULARIO_CONTRATACION }, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
                    
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {

                    curpSeleccionada = data.contrato.CURP;
                    // console.log("CURP seleccionada: ", curpSeleccionada);

                    ID_FORMULARIO_CONTRATACION = data.contrato.ID_FORMULARIO_CONTRATACION;
                    $('#step2, #step3, #step4, #step5, #step6, #step7, #step8').css("display", "flex");
                    $( "#informacionacademica" ).css('display', 'block');
                    $( "#experienciacolaborador" ).css('display', 'block');
            
                    alertMensaje('success','Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    Tablacontratacion.ajax.reload();
                });
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTRATACION: ID_FORMULARIO_CONTRATACION }, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    
                    setTimeout(() => {

                        ID_FORMULARIO_CONTRATACION = data.contrato.ID_FORMULARIO_CONTRATACION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        Tablacontratacion.ajax.reload();

                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});





var Tablacontratacion = $("#Tablacontratacion").DataTable({
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
    destroy: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablacontratacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacontratacion.columns.adjust().draw();
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
        {
            data: null,  render: function (data, type, row)
             {
                return row.NOMBRE_COLABORADOR + ' ' + row.PRIMER_APELLIDO + ' ' + row.SEGUNDO_APELLIDO;
            }
        }
        ,
        { data: 'CURP' },
        { data: 'BTN_EDITAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
        { targets: 2, title: 'CURP', className: 'all text-center' },
        { targets: 3, title: 'Mostrar', className: 'all text-center' }
    ]
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); 
    if (target === '#contratos') {
        Tablacontratacion.columns.adjust().draw(); 
    }
});


function reloadTablaContratacion() {
    Tablacontratacion.ajax.reload(null, false); 
}







 // <!-- ============================================================== -->
// <!-- STEP 1  -->
// <!-- ============================================================== -->




document.getElementById('step1').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step1-content').style.display = 'block';
});


$('#Tablacontratacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratacion.row(tr);
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;

    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3, #step4, #step5, #step6, #step7, #step8').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content, #step5-content, #step6-content, #step7-content, #step8-content').css("display", 'none');

    if (row.data().FOTO_USUARIO) {
        var archivo = row.data().FOTO_USUARIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/usuariocolaborador/' + row.data().ID_FORMULARIO_CONTRATACION + extension;

        if ($('#FOTO_USUARIO').data('dropify')) {
            $('#FOTO_USUARIO').dropify().data('dropify').destroy();
            $('#FOTO_USUARIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_USUARIO').dropify().data('dropify').init();
        } else {
            $('#FOTO_USUARIO').attr('data-default-file', imagenUrl);
            $('#FOTO_USUARIO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                },
                error: {
                    'fileSize': 'Demasiado grande ({{ value }} max).',
                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_USUARIO').dropify().data('dropify').resetPreview();
        $('#FOTO_USUARIO').dropify().data('dropify').clearElement();
    }

    var curp = row.data().CURP;
    $("#CURP").val(curp);
    curpSeleccionada = curp;

    
    // Llenar el formulario con los datos correspondientes
    $("#NOMBRE_COLABORADOR").val(row.data().NOMBRE_COLABORADOR);
    $("#PRIMER_APELLIDO").val(row.data().PRIMER_APELLIDO);
    $("#SEGUNDO_APELLIDO").val(row.data().SEGUNDO_APELLIDO);
    $("#INICIALES_COLABORADOR").val(row.data().INICIALES_COLABORADOR);
    $("#DIA_COLABORADOR").val(row.data().DIA_COLABORADOR);
    $("#MES_COLABORADOR").val(row.data().MES_COLABORADOR);
    $("#ANIO_COLABORADOR").val(row.data().ANIO_COLABORADOR);
    // $("#EDAD_COLABORADOR").val(row.data().EDAD_COLABORADOR);
    $("#LUGAR_NACIMIENTO").val(row.data().LUGAR_NACIMIENTO);
    $("#TELEFONO_COLABORADOR").val(row.data().TELEFONO_COLABORADOR);
    $("#CORREO_COLABORADOR").val(row.data().CORREO_COLABORADOR);
    $("#ESTADO_CIVIL").val(row.data().ESTADO_CIVIL);
    $("#RFC_COLABORADOR").val(row.data().RFC_COLABORADOR);
    $("#VIGENCIA_INE").val(row.data().VIGENCIA_INE);
    $("#NSS_COLABORADOR").val(row.data().NSS_COLABORADOR);
    $("#TIPO_SANGRE").val(row.data().TIPO_SANGRE);
    $("#ALERGIAS_COLABORADOR").val(row.data().ALERGIAS_COLABORADOR);
    $("#CALLE_COLABORADOR").val(row.data().CALLE_COLABORADOR);
    $("#COLONIA_COLABORADOR").val(row.data().COLONIA_COLABORADOR);
    $("#CODIGO_POSTAL").val(row.data().CODIGO_POSTAL);
    $("#CIUDAD_COLABORADOR").val(row.data().CIUDAD_COLABORADOR);
    $("#ESTADO_COLABORADOR").val(row.data().ESTADO_COLABORADOR);
    $("#NOMBRE_EMERGENCIA").val(row.data().NOMBRE_EMERGENCIA);
    $("#PARENTESCO_EMERGENCIA").val(row.data().PARENTESCO_EMERGENCIA);
    $("#TELEFONO1_EMERGENCIA").val(row.data().TELEFONO1_EMERGENCIA);
    $("#TELEFONO2_EMERGENCIA").val(row.data().TELEFONO2_EMERGENCIA);
    $("#NOMBRE_BENEFICIARIO").val(row.data().NOMBRE_BENEFICIARIO);
    $("#PARENTESCO_BENEFICIARIO").val(row.data().PARENTESCO_BENEFICIARIO);
    $("#PORCENTAJE_BENEFICIARIO").val(row.data().PORCENTAJE_BENEFICIARIO);
    $("#TELEFONO1_BENEFICIARIO").val(row.data().TELEFONO1_BENEFICIARIO);
    $("#TELEFONO2_BENEFICIARIO").val(row.data().TELEFONO2_BENEFICIARIO);

    actualizarStepsConCurp(curp);



    tablaDocumentosCargada = false; 


    $('#datosgenerales-tab').tab('show');


    $(".div_trabajador_nombre").html(row.data().NOMBRE_COLABORADOR + ' ' + row.data().PRIMER_APELLIDO + ' ' + row.data().SEGUNDO_APELLIDO);


    if (row.data().DIA_COLABORADOR && row.data().MES_COLABORADOR && row.data().ANIO_COLABORADOR) {
        const fechaNacimiento = `${row.data().ANIO_COLABORADOR}-${row.data().MES_COLABORADOR}-${row.data().DIA_COLABORADOR}`;
        const edad = calcularEdad(fechaNacimiento);
        $('#EDAD_COLABORADOR').val(edad).prop('readonly', true).show();
    }

    setTimeout(() => {
        $('#ANIO_COLABORADOR').val(row.data().ANIO_COLABORADOR);
    }, 100);


});



function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mesDiferencia = hoy.getMonth() - nacimiento.getMonth();
    
    if (mesDiferencia < 0 || (mesDiferencia === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}
    



function actualizarStepsConCurp(curp) {
    $("#CURP").val(curp);
    curpSeleccionada = curp;
}




 // <!-- ============================================================== -->
// <!-- STEP 2  -->
// <!-- ============================================================== -->


document.getElementById('step2').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step2-content').style.display = 'block';

    if (tablaDocumentosCargada) {
        Tabladocumentosoporte.columns.adjust().draw(); 
    } else {
        cargarTablaDocumentosSoporte();
        tablaDocumentosCargada = true; 
    }
});



document.addEventListener('DOMContentLoaded', function() {
    var archivoSoporte = document.getElementById('DOCUMENTO_SOPORTE');
    var quitarSoporte = document.getElementById('quitar_documento');
    var errorElement = document.getElementById('DOCUMENTO_ERROR');

    if (archivoSoporte) {
        archivoSoporte.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarSoporte) quitarSoporte.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarSoporte) quitarSoporte.style.display = 'none';
            }
        });
        quitarSoporte.addEventListener('click', function() {
            archivoSoporte.value = ''; 
            quitarSoporte.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});



document.addEventListener('DOMContentLoaded', function() {
    var tipoArea = document.getElementById('TIPO_DOCUMENTO');
    var nombreDocumento = document.getElementById('NOMBRE_DOCUMENTO');

    tipoArea.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text; 

        if (this.value == '14') {
            nombreDocumento.removeAttribute('readonly');
            nombreDocumento.value = ''; 
        } else {
            nombreDocumento.setAttribute('readonly', true);
            nombreDocumento.value = selectedOption; 
        }
    });
});




$("#guardarDOCUMENTOSOPORTE").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioDOCUMENTOS');

    if (formularioValido) {

    if (ID_DOCUMENTO_SOPORTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 2, CURP: curpSeleccionada , ID_DOCUMENTO_SOPORTE: ID_DOCUMENTO_SOPORTE }, 'contratoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_SOPORTE = data.soporte.ID_DOCUMENTO_SOPORTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
                        Tabladocumentosoporte.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 2, CURP: curpSeleccionada ,ID_DOCUMENTO_SOPORTE: ID_DOCUMENTO_SOPORTE }, 'contratoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_SOPORTE = data.soporte.ID_DOCUMENTO_SOPORTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
                        Tabladocumentosoporte.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


function cargarTablaDocumentosSoporte() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
        Tabladocumentosoporte.clear().destroy();
    }

    Tabladocumentosoporte = $("#Tabladocumentosoporte").DataTable({
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
            url: '/Tabladocumentosoporte',  
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tabladocumentosoporte.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },  
            { data: 'BTN_DOCUMENTO' }, 
            { data: 'BTN_EDITAR' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento de soporte', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' },  
        ]
    });
}

$('#Tabladocumentosoporte').on('click', '.ver-archivo-documentosoporte', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }
    var url = '/mostrardocumentosoporte/' + id;
    abrirModal(url, ' Documento de soporte');
});



const Modaldocumentosoporte = document.getElementById('miModal_DOCUMENTOS_SOPORTE')
Modaldocumentosoporte.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTO_SOPORTE = 0
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');


})






$('#Tabladocumentosoporte').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporte.row(tr);

    ID_DOCUMENTO_SOPORTE = row.data().ID_DOCUMENTO_SOPORTE;

     editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS_SOPORTE', 1);
  
     $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html(row.data().NOMBRE_DOCUMENTO);

});












 // <!-- ============================================================== -->
// <!-- STEP 3  -->
// <!-- ============================================================== -->


document.getElementById('step3').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step3-content').style.display = 'block';

    if (!tablaDocumentosCargada) {
        cargarTablaDocumentosSoporte();
        tablaDocumentosCargada = true; 
    }
});





 // <!-- ============================================================== -->
// <!-- STEP 8  -->
// <!-- ============================================================== -->




document.getElementById('step8').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step8-content').style.display = 'block';

    // if (!tablaDocumentosCargada) {
    //     cargarTablaDocumentosSoporte();
    //     tablaDocumentosCargada = true; 
    // }
});




document.addEventListener('DOMContentLoaded', function() {
    var archivorecibo = document.getElementById('DOCUMENTO_RECIBO');
    var quitarecibo = document.getElementById('quitar_recibo');
    var errorecibo = document.getElementById('RECIBO_ERROR');

    if (archivorecibo) {
        archivorecibo.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorecibo) errorecibo.style.display = 'none';
                if (quitarecibo) quitarecibo.style.display = 'block';
            } else {
                if (errorecibo) errorecibo.style.display = 'block';
                this.value = '';
                if (quitarecibo) quitarecibo.style.display = 'none';
            }
        });
        quitarecibo.addEventListener('click', function() {
            archivorecibo.value = ''; 
            quitarecibo.style.display = 'none'; 
            if (errorecibo) errorecibo.style.display = 'none'; 
        });
    }
});


