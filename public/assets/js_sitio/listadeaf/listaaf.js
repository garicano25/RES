ID_FORMULARIO_INVENTARIO = 0
ID_ENTRADA_FORMULARIO = 0



var inventario_id = null; 



const Modalinventario = document.getElementById('Modal_inventario')
Modalinventario.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INVENTARIO = 0
    document.getElementById('formularioINVENTARIO').reset();
   
    $('#Modal_inventario .modal-title').html('Equipo');


})






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
                    Tablalistadeaf.ajax.reload()

        
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
                    Tablalistadeaf.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablalistadeaf = $("#Tablalistadeaf").DataTable({
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
        url: '/Tablalistadeaf',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablalistadeaf.columns.adjust().draw();
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







$('#Tablalistadeaf tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistadeaf.row(tr);
    ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



    inventario_id = row.data().ID_FORMULARIO_INVENTARIO;

    $("#tab1-info").click();

    $("#tab2-entrada").off("click").on("click", function () {
        cargartablaentradainventario();
    });



    editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);


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

    
    
});



$(document).ready(function() {
    $('#Tablalistadeaf tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablalistadeaf.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#Modal_inventario');

        ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



          inventario_id = row.data().ID_FORMULARIO_INVENTARIO;
    
        $("#tab1-info").click();
    
        $("#tab2-entrada").off("click").on("click", function () {
            cargartablaentradainventario();
        });


                
        
        
        editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);
        


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

        
        
        


    });

    $('#Modal_inventario').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_inventario');
    });
});




$('#Tablalistadeaf tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistadeaf.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_INVENTARIO: row.data().ID_FORMULARIO_INVENTARIO
    };

    eliminarDatoTabla(data, [Tablalistadeaf], 'inventarioDelete');
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






