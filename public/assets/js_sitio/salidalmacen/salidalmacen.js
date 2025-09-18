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
    $('#VISTO_BUENO_JEFE').hide();
    
    $('#APROBACION_DIRECCION').hide();
    $('#DIV_FIRMA_ALMACENISTA').hide();


    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;




const inputFecha = document.getElementById("FECHA_ALMACEN_SOLICITUD");
    if (inputFecha) {
        inputFecha.classList.remove("is-invalid"); 
    }

    if (typeof Swal !== "undefined") {
        Swal.close();
    }
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
                'EN_EXISTENCIA': $(this).find("select[name='EN_EXISTENCIA']").val(),
                'TIPO_INVENTARIO': $(this).find("select[name='TIPO_INVENTARIO']").val(),
                'INVENTARIO': $(this).find("select[name='INVENTARIO']").val(),
                'CANTIDAD_SALIDA': $(this).find("input[name='CANTIDAD_SALIDA']").val(),
                'NOTA_CANTIDAD': $(this).find("textarea[name='NOTA_CANTIDAD']").val()



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
            await ajaxAwaitFormData(requestData,'SalidalmacenSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {

        
               

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
                    Tablasalidalmacen.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'SalidalmacenSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablasalidalmacen.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablasalidalmacen = $("#Tablasalidalmacen").DataTable({
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
        url: '/Tablasalidalmacen',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablasalidalmacen.columns.adjust().draw();
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
    { data: 'ESTATUS' },          
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Tipo de solicitud', className: 'all text-center' },
    { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' }, 
    { targets: 3, title: 'Fecha de solicitud', className: 'all text-center' },
    { targets: 4, title: 'Estatus', className: 'all text-center' }, 
    { targets: 5, title: 'Editar', className: 'all text-center' },
    { targets: 6, title: 'Visualizar', className: 'all text-center' },

]

});




$(document).ready(function() {
    $('#Tablasalidalmacen tbody').on('click', 'td>button.VISUALIZAR', function () {


    var tr = $(this).closest('tr');
    var row = Tablasalidalmacen.row(tr);
    
    hacerSoloLectura(row.data(), '#miModal_RECURSOSEMPLEADOS');

    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;
        
    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);


    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    

     
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

    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
   if (row.data().DAR_BUENO == 1) { 
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();

    } else if (row.data().DAR_BUENO == 2) {
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();

    } else {
        $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    }

    if (row.data().ESTADO_APROBACION === "Aprobada") {
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').show();
    
    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
                    
    } else {
    
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').hide();
    }


   if (row.data().FIRMO_ALMACENISTA === "1") {
        $('#DIV_FIRMAR_ALMACEN').hide();
    } else  {
        $('#DIV_FIRMAR_ALMACEN').show();
    } 

        
        
    });

    $('#miModal_RECURSOSEMPLEADOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RECURSOSEMPLEADOS');
    });
});




$('#Tablasalidalmacen tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasalidalmacen.row(tr);
    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;


    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    
    
    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    


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

    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
   if (row.data().DAR_BUENO == 1) { 
       $('#VISTO_BUENO_JEFE').show();
       $('#MOTIVO_RECHAZO_JEFE_DIV').hide();

    } else if (row.data().DAR_BUENO == 2) {
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();

    } else {
        $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    }

    if (row.data().ESTADO_APROBACION === "Aprobada") {
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').show();
    
    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
                    
    } else {
       
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').hide();
    }

   
  

   if (row.data().FIRMO_ALMACENISTA === "1") {
        $('#DIV_FIRMAR_ALMACEN').hide();
    } else  {
        $('#DIV_FIRMAR_ALMACEN').show();
    } 


});






// function cargarMaterialesDesdeJSON(materialesJson) {
//     const contenedorMateriales = document.querySelector('.materialesdiv');
//     contenedorMateriales.innerHTML = '';
//     contadorMateriales = 1;

//     try {
//         const materiales = JSON.parse(materialesJson);

//         materiales.forEach(material => {
//             const divMaterial = document.createElement('div');
//             divMaterial.classList.add('material-item', 'mt-2');

//             // --- HTML principal ---
//             divMaterial.innerHTML = `
//                 <div class="row p-3 rounded">
//                     <div class="col-1 mt-2">
//                         <label class="form-label">N°</label>
//                         <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
//                     </div>
//                     <div class="col-7 mt-2">
//                         <label class="form-label">Descripción</label>
//                         <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
//                     </div>
//                     <div class="col-1 mt-2">
//                         <label class="form-label">Cantidad</label>
//                         <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
//                     </div>
//                     <div class="col-3 mt-2">
//                         <label class="form-label">¿El material o equipo retorna?*</label>
//                         <select class="form-control retorna_material" name="RETORNA_EQUIPO" required>
//                             <option value="0" disabled>Seleccione una opción</option>
//                             <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
//                             <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
//                         </select>
//                     </div>

//                     <!-- En existencia -->
//                     <div class="col-4 mt-2">
//                         <label class="form-label">En existencia</label>
//                         <select class="form-control en_existencia" name="EN_EXISTENCIA" >
//                             <option value="" ${!material.EN_EXISTENCIA ? "selected" : ""} disabled>Seleccione una opción</option>
//                             <option value="1" ${material.EN_EXISTENCIA === "1" ? "selected" : ""}>Sí</option>
//                             <option value="0" ${material.EN_EXISTENCIA === "0" ? "selected" : ""}>No</option>
//                         </select>
//                     </div>

//                     <!-- Tipo inventario -->
//                     <div class="col-4 mt-2">
//                         <label class="form-label">Tipo inventario</label>
//                         <select class="form-control tipo_inventario" name="TIPO_INVENTARIO" >
//                             <option value="" ${!material.TIPO_INVENTARIO ? "selected" : ""} disabled>Seleccione una opción</option>
//                             ${window.tipoinventario.map(t => `
//                                 <option value="${t.DESCRIPCION_TIPO}" ${material.TIPO_INVENTARIO === t.DESCRIPCION_TIPO ? "selected" : ""}>
//                                     ${t.DESCRIPCION_TIPO}
//                                 </option>
//                             `).join('')}
//                         </select>
//                     </div>

//                     <!-- Inventario -->
//                     <div class="col-4 mt-2">
//                         <label class="form-label">Inventario</label>
//                         <select class="form-control inventario" name="INVENTARIO" >
//                             <option value="" ${!material.INVENTARIO ? "selected" : ""} disabled>Seleccione inventario</option>
//                         </select>
//                     </div>
//                 </div>
//             `;

//             contenedorMateriales.appendChild(divMaterial);
//             contadorMateriales++;

//             // === Selectores ===
//             const selectEnExistencia = divMaterial.querySelector('.en_existencia');
//             const selectTipo = divMaterial.querySelector('.tipo_inventario');
//             const selectInv = divMaterial.querySelector('.inventario');

//             // Función para cargar inventario en orden alfabético
//             function cargarInventario(tipoSeleccionado, valorGuardado = null) {
//                 const opciones = window.inventario
//                     .filter(inv => inv.TIPO_EQUIPO === tipoSeleccionado)
//                     .sort((a, b) => a.DESCRIPCION_EQUIPO.localeCompare(b.DESCRIPCION_EQUIPO))
//                     .map(inv => `
//                         <option value="${inv.ID_FORMULARIO_INVENTARIO}"
//                             ${valorGuardado == inv.ID_FORMULARIO_INVENTARIO ? "selected" : ""}>
//                             ${inv.DESCRIPCION_EQUIPO}
//                         </option>
//                     `).join('');

//                 selectInv.innerHTML = `
//                     <option value="" disabled ${!valorGuardado ? "selected" : ""}>Seleccione inventario</option>
//                     ${opciones}
//                 `;
//             }

//             // Inicializar inventario si ya hay datos guardados
//             if (material.TIPO_INVENTARIO) {
//                 cargarInventario(material.TIPO_INVENTARIO, material.INVENTARIO);
//             }

//             // Evento cambio tipo inventario
//             selectTipo.addEventListener('change', function () {
//                 cargarInventario(this.value);
//             });

//             // Activar/desactivar inventario según "En existencia"
//             function actualizarEstadoInventario() {
//                 if (selectEnExistencia.value === "0") { // No
//                     selectTipo.style.pointerEvents = "none";
//                     selectTipo.style.backgroundColor = "#e9ecef";
//                     selectInv.style.pointerEvents = "none";
//                     selectInv.style.backgroundColor = "#e9ecef";
//                 } else { // Sí
//                     selectTipo.style.pointerEvents = "auto";
//                     selectTipo.style.backgroundColor = "";
//                     selectInv.style.pointerEvents = "auto";
//                     selectInv.style.backgroundColor = "";
//                 }
//             }

//             // Inicializar estado
//             actualizarEstadoInventario();

//             // Listener en existencia
//             selectEnExistencia.addEventListener('change', actualizarEstadoInventario);
//         });

//         revisarSelects();

//     } catch (e) {
//         console.error('Error al parsear MATERIALES_JSON:', e);
//     }
// }



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
                    <div class="col-7 mt-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1 mt-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control cantidad_original" name="CANTIDAD" value="${material.CANTIDAD}" required>
                    </div>
                     <div class="col-3 mt-2">
                         <label class="form-label">¿El material o equipo retorna?*</label>
                         <select class="form-control retorna_material" name="RETORNA_EQUIPO" required>
                             <option value="0" disabled>Seleccione una opción</option>
                             <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
                             <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
                         </select>
                   </div>
                    <div class="col-2 mt-2">
                        <label class="form-label">En existencia</label>
                        <select class="form-control en_existencia" name="EN_EXISTENCIA" required>
                            <option value="" ${!material.EN_EXISTENCIA ? "selected" : ""} disabled>Seleccione</option>
                            <option value="1" ${material.EN_EXISTENCIA === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${material.EN_EXISTENCIA === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>
                    <div class="col-2 mt-2">
                        <label class="form-label">Tipo inventario</label>
                        <select class="form-control tipo_inventario" name="TIPO_INVENTARIO" required>
                            <option value="" ${!material.TIPO_INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                            ${window.tipoinventario.map(t => `
                                <option value="${t.DESCRIPCION_TIPO}" ${material.TIPO_INVENTARIO === t.DESCRIPCION_TIPO ? "selected" : ""}>
                                    ${t.DESCRIPCION_TIPO}
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="col-5 mt-2">
                        <label class="form-label">Inventario</label>
                        <select class="form-control inventario" name="INVENTARIO" required>
                            <option value="" ${!material.INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-3 mt-2">
                        <label class="form-label">Cantidad que sale de almacén</label>
                        <input type="number" class="form-control cantidad_salida" name="CANTIDAD_SALIDA" value="${material.CANTIDAD_SALIDA || ''}">
                    </div>
                    <div class="col-12 mt-2 nota_div" style="display: none;">
                        <label class="form-label">Nota (explique por qué no es la misma cantidad)</label>
                        <textarea class="form-control nota_cantidad" name="NOTA_CANTIDAD">${material.NOTA_CANTIDAD || ''}</textarea>
                    </div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);
            contadorMateriales++;

            // === Selectores ===
            const selectEnExistencia = divMaterial.querySelector('.en_existencia');
            const selectTipo = divMaterial.querySelector('.tipo_inventario');
            const selectInv = divMaterial.querySelector('.inventario');
            const inputCantidad = divMaterial.querySelector('.cantidad_original');
            const inputSalida = divMaterial.querySelector('.cantidad_salida');
            const divNota = divMaterial.querySelector('.nota_div');
            const textareaNota = divMaterial.querySelector('.nota_cantidad');

            // function cargarInventario(tipoSeleccionado, valorGuardado = null) {
            //     const opciones = window.inventario
            //         .filter(inv => inv.TIPO_EQUIPO === tipoSeleccionado)
            //         .sort((a, b) => a.DESCRIPCION_EQUIPO.localeCompare(b.DESCRIPCION_EQUIPO))
            //         .map(inv => `
            //             <option value="${inv.ID_FORMULARIO_INVENTARIO}" 
            //                 ${valorGuardado == inv.ID_FORMULARIO_INVENTARIO ? "selected" : ""}>
            //                 ${inv.DESCRIPCION_EQUIPO}
            //             </option>
            //         `).join('');

            //     selectInv.innerHTML = `
            //         <option value="" disabled ${!valorGuardado ? "selected" : ""}>Seleccione inventario</option>
            //         ${opciones}
            //     `;
            // }

            
            function cargarInventario(tipoSeleccionado, valorGuardado = null) {
                const opciones = window.inventario
                    .filter(inv => inv.TIPO_EQUIPO === tipoSeleccionado)
                    .sort((a, b) => a.DESCRIPCION_EQUIPO.localeCompare(b.DESCRIPCION_EQUIPO))
                    .map(inv => {
                        // Si el tipo es AF o ANF -> mostrar con código
                        const mostrarTexto = (tipoSeleccionado === "AF" || tipoSeleccionado === "ANF")
                            ? `${inv.DESCRIPCION_EQUIPO} (${inv.CODIGO_EQUIPO || ""})`
                            : inv.DESCRIPCION_EQUIPO;

                        return `
                            <option value="${inv.ID_FORMULARIO_INVENTARIO}" 
                                ${valorGuardado == inv.ID_FORMULARIO_INVENTARIO ? "selected" : ""}>
                                ${mostrarTexto}
                            </option>
                        `;
                    }).join('');

                selectInv.innerHTML = `
                    <option value="" disabled ${!valorGuardado ? "selected" : ""}>Seleccione inventario</option>
                    ${opciones}
                `;
            }

            
            
            if (material.TIPO_INVENTARIO) {
                cargarInventario(material.TIPO_INVENTARIO, material.INVENTARIO);
            }

            selectTipo.addEventListener('change', function () {
                cargarInventario(this.value);
            });

            // Activar/desactivar inventario y cantidad salida según existencia
            function actualizarEstadoInventario() {
                if (selectEnExistencia.value === "0") { // No
                    selectTipo.style.pointerEvents = "none";
                    selectTipo.style.backgroundColor = "#e9ecef";
                    selectInv.style.pointerEvents = "none";
                    selectInv.style.backgroundColor = "#e9ecef";
                    inputSalida.disabled = true;
                    inputSalida.removeAttribute("required");

                    // ocultar nota siempre si no hay existencia
                    divNota.style.display = "none";
                    textareaNota.required = false;

                } else { // Sí
                    selectTipo.style.pointerEvents = "auto";
                    selectTipo.style.backgroundColor = "";
                    selectInv.style.pointerEvents = "auto";
                    selectInv.style.backgroundColor = "";
                    inputSalida.disabled = false;
                    inputSalida.setAttribute("required", true);

                    revisarCantidadSalida(); // revisar diferencias al activar
                }
            }

            actualizarEstadoInventario();
            selectEnExistencia.addEventListener('change', actualizarEstadoInventario);

            // Mostrar textarea solo si hay existencia y cantidades diferentes
            function revisarCantidadSalida() {
                if (
                    selectEnExistencia.value === "1" && // Solo cuando hay existencia
                    parseInt(inputSalida.value || 0) !== parseInt(inputCantidad.value || 0)
                ) {
                    divNota.style.display = "block";
                    textareaNota.required = true;
                } else {
                    divNota.style.display = "none";
                    textareaNota.required = false;
                }
            }

            revisarCantidadSalida();
            inputSalida.addEventListener('input', revisarCantidadSalida);
        });

        revisarSelects();

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}






function revisarSelects() {
    const selects = document.querySelectorAll('.retorna_material');
    let mostrar = false;
    selects.forEach(sel => {
        if (sel.value === "1") { 
            mostrar = true;
        }
    });
    document.getElementById("FECHA_ESTIMADA").style.display = mostrar ? "block" : "none";
}










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








// document.addEventListener("DOMContentLoaded", function () {
//     const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_ALMACEN");
//     const inputFirmo = document.getElementById("FIRMO_ALMACENISTA");
//     const inputFirmadoPor = document.getElementById("FIRMA_ALMACEN");
//     const inputFechaSalida = document.getElementById("FECHA_ALMACEN_SOLICITUD");

//     btnFirmar.addEventListener("click", function () {
//         let usuarioNombre = btnFirmar.getAttribute("data-usuario");
//         let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

//         // Obtener hora actual
//         let ahora = new Date();
//         let horas = ahora.getHours();
//         let minutos = String(ahora.getMinutes()).padStart(2, "0");
//         let segundos = String(ahora.getSeconds()).padStart(2, "0");

//         // Determinar AM o PM
//         let ampm = horas >= 12 ? "p.m." : "a.m.";

//         // Convertir a formato de 12 horas
//         horas = horas % 12;
//         horas = horas ? horas : 12; // El 0 se convierte en 12

//         let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

//         // Asignar valores
//         inputFirmo.value = "1";
//         inputFirmadoPor.value =  usuarioNombre + " el " + fechaSalida ;
//     });
// });



document.addEventListener("DOMContentLoaded", function () {
    const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_ALMACEN");
    const inputFirmo = document.getElementById("FIRMO_ALMACENISTA");
    const inputFirmadoPor = document.getElementById("FIRMA_ALMACEN");
    const inputFechaSalida = document.getElementById("FECHA_ALMACEN_SOLICITUD");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");
        let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

        // Validar que exista fecha
        if (!fechaSalida) {
            alert("Debe ingresar la fecha antes de firmar la solicitud.");

            // Marcar el input en rojo
            inputFechaSalida.classList.add("is-invalid");

            // Quitar el rojo automáticamente cuando empiece a escribir
            inputFechaSalida.addEventListener("input", function () {
                if (this.value) {
                    this.classList.remove("is-invalid");
                }
            });

            return; // detener ejecución
        }

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
        inputFirmadoPor.value = usuarioNombre + " el " + fechaSalida ;
    });
});



