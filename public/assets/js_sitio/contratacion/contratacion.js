//VARIABLES GLOBALES
var curpSeleccionada; 
var contrato_id = null; 



// ID DE LOS FORMULARIOS 
ID_FORMULARIO_CONTRATACION = 0;
ID_DOCUMENTO_SOPORTE = 0;
ID_CONTRATOS_ANEXOS = 0;


ID_INFORMACION_MEDICA = 0;
ID_INCIDENCIAS = 0 ;
ID_ACCIONES_DISCIPLINARIAS = 0;
ID_RECIBOS_NOMINA = 0;



// TABLAS
Tablacontratacion = null


var Tablacontratacion1;
var tablacontracion1Cargada = false; 


var Tabladocumentosoporte;
var tablaDocumentosCargada = false; 

var Tablacontratosyanexos;
var tablacontratosCargada = false; 


var Tablarecibonomina;
var tablareciboCargada = false; 



var Tablainformacionmedica;
var tablainformacionCargada = false; 















$('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
});

$(document).ready(function() {
    
    $("#contratos-tab").click(function () {
        $('#datosgenerales-tab').closest('li').css("display", 'none');
        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });
    
    $("#datosgenerales-tab").click(function () {
        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });

});

const textoActivo = document.getElementById('texto_activo');
const textoInactivo = document.getElementById('texto_inactivo');
const tablaActivo = document.getElementById('tabla_activo');
const tablaInactivo = document.getElementById('tabla_inactivo');

textoActivo.addEventListener('click', () => {
    tablaActivo.style.display = 'block';
    tablaInactivo.style.display = 'none';
    textoActivo.classList.add('texto-seleccionado');
    textoActivo.classList.remove('texto-no-seleccionado');
    textoInactivo.classList.add('texto-no-seleccionado');
    textoInactivo.classList.remove('texto-seleccionado');

    Tablacontratacion.columns.adjust().draw(); 

});

textoInactivo.addEventListener('click', () => {
    tablaActivo.style.display = 'none';
    tablaInactivo.style.display = 'block';
    textoInactivo.classList.add('texto-seleccionado');
    textoInactivo.classList.remove('texto-no-seleccionado');
    textoActivo.classList.add('texto-no-seleccionado');
    textoActivo.classList.remove('texto-seleccionado');

    if (tablacontracion1Cargada) {
        Tablacontratacion1.columns.adjust().draw();
    } else {
        cargarTablaContratacionInactivo();
        tablacontracion1Cargada = true;
    }


});

$(document).ready(function() {
    $("#boton_nuevo_contrato").click(function () {
        
        ID_FORMULARIO_CONTRATACION = 0;


        $(".div_trabajador_nombre").html('NOMBRE DEL COLABORADOR');


        $('#datosgenerales-tab').closest('li').css("display", 'block');
        
    
        $("#step1").css('display', 'flex');
        $("#step1-content").css('display', 'block');

        $( "#step2" ).css('display', 'none');
        $( "#step2-content" ).css('display', 'none');

      
        $( "#step3" ).css('display', 'none');
        $( "#step3-content" ).css('display', 'none');

    
        $( "#step4" ).css('display', 'none');
        $( "#step4-content" ).css('display', 'none');

    

    
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


        desbloquearBotones();
        
        $('#FormularioCONTRATACION').each(function(){
            this.reset();
        });

        $(".listadeBeneficiario").empty();

        $("#steps_menu_tab1").click();


    });
});


function bloquearBotones() {
    const botones = [
        'botonagregarbeneficiario',
        'guardarDatosGenerales',
        'botoneliminarbene',
        'guardarDOCUMENTOSOPORTE',
        'guardarCONTRATO',
        'guardarRECIBONOMINA',
        'guardarINFORMACIONMEDICA',
        'guardarINCIDENCIAS'
    ];

    botones.forEach(botonId => {
        const boton = document.getElementById(botonId);
        if (boton) {
            boton.setAttribute('disabled', 'true');
        }
    });
}


function desbloquearBotones() {
    const botones = [
        'botonagregarbeneficiario',
        'guardarDatosGenerales',
        'botoneliminarbene',
        'guardarDOCUMENTOSOPORTE',
        'guardarCONTRATO',
        'guardarRECIBONOMINA',
        'guardarINFORMACIONMEDICA',
        'guardarINCIDENCIAS'
    ];

    botones.forEach(botonId => {
        const boton = document.getElementById(botonId);
        if (boton) {
            boton.removeAttribute('disabled');
        }
    });
}




function verificarEstadoYActualizarBotones() {
    if (typeof curpSeleccionada === 'undefined' || !curpSeleccionada) {
        console.error('CURP no definida.');
        return;
    }

    fetch('/verificarestadobloqueo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ curpSeleccionada }) 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor.');
            }
            return response.json();
        })
        .then(data => {
            const bloqueodesactivado = data.bloqueodesactivado;

            if (bloqueodesactivado === 0) {
                bloquearBotones();
            } else {
                desbloquearBotones();
            }
        })
        .catch(error => {
            console.error('Error al verificar el estado:', error);
        });
}

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
            $('#loadingIcon8').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon8').css('display', 'none');
            Tablacontratacion.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon8').css('display', 'none');
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




// <!-- ============================================================================================================================ -->
// <!--                                                          COLABORADORES INACTIVOS                                             -->
// <!-- ============================================================================================================================ -->



function cargarTablaContratacionInactivo() {
    if ($.fn.DataTable.isDataTable('#Tablacontratacion1')) {
        Tablacontratacion1.clear().destroy();
    }

    Tablacontratacion1 = $("#Tablacontratacion1").DataTable({
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
        url: '/Tablacontratacion1',
        beforeSend: function () {
            $('#loadingIcon7').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon7').css('display', 'none');
            Tablacontratacion1.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon7').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
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
            { data: 'BTN_EDITAR' },
            { data: 'BTN_ACTIVAR' }

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
            { targets: 2, title: 'CURP', className: 'all text-center' },
            { targets: 3, title: 'Mostrar', className: 'all text-center' },
            { targets: 4, title: 'Activar', className: 'all text-center' }

        ]
    });
}

$(document).on('change', '.ACTIVAR', function () {
    var checkbox = $(this); 
    var row = checkbox.closest('tr'); 
    var data = Tablacontratacion1.row(row).data(); 
    var id = checkbox.data('id'); 
    var estadoAnterior = checkbox.prop('checked');

    if (!id || !data) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo obtener la información del colaborador',
            timer: 2000,
            timerProgressBar: true
        });
        return;
    }

    var nombreColaborador = `${data.NOMBRE_COLABORADOR} ${data.PRIMER_APELLIDO} ${data.SEGUNDO_APELLIDO}`;

    var accion = "activar";
    var url = '/activarColaborador/' + id;

    Swal.fire({
        title: `Confirme para ${accion} al colaborador`,
        text: `Está a punto de activar a ${nombreColaborador}. ¿Desea continuar?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === "success") {
                        if ($.fn.DataTable.isDataTable('#Tablacontratacion1')) {
                            Tablacontratacion1.ajax.reload(null, false);
                        }

                        if ($.fn.DataTable.isDataTable('#Tablacontratacion')) {
                            Tablacontratacion.ajax.reload(null, false);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Colaborador activado',
                            text: `${nombreColaborador} ha sido activado exitosamente`,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: response.status,
                            title: 'Atención',
                            text: response.msj,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        checkbox.prop('checked', !estadoAnterior);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo completar la acción',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    checkbox.prop('checked', !estadoAnterior);
                }
            });
        } else {
            checkbox.prop('checked', !estadoAnterior);
        }
    });
});

$('#Tablacontratacion1').on('click', 'button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratacion1.row(tr);
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;

    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content').css("display", 'none');

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

    $("#NOMBRE_COLABORADOR").val(row.data().NOMBRE_COLABORADOR);
    $("#PRIMER_APELLIDO").val(row.data().PRIMER_APELLIDO);
    $("#SEGUNDO_APELLIDO").val(row.data().SEGUNDO_APELLIDO);
    $("#INICIALES_COLABORADOR").val(row.data().INICIALES_COLABORADOR);
    $("#DIA_COLABORADOR").val(row.data().DIA_COLABORADOR);
    $("#MES_COLABORADOR").val(row.data().MES_COLABORADOR);
    $("#ANIO_COLABORADOR").val(row.data().ANIO_COLABORADOR);
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




    $("#CIUDAD_LUGAR_NACIMIENTO").val(row.data().CIUDAD_LUGAR_NACIMIENTO);
    $("#ESTADO_LUGAR_NACIMIENTO").val(row.data().ESTADO_LUGAR_NACIMIENTO);
    $("#PAIS_LUGAR_NACIMIENTO").val(row.data().PAIS_LUGAR_NACIMIENTO);
    $("#TIPO_DOCUMENTO_IDENTIFICACION").val(row.data().TIPO_DOCUMENTO_IDENTIFICACION);
    $("#EMISION_DOCUMENTO").val(row.data().EMISION_DOCUMENTO);
    $("#VIGENCIA_DOCUMENTO").val(row.data().VIGENCIA_DOCUMENTO);
    $("#NUMERO_DOCUMENTO").val(row.data().NUMERO_DOCUMENTO);
    $("#EXPEDIDO_DOCUMENTO").val(row.data().EXPEDIDO_DOCUMENTO);
    $("#CALLE1_COLABORADOR").val(row.data().CALLE1_COLABORADOR);
    $("#CALLE2_COLABORADOR").val(row.data().CALLE2_COLABORADOR);

    $("#TIPO_VIALIDAD").val(row.data().TIPO_VIALIDAD);
    $("#NOMBRE_VIALIDAD").val(row.data().NOMBRE_VIALIDAD);
    $("#NUMERO_EXTERIOR").val(row.data().NUMERO_EXTERIOR);
    $("#NUMERO_INTERIOR").val(row.data().NUMERO_INTERIOR);
    $("#NOMBRE_COLONIA").val(row.data().NOMBRE_COLONIA);
    $("#NOMBRE_LOCALIDAD").val(row.data().NOMBRE_LOCALIDAD);
    $("#NOMBRE_MUNICIPIO").val(row.data().NOMBRE_MUNICIPIO);
    $("#NOMBRE_ENTIDAD").val(row.data().NOMBRE_ENTIDAD);
    $("#ENTRE_CALLE").val(row.data().ENTRE_CALLE);
    $("#ENTRE_CALLE_2").val(row.data().ENTRE_CALLE_2);



    verificarEstadoYActualizarBotones();



    actualizarStepsConCurp(curp);

    tablaDocumentosCargada = false;
    tablacontratosCargada = false;


    $('#datosgenerales-tab').tab('show');

    $(".listadeBeneficiario").empty();
    obtenerDatosBeneficiarios(row);

    $("#step1").click();

    $(".div_trabajador_nombre").html(row.data().NOMBRE_COLABORADOR + ' ' + row.data().PRIMER_APELLIDO + ' ' + row.data().SEGUNDO_APELLIDO);

    if (row.data().DIA_COLABORADOR && row.data().MES_COLABORADOR && row.data().ANIO_COLABORADOR) {
        const fechaNacimiento = `${row.data().ANIO_COLABORADOR}-${row.data().MES_COLABORADOR}-${row.data().DIA_COLABORADOR}`;
        const edad = calcularEdad(fechaNacimiento);
        $('#EDAD_COLABORADOR').val(edad).prop('readonly', true).show();
    }

    setTimeout(() => {
        $('#ANIO_COLABORADOR').val(row.data().ANIO_COLABORADOR);
    }, 100);



    $("#step1").click();
});



// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 1                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step1').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step1-content').style.display = 'block';
});

$("#guardarDatosGenerales").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('FormularioCONTRATACION');

    if (formularioValido) {
        // Generar lista de beneficiarios
        var beneficiarios = [];
        $(".generarlistadebeneficiario").each(function() {
            var beneficiario = {
                'NOMBRE_BENEFICIARIO': $(this).find("input[name='NOMBRE_BENEFICIARIO']").val(),
                'PARENTESCO_BENEFICIARIO': $(this).find("input[name='PARENTESCO_BENEFICIARIO']").val(),
                'PORCENTAJE_BENEFICIARIO': $(this).find("input[name='PORCENTAJE_BENEFICIARIO']").val(),
                'TELEFONO1_BENEFICIARIO': $(this).find("input[name='TELEFONO1_BENEFICIARIO']").val(),
                'TELEFONO2_BENEFICIARIO': $(this).find("input[name='TELEFONO2_BENEFICIARIO']").val()
            };
            beneficiarios.push(beneficiario);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_CONTRATACION: ID_FORMULARIO_CONTRATACION,
            BENEFICIARIOS_JSON: JSON.stringify(beneficiarios)
        };

        if (ID_FORMULARIO_CONTRATACION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData(requestData, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    curpSeleccionada = data.contrato.CURP;
                    ID_FORMULARIO_CONTRATACION = data.contrato.ID_FORMULARIO_CONTRATACION;
                    $('#step2, #step3, #step4').css("display", "flex");
                    $("#informacionacademica").css('display', 'block');

                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
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
                await ajaxAwaitFormData(requestData, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
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

$('#Tablacontratacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratacion.row(tr);
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;

    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content').css("display", 'none');

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

    $("#NOMBRE_COLABORADOR").val(row.data().NOMBRE_COLABORADOR);
    $("#PRIMER_APELLIDO").val(row.data().PRIMER_APELLIDO);
    $("#SEGUNDO_APELLIDO").val(row.data().SEGUNDO_APELLIDO);
    $("#INICIALES_COLABORADOR").val(row.data().INICIALES_COLABORADOR);
    $("#DIA_COLABORADOR").val(row.data().DIA_COLABORADOR);
    $("#MES_COLABORADOR").val(row.data().MES_COLABORADOR);
    $("#ANIO_COLABORADOR").val(row.data().ANIO_COLABORADOR);
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




    $("#CIUDAD_LUGAR_NACIMIENTO").val(row.data().CIUDAD_LUGAR_NACIMIENTO);
    $("#ESTADO_LUGAR_NACIMIENTO").val(row.data().ESTADO_LUGAR_NACIMIENTO);
    $("#PAIS_LUGAR_NACIMIENTO").val(row.data().PAIS_LUGAR_NACIMIENTO);
    $("#TIPO_DOCUMENTO_IDENTIFICACION").val(row.data().TIPO_DOCUMENTO_IDENTIFICACION);
    $("#EMISION_DOCUMENTO").val(row.data().EMISION_DOCUMENTO);
    $("#VIGENCIA_DOCUMENTO").val(row.data().VIGENCIA_DOCUMENTO);
    $("#NUMERO_DOCUMENTO").val(row.data().NUMERO_DOCUMENTO);
    $("#EXPEDIDO_DOCUMENTO").val(row.data().EXPEDIDO_DOCUMENTO);
    $("#CALLE1_COLABORADOR").val(row.data().CALLE1_COLABORADOR);
    $("#CALLE2_COLABORADOR").val(row.data().CALLE2_COLABORADOR);

    $("#TIPO_VIALIDAD").val(row.data().TIPO_VIALIDAD);
    $("#NOMBRE_VIALIDAD").val(row.data().NOMBRE_VIALIDAD);
    $("#NUMERO_EXTERIOR").val(row.data().NUMERO_EXTERIOR);
    $("#NUMERO_INTERIOR").val(row.data().NUMERO_INTERIOR);
    $("#NOMBRE_COLONIA").val(row.data().NOMBRE_COLONIA);
    $("#NOMBRE_LOCALIDAD").val(row.data().NOMBRE_LOCALIDAD);
    $("#NOMBRE_MUNICIPIO").val(row.data().NOMBRE_MUNICIPIO);
    $("#NOMBRE_ENTIDAD").val(row.data().NOMBRE_ENTIDAD);
    $("#ENTRE_CALLE").val(row.data().ENTRE_CALLE);
    $("#ENTRE_CALLE_2").val(row.data().ENTRE_CALLE_2);





    verificarEstadoYActualizarBotones();

    actualizarStepsConCurp(curp);

    tablaDocumentosCargada = false;
    tablacontratosCargada = false;


    $('#datosgenerales-tab').tab('show');

    $(".listadeBeneficiario").empty();
    obtenerDatosBeneficiarios(row);

    $("#step1").click();

    $(".div_trabajador_nombre").html(row.data().NOMBRE_COLABORADOR + ' ' + row.data().PRIMER_APELLIDO + ' ' + row.data().SEGUNDO_APELLIDO);

    if (row.data().DIA_COLABORADOR && row.data().MES_COLABORADOR && row.data().ANIO_COLABORADOR) {
        const fechaNacimiento = `${row.data().ANIO_COLABORADOR}-${row.data().MES_COLABORADOR}-${row.data().DIA_COLABORADOR}`;
        const edad = calcularEdad(fechaNacimiento);
        $('#EDAD_COLABORADOR').val(edad).prop('readonly', true).show();
    }

    setTimeout(() => {
        $('#ANIO_COLABORADOR').val(row.data().ANIO_COLABORADOR);
    }, 100);



    $("#step1").click();
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

function validarPorcentajeBeneficiarios() {
    let suma = 0;

    document.querySelectorAll("input[name='PORCENTAJE_BENEFICIARIO']").forEach(function (input) {
        let valor = parseFloat(input.value) || 0; 
        suma += valor;
    });

    const botonGuardar = document.getElementById('guardarDatosGenerales');

    if (suma > 100) {
        alertToast("La suma de los porcentajes no puede exceder el 100%.");
        botonGuardar.disabled = true; 
    } else if (suma === 100) {
        botonGuardar.disabled = false; 
    } else {
        botonGuardar.disabled = true; 
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const botonAgregar = document.getElementById('botonagregarbeneficiario');
    botonAgregar.addEventListener('click', function () {
        agregarBeneficiario();
        validarPorcentajeBeneficiarios(); 
    });

    document.addEventListener('input', function (e) {
        if (e.target.name === 'PORCENTAJE_BENEFICIARIO') {
            validarPorcentajeBeneficiarios(); 
        }
    });

    function agregarBeneficiario() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarlistadebeneficiario', 'm-3');
        divContacto.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group">
                    <h5><i class="bi bi-person"></i> Agregar beneficiario</h5>                    
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Nombre completo *</label>
                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Parentesco *</label>
                    <input type="text" class="form-control" name="PARENTESCO_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Porcentaje *</label>
                    <input type="number" class="form-control" name="PORCENTAJE_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono 1 *</label>
                    <input type="number" class="form-control" name="TELEFONO1_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono  2 </label>
                    <input type="number" class="form-control" name="TELEFONO2_BENEFICIARIO">
                </div>
            </div>
            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarBeneficiario">Eliminar beneficiario <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.listadeBeneficiario');
        contenedor.appendChild(divContacto);

        const botonEliminar = divContacto.querySelector('.botonEliminarBeneficiario');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
            validarPorcentajeBeneficiarios(); 
        });
    }
});

function obtenerDatosBeneficiarios(data) {
    let row = data.data().BENEFICIARIOS_JSON;
    var beneficiarios = JSON.parse(row);
    let contadorBeneficiario = 1;

    $.each(beneficiarios, function (index, contacto) {
        var nombre = contacto.NOMBRE_BENEFICIARIO;
        var parentesco = contacto.PARENTESCO_BENEFICIARIO;
        var porcentaje = contacto.PORCENTAJE_BENEFICIARIO;
        var telefono1 = contacto.TELEFONO1_BENEFICIARIO;
        var telefono2 = contacto.TELEFONO2_BENEFICIARIO;

        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarlistadebeneficiario', 'm-2');
        divContacto.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group d-flex align-items-center">
                    <h5><i class="bi bi-person"></i> Beneficiario N° ${contadorBeneficiario} &nbsp;</h5>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Nombre completo *</label>
                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" value="${nombre}" required>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Parentesco *</label>
                    <input type="text" class="form-control" name="PARENTESCO_BENEFICIARIO" value="${parentesco}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Porcentaje *</label>
                    <input type="number" class="form-control" name="PORCENTAJE_BENEFICIARIO" value="${porcentaje}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono 1 *</label>
                    <input type="number" class="form-control" name="TELEFONO1_BENEFICIARIO" value="${telefono1}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono  2 </label>
                    <input type="number" class="form-control" name="TELEFONO2_BENEFICIARIO" value="${telefono2}">
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarBeneficiario"  id="botoneliminarbene">Eliminar beneficiario <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.listadeBeneficiario');
        contenedor.appendChild(divContacto);

        contadorBeneficiario++;

        const botonEliminar = divContacto.querySelector('.botonEliminarBeneficiario');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
            validarPorcentajeBeneficiarios(); 
        });
    });

    validarPorcentajeBeneficiarios();
}





// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 2                                                              -->
// <!-- ============================================================================================================================ -->




document.getElementById('step2').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    const step2Content = document.getElementById('step2-content');
    step2Content.style.display = 'block';

    if (tablaDocumentosCargada) {
        Tabladocumentosoporte.columns.adjust().draw();
    } else {
        cargarTablaDocumentosSoporte();
        tablaDocumentosCargada = true;
    }

    cargarDocumentosGuardados();

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

        if (this.value == '13') {
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
                    cargarDocumentosGuardados();

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

                    cargarDocumentosGuardados();


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
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporte.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentosoporte/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});

const Modaldocumentosoporte = document.getElementById('miModal_DOCUMENTOS_SOPORTE')
Modaldocumentosoporte.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTO_SOPORTE = 0
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');

    $('#TIPO_DOCUMENTO').prop('disabled', false); 
    $('#NOMBRE_DOCUMENTO').prop('readonly', false); 


    document.getElementById('quitar_documento').style.display = 'none';

    document.getElementById('DOCUMENTO_ERROR').style.display = 'none';

})

$('#Tabladocumentosoporte').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporte.row(tr);

    ID_DOCUMENTO_SOPORTE = row.data().ID_DOCUMENTO_SOPORTE;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS_SOPORTE', 1);

    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html(row.data().NOMBRE_DOCUMENTO);

    $('#TIPO_DOCUMENTO').prop('disabled', true); 
    $('#NOMBRE_DOCUMENTO').prop('readonly', true); 
});

function cargarDocumentosGuardados() {
    if (!curpSeleccionada || curpSeleccionada.trim() === '') {
        console.error('CURP no definida');
        return;
    }

    $.ajax({
        url: '/obtenerguardados',
        method: 'POST',
        data: {
            CURP: curpSeleccionada, 
            _token: $('input[name="_token"]').val() 
        },
        success: function (data) {
            let select = $('#TIPO_DOCUMENTO');
            select.find('option').prop('disabled', false);

            data.forEach(function (tipoDocumento) {
                select.find(`option[value="${tipoDocumento}"]`).prop('disabled', true);
            });

        },
        error: function (xhr, status, error) {
            console.error('Error al cargar documentos guardados:', error);
        }
    });
}







// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 3                                                              -->
// <!-- ============================================================================================================================ -->



document.getElementById('step3').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step3-content').style.display = 'block';

    if (tablacontratosCargada) {
        Tablacontratosyanexos.columns.adjust().draw();
    } else {
        cargarTablaContratosyanexos();
        tablacontratosCargada = true;
    }
  
});

document.addEventListener('DOMContentLoaded', function() {
    var archivocontrato = document.getElementById('DOCUMENTO_CONTRATO');
    var quitarcontrato = document.getElementById('quitar_contrato');
    var errorElement = document.getElementById('DOCUEMNTO_ERROR_CONTRATO');

    if (archivocontrato) {
        archivocontrato.addEventListener('change', function() {
            var archivoscontrato = this.files[0];
            if (archivoscontrato && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarcontrato) quitarcontrato.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarcontrato) quitarcontrato.style.display = 'none';
            }
        });
        quitarcontrato.addEventListener('click', function() {
            archivocontrato.value = ''; 
            quitarcontrato.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var tipoArea = document.getElementById('TIPO_DOCUMENTO_CONTRATO');
    var nombreDocumento = document.getElementById('NOMBRE_DOCUMENTO_CONTRATO');

    tipoArea.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text; 

        if (this.value == '16') {
            nombreDocumento.removeAttribute('readonly');
            nombreDocumento.value = ''; 
        } else {
            nombreDocumento.setAttribute('readonly', true);
            nombreDocumento.value = selectedOption; 
        }
    });
});

document.getElementById("TIPO_DOCUMENTO_CONTRATO").addEventListener("change", function() {
    const contratoDiv = document.getElementById("CONTRATO");
    const vigenciaDiv = document.getElementById("VIGENCIA");

    const contratoInputs = contratoDiv.querySelectorAll("input, select");
    const vigenciaInputs = vigenciaDiv.querySelectorAll("input");

    if (this.value == "3") {
        contratoDiv.style.display = "block";
        vigenciaDiv.style.display = "none";

        contratoInputs.forEach(element => element.required = true);
        vigenciaInputs.forEach(element => element.required = false);
    } else if (this.value == "4") {
        contratoDiv.style.display = "none";
        vigenciaDiv.style.display = "block";

        contratoInputs.forEach(element => element.required = false);
        vigenciaInputs.forEach(input => input.required = true);
    } else {
        contratoDiv.style.display = "none";
        vigenciaDiv.style.display = "none";

        contratoInputs.forEach(element => element.required = false);
        vigenciaInputs.forEach(input => input.required = false);
    }
});

const ModalContrato = document.getElementById('miModal_CONTRATO');
ModalContrato.addEventListener('hidden.bs.modal', event => {
    
    ID_CONTRATOS_ANEXOS = 0

    document.getElementById('formularioCONTRATO').reset();
    $('#miModal_CONTRATO .modal-title').html('Contratos y anexos');

    const contratoDiv = document.getElementById("CONTRATO");
    const vigenciaDiv = document.getElementById("VIGENCIA");
    
    contratoDiv.style.display = "none";
    vigenciaDiv.style.display = "none";

    const contratoInputs = contratoDiv.querySelectorAll("input, select");
    const vigenciaInputs = vigenciaDiv.querySelectorAll("input");
    
    contratoInputs.forEach(element => element.required = false);
    vigenciaInputs.forEach(element => element.required = false);

    document.getElementById('TIPO_DOCUMENTO_CONTRATO').value = "0";


    
    document.getElementById('quitar_contrato').style.display = 'none';

    document.getElementById('DOCUEMNTO_ERROR_CONTRATO').style.display = 'none';
});

$("#guardarCONTRATO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioCONTRATO');

    if (formularioValido) {

    if (ID_CONTRATOS_ANEXOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATO')
            await ajaxAwaitFormData({ api: 3, CURP: curpSeleccionada , ID_CONTRATOS_ANEXOS: ID_CONTRATOS_ANEXOS }, 'contratoSave', 'formularioCONTRATO', 'guardarCONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_CONTRATOS_ANEXOS = data.soporte.ID_CONTRATOS_ANEXOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_CONTRATO').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
                        Tablacontratosyanexos.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATO')
            await ajaxAwaitFormData({ api: 3, CURP: curpSeleccionada ,ID_CONTRATOS_ANEXOS: ID_CONTRATOS_ANEXOS }, 'contratoSave', 'formularioCONTRATO', 'guardarCONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_CONTRATOS_ANEXOS = data.soporte.ID_CONTRATOS_ANEXOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_CONTRATO').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
                        Tablacontratosyanexos.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablaContratosyanexos() {
    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
        Tablacontratosyanexos.clear().destroy();
    }

    Tablacontratosyanexos = $("#Tablacontratosyanexos").DataTable({
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
            url: '/Tablacontratosyanexos',  
            beforeSend: function () {
                $('#loadingIcon1').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon1').css('display', 'none');
                Tablacontratosyanexos.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_CONTRATO', className: 'text-center' },
            { 
                data: 'NOMBRE_CATEGORIA', 
                className: 'text-center',
                render: function(data) { return data ? data : 'N/A'; }
            }, 
            { 
                data: 'VIGENCIA_CONTRATO', 
                className: 'text-center',
                render: function(data) {
                    return formatoFechaConDiasRestantes(data);
                }
            }, 
            { 
                data: 'VIGENCIA_ACUERDO', 
                className: 'text-center',
                render: function(data) {
                    return formatoFechaConDiasRestantes(data);
                }
            }, 
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
            { data: 'BTN_CONTRATO', className: 'text-center' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Nombre del Cargo', className: 'all text-center' },  
            { targets: 3, title: 'Vigencia del contrato', className: 'all text-center' },  
            { targets: 4, title: 'Vigencia del Acuerdo de <br> confidencialidad', className: 'all text-center' },  
            { targets: 5, title: 'Documento de soporte', className: 'all text-center' },  
            { targets: 6, title: 'Editar', className: 'all text-center' }, 
            { targets: 7, title: 'Contrato', className: 'all text-center' },  

        ],
        rowCallback: function(row, data) {
            const diasContrato = calcularDiasRestantes(data.VIGENCIA_CONTRATO, true);
            const diasAcuerdo = calcularDiasRestantes(data.VIGENCIA_ACUERDO, true);
            
            if ((diasContrato !== null && diasContrato <= 10) || (diasAcuerdo !== null && diasAcuerdo <= 10)) {
                $(row).css({
                    "background-color": "#FFCCCC",
                    "border": "1px solid #FF0000",
                    "color": "#FF0000",
                    "opacity": "0.8"
                });
            }
        }
    });
}

function formatoFechaConDiasRestantes(fechaVencimiento) {
    if (!fechaVencimiento) return 'N/A';

    const hoy = new Date();
    const fecha = new Date(fechaVencimiento);
    
    const diferenciaTiempo = fecha - hoy;
    const diasRestantes = Math.ceil(diferenciaTiempo / (1000 * 60 * 60 * 24));

    if (diasRestantes >= 0) {
        return `${fechaVencimiento} (${diasRestantes} días restantes)`;
    } else {
        return `${fechaVencimiento} (Vencido)`;
    }
}

function calcularDiasRestantes(fechaVencimiento, returnNumber = false) {
    if (!fechaVencimiento) return null;

    const hoy = new Date();
    const fecha = new Date(fechaVencimiento);
    
    const diferenciaTiempo = fecha - hoy;
    const diasRestantes = Math.ceil(diferenciaTiempo / (1000 * 60 * 60 * 24));

    return diasRestantes >= 0 ? diasRestantes : null;
}

$('#Tablacontratosyanexos').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);

    ID_CONTRATOS_ANEXOS = row.data().ID_CONTRATOS_ANEXOS;

    editarDatoTabla(row.data(), 'formularioCONTRATO', 'miModal_CONTRATO', 1);
    $('#miModal_CONTRATO .modal-title').html(row.data().NOMBRE_DOCUMENTO_CONTRATO);

    $('#CONTRATO').css('display', 'none');
    $('#VIGENCIA').css('display', 'none');

    if (row.data().TIPO_DOCUMENTO_CONTRATO == 3) {
        $('#CONTRATO').css('display', 'block');
    } else if (row.data().TIPO_DOCUMENTO_CONTRATO == 4) {
        $('#VIGENCIA').css('display', 'block');
    }
});

$('#Tablacontratosyanexos').on('click', '.ver-archivo-contratosyanexos', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_CONTRATO;
    var url = '/mostrarcontratosyanexos/' + id;
    
    abrirModal(url, nombreDocumento);
});

$('#Tablacontratosyanexos').on('click', 'button.informacion', function () {

    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);


    contrato_id = row.data().ID_CONTRATOS_ANEXOS;
    NOMBRE_CATEGORIA = row.data().NOMBRE_CATEGORIA;
    VIGENCIA_CONTRATO = row.data().VIGENCIA_CONTRATO;

    


    $('#contratosdoc-tab').closest('li').css("display", "block");
    $("#contratosdoc-tab").click();



    $('#contrato_cargo').text(NOMBRE_CATEGORIA);
    $('#contrato_fecha_final').text(VIGENCIA_CONTRATO);

    cargarTablaInformacionMedica ();
    cargarTablaIncidencias ();  
    cargarTablaAccionesDisciplinarias ();
    cargarTablaRecibosNomina();

});

 

// <!-- ============================================================================================================================ -->
// <!--                                                          DOCUMENTOS DE CONTRATOS                                             -->
// <!-- ============================================================================================================================ -->



// <!-- ============================================================== -->
// <!--INFORMACION MEDICA-->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archivoinformacion = document.getElementById('DOCUMENTO_INFORMACION_MEDICA');
    var quitarinformacion = document.getElementById('quitar_informacion_medica');
    var errorinformacion = document.getElementById('INFORMACIONMEDICA_ERROR');

    if (archivoinformacion) {
        archivoinformacion.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorinformacion) errorinformacion.style.display = 'none';
                if (quitarinformacion) quitarinformacion.style.display = 'block';
            } else {
                if (errorinformacion) errorinformacion.style.display = 'block';
                this.value = '';
                if (quitarinformacion) quitarinformacion.style.display = 'none';
            }
        });
        quitarinformacion.addEventListener('click', function() {
            archivoinformacion.value = ''; 
            quitarinformacion.style.display = 'none'; 
            if (errorinformacion) errorinformacion.style.display = 'none'; 
        });
    }
});

$("#guardarINFORMACIONMEDICA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioINFORMACION');

    if (formularioValido) {

    if (ID_INFORMACION_MEDICA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINFORMACIONMEDICA')
            await ajaxAwaitFormData({ api: 5,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_INFORMACION_MEDICA: ID_INFORMACION_MEDICA }, 'contratoSave', 'formularioINFORMACION', 'guardarINFORMACIONMEDICA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_INFORMACION_MEDICA = data.soporte.ID_INFORMACION_MEDICA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_INFORMACION_MEDICA').modal('hide')
                    document.getElementById('formularioINFORMACION').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                        Tablainformacionmedica.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINFORMACIONMEDICA')
            await ajaxAwaitFormData({ api: 5,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_INFORMACION_MEDICA: ID_INFORMACION_MEDICA }, 'contratoSave', 'formularioINFORMACION', 'guardarINFORMACIONMEDICA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INFORMACION_MEDICA = data.soporte.ID_INFORMACION_MEDICA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_INFORMACION_MEDICA').modal('hide')
                    document.getElementById('formularioINFORMACION').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                        Tablainformacionmedica.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalinformacionmedica = document.getElementById('miModal_INFORMACION_MEDICA')
Modalinformacionmedica.addEventListener('hidden.bs.modal', event => {

    ID_INFORMACION_MEDICA = 0
    document.getElementById('formularioINFORMACION').reset();
   
    $('#miModal_INFORMACION_MEDICA .modal-title').html('Información medica');

    document.getElementById('quitar_informacion_medica').style.display = 'none';

    document.getElementById('INFORMACIONMEDICA_ERROR').style.display = 'none';

})

function cargarTablaInformacionMedica() {
    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
        Tablainformacionmedica.clear().destroy();
    }

    Tablainformacionmedica = $("#Tablainformacionmedica").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablainformacionmedica',  
            beforeSend: function () {
                $('#loadingIcon3').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon3').css('display', 'none');
                Tablainformacionmedica.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_INFORMACION', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablainformacionmedica').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionmedica.row(tr);

    ID_INFORMACION_MEDICA = row.data().ID_INFORMACION_MEDICA;

    editarDatoTabla(row.data(), 'formularioINFORMACION', 'miModal_INFORMACION_MEDICA', 1);

    $('#miModal_INFORMACION_MEDICA .modal-title').html(row.data().NOMBRE_DOCUMENTO_INFORMACION);


});

$('#Tablainformacionmedica').on('click', '.ver-archivo-informacionmedica', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionmedica.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_INFORMACION;
    var url = '/mostrarinformacionmedica/' + id;
    
    abrirModal(url, nombreDocumento);
});





// <!-- ============================================================== -->
// <!--INCIDENCIAS-->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archivoincidencias = document.getElementById('DOCUMENTO_INCIDENCIAS');
    var quitarincidencias = document.getElementById('quitar_incidencias');
    var errorincidencias = document.getElementById('INCIDENCIAS_ERROR');

    if (archivoincidencias) {
        archivoincidencias.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorincidencias) errorincidencias.style.display = 'none';
                if (quitarincidencias) quitarincidencias.style.display = 'block';
            } else {
                if (errorincidencias) errorincidencias.style.display = 'block';
                this.value = '';
                if (quitarincidencias) quitarincidencias.style.display = 'none';
            }
        });
        quitarincidencias.addEventListener('click', function() {
            archivoincidencias.value = ''; 
            quitarincidencias.style.display = 'none'; 
            if (errorincidencias) errorincidencias.style.display = 'none'; 
        });
    }
});

$("#guardarINCIDENCIAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioINCIDENCIAS');

    if (formularioValido) {

    if (ID_INCIDENCIAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINCIDENCIAS')
            await ajaxAwaitFormData({ api: 6,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_INCIDENCIAS: ID_INCIDENCIAS }, 'contratoSave', 'formularioINCIDENCIAS', 'guardarINCIDENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_INCIDENCIAS = data.soporte.ID_INCIDENCIAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_INCIDENCIAS').modal('hide')
                    document.getElementById('formularioINCIDENCIAS').reset();

                    
                    // if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                    //     Tablainformacionmedica.ajax.reload(null, false); 
                    // }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINCIDENCIAS')
            await ajaxAwaitFormData({ api: 6,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_INCIDENCIAS: ID_INCIDENCIAS }, 'contratoSave', 'formularioINCIDENCIAS', 'guardarINCIDENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INCIDENCIAS = data.soporte.ID_INCIDENCIAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_INCIDENCIAS').modal('hide')
                    document.getElementById('formularioINCIDENCIAS').reset();


                    
                    // if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                    //     Tablainformacionmedica.ajax.reload(null, false); 
                    // }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalincidendia = document.getElementById('miModal_INCIDENCIAS')
Modalinformacionmedica.addEventListener('hidden.bs.modal', event => {

    ID_INCIDENCIAS = 0

    document.getElementById('formularioINCIDENCIAS').reset();
   
    $('#miModal_INCIDENCIAS .modal-title').html('Incidencias');

    document.getElementById('quitar_incidencias').style.display = 'none';

    document.getElementById('INCIDENCIAS_ERROR').style.display = 'none';

})

function cargarTablaIncidencias() {
    if ($.fn.DataTable.isDataTable('#Tablaincidencias')) {
        Tablaincidencias.clear().destroy();
    }

    Tablaincidencias = $("#Tablaincidencias").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaincidencias',  
            beforeSend: function () {
                $('#loadingIcon4').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon4').css('display', 'none');
                Tablaincidencias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon4').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_INCIDENCIAS', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablaincidencias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaincidencias.row(tr);

    ID_INCIDENCIAS = row.data().ID_INCIDENCIAS;

    editarDatoTabla(row.data(), 'formularioINCIDENCIAS', 'miModal_INCIDENCIAS', 1);

    $('#miModal_INCIDENCIAS .modal-title').html(row.data().NOMBRE_DOCUMENTO_INCIDENCIAS);


});

$('#Tablaincidencias').on('click', '.ver-archivo-incidencias', function () {
    var tr = $(this).closest('tr');
    var row = Tablaincidencias.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_INCIDENCIAS;
    var url = '/mostrarincidencias/' + id;
    
    abrirModal(url, nombreDocumento);
});


// <!-- ============================================================== -->
// <!--ACCIONES DISCIPLINARIAS -->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archvioaccciones = document.getElementById('DOCUMENTO_ACCIONES_DISCIPLINARIAS');
    var quitacciones = document.getElementById('quitar_acciones_disciplinarias');
    var erroracciones = document.getElementById('ACCIONES_DISCIPLINARIAS_ERROR');

    if (archvioaccciones) {
        archvioaccciones.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (erroracciones) erroracciones.style.display = 'none';
                if (quitacciones) quitacciones.style.display = 'block';
            } else {
                if (erroracciones) erroracciones.style.display = 'block';
                this.value = '';
                if (quitacciones) quitacciones.style.display = 'none';
            }
        });
        quitacciones.addEventListener('click', function() {
            archvioaccciones.value = ''; 
            quitacciones.style.display = 'none'; 
            if (erroracciones) erroracciones.style.display = 'none'; 
        });
    }
});

$("#guardarACCIONES").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioACCIONES_DISCIPLINARIAS');

    if (formularioValido) {

    if (ID_ACCIONES_DISCIPLINARIAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACCIONES')
            await ajaxAwaitFormData({ api: 7,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_ACCIONES_DISCIPLINARIAS: ID_ACCIONES_DISCIPLINARIAS }, 'contratoSave', 'formularioACCIONES_DISCIPLINARIAS', 'guardarACCIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ACCIONES_DISCIPLINARIAS = data.soporte.ID_ACCIONES_DISCIPLINARIAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_ACCIONES_DISCIPLINARIAS').modal('hide')
                    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();

                    
                    // if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                    //     Tablainformacionmedica.ajax.reload(null, false); 
                    // }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACCIONES')
            await ajaxAwaitFormData({ api: 7,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_ACCIONES_DISCIPLINARIAS: ID_ACCIONES_DISCIPLINARIAS }, 'contratoSave', 'formularioACCIONES_DISCIPLINARIAS', 'guardarACCIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ACCIONES_DISCIPLINARIAS = data.soporte.ID_ACCIONES_DISCIPLINARIAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_ACCIONES_DISCIPLINARIAS').modal('hide')
                    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();


                    
                    // if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                    //     Tablainformacionmedica.ajax.reload(null, false); 
                    // }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalacciones = document.getElementById('miModal_ACCIONES_DISCIPLINARIAS')
Modalacciones.addEventListener('hidden.bs.modal', event => {

    ID_ACCIONES_DISCIPLINARIAS = 0

    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();
   
    $('#miModal_ACCIONES_DISCIPLINARIAS .modal-title').html('Acciones disciplinarias');

    document.getElementById('quitar_acciones_disciplinarias').style.display = 'none';

    document.getElementById('ACCIONES_DISCIPLINARIAS_ERROR').style.display = 'none';

})

function cargarTablaAccionesDisciplinarias() {
    if ($.fn.DataTable.isDataTable('#Tablaccionesdisciplinarias')) {
        Tablaccionesdisciplinarias.clear().destroy();
    }

    Tablaccionesdisciplinarias = $("#Tablaccionesdisciplinarias").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaccionesdisciplinarias',  
            beforeSend: function () {
                $('#loadingIcon5').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon5').css('display', 'none');
                Tablaccionesdisciplinarias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon5').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_ACCIONES', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablaccionesdisciplinarias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaccionesdisciplinarias.row(tr);

    ID_ACCIONES_DISCIPLINARIAS = row.data().ID_ACCIONES_DISCIPLINARIAS;

    editarDatoTabla(row.data(), 'formularioACCIONES_DISCIPLINARIAS', 'miModal_ACCIONES_DISCIPLINARIAS', 1);

    $('#miModal_ACCIONES_DISCIPLINARIAS .modal-title').html(row.data().NOMBRE_DOCUMENTO_ACCIONES);


});

$('#Tablaccionesdisciplinarias').on('click', '.ver-archivo-acciones', function () {
    var tr = $(this).closest('tr');
    var row = Tablaccionesdisciplinarias.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_ACCIONES;
    var url = '/mostraracciones/' + id;
    
    abrirModal(url, nombreDocumento);
});


// <!-- ============================================================== -->
// <!--RECIBOS DE NOMINA-->
// <!-- ============================================================== -->

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

$("#guardarRECIBONOMINA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioRECIBO');

    if (formularioValido) {

    if (ID_RECIBOS_NOMINA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRECIBONOMINA')
            await ajaxAwaitFormData({ api: 8,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_RECIBOS_NOMINA: ID_RECIBOS_NOMINA }, 'contratoSave', 'formularioRECIBO', 'guardarRECIBONOMINA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_RECIBOS_NOMINA = data.soporte.ID_RECIBOS_NOMINA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RECIBOS_NOMINA').modal('hide')
                    document.getElementById('formularioRECIBO').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
                        Tablarecibonomina.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRECIBONOMINA')
            await ajaxAwaitFormData({ api: 8,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_RECIBOS_NOMINA: ID_RECIBOS_NOMINA }, 'contratoSave', 'formularioRECIBO', 'guardarRECIBONOMINA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_RECIBOS_NOMINA = data.soporte.ID_RECIBOS_NOMINA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RECIBOS_NOMINA').modal('hide')
                    document.getElementById('formularioRECIBO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
                        Tablarecibonomina.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalrecibonomina = document.getElementById('miModal_RECIBOS_NOMINA')
Modalrecibonomina.addEventListener('hidden.bs.modal', event => {
    
    ID_RECIBOS_NOMINA = 0
    document.getElementById('formularioRECIBO').reset();
   
    $('#miModal_RECIBOS_NOMINA .modal-title').html('Recibo de nómina');

    document.getElementById('quitar_recibo').style.display = 'none';

    document.getElementById('RECIBO_ERROR').style.display = 'none';

})

function cargarTablaRecibosNomina() {
    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
        Tablarecibonomina.clear().destroy();
    }

    Tablarecibonomina = $("#Tablarecibonomina").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablarecibonomina',  
            beforeSend: function () {
                $('#loadingIcon6').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon6').css('display', 'none');
                Tablarecibonomina.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_RECIBO', className: 'text-center' },
            { 
                data: 'FECHA_RECIBO', 
                className: 'text-center',
                render: function(data) { return data ? data : 'N/A'; }
            }, 
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Fecha del recibo', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablarecibonomina').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarecibonomina.row(tr);

    ID_RECIBOS_NOMINA = row.data().ID_RECIBOS_NOMINA;

    editarDatoTabla(row.data(), 'formularioRECIBO', 'miModal_RECIBOS_NOMINA', 1);

    $('#miModal_RECIBOS_NOMINA .modal-title').html(row.data().NOMBRE_RECIBO);


});

$('#Tablarecibonomina').on('click', '.ver-archivo-recibonomina', function () {
    var tr = $(this).closest('tr');
    var row = Tablarecibonomina.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_RECIBO;
    var url = '/mostrarecibosnomina/' + id;
    
    abrirModal(url, nombreDocumento);
});





// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 4                                                              -->
// <!-- ============================================================================================================================ -->

document.getElementById('step4').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step4-content').style.display = 'block';
});
