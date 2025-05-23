//VARIABLES GLOBALES
    var rfcSeleccionada; 




// ID DE LOS FORMULARIOS



// ID_FORMULARIO_ALTA = 0;

window.ID_FORMULARIO_ALTA = 0;



ID_FORMULARIO_CUENTAPROVEEDOR = 0
ID_FORMULARIO_CONTACTOPROVEEDOR = 0
ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0
ID_FORMULARIO_REFERENCIASPROVEEDOR = 0
ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0


// TABLAS
Tablalistaproveedores = null



var Tablacuentas;
var tablacuentasCargada = false; 


var Tablacontactos;
var tablacontactosCargada = false; 


var Tablacertificaciones;
var tablacertificacionesCargada = false; 


var Tablareferencias;
var tablareferenciasCargada = false; 


var Tabladocumentosoporteproveedores;
var tablasoportesCargada = false; 










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
        
        if (tablacontratosCargada) {
            Tablacontratosyanexos.columns.adjust().draw();
        } else {
            cargarTablaContratosyanexos();
            tablacontratosCargada = true;
        }

        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });

});






var Tablalistaproveedores = $("#Tablalistaproveedores").DataTable({
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
        url: '/Tablalistaproveedores',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablalistaproveedores.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
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
        { data: 'RFC_ALTA' },
        { data: 'RAZON_SOCIAL_ALTA' },
        { data: 'BTN_EDITAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'RFC/Tax ID ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón social/Nombre  ', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Mostrar', className: 'all text-center' }
    ]
});



$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); 
    if (target === '#contratos') {
        Tablalistaproveedores.columns.adjust().draw(); 
    }
    
});

function reloadTablalistaproveedores() {
    Tablalistaproveedores.ajax.reload(null, false); 
}








// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 1                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step1').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step1-content').style.display = 'block';
});



$("#guardarALTA").click(function (e) {
    e.preventDefault();


    

    formularioValido = validarFormularioV1('formularioALTA');

    if (formularioValido) {
       

        if (ID_FORMULARIO_ALTA == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarALTA');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave1', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    rfcSeleccionada = data.funcion.RFC_ALTA;
                    ID_FORMULARIO_ALTA = data.funcion.ID_FORMULARIO_ALTA;
        
                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    Tablalistaproveedores.ajax.reload();
                });
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarALTA');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave1', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_ALTA = data.funcion.ID_FORMULARIO_ALTA;



                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        Tablalistaproveedores.ajax.reload();
                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});






document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA_ALTA");
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");
    const labelRFC = document.querySelector('label[for="RFC_LABEL"]'); 


    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";
            labelRFC.textContent = "R.F.C *";

        } else if (this.value === "2") {
            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";
            labelRFC.textContent = "Tax ID *";

        }
    });
});


$('#Tablalistaproveedores tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistaproveedores.row(tr);


    
    ID_FORMULARIO_ALTA = row.data().ID_FORMULARIO_ALTA;

    $('#formularioALTA').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4,#step5,#step6,#step7').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content,#step5-content,#step6-content,#step7-content').css("display", 'none');



    var rfc = row.data().RFC_ALTA;
    $("#RFC_ALTA").val(rfc);
    rfcSeleccionada = rfc;

    $("#ID_FORMULARIO_ALTA").val(row.data().ID_FORMULARIO_ALTA);


    
    $("#TIPO_PERSONA_OPCION").val(row.data().TIPO_PERSONA_OPCION);

    $("#TIPO_PERSONA_ALTA").val(row.data().TIPO_PERSONA_ALTA);
    $("#RAZON_SOCIAL_ALTA").val(row.data().RAZON_SOCIAL_ALTA);
    $("#RFC_ALTA").val(row.data().RFC_ALTA);
    $("#REPRESENTANTE_LEGAL_ALTA").val(row.data().REPRESENTANTE_LEGAL_ALTA || '');
    $("#REGIMEN_ALTA").val(row.data().REGIMEN_ALTA || '');
    $("#CORREO_DIRECTORIO").val(row.data().CORREO_DIRECTORIO || '');
    $("#TELEFONO_OFICINA_ALTA").val(row.data().TELEFONO_OFICINA_ALTA || '');
    $("#PAGINA_WEB_ALTA").val(row.data().PAGINA_WEB_ALTA || '');
    $("#CUAL_ACTVIDAD_ECONOMICA").val(row.data().CUAL_ACTVIDAD_ECONOMICA || '');
    $("#CUAL_DESCUENTOS_ECONOMICA").val(row.data().CUAL_DESCUENTOS_ECONOMICA || '');
    $("#DIAS_CREDITO_ALTA").val(row.data().DIAS_CREDITO_ALTA || '');
    $("#TERMINOS_IMPORTANCIAS_ALTA").val(row.data().TERMINOS_IMPORTANCIAS_ALTA || '');
    $("#DESCRIPCION_VINCULO").val(row.data().DESCRIPCION_VINCULO || '');
    $("#NUMERO_PROVEEDOR").val(row.data().NUMERO_PROVEEDOR || '');
    $("#ACTVIDAD_COMERCIAL").val(row.data().ACTVIDAD_COMERCIAL || '');
    
    $("#CODIGO_POSTAL").val(row.data().CODIGO_POSTAL);
    $("#TIPO_VIALIDAD_EMPRESA").val(row.data().TIPO_VIALIDAD_EMPRESA);
    $("#NOMBRE_VIALIDAD_EMPRESA").val(row.data().NOMBRE_VIALIDAD_EMPRESA);
    $("#NUMERO_EXTERIOR_EMPRESA").val(row.data().NUMERO_EXTERIOR_EMPRESA);
    $("#NUMERO_INTERIOR_EMPRESA").val(row.data().NUMERO_INTERIOR_EMPRESA);
    $("#NOMBRE_COLONIA_EMPRESA").val(row.data().NOMBRE_COLONIA_EMPRESA);
    $("#NOMBRE_LOCALIDAD_EMPRESA").val(row.data().NOMBRE_LOCALIDAD_EMPRESA);
    $("#NOMBRE_MUNICIPIO_EMPRESA").val(row.data().NOMBRE_MUNICIPIO_EMPRESA);
    $("#NOMBRE_ENTIDAD_EMPRESA").val(row.data().NOMBRE_ENTIDAD_EMPRESA);
    $("#PAIS_EMPRESA").val(row.data().PAIS_EMPRESA);
    $("#ENTRE_CALLE_EMPRESA").val(row.data().ENTRE_CALLE_EMPRESA);
    $("#ENTRE_CALLE2_EMPRESA").val(row.data().ENTRE_CALLE2_EMPRESA);
    
    $("#DOMICILIO_EXTRANJERO").val(row.data().DOMICILIO_EXTRANJERO);
    $("#CODIGO_EXTRANJERO").val(row.data().CODIGO_EXTRANJERO);
    $("#CIUDAD_EXTRANJERO").val(row.data().CIUDAD_EXTRANJERO);
    $("#ESTADO_EXTRANJERO").val(row.data().ESTADO_EXTRANJERO);
    $("#PAIS_EXTRANJERO").val(row.data().PAIS_EXTRANJERO);
    $("#DEPARTAMENTO_EXTRANJERO").val(row.data().DEPARTAMENTO_EXTRANJERO);
    
   
let actividad = $(`input[name="ACTIVIDAD_ECONOMICA"][value="${row.data().ACTIVIDAD_ECONOMICA}"]`);
if (actividad.length) actividad.prop('checked', true);

let descuento = $(`input[name="DESCUENTOS_ACTIVIDAD_ECONOMICA"][value="${row.data().DESCUENTOS_ACTIVIDAD_ECONOMICA}"]`);
if (descuento.length) {
    descuento.prop('checked', true);
    if (row.data().DESCUENTOS_ACTIVIDAD_ECONOMICA == "4") {
        $("#CUAL_DESCUENTOS").show();
    }
}

let vinculo = $(`input[name="VINCULO_FAMILIAR"][value="${row.data().VINCULO_FAMILIAR}"]`);
if (vinculo.length) {
    vinculo.prop('checked', true);
    if (row.data().VINCULO_FAMILIAR?.toUpperCase() === "SI") {
        $("#DIV_VINCULOS").show();
    }
}

let servicios = $(`input[name="SERVICIOS_PEMEX"][value="${row.data().SERVICIOS_PEMEX}"]`);
if (servicios.length) {
    servicios.prop('checked', true);
    if (row.data().SERVICIOS_PEMEX?.toUpperCase() === "SI") {
        $("#DIV_NUMEROPROVEEDOR").show();
    }
    }
    
    
let beneficios = $(`input[name="BENEFICIOS_PERSONA"][value="${row.data().BENEFICIOS_PERSONA}"]`);
if (beneficios.length) {
    beneficios.prop('checked', true);
    if (row.data().BENEFICIOS_PERSONA?.toUpperCase() === "SI") {
        $("#PERSONA_EXPUESTA").show();
    }
}
    

    $("#NOMBRE_PERSONA").val(row.data().NOMBRE_PERSONA);




let coloniaGuardada = row.data().NOMBRE_COLONIA_EMPRESA || '';
let codigoPostalInput = document.getElementById("CODIGO_POSTAL");

codigoPostalInput.value = row.data().CODIGO_POSTAL || '';
codigoPostalInput.dispatchEvent(new Event('change'));

let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
let observer = new MutationObserver(() => {
    if (coloniaSelect.options.length > 1) {
        coloniaSelect.value = coloniaGuardada;
        observer.disconnect();
    }
});
observer.observe(coloniaSelect, { childList: true });



if (row.data().TIPO_PERSONA_ALTA == "1") {
    $('label[for="RFC_LABEL"]').text("R.F.C");
    $("#DOMICILIO_NACIONAL").show();
    $("#DOMICILIO_ERXTRANJERO").hide();
} else if (row.data().TIPO_PERSONA_ALTA == "2") {
    $('label[for="RFC_LABEL"]').text("Tax ID");
    $("#DOMICILIO_NACIONAL").hide();
    $("#DOMICILIO_ERXTRANJERO").show();
}

    actualizarStepsConCurp(rfc);

    tablacuentasCargada = false;
    tablacontactosCargada = false;
    tablacertificacionesCargada = false;
    tablareferenciasCargada = false;
    tablasoportesCargada = false;

    $('#datosgenerales-tab').tab('show');



    $(".div_trabajador_nombre").html(row.data().RFC_ALTA);



    $("#step1").click();
});



function actualizarStepsConCurp(rfc) {
    $("#RFC_ALTA").val(rfc);
    rfcSeleccionada = rfc;
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

    if (tablacuentasCargada) {
        Tablacuentas.columns.adjust().draw();
    } else {
        cargarTablacuentas();
        tablacuentasCargada = true;
    }


});


const Modalcuenta = document.getElementById('miModal_cuentas');

Modalcuenta.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_CUENTAPROVEEDOR = 0;
    document.getElementById('formularioCuentas').reset();

    $('#DIV_EXTRAJERO').hide();
    $('#CLABE_INTERBANCARIA').show();

    document.getElementById('CARATULA_BANCARIA').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
});


$("#guardarCuentas").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCuentas'))

    if (formularioValido) {

    if (ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltacuentaSave', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    
                    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
                        Tablacuentas.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltacuentaSave', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
                        Tablacuentas.ajax.reload(null, false); 
                    }


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





function cargarTablacuentas() {
    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
        Tablacuentas.clear().destroy();
    }

    Tablacuentas = $("#Tablacuentas").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacuentas',  
            beforeSend: function () {
                $('#loadingIcon2').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon2').css('display', 'none');
                Tablacuentas.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon2').css('display', 'none');
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
            { data: 'TIPO_CUENTA' },
            { data: 'NOMBRE_BENEFICIARIO' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_DOCUMENTO' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Tipo de cuenta', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Nombre del beneficiario', className: 'all text-center nombre-column' },
            { targets: 3, title: 'Editar', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
            { targets: 5, title: 'Carátula bancaria', className: 'all text-center' },
            { targets: 6, title: 'Activo', className: 'all text-center' }
        ]
    });
}


$('#Tablacuentas').on('click', '.ver-archivo-caratula', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarcaratula/' + id;
    abrirModal(url, 'Carátula bancaria');
});



$('#Tablacuentas    ').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentas.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CUENTAPROVEEDOR: row.data().ID_FORMULARIO_CUENTAPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacuentas], 'CuentasDelete');
});



$('#Tablacuentas').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentas.row(tr);
    ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
    

     if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
    } else {
        $('#DIV_EXTRAJERO').hide();
        $('#CLABE_INTERBANCARIA').show();
    }
});


$(document).ready(function() {
    $('#Tablacuentas').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacuentas.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_cuentas');

        ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
        
          if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
        } else {
            $('#DIV_EXTRAJERO').hide();
            $('#CLABE_INTERBANCARIA').show();
        }
    });


    $('#miModal_cuentas').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_cuentas');
    });
});



// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 3                                                              -->
// // <!-- ============================================================================================================================ -->



document.getElementById('step3').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step3-content').style.display = 'block';

    if (tablacontactosCargada) {
        Tablacontactos.columns.adjust().draw();
    } else {
        cargarTablacontactos();
        tablacontactosCargada = true;
    }
  
});


$(document).ready(function () {
    var selectizeInstance = $('#FUNCIONES_CUENTA').selectize({
        placeholder: 'Seleccione una opción',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVO_CONTACTO").click(function (e) {
        e.preventDefault();

        $("#miModal_contactos").modal("show");

        document.getElementById('formularioCONTACTOS').reset();

        var selectize = selectizeInstance[0].selectize;
        selectize.clear();
        selectize.setValue(""); 


      
    });
});


const Modalcontacto = document.getElementById('miModal_contactos')
Modalcontacto.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONTACTOPROVEEDOR = 0
    document.getElementById('formularioCONTACTOS').reset();
      var selectize = $('#FUNCIONES_CUENTA')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");

})


$("#guardarCONTACTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCONTACTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltacontactoSave', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();

                    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
                        Tablacontactos.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltacontactoSave', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();

                    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
                        Tablacontactos.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




function cargarTablacontactos() {
    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
        Tablacontactos.clear().destroy();
    }

    Tablacontactos = $("#Tablacontactos").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacontactos',  
            beforeSend: function () {
                $('#loadingIcon3').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon3').css('display', 'none');
                Tablacontactos.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon3').css('display', 'none');
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
                data: null,
                render: function (data, type, row) {
                    return row.TITULO_CUENTA ? `${row.TITULO_CUENTA}. ${row.NOMBRE_CONTACTO_CUENTA}` : row.NOMBRE_CONTACTO_CUENTA;
                }
            },
            { data: 'CARGO_CONTACTO_CUENTA' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Cargo', className: 'all text-center nombre-column' },
            { targets: 3, title: 'Editar', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
            { targets: 5, title: 'Activo', className: 'all text-center' }
        ]
    });
}






$('#Tablacontactos').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactos.row(tr);
    ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
    

     var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }


});





$(document).ready(function() {
    $('#Tablacontactos').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacontactos.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_contactos');

        ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
        
       
  var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }
        

    });


    $('#miModal_contactos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_contactos');
    });
});






$('#Tablacontactos').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONTACTOPROVEEDOR: row.data().ID_FORMULARIO_CONTACTOPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacontactos], 'ContactoDelete');
});





// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 4                                                              -->
// // <!-- ============================================================================================================================ -->

document.getElementById('step4').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step4-content').style.display = 'block';

    if (tablacertificacionesCargada) {
        Tablacertificaciones.columns.adjust().draw();
    } else {
        cargarTablacertificaciones();
        tablacertificacionesCargada = true;
    }


});



const Modalcertificacion = document.getElementById('miModal_certificaciones');

Modalcertificacion.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0;

    document.getElementById('formularioCertificaciones').reset();

    $('#DIV_CERTIFICACION').hide();
    $('#DIV_ACREDITACION').hide();
    $('#DIV_AUTORIZACION').hide();
    $('#DIV_MEMBRESIA').hide();

 
});

$("#guardarCertificaciones").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCertificaciones'))

    if (formularioValido) {

    if (ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltacertificacionSave', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    
                    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
                        Tablacertificaciones.ajax.reload(null, false); 
                    }

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltacertificacionSave', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
                        Tablacertificaciones.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablacertificaciones() {
    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
        Tablacertificaciones.clear().destroy();
    }

    Tablacertificaciones = $("#Tablacertificaciones").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacertificaciones',  
            beforeSend: function () {
                $('#loadingIcon4').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon4').css('display', 'none');
                Tablacertificaciones.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon4').css('display', 'none');
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
            { data: 'TIPO_DOCUMENTO' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_DOCUMENTO' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Tipo ', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Editar', className: 'all text-center' },
            { targets: 3, title: 'Visualizar', className: 'all text-center' },
            { targets: 4, title: 'Documentos', className: 'all text-center' },
            { targets: 5, title: 'Activo', className: 'all text-center' }
        ]
    });
}






$('#Tablacertificaciones').on('click', '.ver-archivo-certificación', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarcertificacion/' + id;
    abrirModal(url, 'Certificación');
});





$('#Tablacertificaciones').on('click', '.ver-archivo-acreditacion', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostraracreditacion/' + id;
    abrirModal(url, 'Acreditación');
});





$('#Tablacertificaciones').on('click', '.ver-archivo-autorizacion', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarautorizacion/' + id;
    abrirModal(url, 'Autorización');
});




$('#Tablacertificaciones').on('click', '.ver-archivo-membresia', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarmembresia/' + id;
    abrirModal(url, 'Membresía');
});




$('#Tablacertificaciones').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CERTIFICACIONPROVEEDOR: row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacertificaciones], 'CertificacionDelete');
});


$('#Tablacertificaciones').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr);

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
    

     if (row.data().TIPO_DOCUMENTO === "Certificación") {
        $('#DIV_CERTIFICACION').show();
         $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
    } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
         $('#DIV_ACREDITACION').show();
         $('#DIV_CERTIFICACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
        
     } else {
         $('#DIV_MEMBRESIA').show();
        $('#DIV_CERTIFICACION').hide();
        $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
          
    }


    if (row.data().REQUISITO_AUTORIZACION === "Si") {
        $('#DIV_AUTORIZACION').show();
    } else {
        $('#DIV_AUTORIZACION').hide();
    }

  
});



$(document).ready(function() {
    $('#Tablacertificaciones').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacertificaciones.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_certificaciones');

        ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
        
        if (row.data().TIPO_DOCUMENTO === "Certificación") {
            $('#DIV_CERTIFICACION').show();
             $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
        } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
             $('#DIV_ACREDITACION').show();
             $('#DIV_CERTIFICACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
            
         } else {
             $('#DIV_MEMBRESIA').show();
            $('#DIV_CERTIFICACION').hide();
            $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
              
        }
    
    
        if (row.data().REQUISITO_AUTORIZACION === "Si") {
            $('#DIV_AUTORIZACION').show();
        } else {
            $('#DIV_AUTORIZACION').hide();
        }
    
    });


    $('#miModal_certificaciones').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_certificaciones');
    });
});





// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 5                                                              -->
// // <!-- ============================================================================================================================ -->

document.getElementById('step5').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step5-content').style.display = 'block';

    
 if (tablareferenciasCargada) {
        Tablareferencias.columns.adjust().draw();
    } else {
        cargarTablareferencias();
        tablareferenciasCargada = true;
    }
});



const Modalreferencia = document.getElementById('miModal_referencia')
Modalreferencia.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_REFERENCIASPROVEEDOR = 0
    document.getElementById('formularioReferencias').reset();
    
})

$("#guardarREFERENCIAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioReferencias'))

    if (formularioValido) {

    if (ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltareferenciaSave', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();

                    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
                        Tablareferencias.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltareferenciaSave', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();


                    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
                        Tablareferencias.ajax.reload(null, false); 
                    }



                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



function cargarTablareferencias() {
    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
        Tablareferencias.clear().destroy();
    }

    Tablareferencias = $("#Tablareferencias").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablareferencias',  
            beforeSend: function () {
                $('#loadingIcon5').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon5').css('display', 'none');
                Tablareferencias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon5').css('display', 'none');
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
                { data: 'NOMBRE_EMPRESA' },
                { data: 'NOMBRE_CONTACTO' },
                { data: 'CARGO_REFERENCIA' },
                { data: 'BTN_EDITAR' },
                { data: 'BTN_VISUALIZAR' },
                { data: 'BTN_ELIMINAR' }
            ],
            columnDefs: [
                { targets: 0, title: '#', className: 'all  text-center' },
                { targets: 1, title: 'Nombre de la empresa', className: 'all text-center nombre-column' },
                { targets: 2, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
                { targets: 3, title: 'Cargo', className: 'all text-center nombre-column' },
                { targets: 4, title: 'Editar', className: 'all text-center' },
                { targets: 5, title: 'Visualizar', className: 'all text-center' },
                { targets: 6, title: 'Activo', className: 'all text-center' }
            ]
    });
}






$('#Tablareferencias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferencias.row(tr);
    ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
    

   


});





$(document).ready(function() {
    $('#Tablareferencias').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablareferencias.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_referencia');

        ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
        
    });

    $('#miModal_referencia').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_referencia');
    });
});






$('#Tablareferencias').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferencias.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_REFERENCIASPROVEEDOR: row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablareferencias], 'ReferenciasDelete');
});




// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 6                                                              -->
// // <!-- ============================================================================================================================ -->


document.getElementById('step6').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step6-content').style.display = 'block';

    if (tablasoportesCargada) {
        Tabladocumentosoporteproveedores.columns.adjust().draw();
    } else {
        cargarTablasoportes();
        tablasoportesCargada = true;
    }
  
});





const Modaldocumentos = document.getElementById('miModal_documentos');

Modaldocumentos.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0;

    document.getElementById('formularioDOCUMENTOS').reset();

  

    document.getElementById('DOCUMENTO_SOPORTE').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
 
});



$("#guardarDOCUMENTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaDocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
                        Tabladocumentosoporteproveedores.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaDocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
                        Tabladocumentosoporteproveedores.ajax.reload(null, false); 
                    }
        

                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


    
function cargarTablasoportes() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
        Tabladocumentosoporteproveedores.clear().destroy();
    }

    Tabladocumentosoporteproveedores = $("#Tabladocumentosoporteproveedores").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentosoporteproveedores',  
            beforeSend: function () {
                $('#loadingIcon6').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon6').css('display', 'none');
                Tabladocumentosoporteproveedores.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon6').css('display', 'none');
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
        { data: 'NOMBRE_DOCUMENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del documento ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Documentos', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
    });
}


$('#Tabladocumentosoporteproveedores').on('click', '.ver-archivo-documentosoporte', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporteproveedores.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentosoporteproveedor/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});






$('#Tabladocumentosoporteproveedores').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporteproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_DOCUMENTOSPROVEEDOR: row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR
    };

    eliminarDatoTabla(data, [Tabladocumentosoporteproveedores], 'DocumentosDelete');
});


$('#Tabladocumentosoporteproveedores').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporteproveedores.row(tr);

    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos', 1);
    

    
    $('#TIPO_DOCUMENTO').prop('disabled',true ); 
    $('#NOMBRE_DOCUMENTO').prop('disabled', true); 


    $('#miModal_documentos .modal-title').html(row.data().NOMBRE_DOCUMENTO);

  
});





$(document).ready(function() {
    $('#Tabladocumentosoporteproveedores').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladocumentosoporteproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_documentos');

        ID_FORMULARIO_DOCUMENTOSPROVEEDOR = row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos', 1);
        
       
    
    });


    $('#miModal_documentos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_documentos');
    });
});








const inputArchivo = document.getElementById('DOCUMENTO_SOPORTE');
const iconEliminar = document.getElementById('iconEliminarArchivo');

inputArchivo.addEventListener('change', function () {
    if (this.files.length > 0) {
        iconEliminar.classList.remove('d-none');
    } else {
        iconEliminar.classList.add('d-none');
    }
});

iconEliminar.addEventListener('click', function () {
    inputArchivo.value = '';
    iconEliminar.classList.add('d-none');
});