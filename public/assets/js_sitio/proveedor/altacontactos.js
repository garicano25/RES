




$(document).ready(function () {
    var selectizeInstance = $('#TITULO_CUENTA').selectize({
        placeholder: 'Seleccione una opción',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVO_CONTACTO").click(function (e) {
        e.preventDefault();

        $("#miModal_contactos").modal("show");

        // Resetear el formulario
        document.getElementById('formularioCertificaciones').reset();

        // Resetear Selectize
        var selectize = selectizeInstance[0].selectize;
        selectize.clear();
        selectize.setValue(""); 


      
    });
});




var Tablacontactosproveedor = $("#Tablacontactosproveedor").DataTable({
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
        url: '/Tablacontactosproveedor',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacontactosproveedor.columns.adjust().draw();
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
        { data: 'TIPO_CUENTA' },
        { data: 'NOMBRE_BENEFICIARIO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo de cuenta', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre del beneficiario', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});
