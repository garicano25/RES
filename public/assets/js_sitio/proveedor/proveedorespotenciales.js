ID_FORMULARIO_DIRECTORIO = 0











$("#guardarDIRECTORIO").click(async function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDIRECTORIO'));

    if (formularioValido) {

        var servicios = [];
        $(".generarservicio").each(function() {
            var servicio = {
                'NOMBRE_SERVICIO': $(this).find("input[name='NOMBRE_SERVICIO']").val()
            };
            servicios.push(servicio);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_DIRECTORIO: ID_FORMULARIO_DIRECTORIO,
            SERVICIOS_JSON: JSON.stringify(servicios)
        };

        if (ID_FORMULARIO_DIRECTORIO == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información guardada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'block';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);

        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información editada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'none';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});

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
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre comercial', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón social/Nombre', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Giro', className: 'all text-center nombre-column' },
        { targets: 4, title: 'RFC', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Servicios que ofrece', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
        { targets: 7, title: 'Visualizar', className: 'all text-center' },
        { targets: 8, title: 'Constancia', className: 'all text-center  nombre-column' },
        { targets: 9, title: 'Activo', className: 'all text-center' }
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



$('#Tabladirectorio').on('click', '.ver-archivo-constancia', function () {
    var tr = $(this).closest('tr');
    var row = Tabladirectorio.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_COMERCIAL;
    var url = '/mostrarconstanciaproveedor/' + id;
    
    abrirModal(url, nombreDocumento);
});


$('#Tabladirectorio tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladirectorio.row(tr);
    ID_FORMULARIO_DIRECTORIO = row.data().ID_FORMULARIO_DIRECTORIO;


    $(".serviciodiv").empty();
    obtenerservicios(row);

    $('#miModal_POTENCIALES .modal-title').html(row.data().NOMBRE_COMERCIAL);

    editarDatoTabla(row.data(), 'formularioDIRECTORIO', 'miModal_POTENCIALES',1);
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
                        <label class="form-label">Nombre del servicio *</label>
                        <input type="text" class="form-control" name="NOMBRE_SERVICIO"  value="${nombre}" required>
                    </div>
                </div>
            </div>
           
        `;
        const contenedor = document.querySelector('.serviciodiv');
        contenedor.appendChild(divDocumentoOfi);
    });

}
