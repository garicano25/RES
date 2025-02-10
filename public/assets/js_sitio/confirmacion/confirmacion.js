


//VARIABLES
ID_FORMULARIO_CONFRIMACION = 0




const Modalconfirmacion = document.getElementById('miModal_CONFIRMACION')
Modalconfirmacion.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONFRIMACION = 0
    document.getElementById('formularioCONFIRMACION').reset();
   

})



$("#guardarCONFIRMACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCONFIRMACION'))

    if (formularioValido) {

    if (ID_FORMULARIO_CONFRIMACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONFIRMACION')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONFRIMACION: ID_FORMULARIO_CONFRIMACION }, 'ContratacionSave', 'formularioCONFIRMACION', 'guardarCONFIRMACION', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CONFRIMACION = data.confirmacion.ID_FORMULARIO_CONFRIMACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_CONFIRMACION').modal('hide')
                    document.getElementById('formularioCONFIRMACION').reset();
                    Tablaconfirmacion.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONFIRMACION')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONFRIMACION: ID_FORMULARIO_CONFRIMACION }, 'ContratacionSave', 'formularioCONFIRMACION', 'guardarCONFIRMACION', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CONFRIMACION = data.confirmacion.ID_FORMULARIO_CONFRIMACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_CONFIRMACION').modal('hide')
                    document.getElementById('formularioCONFIRMACION').reset();
                    Tablaconfirmacion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


$(document).ready(function () {
    var selectizeInstance = $('#OFERTA_ID').selectize({
        placeholder: 'Seleccione una oferta',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVA_CONFIRMACION").click(function (e) {
        e.preventDefault();

        $("#miModal_CONFIRMACION").modal("show");

       

      
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
        { data: 'NO_OFERTA' },
        { data: 'FECHA_CONFIRMACION' },
        { data: 'BTN_DOCUMENTO', className: 'text-center' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de cotización', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Fecha de aceptación', className: 'all text-center' },
        { targets: 3, title: 'Documento aceptación', className: 'all text-center' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});

$('#Tablaconfirmacion').on('click', '.ver-archivo-aceptacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = 'Documento de aceptación';
    var url = '/mostraraceptacion/' + id;
    
    abrirModal(url, nombreDocumento);
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


function toggleInput(inputId, activar) {
    const input = document.getElementById(inputId);
    if (activar) {
        input.classList.remove("d-none"); 
    } else {
        input.classList.add("d-none"); 
        input.value = ""; 
    }
}



document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".botonEliminarArchivo").forEach(boton => {
        boton.addEventListener("click", function () {
            const inputArchivo = this.previousElementSibling;
            if (inputArchivo && inputArchivo.type === "file") {
                inputArchivo.value = ""; 
            }
        });
    });
});




$('#Tablaconfirmacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);
    ID_FORMULARIO_CONFRIMACION = row.data().ID_FORMULARIO_CONFRIMACION;

    editarDatoTabla(row.data(), 'formularioCONFIRMACION', 'miModal_CONFIRMACION',1);
});



$(document).ready(function() {
    $('#Tablaconfirmacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaconfirmacion.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_CONFIRMACION');

        ID_FORMULARIO_CONFRIMACION = row.data().ID_FORMULARIO_CONFRIMACION;
        editarDatoTabla(row.data(), 'formularioCONFIRMACION', 'miModal_CONFIRMACION',1);
    });

    $('#miModal_CONFIRMACION').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_CONFIRMACION');
    });
});


$('#Tablaconfirmacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONFRIMACION: row.data().ID_FORMULARIO_CONFRIMACION
    };

    eliminarDatoTabla(data, [Tablaconfirmacion], 'confirmacionDelete');
});
