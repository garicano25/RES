

//VARIABLES
ID_FORMULARIO_ORDEN = 0

let modoEdicion = false;
let datosEditados = {}; 




const Modalorden = document.getElementById('miModal_OT')
Modalorden.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_ORDEN = 0
    document.getElementById('formularioOT').reset();
      var selectize = $('#OFERTA_ID')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");

 
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;    
})




$(document).ready(function () {
    var selectizeInstance = $('#OFERTA_ID').selectize({
        placeholder: 'Seleccione una oferta',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });
    var selectize = selectizeInstance[0].selectize;

    
    var opcionesOriginales = JSON.parse(JSON.stringify(selectize.options));
    var idsOriginales = Object.keys(opcionesOriginales);

                modoEdicion = false;


        $("#NUEVA_OT").click(function (e) {
            e.preventDefault();

            $("#miModal_OT").modal("show");
            document.getElementById('formularioOT').reset();

            Object.keys(selectize.options).forEach(function (id) {
                if (!idsOriginales.includes(id)) {
                    selectize.removeOption(id);
                }
            });

            selectize.clear();
            selectize.setValue([]);

            const quienValidaInput = document.getElementById("VERIFICADO_POR");
            const usuarioAutenticado = quienValidaInput.getAttribute("data-usuario");
            quienValidaInput.value = usuarioAutenticado;

            
        });
});








$("#guardarOT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioOT'))

    if (formularioValido) {


            var servicios = [];
                $(".material-item").each(function() {
                    var servicio = {
                        'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                        'SERVICIO': $(this).find("textarea[name='SERVICIO").val(),
                        'DESCRIPCION': $(this).find("textarea[name='DESCRIPCION']").val()
                       
                    };
                    servicios.push(servicio);
                });


        
        const requestData = {
                api: 1,
                ID_FORMULARIO_ORDEN: ID_FORMULARIO_ORDEN,
                SERVICIOS_JSON: JSON.stringify(servicios)


            };

        
        
            if (ID_FORMULARIO_ORDEN == 0) {
                
                alertMensajeConfirm({
                    title: "¿Desea guardar la información?",
                    text: "Al guardarla, se podra usar",
                    icon: "question",
                },async function () { 

                    await loaderbtn('guardarOT')
                    await ajaxAwaitFormData( requestData, 'otSave', 'formularioOT', 'guardarOT', { callbackAfter: true, callbackBefore: true }, () => {
                
                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        })

                        $('.swal2-popup').addClass('ld ld-breath')
                
                        
                    }, function (data) {
                            
                        ID_FORMULARIO_ORDEN = data.orden.ID_FORMULARIO_ORDEN

                    var ofertasUsadas = $("#OFERTA_ID").val(); 
                    if (Array.isArray(ofertasUsadas)) {
                        var selectize = $('#OFERTA_ID')[0].selectize;
                        ofertasUsadas.forEach(id => {
                            selectize.removeOption(id);
                        });
                    }

                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                            $('#miModal_OT').modal('hide')
                        document.getElementById('formularioOT').reset();
                        Tablaordentrabajo.ajax.reload()

                    })
                    
                    
                }, 1)
                
            } else {
                    alertMensajeConfirm({
                    title: "¿Desea editar la información de este formulario?",
                    text: "Al guardarla, se podra usar",
                    icon: "question",
                },async function () { 

                    await loaderbtn('guardarOT')
                    await ajaxAwaitFormData( requestData, 'otSave', 'formularioOT', 'guardarOT', { callbackAfter: true, callbackBefore: true }, () => {
                
                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        })

                        $('.swal2-popup').addClass('ld ld-breath')
                
                        
                    }, function (data) {
                            
                        setTimeout(() => {

                            
                            ID_FORMULARIO_ORDEN = data.orden.ID_FORMULARIO_ORDEN
                            alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                            $('#miModal_OT').modal('hide')
                            document.getElementById('formularioOT').reset();
                            Tablaordentrabajo.ajax.reload()


                        }, 300);  
                    })
                }, 1)
            }

        } else {
            alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

        }
    
});





var Tablaordentrabajo = $("#Tablaordentrabajo").DataTable({
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
        url: '/Tablaordentrabajo',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaordentrabajo.columns.adjust().draw();
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
        { data: 'NO_OFERTA_HTML' },
        { data: 'NO_ORDEN_CONFIRMACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° de cotización', className: 'all text-center nombre-column' },
        { targets: 2, title: 'N° de OT', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});





// $('#Tablaordentrabajo tbody').on('click', 'td>button.EDITAR', function () {
//     var tr = $(this).closest('tr');
//     var row = Tablaordentrabajo.row(tr);
//     ID_FORMULARIO_ORDEN = row.data().ID_FORMULARIO_ORDEN;

//     editarDatoTabla(row.data(), 'formularioOT', 'miModal_OT', 1);



//   var selectize = $('#OFERTA_ID')[0].selectize;
//         selectize.clear();
//             selectize.setValue([]);
            
//             if (row.data().OFERTA_ID) {
//                 try {
//                     let ofertaArray = JSON.parse(row.data().OFERTA_ID);
//                     let nombres = row.data().NO_OFERTA.split(',').map(e => e.trim()); 

//                     if (Array.isArray(ofertaArray)) {
//                         ofertaArray.forEach((id, index) => {
//                             if (!selectize.options[id]) {
//                                 selectize.addOption({ value: id, text: nombres[index] || id });
//                             }
//                         });

//                         selectize.setValue(ofertaArray);
//                     }
//                 } catch (error) {
//                     console.error("Error al parsear OFERTA_ID:", error);
//                     selectize.clear();
//                 }
//             }

//     if (row.data().VERIFICADO_POR) {
//         $("#VERIFICADO_POR").val(row.data().VERIFICADO_POR);
//     }

// });


$('#Tablaordentrabajo tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaordentrabajo.row(tr);
    var data = row.data();

    ID_FORMULARIO_ORDEN = data.ID_FORMULARIO_ORDEN;

    editarDatoTabla(data, 'formularioOT', 'miModal_OT', 1);

        modoEdicion = true;

        datosEditados = {
            direccion: data.DIRECCION_SERVICIO,
            solicita: data.PERSONA_SOLICITA,
            contacto: {
                nombre: data.CONTACTO,
                telefono: data.TELEFONO_CONTACTO,
                celular: data.CELULAR_CONTACTO,
                correo: data.EMAIL_CONTACTO
            }
        };

        var selectize = $('#OFERTA_ID')[0].selectize;
        selectize.clear();
        selectize.setValue([]);

        if (data.OFERTA_ID) {
            try {
                let ofertaArray = JSON.parse(data.OFERTA_ID);
                let nombres = data.NO_OFERTA.split(',').map(e => e.trim());

                if (Array.isArray(ofertaArray)) {
                    ofertaArray.forEach((id, index) => {
                        if (!selectize.options[id]) {
                            selectize.addOption({ value: id, text: nombres[index] || id });
                        }
                    });

                    selectize.setValue(ofertaArray); 
                }
            } catch (error) {
                console.error("Error al parsear OFERTA_ID:", error);
            }
        }

        if (data.VERIFICADO_POR) {
            $("#VERIFICADO_POR").val(data.VERIFICADO_POR);
    }
    

    $(".materialesdiv").empty();

        cargarMaterialesDesdeJSON(row.data().SERVICIOS_JSON);

    
   


});



$(document).ready(function() {
    $('#Tablaordentrabajo tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaordentrabajo.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_OT');

        ID_FORMULARIO_ORDEN = row.data().ID_FORMULARIO_ORDEN;
        editarDatoTabla(row.data(), 'formularioOT', 'miModal_OT', 1);
 modoEdicion = true;

                datosEditados = {
                    direccion: data.DIRECCION_SERVICIO,
                    solicita: data.PERSONA_SOLICITA,
                    contacto: {
                        nombre: data.CONTACTO,
                        telefono: data.TELEFONO_CONTACTO,
                        celular: data.CELULAR_CONTACTO,
                        correo: data.EMAIL_CONTACTO
                    }
                };

                var selectize = $('#OFERTA_ID')[0].selectize;
                selectize.clear();
                selectize.setValue([]);

                if (data.OFERTA_ID) {
                    try {
                        let ofertaArray = JSON.parse(data.OFERTA_ID);
                        let nombres = data.NO_OFERTA.split(',').map(e => e.trim());

                        if (Array.isArray(ofertaArray)) {
                            ofertaArray.forEach((id, index) => {
                                if (!selectize.options[id]) {
                                    selectize.addOption({ value: id, text: nombres[index] || id });
                                }
                            });

                            selectize.setValue(ofertaArray); 
                        }
                    } catch (error) {
                        console.error("Error al parsear OFERTA_ID:", error);
                    }
                }

                if (data.VERIFICADO_POR) {
                    $("#VERIFICADO_POR").val(data.VERIFICADO_POR);
                }


    });

    $('#miModal_OT').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_OT');
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const quienValidaInput = document.getElementById("VERIFICADO_POR");
    const usuarioAutenticado = quienValidaInput.getAttribute("data-usuario");
    quienValidaInput.value = usuarioAutenticado;
});



let contadorMateriales = 1; 
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
            <div class="col-1">
                <label class="form-label">No.</label>
                <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
            </div>
             <div class="col-1">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="CANTIDAD" required>
            </div>
             <div class="col-5">
                <label class="form-label">Servicio</label>
                <textarea type="text" class="form-control" name="SERVICIO" required rows="3"></textarea>
            </div>
            <div class="col-5">
                <label class="form-label">Descripción</label>
                <textarea type="text" class="form-control" name="DESCRIPCION" required rows="3"></textarea>
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
});



 function actualizarNumerosOrden() {
        const materiales = document.querySelectorAll('.material-item');
        let nuevoContador = 1;
        materiales.forEach(material => {
            material.querySelector('input[name="NUMERO_ORDEN"]').value = nuevoContador;
            nuevoContador++;
        });
        contadorMateriales = nuevoContador;
}


// $(document).ready(function () {
//    $('#OFERTA_ID').change(function () {
//     var selectedIds = $(this).val();

//     if (selectedIds.length > 0) {
//         $.ajax({
//             url: '/obtenerDatosOferta',
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//                 oferta_ids: selectedIds
//             },
//             success: function (data) {
//                 $('#RAZON_CONFIRMACION').val(data.razones.join(', '));
//                 $('#COMERCIAL_CONFIRMACION').val(data.comerciales.join(', '));
//                 $('#RFC_CONFIRMACION').val(data.rfcs.join(', '));
//                 $('#GIRO_CONFIRMACION').val(data.giros.join(', '));

//                 const selectorDir = $('#SELECTOR_DIRECCION');
//                 selectorDir.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
//                 data.direcciones.forEach(function (direccion) {
//                     selectorDir.append('<option value="' + direccion + '">' + direccion + '</option>');
//                 });
//                 if (!modoEdicion) {
//                     $('#DIRECCION_CONFIRMACION').val('');
//                 }

//                 const selectorSolicita = $('#SELECTOR_SOLICITA');
//                 selectorSolicita.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
//                 data.contactos.forEach(function (nombre) {
//                     selectorSolicita.append('<option value="' + nombre + '">' + nombre + '</option>');
//                 });
//                 if (!modoEdicion) {
//                     $('#PERSONA_SOLICITA_CONFIRMACION').val('');
//                 }

//                 const selectorContacto = $('#SELECTOR_CONTACTO');
//                 selectorContacto.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
//                 window.contactosMap = {};
//                 data.contactos_completos.forEach(function (contacto) {
//                     selectorContacto.append('<option value="' + contacto.nombre + '">' + contacto.nombre + '</option>');
//                     window.contactosMap[contacto.nombre] = contacto;
//                 });

//                 if (!modoEdicion) {
//                     $('#CONTACTO_CONFIRMACION').val('');
//                     $('#CONTACTO_TELEFONO_CONFIRMACION').val('');
//                     $('#CONTACTO_CELULAR_CONFIRMACION').val('');
//                     $('#CONTACTO_EMAIL_CONFIRMACION').val('');
//                 }

//                 modoEdicion = false;
//             },
//             error: function (xhr) {
//                 console.error(xhr.responseText);
//                 alert('Hubo un error al obtener los datos.');
//             }
//         });
//     }
// });

// });


$(document).ready(function () {
    $('#OFERTA_ID').change(function () {
        var selectedIds = $(this).val();

        if (selectedIds.length > 0) {
            $.ajax({
                url: '/obtenerDatosOferta',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    oferta_ids: selectedIds
                },
                success: function (data) {
                    $('#RAZON_CONFIRMACION').val(data.razones.join(', '));
                    $('#COMERCIAL_CONFIRMACION').val(data.comerciales.join(', '));
                    $('#RFC_CONFIRMACION').val(data.rfcs.join(', '));
                    $('#GIRO_CONFIRMACION').val(data.giros.join(', '));

                    const selectorDir = $('#SELECTOR_DIRECCION');
                    selectorDir.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
                    data.direcciones.forEach(function (direccion) {
                        selectorDir.append('<option value="' + direccion + '">' + direccion + '</option>');
                    });
                    if (!modoEdicion) {
                        $('#DIRECCION_CONFIRMACION').val('');
                    }

                    const selectorSolicita = $('#SELECTOR_SOLICITA');
                    selectorSolicita.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
                    data.contactos.forEach(function (nombre) {
                        selectorSolicita.append('<option value="' + nombre + '">' + nombre + '</option>');
                    });
                    if (!modoEdicion) {
                        $('#PERSONA_SOLICITA_CONFIRMACION').val('');
                    }

                    const selectorContacto = $('#SELECTOR_CONTACTO');
                    selectorContacto.empty().append('<option value="" disabled selected>Seleccione una opción</option>');
                    window.contactosMap = {};
                    data.contactos_completos.forEach(function (contacto) {
                        selectorContacto.append('<option value="' + contacto.nombre + '">' + contacto.nombre + '</option>');
                        window.contactosMap[contacto.nombre] = contacto;
                    });

                    if (!modoEdicion) {
                        $('#CONTACTO_CONFIRMACION').val('');
                        $('#CONTACTO_TELEFONO_CONFIRMACION').val('');
                        $('#CONTACTO_CELULAR_CONFIRMACION').val('');
                        $('#CONTACTO_EMAIL_CONFIRMACION').val('');
                    }

                    modoEdicion = false;
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Hubo un error al obtener los datos.');
                }
            });
        }
    });

    $('#SELECTOR_DIRECCION').on('change', function () {
        const direccion = $(this).val();
        $('#DIRECCION_CONFIRMACION').val(direccion);
    });

    $('#SELECTOR_SOLICITA').on('change', function () {
        const persona = $(this).val();
        $('#PERSONA_SOLICITA_CONFIRMACION').val(persona);
    });

    $('#SELECTOR_CONTACTO').on('change', function () {
        const seleccionado = $(this).val();
        const datos = window.contactosMap ? window.contactosMap[seleccionado] : null;

        if (datos) {
            $('#CONTACTO_CONFIRMACION').val(datos.nombre);
            $('#CONTACTO_TELEFONO_CONFIRMACION').val(datos.telefono);
            $('#CONTACTO_CELULAR_CONFIRMACION').val(datos.celular);
            $('#CONTACTO_EMAIL_CONFIRMACION').val(datos.correo);
        } else {
            $('#CONTACTO_CONFIRMACION').val('');
            $('#CONTACTO_TELEFONO_CONFIRMACION').val('');
            $('#CONTACTO_CELULAR_CONFIRMACION').val('');
            $('#CONTACTO_EMAIL_CONFIRMACION').val('');
        }
    });
});



function cargarMaterialesDesdeJSON(serviciosJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    try {
        const servicios = typeof serviciosJson === 'string' ? JSON.parse(serviciosJson) : serviciosJson;

        servicios.forEach(servicio => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('row', 'material-item', 'mt-1');

            divMaterial.innerHTML = `
                <div class="col-1">
                    <label class="form-label">No.</label>
                    <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                </div>
                <div class="col-1">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="CANTIDAD" value="${servicio.CANTIDAD}" required>
                </div>
                <div class="col-5">
                    <label class="form-label">Servicio</label>
                    <textarea class="form-control" name="SERVICIO" required rows="3">${servicio.SERVICIO}</textarea>
                </div>
                <div class="col-5">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="DESCRIPCION" required rows="3">${servicio.DESCRIPCION}</textarea>
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
    } catch (e) {
        console.error('Error al parsear SERVICIOS_JSON:', e);
    }
}
