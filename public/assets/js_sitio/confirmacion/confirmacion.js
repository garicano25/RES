




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



document.addEventListener("DOMContentLoaded", function () {
    const botonVerificacion = document.getElementById('botonVerificacion');

    botonVerificacion.addEventListener('click', function () {
        agregarVerificacion();
    });

    function agregarVerificacion() {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');
        divVerificacion.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la evidencia *</label>
                        <input type="text" class="form-control" name="VERIFICADO_EN" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subir Evidencia (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="EVIDENCIA_VERIFICACION" accept=".pdf" required>
                            <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar verificación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.verifiacionesdiv');
        contenedor.appendChild(divVerificacion);

        const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divVerificacion);
        });

        const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
        const inputArchivo = divVerificacion.querySelector('input[name="EVIDENCIA_VERIFICACION"]');

        botonEliminarArchivo.addEventListener('click', function () {
            inputArchivo.value = ''; 
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const btnVerificacion = document.getElementById("btnVerificacion");
    const verificacionClienteDiv = document.getElementById("VERIFICACION_CLIENTE");
    const inputVerificacionEstado = document.getElementById("inputVerificacionEstado");

    btnVerificacion.addEventListener("click", function () {
        let estadoActual = parseInt(inputVerificacionEstado.value, 10);
        let nuevoEstado = estadoActual === 0 ? 1 : 0;

        inputVerificacionEstado.value = nuevoEstado;

        verificacionClienteDiv.style.display = nuevoEstado === 1 ? "block" : "none";

        if (nuevoEstado === 1) {
            btnVerificacion.classList.remove("btn-info");
            btnVerificacion.classList.add("btn-success");
        } else {
            btnVerificacion.classList.remove("btn-success");
            btnVerificacion.classList.add("btn-info");
        }
    });
});
