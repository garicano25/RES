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
    $('#EXPLIQUE_PERMISO').hide();
    $('#DIV_FIRMAR').show();
    $('#MOTIVO_RECHAZO_JEFE_DIV').hide();


    

    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;
});










let contadorMateriales = 1; 



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
                'RETORNA_EQUIPO': $(this).find("select[name='RETORNA_EQUIPO']").val(),


            };
            documentos.push(documento);
        });

        const requestData = {
            api: 2,
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
            await ajaxAwaitFormData(requestData,'RecempleadoSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {

        
               

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
                    Tablarecempleadovobo.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'RecempleadoSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablarecempleadovobo.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablarecempleadovobo = $("#Tablarecempleadovobo").DataTable({
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
        url: '/Tablarecempleadovobo',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarecempleadovobo.columns.adjust().draw();
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
    { data: 'TIPO_SOLICITUD_TEXTO' },
    { data: 'SOLICITANTE_SALIDA' },    
    { data: 'FECHA_SALIDA' },    
    { data: 'ESTADO_REVISION' }, 
    { data: 'ESTATUS' },          
    { data: 'BTN_EDITAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Tipo de solicitud', className: 'all text-center' },
    { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' }, 
    { targets: 3, title: 'Fecha de solicitud', className: 'all text-center' },
    { targets: 4, title: 'Vo. Bo ', className: 'all text-center' },
    { targets: 5, title: 'Estatus', className: 'all text-center' }, 
    { targets: 6, title: 'Editar', className: 'all text-center' },
]

});




$(document).ready(function() {
    $('#Tablarecempleadovobo tbody').on('click', 'td>button.VISUALIZAR', function () {


        var tr = $(this).closest('tr');
        var row = Tablarecempleadovobo.row(tr);
    
        hacerSoloLectura(row.data(), '#miModal_RECURSOSEMPLEADOS');

        ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;
        


        
        cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
        editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    

        
        
        // === Para TIPO_SOLICITUD ===
        if (row.data().TIPO_SOLICITUD === "1") {
            $('#PERMISO_AUSENCIA').show();
            $('#SOLIDA_ALMACEN').hide();
            $('#SOLICITUD_VACACIONES').hide();
        } else if (row.data().TIPO_SOLICITUD === "2") {
            $('#SOLIDA_ALMACEN').show();
            $('#PERMISO_AUSENCIA').hide();
            $('#SOLICITUD_VACACIONES').hide();
        } else if (row.data().TIPO_SOLICITUD === "3") {
            $('#SOLICITUD_VACACIONES').show();
            $('#PERMISO_AUSENCIA').hide();
            $('#SOLIDA_ALMACEN').hide();
        }

        // === Para CONCEPTO_PERMISO ===
        if (row.data().CONCEPTO_PERMISO === "9") {
            $('#EXPLIQUE_PERMISO').show();
        } else {
            $('#EXPLIQUE_PERMISO').hide();
        }

        // === Para MATERIAL_RETORNA_SALIDA ===
        if (row.data().MATERIAL_RETORNA_SALIDA === "Sí") {
            $('#FECHA_ESTIMADA').css("display", "inline-flex");
        } else {
            $('#FECHA_ESTIMADA').hide();
        }

        // === Para ocultar la firma si ya esta firmado ===

        if (row.data().FIRMO_USUARIO === "1") {
            $('#DIV_FIRMAR').hide();
        } else  {
              $('#DIV_FIRMAR').show();
            } 
        
        
        
//      if (row.data().DAR_BUENO === "1") {
//         $('#VISTO_BUENO_JEFE').show();
//          $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
//          $('#BOTON_VISTO_BUENO').hide();
//          $('#guardaRECEMPLEADOS').hide();

      
//     } else if (row.data().DAR_BUENO === "2") {
//         $('#VISTO_BUENO_JEFE').show();
//          $('#MOTIVO_RECHAZO_JEFE_DIV').show();
//          $('#guardaRECEMPLEADOS').show();
         
        
//      } else {
//          $('#VISTO_BUENO_JEFE').hide();
//         $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
       
          
//     }


//    if (row.data().ESTADO_APROBACION === "Aprobada") {
//          $('#motivo-rechazo-container').hide();   
//          $('#APROBACION_DIRECCION').show();
//          $('#guardaRECEMPLEADOS').hide();

//     } else if (row.data().ESTADO_APROBACION === "Rechazada") {
//         $('#APROBACION_DIRECCION').show();
//         $('#motivo-rechazo-container').show();
//          $('#guardaRECEMPLEADOS').hide();
                 
//      } else {
       
          
//     }

    


    });

    $('#miModal_RECURSOSEMPLEADOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RECURSOSEMPLEADOS');
    });
});




$('#Tablarecempleadovobo tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarecempleadovobo.row(tr);
    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;


    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    


                // === Para TIPO_SOLICITUD ===
    if (row.data().TIPO_SOLICITUD === "1") {
        $('#PERMISO_AUSENCIA').show();
        $('#SOLIDA_ALMACEN').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "2") {
        $('#SOLIDA_ALMACEN').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "3") {
        $('#SOLICITUD_VACACIONES').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLIDA_ALMACEN').hide();
    }

    // === Para CONCEPTO_PERMISO ===
    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

    // === Para MATERIAL_RETORNA_SALIDA ===
    if (row.data().MATERIAL_RETORNA_SALIDA === "Sí") {
        $('#FECHA_ESTIMADA').css("display", "inline-flex");
    } else {
        $('#FECHA_ESTIMADA').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
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

                 
                    <div class="col-1 mt-2">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>
                    <div class="col-5 mt-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1 mt-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
                    </div>
                     <div class="col-3 mt-2">
                        <label class="form-label">¿El material y/o equipo retorna? *</label>
                        <select class="form-control" name="RETORNA_EQUIPO" required>
                            <option value="0" disabled>Seleccione una opción</option>
                            <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
                            <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
                        </select>
                    </div>

                        <div class="col-2 mt-3">
                            <br>
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
    const btnFirmar = document.getElementById("FIRMAR_SOLICITUD");
    const inputFirmo = document.getElementById("FIRMO_USUARIO");
    const inputFirmadoPor = document.getElementById("FIRMADO_POR");
    const inputFechaSalida = document.getElementById("FECHA_SALIDA");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");
        let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

        // Obtener hora actual
        let ahora = new Date();
        let horas = ahora.getHours();
        let minutos = String(ahora.getMinutes()).padStart(2, "0");
        let segundos = String(ahora.getSeconds()).padStart(2, "0");

        // Determinar AM o PM
        let ampm = horas >= 12 ? "p.m." : "a.m.";

        // Convertir a formato de 12 horas
        horas = horas % 12;
        horas = horas ? horas : 12; // El 0 se convierte en 12

        let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

        // Asignar valores
        inputFirmo.value = "1";
        inputFirmadoPor.value =  usuarioNombre + " el " + fechaSalida ;
    });
});







document.addEventListener("DOMContentLoaded", function () {
    const selectConcepto = document.getElementById("DAR_BUENO");
    const divExplique = document.getElementById("MOTIVO_RECHAZO_JEFE_DIV");

    selectConcepto.addEventListener("change", function () {
        if (this.value === "2") {
            divExplique.style.display = "block";
            divExplique.querySelector("textarea").setAttribute("required", "required");
        } else {
            divExplique.style.display = "none";
            const textarea = divExplique.querySelector("textarea");
            textarea.value = "";
            textarea.removeAttribute("required");
        }
    });
});






document.addEventListener("DOMContentLoaded", function () {
    const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_JEFE");
    const inputFirmo = document.getElementById("FIRMO_JEFE");
    const inputFirmadoPor = document.getElementById("VISTO_BUENO");
    const inputFechaSalida = document.getElementById("FECHA_VISTO_SOLICITUD");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");
        let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

        // Obtener hora actual
        let ahora = new Date();
        let horas = ahora.getHours();
        let minutos = String(ahora.getMinutes()).padStart(2, "0");
        let segundos = String(ahora.getSeconds()).padStart(2, "0");

        // Determinar AM o PM
        let ampm = horas >= 12 ? "p.m." : "a.m.";

        // Convertir a formato de 12 horas
        horas = horas % 12;
        horas = horas ? horas : 12; // El 0 se convierte en 12

        let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

        // Asignar valores
        inputFirmo.value = "1";
        inputFirmadoPor.value = "Por" +" " + usuarioNombre + " el " + fechaSalida + " a las " + horaCompleta;
    });
});


