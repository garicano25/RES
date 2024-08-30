




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
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center' },
        { targets: 2, title: 'N° de vacante', className: 'all text-center' },
        { targets: 3, title: 'Fecha límite', className: 'all  text-center' },

    ]
});



