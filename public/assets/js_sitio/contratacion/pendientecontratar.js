//VARIABLES
ID_PENDIENTES_CONTRATAR = 0






const ModalArea = document.getElementById('miModal_PENDIENTE')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_PENDIENTES_CONTRATAR = 0
    document.getElementById('formularioPENDIENTE').reset();


})




var Tablapendientecontratacion = $("#Tablapendientecontratacion").DataTable({
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
        url: '/Tablapendientecontratacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablapendientecontratacion.columns.adjust().draw();
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
            data: null,
            render: function (data, type, row) {
                return row.NOMBRE_PC + ' ' + row.PRIMER_APELLIDO_PC + ' ' + row.SEGUNDO_APELLIDO_PC;
            }
        },
        
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_CONTRATACION' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre completo', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Visualizar', className: 'all text-center' },
        { targets: 3, title: 'Enviar', className: 'all text-center' }

    ]
});




$(document).ready(function() {
    $('#Tablapendientecontratacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablapendientecontratacion.row(tr);

        

    $('#miModal_PENDIENTE .modal-title').html(row.data().NOMBRE_PC);

        hacerSoloLectura(row.data(), '#miModal_PENDIENTE');

        ID_PENDIENTES_CONTRATAR = row.data().ID_PENDIENTES_CONTRATAR;
        editarDatoTabla(row.data(), 'formularioPENDIENTE', 'miModal_PENDIENTE',1);
    });

    $('#miModal_PENDIENTE').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_PENDIENTE');
    });
});
