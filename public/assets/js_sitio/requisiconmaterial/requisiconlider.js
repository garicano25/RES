//VARIABLES
ID_FORMULARIO_MR = 0




const Modalmr = document.getElementById('miModal_MR');
Modalmr.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_MR = 0;
    document.getElementById('formularioMR').reset();

    $('#VISTO_BUENO_JEFE').hide();
    $('#APROBACION_DIRECCION').hide();
    $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    $('#BOTON_VISTO_BUENO').hide();


    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;
});







$("#NUEVO_MR").click(function (e) {
    e.preventDefault();


       
    $('#formularioMR').each(function(){
        this.reset();
    });

    $(".materialesdiv").empty();


    $("#miModal_MR").modal("show");


    $.get('/obtenerAreaSolicitante', function(response) {
    if (response.area) {
        $("#AREA_SOLICITANTE_MR").val(response.area);
    } else {
        $("#AREA_SOLICITANTE_MR").val("Área no encontrada");
    }
});


    

cambiarColor();
   
});



let contadorMateriales = 1; // Declaración global para que sea accesible en todo el script

document.addEventListener("DOMContentLoaded", function () {
    const botonMaterial = document.getElementById('botonmaterial');
    const contenedorMateriales = document.querySelector('.materialesdiv');

    botonMaterial.addEventListener('click', function () {
        agregarMaterial();
    });

    function agregarMaterial() {
        const divMaterial = document.createElement('div');
        divMaterial.classList.add('row', 'material-item', 'mt-1');
        divMaterial.innerHTML = `
            <div class="col-2">
                <label class="form-label">N°</label>
                <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
            </div>
            <div class="col-5">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="DESCRIPCION" required>
            </div>
            <div class="col-2">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="CANTIDAD" required>
            </div>
            <div class="col-3">
                <label class="form-label">Unidad de Medida</label>
                <input type="text" class="form-control" name="UNIDAD_MEDIDA" required>
            </div>
            <div class="col-12 mt-2 text-end">
                <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        contenedorMateriales.appendChild(divMaterial);
        contadorMateriales++; 
        const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
        botonEliminar.addEventListener('click', function () {
            contenedorMateriales.removeChild(divMaterial);
            actualizarNumerosOrden(); 
        });
    }

    function actualizarNumerosOrden() {
        const materiales = document.querySelectorAll('.material-item');
        let nuevoContador = 1;
        materiales.forEach(material => {
            material.querySelector('input[name="NUMERO_ORDEN"]').value = nuevoContador;
            nuevoContador++;
        });
        contadorMateriales = nuevoContador;
    }
});

function cambiarColor() {
        var select = document.getElementById("ESTADO_APROBACION");
        var container = document.getElementById("estado-container");
        var motivoContainer = document.getElementById("motivo-rechazo-container");

        if (select.value === "Aprobada") {
            container.style.backgroundColor = "green";
            container.style.color = "white";
            motivoContainer.style.display = "none"; 
        } else if (select.value === "Rechazada") {
            container.style.backgroundColor = "red";
            container.style.color = "white";
            motivoContainer.style.display = "block"; 
        } else {
            container.style.backgroundColor = "transparent";
            container.style.color = "black";
            motivoContainer.style.display = "none"; 
        }
}
    











$("#guardarMR").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('FormularioCONTRATACION');

    if (formularioValido) {

        
        var documentos = [];
        $(".material-item").each(function() {
            var documento = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                'UNIDAD_MEDIDA': $(this).find("input[name='UNIDAD_MEDIDA']").val(),            };
            documentos.push(documento);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_MR: ID_FORMULARIO_MR,
            MATERIALES_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_MR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMR')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioMR', 'guardarMR', { callbackAfter: true, callbackBefore: true }, () => {

        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_MR = data.mr.ID_FORMULARIO_MR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_MR').modal('hide')
                    document.getElementById('formularioMR').reset();
                    Tablarequisicion.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMR')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioMR', 'guardarMR', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_MR = data.mr.ID_FORMULARIO_MR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_MR').modal('hide')
                    document.getElementById('formularioMR').reset();
                    Tablarequisicion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablarequisicion = $("#Tablarequisicion").DataTable({
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
        url: '/Tablarequisicion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarequisicion.columns.adjust().draw();
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
    { data: 'SOLICITANTE_MR' },
    { data: 'NO_MR' },
    { data: 'FECHA_SOLICITUD_MR' },
    { data: 'ESTADO_REVISION' }, // 👈 NUEVA COLUMNA
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },
    { data: 'BTN_ELIMINAR' }
],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Nombre del solicitante', className: 'all text-center' },
    { targets: 2, title: 'N° MR', className: 'all text-center' },
    { targets: 3, title: 'Fecha solicitud', className: 'all text-center' },
    { targets: 4, title: 'Estado', className: 'all text-center' }, 
    { targets: 5, title: 'Editar', className: 'all text-center' },
    { targets: 6, title: 'Visualizar', className: 'all text-center' },
    { targets: 7, title: 'Activo', className: 'all text-center' }
]

});




$('#Tablarequisicion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequisicion.row(tr);
    ID_FORMULARIO_MR = row.data().ID_FORMULARIO_MR;


        cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
    editarDatoTabla(row.data(), 'formularioMR', 'miModal_MR', 1);
    

});



function cargarMaterialesDesdeJSON(materialesJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = ''; 
    let contadorMateriales = 1;

    try {
        const materiales = JSON.parse(materialesJson);

        materiales.forEach(material => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('row', 'material-item', 'mt-1');
            divMaterial.innerHTML = `
                <div class="col-2">
                    <label class="form-label">N°</label>
                    <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                </div>
                <div class="col-5">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control" name="DESCRIPCION" value="${material.DESCRIPCION}" required>
                </div>
                <div class="col-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
                </div>
                <div class="col-3">
                    <label class="form-label">Unidad de Medida</label>
                    <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}" required>
                </div>
                <div class="col-12 mt-2 text-end">
                    <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);
            contadorMateriales++;

            const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
            botonEliminar.addEventListener('click', function () {
                contenedorMateriales.removeChild(divMaterial);
                actualizarNumerosOrden();
            });
        });

        window.contadorMateriales = contadorMateriales;

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}


function darVistoBueno() {
    Swal.fire({
        title: '¿Deseas dar el visto bueno a la M.R?',
        text: "Esta acción enviará la solicitud.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/darVistoBueno',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
                        _token: $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Visto bueno registrado',
                                text: response.message
                            });

                            $('#miModal_MR').modal('hide');
                            $('#Tablarequisicion').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al guardar el visto bueno.'
                        });
                    }
                });
            }
        }
    });
}






function rechazarVistoBueno() {
    document.getElementById('motivoRechazoTextarea').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalRechazo'));
    modal.show();
}

document.getElementById('formRechazo').addEventListener('submit', function (event) {
    event.preventDefault();

    const motivo = document.getElementById('motivoRechazoTextarea').value.trim();

    if (motivo === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Por favor, escriba el motivo del rechazo.'
        });
        return;
    }

    Swal.fire({
        title: '¿Deseas rechazar la M.R?',
        text: "Esta acción registrará el rechazo de manera permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/rechazar',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
                        motivo: motivo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rechazar M.R',
                                text: response.message
                            });

                            bootstrap.Modal.getInstance(document.getElementById('modalRechazo')).hide();
                            $('#miModal_MR').modal('hide');
                            $('#Tablarequisicion').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo registrar el rechazo.'
                        });
                    }
                });
            }
        }
    });
});
