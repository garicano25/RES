
var Tablabitacoraconsumibles = $("#Tablabitacoraconsumibles").DataTable({
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
        url: '/Tablabitacoraconsumibles',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoraconsumibles.columns.adjust().draw();
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
        { data: 'DESCRIPCION' },
        { data: 'SOLICITANTE_SALIDA' },
        { data: 'FECHA_SALIDA' },
        { data: 'CANTIDAD' },
        { data: 'CANTIDAD_SALIDA' },
        { data: 'PRODUCTO_NOMBRE' },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Descripción del artículo', className: 'all text-center' },
        { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' },
        { targets: 3, title: 'Fecha de solicitud', className: 'all text-center' },
        { targets: 4, title: 'Cantidad solicitada', className: 'all text-center' },
        { targets: 5, title: 'Cantidad que sale del inventario', className: 'all text-center' },
        { targets: 6, title: 'Artículo que sale del inventario', className: 'all text-center' },
        { targets: 7, title: 'Marca', className: 'all text-center' },
        { targets: 8, title: 'Modelo', className: 'all text-center' },
        { targets: 9, title: 'No. Serie', className: 'all text-center' },
        { targets: 10, title: 'Editar', className: 'all text-center' },
        { targets: 11, title: 'Visualizar', className: 'all text-center' }
    ]

});






$(document).on('click', '.editarMaterial', function () {
    let idFormulario = $(this).data('id');
    let idInventario = $(this).data('inventario');

    $.ajax({
        url: '/obtenerMaterialIndividual',
        method: 'GET',
        data: { id: idFormulario, inventario: idInventario },
        success: function (res) {
            if (res.success) {
                let material = res.material;

                $("#SOLICITANTE_SALIDA").val(material.SOLICITANTE_SALIDA);
                $("#FECHA_SALIDA").val(material.FECHA_SALIDA);
                $("#DESCRIPCION").val(material.DESCRIPCION);
                $("#CANTIDAD").val(material.CANTIDAD);
                $("#CANTIDAD_SALIDA").val(material.CANTIDAD_SALIDA);
                $("#INVENTARIO").val(material.INVENTARIO);
                $("#OBSERVACIONES_REC").val(material.OBSERVACIONES_REC);
                $("#RECIBIDO_POR").val(material.SOLICITANTE_SALIDA);

                $("#miModal_RECURSOSEMPLEADOS").modal("show");
            } else {
                alert(res.message || "No se pudo obtener el material.");
            }
        },
        error: function () {
            alert("Error al obtener el material individual.");
        }
    });
});
