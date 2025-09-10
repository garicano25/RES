ID_FORMULARIO_INVENTARIO = 0
ID_ENTRADA_FORMULARIO = 0



var inventario_id = null; 



const Modalinventario = document.getElementById('Modal_inventario')
Modalinventario.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INVENTARIO = 0
    document.getElementById('formularioINVENTARIO').reset();
   
    $('#Modal_inventario .modal-title').html('Equipo');


})

$(document).ready(function() {
    $('#NUEVO_EQUIPO').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_EQUIPO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
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

        $('#Modal_inventario').modal('show');


        $("#tab1-info").click();
        $("#tab2-entrada").prop("disabled", true);
  
        

    });

});



function limpiarFormularioUsuario() {
    $('#formularioINVENTARIO')[0].reset(); 

    var drEvent = $('#FOTO_EQUIPO').data('dropify');
    if (drEvent) {
        drEvent.resetPreview();
        drEvent.clearElement();
    }
}




$("#guardarINVENTARIO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioINVENTARIO'))

    if (formularioValido) {

    if (ID_FORMULARIO_INVENTARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'InventarioSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

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
                    Tablainventario.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'InventarioSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablainventario.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablainventario = $("#Tablainventario").DataTable({
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
        url: '/Tablainventario',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablainventario.columns.adjust().draw();
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
            data: 'FOTO_EQUIPO_HTML',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        { data: 'DESCRIPCION_EQUIPO' },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'CODIGO_EQUIPO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Foto', className: 'all text-center',width: '250px' },
        { targets: 2, title: 'Descripción', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Marca', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Modelo', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Serie', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Código de Identificación ', className: 'all text-center nombre-column' },
        { targets: 7, title: 'Editar', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },
        { targets: 9, title: 'Activo', className: 'all text-center' }
    ],
    createdRow: function (row, data) {
        $(row).addClass(data.ROW_CLASS);
    }
});




$(document).ready(function () {

    $('#boton_cargarExcelEquipos').on('click', function (e) {
        e.preventDefault();

        $('#divCargaEquipos').css('display', 'none');
        $('#alertaVerificacion').css('display', 'none');

        $('#formExcelEquipos')[0].reset();

        $('#modal_excel_equipo').modal({
            backdrop: false,
            keyboard: true
        }).modal('show');
    });

    $('#modal_excel_equipo').on('hidden.bs.modal', function () {
        $('#formExcelEquipos')[0].reset();
        $('#divCargaEquipos').css('display', 'none');
        $('#alertaVerificacion').css('display', 'none');
    });

 $("#botonCargarExcelEquipos").click(function (e) {
    e.preventDefault();

    let form = $('#formExcelEquipos')[0];
    let formData = new FormData(form);
    formData.append("api", 2);

    $.ajax({
        url: "/InventarioSave",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            $('#botonCargarExcelEquipos').prop('disabled', true);
            $('#divCargaEquipos').css('display', 'block');
        },
        success: function (dato) {
            $('#botonCargarExcelEquipos').prop('disabled', false);
            $('#divCargaEquipos').css('display', 'none');

            if (dato.code == 200) {
                Tablainventario.ajax.reload();
                $('#modal_excel_equipo').modal('hide');

                swal({
                    title: "Equipos cargados",
                    text: dato.msj,
                    type: "success",
                    showConfirmButton: true
                });
            } else {
                swal({
                    title: "Error",
                    text: dato.msj,
                    type: "error",
                    showConfirmButton: true
                });
            }
        },
        error: function (xhr) {
            $('#botonCargarExcelEquipos').prop('disabled', false);
            $('#divCargaEquipos').css('display', 'none');

            swal({
                title: "Error",
                text: xhr.responseText,
                type: "error"
            });
        }
    });
});


  $('#excelEquipos').change(function() {
        if ($(this).val()) {
            
            $('#alertaVerificacion').css('display', 'block');

        } else {
            $('#alertaVerificacion').css('display', 'none');
            
        }
    });

});





$('#Tablainventario tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablainventario.row(tr);
    ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



    inventario_id = row.data().ID_FORMULARIO_INVENTARIO;

    $("#tab1-info").click();

    $("#tab2-entrada").off("click").on("click", function () {
        cargartablaentradainventario();
    });



    editarDatoTabla(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);


    if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/equipofoto/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

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
});



$(document).ready(function() {
    $('#Tablainventario tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablainventario.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#Modal_inventario');

        ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



          inventario_id = row.data().ID_FORMULARIO_INVENTARIO;
    
        $("#tab1-info").click();
    
        $("#tab2-entrada").off("click").on("click", function () {
            cargartablaentradainventario();
        });


                
        
        
        editarDatoTabla(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);
        


         if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/equipofoto/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

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
                    


    });

    $('#Modal_inventario').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_inventario');
    });
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



///// ENTRADA INVENTARIO TAB 2


function cargartablaentradainventario() {
    if ($.fn.DataTable.isDataTable('#Tablaentradainventario')) {
        Tablaentradainventario.clear().destroy();
    }

    Tablaentradainventario = $("#Tablaentradainventario").DataTable({
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
            data: { inventario: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaentradainventario',  
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tablaentradainventario.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
     { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
    { data: 'FECHA_INGRESO', className: 'text-center' },
    { data: 'CANTIDAD_PRODUCTO', className: 'text-center' },
    { 
        data: 'VALOR_UNITARIO', 
        className: 'text-center',
        render: function(data) {
            if (!data) return '';
            let numero = parseFloat(data);
            return isNaN(numero) ? data : '$ ' + numero.toFixed(2);
        }
    },
    { 
        data: 'COSTO_TOTAL',
        className: 'text-center',
        render: function(data) {
            if (!data) return '';
            let numero = parseFloat(data);
            return isNaN(numero) ? data : '$ ' + numero.toFixed(2);
        }
    },
    { data: 'TIPO', className: 'text-center' }, 
],
columnDefs: [
   { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Fecha', className: 'all text-center' },  
    { targets: 2, title: 'Cantidad', className: 'all text-center' },  
    { targets: 3, title: 'Valor unitario de compras', className: 'all text-center' },  
    { targets: 4, title: 'Total', className: 'all text-center' },
    { targets: 5, title: 'Tipo', className: 'all text-center' },  
],

    });
}






// document.getElementById('btnRespaldarInventario').addEventListener('click', function () {
//     if (confirm("¿Seguro que deseas respaldar toda la información del inventario?")) {
//         fetch('/inventario/respaldar', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                 'Content-Type': 'application/json'
//             }
//         })
//         .then(response => response.json())
//         .then(data => {
//             alert(data.message);
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert("Ocurrió un error al respaldar el inventario.");
//         });
//     }
// });




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



