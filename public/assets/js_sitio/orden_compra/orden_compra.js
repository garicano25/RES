


ID_FORMULARIO_PO = 0


var Tablaordencompra = $("#Tablaordencompra").DataTable({
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
        url: '/Tablaordencompra',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaordencompra.columns.adjust().draw();
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
        { data: 'NO_PO' },
        { data: 'NO_MR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° PO', className: 'all text-center' },
        { targets: 2, title: 'N° MR', className: 'all text-center' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },

    ]
});




$('#Tablaordencompra tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaordencompra.row(tr);
    var HOJA_ID = row.data().HOJA_ID;
    ID_FORMULARIO_PO = row.data().ID_FORMULARIO_PO;

    $.ajax({
        url: `/ordencompra/materiales/${HOJA_ID}`,
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const { proveedor, materiales, subtotal, iva, importe } = response;
    
                $('#proveedor_seleccionado').val(proveedor ?? '');
    
                $('#tabla_materiales tbody').empty();
                materiales.forEach(m => {
                    $('#tabla_materiales tbody').append(`
                        <tr>
                            <td>${m.DESCRIPCION}</td>
                            <td>${m.CANTIDAD_REAL}</td>
                            <td>${m.PRECIO_UNITARIO}</td>
                        </tr>
                    `);
                });
    
                $('#subtotal_q').val(subtotal ?? '');
                $('#iva_q').val(iva ?? '');
                $('#importe_q').val(importe ?? '');
    
                $('#miModal_PO').modal('show');
            } else {
                alert('Error al obtener materiales.');
            }
        },
        error: function () {
            alert('Error en la solicitud al servidor.');
        }
    });
    

    editarDatoTabla(row.data(), 'formularioPO', 'miModal_PO');
});
