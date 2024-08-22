




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
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'CURP' }, 
        { data: null,
            render: function (data, type, row) {
                return row.NOMBRE_SELC + ' ' + row.PRIMER_APELLIDO_SELEC + ' ' + row.SEGUNDO_APELLIDO_SELEC;
            }
        },
        { data: 'CORREO_SELEC' },
        { data: null,
            render: function (data, type, row) {
                return row.TELEFONO1_SELECT + ','+ ' ' + row.TELEFONO2_SELECT;
            }
        },
        { data: 'PORCENTAJE' },
        { data: 'BTN_ELIMINAR' },
        { data: 'BTN_VISUALIZAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la vacante', className: 'all text-center nombre-column' },
        { targets: 2, title: 'CURP', className: 'all text-center' },
        { targets: 3, title: 'Nombre completo', className: 'all text-center' },
        { targets: 4, title: 'Correo', className: 'all text-center' },
        { targets: 5, title: 'Teléfonos', className: 'all text-center' },
        { targets: 6, title: '% de selección', className: 'all text-center' },
        { targets: 7, title: 'Eliminar', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },

    ]
});



