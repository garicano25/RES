




$(document).ready(function () {
    var selectizeInstance = $('#SOLICITUD_ID').selectize({
        placeholder: 'Seleccione una oferta',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVA_CONFIRMACION").click(function (e) {
        e.preventDefault();

        $("#miModal_CONFIRMACION").modal("show");

        // var selectize = selectizeInstance[0].selectize;
        // selectize.clear(); 
        // selectize.clearOptions(); 
        // selectize.addOption({
        //     value: '',
        //     text: 'Seleccione una oferta'
        // }); 

      
        document.getElementById('formularioCONFIRMACION').reset();
    });
});




var Tablaconfirmacion = $("#Tablaconfirmacion").DataTable({
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
        url: '/Tablaconfirmacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaconfirmacion.columns.adjust().draw();
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
        { data: 'NO_CONFIRMACION' },
        { data: 'ACEPTACION_CONFIRMACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_CORREO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de orden', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Fecha emisión', className: 'all text-center' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});