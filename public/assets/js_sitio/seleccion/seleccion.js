




// var Tablaseleccion = $("#Tablaseleccion").DataTable({
//     language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
//     lengthChange: true,
//     lengthMenu: [
//         [10, 25, 50, -1],
//         [10, 25, 50, 'All']
//     ],
//     info: false,
//     paging: true,
//     searching: true,
//     filtering: true,
//     scrollY: '65vh',
//     scrollCollapse: true,
//     responsive: true,
//     ajax: {
//         dataType: 'json',
//         data: {},
//         method: 'GET',
//         cache: false,
//         url: '/Tablaseleccion',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             Tablaseleccion.columns.adjust().draw();
//             ocultarCarga();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     order: [[0, 'asc']], 
//     columns:[
//         { 
//             data: null,
//             render: function(data, type, row, meta) {
//                 return meta.row + 1;
//             }
//         },
//         { data: 'NOMBRE_CATEGORIA' },
//         { data: 'NUMERO_VACANTE' },
//         { data: 'FECHA_EXPIRACION' },
//     ],
//     columnDefs: [
//         { targets: 0, title: '#', className: 'all  text-center' },
//         { targets: 1, title: 'Nombre de la categoría', className: 'all text-center' },
//         { targets: 2, title: 'N° de vacante', className: 'all text-center' },
//         { targets: 3, title: 'Fecha límite', className: 'all  text-center' },

//     ]
// });





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
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center clickable' },
        { targets: 2, title: 'N° de vacante', className: 'all text-center' },
        { targets: 3, title: 'Fecha límite', className: 'all text-center' },
    ]
});




$('#Tablaseleccion tbody').on('click', 'td.clickable', function() {
    var tr = $(this).closest('tr');
    var row = Tablaseleccion.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        Swal.fire({
            title: 'Consultando información',
            text: 'Por favor, espere...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        var categoriaId = row.data().CATEGORIA_VACANTE;
        $.ajax({
            url: '/getRelatedData/' + categoriaId,
            method: 'GET',
            success: function(response) {
                Swal.close(); 
                if (response.data.length === 0) {
                    Swal.fire('Sin información', 'No hay información relacionada para esta categoría.', 'info');
                } else {
                    // Crear la tabla interna con encabezados
                    var innerTable = `
                        <table class="table text-center">
                            <thead class="custom-header">
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Nombre Completo</th>
                                    <th class="text-center">CURP</th>
                                    <th class="text-center">Contacto</th>
                                    <th class="text-center">% Entrevista</th>
                                    <th class="text-center">% PPT</th>
                                    <th class="text-center">% Pruebas</th>
                                    <th class="text-center">Mostrar</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    // Agregar filas de datos
                    response.data.forEach(function(item, index) {
                        innerTable += `
                            <tr>
                                <td>${index + 1}</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td class="text-center">${item.NOMBRE_SELC} ${item.PRIMER_APELLIDO_SELEC} ${item.SEGUNDO_APELLIDO_SELEC}</td>
                                <td class="text-center">${item.CURP}</td>
                                <td class="text-center">${item.CORREO_SELEC}<br>${item.TELEFONO1_SELECT}, ${item.TELEFONO2_SELECT}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-circle">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    innerTable += `
                            </tbody>
                        </table>
                    `;
                    
                    row.child(innerTable).show();
                    tr.addClass('shown');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.close(); 
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            }
        });
    }
});





