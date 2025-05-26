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

                     $('#miModal_POTENCIALES').modal('hide')
                    document.getElementById('formularioDIRECTORIO').reset();
                    Tabladirectorio.ajax.reload()

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




// var Tabladirectorio = $("#Tabladirectorio").DataTable({
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
//         url: '/Tabladirectorio',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             Tabladirectorio.columns.adjust().draw();
//             ocultarCarga();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     order: [[0, 'asc']],
//     columns: [
//         {
//             data: null,
//             render: function(data, type, row, meta) {
//                 return meta.row + 1;
//             }
//         },
//         { data: 'RFC_PROVEEDOR' },
//         { data: 'GIRO_PROVEEDOR' },
//         { data: 'NOMBRE_COMERCIAL' },
//         { data: 'RAZON_SOCIAL' },
//         {
//             data: 'SERVICIOS_JSON',
//             render: function (data, type, row) {
//                 if (data) {
//                     let servicios = JSON.parse(data);
//                     let lista = '<ul>';
//                     servicios.forEach(servicio => {
//                         lista += `<li>${servicio.NOMBRE_SERVICIO}</li>`;
//                     });
//                     lista += '</ul>';
//                     return lista;
//                 }
//                 return '';
//             }
//         },
//         { data: 'BTN_EDITAR' },
//         { data: 'BTN_VISUALIZAR' },
//         { data: 'BTN_DOCUMENTO' },
//         { data: 'BTN_CORREO' },
//         { data: 'BTN_ELIMINAR' }
//     ],
//     columnDefs: [
//         { targets: 0, title: '#', className: 'all  text-center' },
//         { targets: 1, title: 'RFC', className: 'all text-center nombre-column' },
//         { targets: 2, title: 'Giro', className: 'all text-center nombre-column' },
//         { targets: 3, title: 'Nombre comercial', className: 'all text-center nombre-column' },
//         { targets: 4, title: 'Razón social/Nombre', className: 'all text-center nombre-column' },
//         { targets: 5, title: 'Servicios que ofrece', className: 'all text-center nombre-column' },
//         { targets: 6, title: 'Editar', className: 'all text-center' },
//         { targets: 7, title: 'Visualizar', className: 'all text-center' },
//         { targets: 8, title: 'C.S.F', className: 'all text-center  nombre-column' },
//         { targets: 9, title: 'Correo', className: 'all text-center  nombre-column' },
//         { targets: 10, title: 'Activo', className: 'all text-center' }
//     ]
// });



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
    createdRow: function (row, data, dataIndex) {
        if (data.ROW_CLASS) {
            $(row).addClass(data.ROW_CLASS);
        }
    },
    
    order: [[0, 'asc']], 
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'RFC_PROVEEDOR' },
        { data: 'GIRO_PROVEEDOR' },
        { data: 'NOMBRE_COMERCIAL' },
        { data: 'RAZON_SOCIAL' },
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
        { data: 'BTN_CORREO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'RFC', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Giro', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Nombre comercial', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Razón social/Nombre', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Servicios que ofrece', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
        { targets: 7, title: 'Visualizar', className: 'all text-center' },
        { targets: 8, title: 'C.S.F', className: 'all text-center nombre-column' },
        { targets: 9, title: 'Correo', className: 'all text-center nombre-column' },
        { targets: 10, title: 'Activo', className: 'all text-center' }
    ]
});




$(document).on("click", ".CORREO", function (e) {
    e.preventDefault();

    const $btn = $(this);
    const id = $btn.data("id");

    $btn.prop("disabled", true);

    Swal.fire({
        title: 'Enviando correo...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "/enviarCorreoProveedor",
        type: "POST",
        data: {
            id: id,
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            Swal.close(); 

            if (response.status === "success") {
                Swal.fire("Correo enviado", response.message, "success");
            } else {
                Swal.fire("Atención", response.message, "warning");
            }
        },
        error: function (xhr) {
            Swal.close();

            let mensaje = "Ocurrió un error inesperado al enviar el correo.";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje = xhr.responseJSON.message;
            }

            Swal.fire("Error", mensaje, "error");
        },
        complete: function () {
            $btn.prop("disabled", false);
        }
    });
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


    
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

    if (row.data().TIPO_PERSONA == "1") {
        domicilioNacional.style.display = "block";
        domicilioExtranjero.style.display = "none";
                        document.querySelector('label[for="RFC_LABEL"]').textContent = "RFC";

        if (row.data().CODIGO_POSTAL) {
            fetch(`/codigo-postal/${row.data().CODIGO_POSTAL}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;

                        let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        if (row.data().NOMBRE_COLONIA_EMPRESA) {
                            coloniaSelect.value = row.data().NOMBRE_COLONIA_EMPRESA;
                        }

                        document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = response.municipio || "No disponible";
                        document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = response.estado || "No disponible";
                    } else {
                        alert("Código postal no encontrado");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                    alert("Hubo un error al consultar la API.");
                });
        }
    } else if (row.data().TIPO_PERSONA == "2") {
        domicilioNacional.style.display = "none";
        domicilioExtranjero.style.display = "block";
                        document.querySelector('label[for="RFC_LABEL"]').textContent = "Tax ID";

    }




    editarDatoTabla(row.data(), 'formularioDIRECTORIO', 'miModal_POTENCIALES', 1);
    


    
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


        const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
            const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

            if (row.data().TIPO_PERSONA == "1") {
                domicilioNacional.style.display = "block";
                domicilioExtranjero.style.display = "none";
                                document.querySelector('label[for="RFC_LABEL"]').textContent = "RFC";

                if (row.data().CODIGO_POSTAL) {
                    fetch(`/codigo-postal/${row.data().CODIGO_POSTAL}`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.error) {
                                let response = data.response;

                                let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
                                coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                                let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                                colonias.forEach(colonia => {
                                    let option = document.createElement("option");
                                    option.value = colonia;
                                    option.textContent = colonia;
                                    coloniaSelect.appendChild(option);
                                });

                                if (row.data().NOMBRE_COLONIA_EMPRESA) {
                                    coloniaSelect.value = row.data().NOMBRE_COLONIA_EMPRESA;
                                }

                                document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = response.municipio || "No disponible";
                                document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = response.estado || "No disponible";
                            } else {
                                alert("Código postal no encontrado");
                            }
                        })
                        .catch(error => {
                            console.error("Error al obtener datos:", error);
                            alert("Hubo un error al consultar la API.");
                        });
                }
            } else if (row.data().TIPO_PERSONA == "2") {
                domicilioNacional.style.display = "none";
                domicilioExtranjero.style.display = "block";
                                document.querySelector('label[for="RFC_LABEL"]').textContent = "Tax ID";

            }
        

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






    document.addEventListener("DOMContentLoaded", function () {
        const tipoPersona = document.getElementById("TIPO_PERSONA");
        const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
        const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

        tipoPersona.addEventListener("change", function () {
            if (this.value === "1") {
                domicilioNacional.style.display = "block";
                domicilioExtranjero.style.display = "none";
            } else if (this.value === "2") {
                domicilioNacional.style.display = "none";
                domicilioExtranjero.style.display = "block";
            }
        });
    });


    
document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botonAgregarservicio');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarContacto();
    });

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarservicio', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Servicio *</label>
                        <input type="text" class="form-control" name="NOMBRE_SERVICIO" required>
                    </div>
                </div>
            </div>
    
          
    
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar servicio<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.serviciodiv');
        contenedor.appendChild(divContacto);
    
        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    
    }
    
});
