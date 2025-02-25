ID_FORMULARIO_DIRECTORIO = 0





const Modalgiro = document.getElementById('miModal_POTENCIALES')
Modalgiro.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_DIRECTORIO = 0
    document.getElementById('formularioDIRECTORIO').reset();
   
    $('#miModal_POTENCIALES .modal-title').html('Proveedores');

})




var Tabladirectorio = $("#Tabladirectorio").DataTable({
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
        url: '/Tabladirectorio',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladirectorio.columns.adjust().draw();
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
        { data: 'NOMBRE_COMERCIAL' },
        { data: 'RAZON_SOCIAL' },
        { data: 'GIRO_PROVEEDOR' },
        { data: 'RFC_PROVEEDOR' },
        {
            data: 'SERVICIOS_JSON',
            render: function (data, type, row) {
                if (data) {
                    let servicios = JSON.parse(data); 
                    let lista = '<ul>'; 
                    servicios.forEach(servicio => {
                        lista += `<li>${servicio.NOMBRE_SERVICIO}</li>`;
                    });
                    lista += '</ul>';
                    return lista;
                }
                return ''; 
            }
        },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre comercial', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón social', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Giro', className: 'all text-center nombre-column' },
        { targets: 4, title: 'RFC', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Servicios que ofrece', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Visualizar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' }
    ]
});




$('#Tabladirectorio tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladirectorio.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_DIRECTORIO: row.data().ID_FORMULARIO_DIRECTORIO
    };

    eliminarDatoTabla(data, [Tabladirectorio], 'ServicioDelete');
});




$(document).ready(function() {
    $('#Tabladirectorio tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladirectorio.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_POTENCIALES');

        ID_FORMULARIO_DIRECTORIO = row.data().ID_FORMULARIO_DIRECTORIO;


        $(".serviciodiv").empty();
        obtenerservicios(row);

        $('#miModal_POTENCIALES .modal-title').html(row.data().NOMBRE_COMERCIAL);

        editarDatoTabla(row.data(), 'formularioDIRECTORIO', 'miModal_POTENCIALES',1);
    });

    $('#miModal_POTENCIALES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_POTENCIALES');
    });
});





function obtenerservicios(data) {
    let row = data.data().SERVICIOS_JSON;
    var servicios = JSON.parse(row);

    $.each(servicios, function (index, contacto) {
        var nombre = contacto.NOMBRE_SERVICIO;
     

        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generarservicio', 'mb-3');
        divDocumentoOfi.innerHTML = `
         
              <div class="col-12">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="NOMBRE_SERVICIO"  value="${nombre}" required>
                    </div>
                </div>
            </div>
           
        `;
        const contenedor = document.querySelector('.serviciodiv');
        contenedor.appendChild(divDocumentoOfi);
    });

}
