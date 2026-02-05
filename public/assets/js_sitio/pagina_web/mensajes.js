//VARIABLES
ID_FORMULARIO_CONTACTOSPAGINAWEB = 0




const ModalArea = document.getElementById('miModal_MENSAJES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONTACTOSPAGINAWEB = 0
    document.getElementById('formularioMENSAJES').reset();
   
    $('#miModal_MENSAJES .modal-title').html('Nuevo asesor');


})


var Tablamensajepaginaweb = $("#Tablamensajepaginaweb").DataTable({
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
        url: '/Tablamensajepaginaweb',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamensajepaginaweb.columns.adjust().draw();
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
        { data: 'NOMBRE' },
        { data: 'CORREO' },
        { data: 'MENSAJE' },
          {
            data: 'created_at',
            render: function (data) {
                if (!data) return '';
                return data.split('T')[0]; 
            }
        },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Correo electrónico', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Mensaje', className: 'all text-center descripcion-column' },
        { targets: 4, title: 'Fecha de envío', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablamensajepaginaweb tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablamensajepaginaweb.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_FORMULARIO_CONTACTOSPAGINAWEB: row.data().ID_FORMULARIO_CONTACTOSPAGINAWEB
    }
    
    eliminarDatoTabla1(data, [Tablamensajepaginaweb], 'MensajespaginaDelete')

})




$(document).ready(function() {
    $('#Tablamensajepaginaweb tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamensajepaginaweb.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_MENSAJES');

        ID_FORMULARIO_CONTACTOSPAGINAWEB = row.data().ID_FORMULARIO_CONTACTOSPAGINAWEB;
        editarDatoTabla(row.data(), 'formularioMENSAJES', 'miModal_MENSAJES',1);
         $('#miModal_MENSAJES .modal-title').html(row.data().NOMBRE_ASESOR);

    });

    $('#miModal_MENSAJES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_MENSAJES');
    });
});

