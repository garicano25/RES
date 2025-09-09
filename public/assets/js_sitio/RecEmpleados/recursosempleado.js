//VARIABLES
ID_FORMULARIO_RECURSOS_EMPLEADOS = 0




const Modalmr = document.getElementById('miModal_RECURSOSEMPLEADOS');
Modalmr.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_RECURSOS_EMPLEADOS = 0;
    document.getElementById('formularioRECURSOSEMPLEADO').reset();



    $('#FECHA_ESTIMADA').hide();
    $('#SOLIDA_ALMACEN').hide();
    $('#PERMISO_AUSENCIA').hide();
    $('#SOLICITUD_VACACIONES').hide();

    
    


    $('#VISTO_BUENO_JEFE').hide();
    $('#APROBACION_DIRECCION').hide();
    $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    $('#BOTON_VISTO_BUENO').hide();

    $('#guardaRECEMPLEADOS').show();



    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;
});







$("#NUEVO_RECUROSEMPLEADO").click(function (e) {
    e.preventDefault();


       
    $('#formularioRECURSOSEMPLEADO').each(function(){
        this.reset();
    });

    $(".materialesdiv").empty();


    $("#miModal_RECURSOSEMPLEADOS").modal("show");


    $.get('/obtenerAreaSolicitante', function(response) {
    if (response.area) {
        $("#AREA_SOLICITANTE_MR").val(response.area);
    } else {
        $("#AREA_SOLICITANTE_MR").val("Área no encontrada");
        }
        
        });

    
     $.get('/obtenerDatosPermiso', function (response) {
        if (response.cargo) {
            $("#CARGO_PERMISO").val(response.cargo);
        }
        if (response.numero_empleado) {
            $("#NOEMPLEADO_PERMISO").val(response.numero_empleado);
        }
     });
    
    

    

   
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
    
            <div class="col-1 mt-2">
                <label class="form-label">N°</label>
                <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
            </div>
            <div class="col-8 mt-2">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="DESCRIPCION" required>
            </div>
            <div class="col-1 mt-2">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="CANTIDAD" required>
            </div>
           
            <div class="col-2 mt-3">
                 <br>
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
    
    













$("#guardaRECEMPLEADOS").click(function (e) {
    e.preventDefault();

        formularioValido = validarFormulario3($('#formularioRECURSOSEMPLEADO'))

    
    if (formularioValido) {

        
        var documentos = [];
        $(".material-item").each(function() {
            var documento = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                'UNIDAD_MEDIDA': $(this).find("input[name='UNIDAD_MEDIDA']").val(),
                'CHECK_VO': $(this).find("select[name='CHECK_VO']").val(),
                'CATEGORIA_MATERIAL': $(this).find("select[name='CATEGORIA_MATERIAL']").val(),
                'CHECK_MATERIAL': $(this).find("select[name='CHECK_MATERIAL']").val()


            };
            documentos.push(documento);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_RECURSOS_EMPLEADOS: ID_FORMULARIO_RECURSOS_EMPLEADOS,
            MATERIALES_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_RECURSOS_EMPLEADOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {

        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_RECURSOS_EMPLEADOS = data.mr.ID_FORMULARIO_RECURSOS_EMPLEADOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RECURSOSEMPLEADOS').modal('hide')
                    document.getElementById('formularioRECURSOSEMPLEADO').reset();
                    Tablamr.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_RECURSOS_EMPLEADOS = data.mr.ID_FORMULARIO_RECURSOS_EMPLEADOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RECURSOSEMPLEADOS').modal('hide')
                    document.getElementById('formularioRECURSOSEMPLEADO').reset();
                    Tablamr.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablamr = $("#Tablamr").DataTable({
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
        url: '/Tablamr',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamr.columns.adjust().draw();
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
    { data: 'ESTADO_REVISION' }, 
    { data: 'ESTATUS' },          
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Nombre del solicitante', className: 'all text-center' },
    { targets: 2, title: 'N° MR', className: 'all text-center' },
    { targets: 3, title: 'Fecha solicitud', className: 'all text-center' },
    { targets: 4, title: 'Vo. Bo ', className: 'all text-center' },
    { targets: 5, title: 'Estatus', className: 'all text-center' }, 
    { targets: 6, title: 'Editar', className: 'all text-center' },
    { targets: 7, title: 'Visualizar', className: 'all text-center' },

]

});




$(document).ready(function() {
    $('#Tablamr tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamr.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_RECURSOSEMPLEADOS');

        ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;
        


        
        cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    

     if (row.data().DAR_BUENO === "1") {
        $('#VISTO_BUENO_JEFE').show();
         $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
         $('#BOTON_VISTO_BUENO').hide();
         $('#guardaRECEMPLEADOS').hide();

      
    } else if (row.data().DAR_BUENO === "2") {
        $('#VISTO_BUENO_JEFE').show();
         $('#MOTIVO_RECHAZO_JEFE_DIV').show();
         $('#guardaRECEMPLEADOS').show();
         
        
     } else {
         $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
       
          
    }


   if (row.data().ESTADO_APROBACION === "Aprobada") {
         $('#motivo-rechazo-container').hide();   
         $('#APROBACION_DIRECCION').show();
         $('#guardaRECEMPLEADOS').hide();

    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
         $('#guardaRECEMPLEADOS').hide();
                 
     } else {
       
          
    }

    


    });

    $('#miModal_RECURSOSEMPLEADOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RECURSOSEMPLEADOS');
    });
});




$('#Tablamr tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamr.row(tr);
    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;


        // cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    

     if (row.data().DAR_BUENO === "1") {
        $('#VISTO_BUENO_JEFE').show();
         $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
         $('#BOTON_VISTO_BUENO').hide();
         $('#guardaRECEMPLEADOS').hide();

      
    } else if (row.data().DAR_BUENO === "2") {
        $('#VISTO_BUENO_JEFE').show();
         $('#MOTIVO_RECHAZO_JEFE_DIV').show();
         $('#guardaRECEMPLEADOS').show();
         
        
     } else {
         $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
       
          
    }


   if (row.data().ESTADO_APROBACION === "Aprobada") {
         $('#motivo-rechazo-container').hide();   
         $('#APROBACION_DIRECCION').show();
         $('#guardaRECEMPLEADOS').hide();

    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
         $('#guardaRECEMPLEADOS').hide();
                 
     } else {
       
          
    }
  
});



function cargarMaterialesDesdeJSON(materialesJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    try {
        const materiales = JSON.parse(materialesJson);

        materiales.forEach(material => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('material-item', 'mt-2');

            divMaterial.innerHTML = `
                <div class="row p-3 rounded">

                    <div class="col-1">
                        <label class="form-label">Aprobado</label>
                        <select class="form-select" name="CHECK_MATERIAL" disabled>
                            <option value=""></option>
                            <option value="SI" ${material.CHECK_MATERIAL === 'SI' ? 'selected' : ''}>Sí</option>
                            <option value="NO" ${material.CHECK_MATERIAL === 'NO' ? 'selected' : ''}>No</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label">Línea de Negocios</label>
                        <select class="form-select" name="CATEGORIA_MATERIAL" disabled>
                            <option value="">Seleccionar</option>
                            <option value="STE" ${material.CATEGORIA_MATERIAL === 'STE' ? 'selected' : ''}>STE</option>
                            <option value="SST" ${material.CATEGORIA_MATERIAL === 'SST' ? 'selected' : ''}>SST</option>
                            <option value="SCA" ${material.CATEGORIA_MATERIAL === 'SCA' ? 'selected' : ''}>SCA</option>
                            <option value="SMA" ${material.CATEGORIA_MATERIAL === 'SMA' ? 'selected' : ''}>SMA</option>
                            <option value="SLH" ${material.CATEGORIA_MATERIAL === 'SLH' ? 'selected' : ''}>SLH</option>
                            <option value="ADM" ${material.CATEGORIA_MATERIAL === 'ADM' ? 'selected' : ''}>ADM</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <label class="form-label">Vo. Bo</label>
                        <select class="form-select" name="CHECK_VO" disabled>
                            <option value=""></option>
                            <option value="SI" ${material.CHECK_VO === 'SI' ? 'selected' : ''}>Sí</option>
                            <option value="NO" ${material.CHECK_VO === 'NO' ? 'selected' : ''}>No</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2 text-end">
                        <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
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
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}








document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="MATERIAL_RETORNA_SALIDA"]');
    const fechaDiv = document.getElementById("FECHA_ESTIMADA");
    const fechaInput = document.getElementById("FECHA__ESTIMADA_SALIDA");

    radios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "Sí") {
                fechaDiv.style.display = "inline-flex"; 
                fechaInput.setAttribute("required", "required");
            } else {
                fechaDiv.style.display = "none"; 
                fechaInput.removeAttribute("required");
                fechaInput.value = "";
            }
        });
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("TIPO_SOLICITUD");

    const divs = {
        "1": document.getElementById("PERMISO_AUSENCIA"),
        "2": document.getElementById("SOLIDA_ALMACEN"),
        "3": document.getElementById("SOLICITUD_VACACIONES")
    };

    select.addEventListener("change", function () {
        Object.values(divs).forEach(div => {
            div.style.display = "none";

            div.querySelectorAll("input, select, textarea").forEach(el => {
                if (el.id === "SOLICITANTE_SALIDA" || el.id === "SOLICITANTE_PERMISO") {
                    return; 
                }

                if (el.type === "radio" || el.type === "checkbox") {
                    el.checked = false;
                } else {
                    el.value = "";
                }
            });
        });


        if (divs[this.value]) {
            divs[this.value].style.display = "block";
        }

        

        if (this.value === "1") {
            $.get('/obtenerDatosPermiso', function (response) {
                if (response.cargo) {
                    $("#CARGO_PERMISO").val(response.cargo);
                }
                if (response.numero_empleado) {
                    $("#NOEMPLEADO_PERMISO").val(response.numero_empleado);
                }
            });
        }
    });
});