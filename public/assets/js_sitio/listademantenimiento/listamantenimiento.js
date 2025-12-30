ID_FORMULARIO_INVENTARIO = 0
ID_ENTRADA_FORMULARIO = 0
ID_DOCUMENTO_ARTICULO = 0


var inventario_id = null; 


const Modalinventario = document.getElementById('Modal_inventario')
Modalinventario.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INVENTARIO = 0
    document.getElementById('formularioINVENTARIO').reset();
   
    $('#CANTIDAD_EQUIPO').prop('readonly', false);
    $('#LIMITEMINIMO_EQUIPO').prop('readonly', false);

    $('#Modal_inventario .modal-title').html('Equipo');

})


$("#guardarINVENTARIO").click(function (e) {
    e.preventDefault();


            formularioValido = validarFormulario3($('#formularioINVENTARIO'))

    if (formularioValido) {

    if (ID_FORMULARIO_INVENTARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_INVENTARIO = data.inventario.ID_FORMULARIO_INVENTARIO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#Modal_inventario').modal('hide')
                    document.getElementById('formularioINVENTARIO').reset();
                    Tablamantenimiento.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_INVENTARIO = data.inventario.ID_FORMULARIO_INVENTARIO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#Modal_inventario').modal('hide')
                    document.getElementById('formularioINVENTARIO').reset();
                    Tablamantenimiento.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablamantenimiento = $("#Tablamantenimiento").DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    scrollX: true,
    autoWidth: false,
    responsive: false,
    paging: true,
    searching: true,
    info: false,
    lengthChange: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        method: 'GET',
        url: '/Tablamantenimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamantenimiento.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', className: 'text-center' }, 
        { targets: 0,  width:  '50px' },
        { targets: 1,  width:  '120px'  },
        { targets: 2,  width:  '250px' },
        { targets: 3,  width:  '120px'},
        { targets: 4,  width:  '120px'},
        { targets: 5,  width:  '120px'},
        { targets: 6,  width:  '120px'},
        { targets: 7,  width:  '250px'},
        { targets: 8,  width:  '120px'},
        { targets: 9,  width:  '70px' },
        { targets: 10, width:  '70px' },
        { targets: 11, width:  '70px' }                                 
    ],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
         { 
            data: 'FOTO_EQUIPO_HTML',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        { data: 'DESCRIPCION_EQUIPO' },
        //  { data: 'CANTIDAD_EQUIPO' },
        {
            data: null,
            render: function (data) {
                let cantidad = data.CANTIDAD_EQUIPO || '';
                let unidad = data.UNIDAD_MEDIDA || '';
                return `${cantidad} (${unidad})`;
            }
        },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'UBICACION_EQUIPO' },
        { data: 'CODIGO_EQUIPO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
        
       
  ],
     createdRow: function (row, data) {
        $(row).addClass(data.ROW_CLASS);
    },

drawCallback: function () {
    const topScroll = document.querySelector('.tabla-scroll-top');
    const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
    const table = document.querySelector('#Tablamantenimiento');
    const scrollBody = document.querySelector('.dataTables_scrollBody');

    if (!topScroll || !scrollInner || !table || !scrollBody) return;

    const tableWidth = table.scrollWidth;

    scrollInner.style.width = tableWidth + 'px';

    let syncingTop = false;
    let syncingBottom = false;

    topScroll.addEventListener('scroll', function () {
        if (syncingTop) return;
        syncingBottom = true;
        scrollBody.scrollLeft = topScroll.scrollLeft;
        syncingBottom = false;
    });

    scrollBody.addEventListener('scroll', function () {
        if (syncingBottom) return;
        syncingTop = true;
        topScroll.scrollLeft = scrollBody.scrollLeft;
        syncingTop = false;
    });
}


});



document.getElementById('TIPO_EQUIPO').addEventListener('change', function () {
    const tipo = this.value;
    const divVehiculos = document.getElementById('DATOS_VEHICULOS');

    if (tipo === 'Vehículos') {
        divVehiculos.style.display = 'block';
    } else {
        divVehiculos.style.display = 'none';
    }
});



$('#Tablamantenimiento tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamantenimiento.row(tr);
    ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



    inventario_id = row.data().ID_FORMULARIO_INVENTARIO;

    $("#tab1-info").click();

   $("#tab3-documentos").off("click").on("click", function () {
       cargarTablaDocumentosEquipo();
       
    });
    
    cargarDocumentos(inventario_id);
    

    editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);


    if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoEquipoMan/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

        if ($('#FOTO_EQUIPO').data('dropify')) {
            $('#FOTO_EQUIPO').dropify().data('dropify').destroy();
            $('#FOTO_EQUIPO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_EQUIPO').dropify().data('dropify').init();
        } else {
            $('#FOTO_EQUIPO').attr('data-default-file', imagenUrl);
            $('#FOTO_EQUIPO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_EQUIPO').dropify().data('dropify').resetPreview();
        $('#FOTO_EQUIPO').dropify().data('dropify').clearElement();
    }

    $('#Modal_inventario .modal-title').html(row.data().DESCRIPCION_EQUIPO);

   
    const cantidad = document.getElementById("CANTIDAD_EQUIPO");
    const unitario = document.getElementById("UNITARIO_EQUIPO");
    const total = document.getElementById("TOTAL_EQUIPO");

    function calcularTotal() {
        let cant = parseFloat(cantidad.value) || 0;
        let precio = parseFloat(unitario.value) || 0;

        if (cant === 0 || precio === 0) {
            total.value = "0.00";
        } else {
            total.value = (cant * precio).toFixed(2);
        }
    }

    cantidad.removeEventListener("input", calcularTotal); 
    unitario.removeEventListener("input", calcularTotal);
    cantidad.addEventListener("input", calcularTotal);
    unitario.addEventListener("input", calcularTotal);

    calcularTotal();



       let fechaAdquisicion = row.data().FECHA_ADQUISICION || "";
    if (fechaAdquisicion === "2024-12-31") {
        $("#ANTES_2024").show();
        $("#DESPUES_2024").hide();

        $("#PROVEEDOR_ANTESDEL2024").val(row.data().PROVEEDOR_EQUIPO || "");
    } else {
        $("#ANTES_2024").hide();
        $("#DESPUES_2024").show();
        $("#PROVEEDOR_EQUIPO").val(row.data().PROVEEDOR_EQUIPO || "");
    }

       
    if (row.data().TIPO_EQUIPO === 'Vehículos') {
        $('#DATOS_VEHICULOS').show();
    } else {
        $('#DATOS_VEHICULOS').hide();
    }

    
   


    $.get('/cantidadEquipoReadonlyMan', function (resp) {

    if (resp.readonly === true) {
        $('#CANTIDAD_EQUIPO').attr('readonly', true);
        $('#LIMITEMINIMO_EQUIPO').attr('readonly', true);

    } else {
        $('#CANTIDAD_EQUIPO').removeAttr('readonly');
        $('#LIMITEMINIMO_EQUIPO').removeAttr('readonly');

    }

});


});

$(document).ready(function() {
    $('#Tablamantenimiento tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamantenimiento.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#Modal_inventario');

        ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;

        inventario_id = row.data().ID_FORMULARIO_INVENTARIO;
    
        $("#tab1-info").click();
    
         $("#tab3-documentos").off("click").on("click", function () {
            cargarTablaDocumentosEquipo();
            cargarDocumentos(inventario_id);

        });


        editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);
        

        if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoEquipoMan/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

        if ($('#FOTO_EQUIPO').data('dropify')) {
            $('#FOTO_EQUIPO').dropify().data('dropify').destroy();
            $('#FOTO_EQUIPO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_EQUIPO').dropify().data('dropify').init();
        } else {
            $('#FOTO_EQUIPO').attr('data-default-file', imagenUrl);
            $('#FOTO_EQUIPO').dropify({
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
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_EQUIPO').dropify().data('dropify').resetPreview();
        $('#FOTO_EQUIPO').dropify().data('dropify').clearElement();
        }
        
        $('#Modal_inventario .modal-title').html(row.data().DESCRIPCION_EQUIPO);
        
        
                
        const cantidad = document.getElementById("CANTIDAD_EQUIPO");
        const unitario = document.getElementById("UNITARIO_EQUIPO");
        const total = document.getElementById("TOTAL_EQUIPO");

        function calcularTotal() {
            let cant = parseFloat(cantidad.value) || 0;
            let precio = parseFloat(unitario.value) || 0;

            if (cant === 0 || precio === 0) {
                total.value = "0.00";
            } else {
                total.value = (cant * precio).toFixed(2);
            }
        }

        cantidad.removeEventListener("input", calcularTotal); 
        unitario.removeEventListener("input", calcularTotal);
        cantidad.addEventListener("input", calcularTotal);
        unitario.addEventListener("input", calcularTotal);

        calcularTotal();
                   
        
       let fechaAdquisicion = row.data().FECHA_ADQUISICION || "";
        if (fechaAdquisicion === "2024-12-31") {
            $("#ANTES_2024").show();
            $("#DESPUES_2024").hide();

            $("#PROVEEDOR_ANTESDEL2024").val(row.data().PROVEEDOR_EQUIPO || "");
        } else {
            $("#ANTES_2024").hide();
            $("#DESPUES_2024").show();

            $("#PROVEEDOR_EQUIPO").val(row.data().PROVEEDOR_EQUIPO || "");
        }

        
        

    if (row.data().TIPO_EQUIPO === 'Vehículos') {
        $('#DATOS_VEHICULOS').show();
    } else {
        $('#DATOS_VEHICULOS').hide();
    }

    });

    $('#Modal_inventario').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_inventario');
    });
});

$('#Tablamantenimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamantenimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_INVENTARIO: row.data().ID_FORMULARIO_INVENTARIO
    };

    eliminarDatoTabla(data, [Tablamantenimiento], 'MantenimientoDelete');
});

document.addEventListener("DOMContentLoaded", function () {
    const cantidad = document.getElementById("CANTIDAD_EQUIPO");
    const unitario = document.getElementById("UNITARIO_EQUIPO");
    const total = document.getElementById("TOTAL_EQUIPO");

    function calcularTotal() {
        let cant = parseFloat(cantidad.value) || 0;
        let precio = parseFloat(unitario.value) || 0;
        let resultado = cant * precio;

        total.value = resultado.toFixed(2); 
    }

    cantidad.addEventListener("input", calcularTotal);
    unitario.addEventListener("input", calcularTotal);
});



////////////////////////  ENTRADA INVENTARIO TAB 2 ////////////////////////


document.addEventListener('DOMContentLoaded', function () {
  const guardarBtn = document.getElementById('guardarINVENTARIO');
  const tabs = document.querySelectorAll('#tabsinventario button[data-bs-toggle="tab"]');

  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (event) {
      const target = event.target.getAttribute('data-bs-target');
      if (target === '#contenido-info') {
        guardarBtn.style.display = 'inline-block';
      } else {
        guardarBtn.style.display = 'none';
      }
    });
  });

  const activeTab = document.querySelector('#tabsinventario button.active');
  if (activeTab && activeTab.getAttribute('data-bs-target') !== '#contenido-info') {
    guardarBtn.style.display = 'none';
  }
});

////////////////////////////////// DOCUMENTOS ARTICULO //////////////////////////////////

const Modaldocumento = document.getElementById('miModal_DOCUMENTOS')
Modaldocumento.addEventListener('hidden.bs.modal', event => {
     
    ID_DOCUMENTO_ARTICULO = 0
    document.getElementById('formularioDOCUMENTOS').reset();
    $('#miModal_DOCUMENTOS .modal-title').html('Nuevo documento ');
   
    document.getElementById('FECHA_DOCUMENTO').style.display = 'none';

    const fechaFin = document.getElementById('FECHAF_DOCUMENTO');
    fechaFin.disabled = false;

})

$("#NUEVA_DOCUMENTACION").click(function (e) {
    e.preventDefault();

    $('#formularioDOCUMENTOS').each(function(){
        this.reset();
    });

    $("#miModal_DOCUMENTOS").modal("show");
   

        $('#FECHAF_DOCUMENTO').prop('required', false).removeClass('validar');

});

document.addEventListener('DOMContentLoaded', function () {
    const contratoSi = document.getElementById('fechasi');
    const contratoNo = document.getElementById('fechano');
    const documentoContrato = document.getElementById('FECHA_DOCUMENTO');

    function toggleDocumentoContrato() {
        if (contratoSi.checked) {
            documentoContrato.style.display = 'block';
        } else {
            documentoContrato.style.display = 'none';
        }
    }

    contratoSi.addEventListener('change', toggleDocumentoContrato);
    contratoNo.addEventListener('change', toggleDocumentoContrato);
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".botonEliminarArchivo").forEach(boton => {
        boton.addEventListener("click", function () {
            const inputArchivo = this.previousElementSibling;
            if (inputArchivo && inputArchivo.type === "file") {
                inputArchivo.value = ""; 
            }
        });
    });
});

$(document).ready(function() {
    $('input[name="INDETERMINADO_DOCUMENTO"]').on('change', function() {
        if ($(this).val() === '1') { 
            $('#FECHAF_DOCUMENTO').prop('disabled', true).val('');
            $('#FECHAF_DOCUMENTO').prop('required', false).removeClass('validar error');

        } else {
            $('#FECHAF_DOCUMENTO').prop('disabled', false);
            $('#FECHAF_DOCUMENTO').prop('required', true).addClass('validar error');
        }
    });
});

$("#guardarDOCUMENTACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_DOCUMENTO_ARTICULO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACION')
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id, ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'MantenimientoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_ARTICULO = data.cliente.ID_DOCUMENTO_ARTICULO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOS').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
                        Tabladocumentomantenimiento.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACION')
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id ,ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'MantenimientoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_ARTICULO = data.cliente.ID_DOCUMENTO_ARTICULO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOS').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
                        Tabladocumentomantenimiento.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

function cargarTablaDocumentosEquipo() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
        Tabladocumentomantenimiento.clear().destroy();
    }

    Tabladocumentomantenimiento = $("#Tabladocumentomantenimiento").DataTable({
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
            data: { equipo: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentomantenimiento',  
            beforeSend: function () {
                $('#loadingIcon1').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon1').css('display', 'none');
                Tabladocumentomantenimiento.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon1').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },
            { data: 'FECHAS_DOCUMENTOS' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento:', className: 'all text-center' },  
            { targets: 2, title: 'Fecha documentos:', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tabladocumentomantenimiento').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr);

    ID_DOCUMENTO_ARTICULO = row.data().ID_DOCUMENTO_ARTICULO;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS', 1);

    $('#miModal_DOCUMENTOS .modal-title').html(row.data().NOMBRE_DOCUMENTO);


     if (row.data().REQUIERE_FECHA == 1) {
        $('#FECHA_DOCUMENTO').show();
        $('#fechasi').prop('checked', true);
    } else {
        $('#FECHA_DOCUMENTO').hide();
        $('#fechano').prop('checked', true);
    }


    if (row.data().INDETERMINADO_DOCUMENTO == 1) {
        $('#indeterminadosi').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', true).val('');
        $('#FECHAF_DOCUMENTO').prop('required', false);

    } else if (row.data().INDETERMINADO_DOCUMENTO == 2) {
        $('#indeterminadono').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
        $('#FECHAF_DOCUMENTO').prop('required', true);


    } else {
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
    }



});

$('#Tabladocumentomantenimiento').on('click', '.ver-archivo-documentosequipo', function (e) {
    e.preventDefault(); 
    e.stopPropagation(); 

    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_ARTICULO || row.DOCUMENTO_ARTICULO.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentomantenimiento/' + id;

    window.open(url, '_blank');
});

////////////////////////////////// FECHAS DOCUMENTOS //////////////////////////////////

function cargarDocumentos(inventario_id) {
    $.ajax({
        url: `/obtenerDocumentosPorMantenimiento/${inventario_id}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const tbody = $('#tablaDocumentos tbody');
            tbody.empty();

            if (data.length > 0) {
                $('#MOSTRAR_ALERTA_DOCUMENTOS').show();

                data.forEach(doc => {
                    const fechaInicio = new Date(doc.FECHAI_DOCUMENTO);
                    const fechaFin = new Date(doc.FECHAF_DOCUMENTO);
                    const hoy = new Date();

                    let diasTotales = Math.ceil((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24));
                    let diasRestantes = Math.ceil((fechaFin - hoy) / (1000 * 60 * 60 * 24));

                    if (diasTotales < 0) diasTotales = 0;
                    if (diasRestantes < 0) diasRestantes = 0;

                    const porcentaje = diasTotales > 0 
                        ? ((diasTotales - diasRestantes) / diasTotales) * 100 
                        : 100;

                    let color = 'success'; 
                    if (porcentaje >= 80) color = 'danger'; 
                    else if (porcentaje >= 60) color = 'warning'; 

                    const textoBadge = diasRestantes > 0
                        ? `${diasRestantes} días restantes`
                        : 'Vencido';

                    tbody.append(`
                        <tr>
                            <td class="text-center">${doc.NOMBRE_DOCUMENTO}</td>
                            <td class="text-center">
                                ${doc.FECHAI_DOCUMENTO} - ${doc.FECHAF_DOCUMENTO}<br>
                                <span class="badge bg-${color}">${textoBadge}</span>
                            </td>
                        </tr>
                    `);
                });
            } else {
                $('#MOSTRAR_ALERTA_DOCUMENTOS').hide();
            }
        },
        error: function () {
            console.error('Error al cargar los documentos.');
        }
    });
}

