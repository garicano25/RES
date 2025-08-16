


// var Tablabitacoragr = $("#Tablabitacoragr").DataTable({
//     language: {
//         url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
//     },
//     scrollX: true,
//     autoWidth: false,
//     responsive: false,
//     paging: true,
//     searching: true,
//     info: false,
//     lengthChange: true,
//     lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
//     ajax: {
//         dataType: 'json',
//         method: 'GET',
//         url: '/Tablabitacoragr',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             Tablabitacoragr.columns.adjust().draw();
//             ocultarCarga();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     columnDefs: [
       
        

//     ],
//     columns: [
      
//   ],
//   createdRow: function (row, data, dataIndex) {
//     $(row).css('background-color', data.COLOR);
//   },

// drawCallback: function () {
//     const topScroll = document.querySelector('.tabla-scroll-top');
//     const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
//     const table = document.querySelector('#Tablabitacoragr');
//     const scrollBody = document.querySelector('.dataTables_scrollBody');

//     if (!topScroll || !scrollInner || !table || !scrollBody) return;

//     const tableWidth = table.scrollWidth;

//     scrollInner.style.width = tableWidth + 'px';

//     let syncingTop = false;
//     let syncingBottom = false;

//     topScroll.addEventListener('scroll', function () {
//         if (syncingTop) return;
//         syncingBottom = true;
//         scrollBody.scrollLeft = topScroll.scrollLeft;
//         syncingBottom = false;
//     });

//     scrollBody.addEventListener('scroll', function () {
//         if (syncingBottom) return;
//         syncingTop = true;
//         topScroll.scrollLeft = scrollBody.scrollLeft;
//         syncingTop = false;
//     });
// }


// });






var Tablabitacoragr = $("#Tablabitacoragr").DataTable({
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
        url: '/Tablabitacoragr',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoragr.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', defaultContent: 'N/A' },
        { targets: 0, width: '250px', className: 'text-center'  },
        { targets: 1, width: '250px',className: 'text-center'  },
        { targets: 2, width: '200px',className: 'text-center'  },
        { targets: 3, width: '250px', className: 'text-center' },
        { targets: 4, width: '400px' },
        { targets: 5, width: '250px',className: 'text-center'  },
        { targets: 6, width: '400px' },
    ],
    columns: [
        { data: 'NO_MR' },
        { data: 'FECHA_APRUEBA_MR' },
        { data: 'NO_PO' },
        { data: 'FECHA_APROBACION_PO' },
        { data: 'PROVEEDOR' },
        { data: 'FECHA_ENTREGA_PO' },
        { data: 'BIEN_SERVICIO' }
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).css('background-color', data.COLOR);
    },
    drawCallback: function () {
        const topScroll = document.querySelector('.tabla-scroll-top');
        const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
        const table = document.querySelector('#Tablabitacoragr');
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

$(document).on('click', '.btn-ver-mas-materiales', function() {
    let $btn = $(this);
    let $extra = $btn.siblings('.extra-materiales');
    if ($extra.is(':visible')) {
        $extra.hide();
        $btn.text('Ver más');
    } else {
        $extra.show();
        $btn.text('Ver menos');
    }
});

