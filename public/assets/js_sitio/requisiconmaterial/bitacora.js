ID_FORMULARIO_MR = 0




const Modalmr = document.getElementById('miModal_MR');
Modalmr.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_MR = 0;
    document.getElementById('formularioMR').reset();

    
        document.getElementById('DAR_BUENO').value = "0"; 


        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
   
    $('#motivo-rechazo-container').hide();


    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

});





var Tablabitacora = $("#Tablabitacora").DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    scrollX: true,
    autoWidth: false,
    responsive: false,
    paging: true,
    searching: true,
    info: false,
    lengthChange: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        method: 'GET',
        url: '/Tablabitacora',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacora.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
            { targets: '_all', className: 'text-center' }, // 👈 centra todo
        { targets: 0, width: '150px' },
        { targets: 1, width: '150px' },
        { targets: 2, width: '200px' },
        { targets: 3, width: '250px' },
        { targets: 4, width: '250px' },
        { targets: 5, width: '200px' },
        { targets: 6, width: '250px' },
        { targets: 7, width: '200px' },
        { targets: 8, width: '250px' },
        { targets: 9, width: '150px' },
        { targets: 10, width: '300px' },
        { targets: 11, width: '200px' },
        { targets: 12, width: '300px' },
        { targets: 13, width: '300px' },

    ],
    columns: [
        { data: 'BTN_EDITAR' },
        { data: 'BTN_NO_MR' },
        { data: 'NO_MR' },
        { data: 'FECHA_SOLICITUD_MR' },
        { data: 'SOLICITANTE_MR' },
        { data: 'AREA_SOLICITANTE_MR' },
        { data: 'FECHA_VISTO_MR' },
        { data: 'VISTO_BUENO' },
        { data: 'FECHA_APRUEBA_MR' },
        { data: 'QUIEN_APROBACION' },
        { data: 'PRIORIDAD_MR' },

        {
            data: null,
            render: () => `
                <select class="form-select" style="width: 100%">
                    <option value="">Seleccionar</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Canceladas">Canceladas</option>
                    <option value="Finalizada">Finalizada</option>
                </select>`
        },
        {
            data: null,
            render: () => `<textarea type="text" class="form-control" style="width: 100%" rowas="5"></textarea>`
        },
        {
            data: null,
            render: () => `<input type="date" class="form-control" style="width: 100%">`
        },
          { data: 'MATERIALES_JSON', visible: false }, 
    { data: 'ESTADO_APROBACION', visible: false } 
        
       
    ]
});










$('#Tablabitacora tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablabitacora.row(tr);
    ID_FORMULARIO_MR = row.data().ID_FORMULARIO_MR;

    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);



    editarDatoTabla(row.data(), 'formularioMR', 'miModal_MR', 1);

    var nombreAutenticado = $('meta[name="usuario-autenticado"]').attr('content');
    if (!row.data().VISTO_BUENO) {
        $('#VISTO_BUENO').val(nombreAutenticado);
    } else {
        $('#VISTO_BUENO').val(row.data().VISTO_BUENO);
    }


       if (row.data().ESTADO_APROBACION === "Aprobada") {
         $('#motivo-rechazo-container').hide();
        $('#APROBACION_DIRECCION').show();
    
           
           
      } else {
          
        $('#motivo-rechazo-container').show();
        $('#APROBACION_DIRECCION').show();
           
      
    }


    if (row.data().DAR_BUENO === "1") {
        $('#BOTON_VISTO_BUENO').hide();

 
    } else if (row.data().DAR_BUENO === "2") {
         $('#BOTON_VISTO_BUENO').hide();
         
    
        
     } else {
         $('#BOTON_VISTO_BUENO').show();
       
          
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

            let colorClass = '';
           if (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL !== 'NO') {
                colorClass = 'bg-verde-suave';
            } else if (
                material.CHECK_VO === 'NO' ||
                (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL === 'NO')
            ) {
                colorClass = 'bg-rojo-suave';
            }

            divMaterial.innerHTML = `
                <div class="row p-3 rounded color-vo ${colorClass}">
                    <div class="col-1">
                        <label class="form-label">Aprobado</label>
                        <select class="form-select" name="CHECK_MATERIAL" disabled >
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
                        <input type="text" class="form-control" name="DESCRIPCION" value="${material.DESCRIPCION}" required>
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
                        <select class="form-select check-vo-select" name="CHECK_VO" disabled>
                            <option value=""></option>
                            <option value="SI" ${material.CHECK_VO === 'SI' ? 'selected' : ''}>Sí</option>
                            <option value="NO" ${material.CHECK_VO === 'NO' ? 'selected' : ''}>No</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2 text-end" style="display: none;">
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

            const selectVoBo = divMaterial.querySelector('.check-vo-select');
            const contenedorColor = divMaterial.querySelector('.color-vo');

            selectVoBo.addEventListener('change', function () {
                contenedorColor.classList.remove('bg-verde-suave', 'bg-rojo-suave');

                if (selectVoBo.value === 'SI') {
                    contenedorColor.classList.add('bg-verde-suave');
                } else if (selectVoBo.value === 'NO') {
                    contenedorColor.classList.add('bg-rojo-suave');
                }
            });
        });

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}



// $('#Tablabitacora tbody').on('click', 'td>button.VISUALIZAR', function () {






//     const row = Tablabitacora.row($(this).closest('tr')).data();
//     console.log("Fila seleccionada:", row); // 👈 Diagnóstico

//     if (row.ESTADO_APROBACION === null) {
//         alertToast('La MR aún no ha sido aprobada', 'warning');
//         return;
//     }
//     if (row.ESTADO_APROBACION === 'Rechazada') {
//         alertToast('La MR fue rechazada', 'error');
//         return;
//     }

//     try {
//         let materiales = [];

//         // Detecta si ya es un arreglo o hay que parsear
//         if (Array.isArray(row.MATERIALES_JSON)) {
//             materiales = row.MATERIALES_JSON;
//         } else if (typeof row.MATERIALES_JSON === 'string') {
//             materiales = JSON.parse(row.MATERIALES_JSON);
//         }

//         console.log("Materiales parseados:", materiales); // 👈 Confirma estructura

//         const listaFiltrada = materiales.filter(
//             m => m.CHECK_VO === 'SI' && m.CHECK_MATERIAL === 'SI'
//         );

//         let html = '';
//         if (listaFiltrada.length === 0) {
//             html = `<li class="list-group-item">No hay materiales aprobados disponibles.</li>`;
//         } else {
//             listaFiltrada.forEach(mat => {
//                 html += `<li class="list-group-item">${mat.DESCRIPCION}</li>`;
//             });
//         }

//         $('#listaMateriales').html(html);

//         const modal = new bootstrap.Modal(document.getElementById('modalMateriales'));
//         modal.show();
//     } catch (err) {
//         console.error('Error al procesar MATERIALES_JSON', err);
//         alertToast('Error al procesar los materiales', 'error');
//     }
// });



// Función para cargar la lista de materiales al modal



function inicializarDatepickers() {
  $('.mydatepicker').datepicker({
    format: 'yyyy-mm-dd', // Formato de fecha
                weekStart: 1, // Día que inicia la semana, 1 = Lunes
                autoclose: true, // Cierra automáticamente el calendario
                todayHighlight: true, // Marca el día de hoy en el calendario
                language: 'es' // Configura el idioma en español
  });
}


// $('#Tablabitacora tbody').on('click', 'td>button.VISUALIZAR', function () {
//   const row = Tablabitacora.row($(this).closest('tr')).data();

//   if (row.ESTADO_APROBACION === null) {
//       alertToast('La MR aún no ha sido aprobada', 'warning');
//       return;
//   }

//   if (row.ESTADO_APROBACION === 'Rechazada') {
//       alertToast('La MR fue rechazada', 'error');
//       return;
//   }

//   try {
//       let materiales = [];
//       if (Array.isArray(row.MATERIALES_JSON)) {
//           materiales = row.MATERIALES_JSON;
//       } else if (typeof row.MATERIALES_JSON === 'string') {
//           materiales = JSON.parse(row.MATERIALES_JSON);
//       }

//       const listaFiltrada = materiales.filter(m => m.CHECK_VO === 'SI' && m.CHECK_MATERIAL === 'SI');

//       $('#contenedorProductos').empty();
//       $('#preguntaProveedorUnico').removeClass('d-none');
//       $('#contenedorProductos').hide();

//       // Eliminar eventos anteriores para evitar múltiples asignaciones
//       $('#respuestaProveedorUnicoSi').off('click');
//       $('#respuestaProveedorUnicoNo').off('click');

//       const modal = new bootstrap.Modal(document.getElementById('modalMateriales'));
//       modal.show();

//       $('#noMRModal').text(row.NO_MR || 'No disponible');
// $('#inputNoMR').val(row.NO_MR || '');
    
//       if (listaFiltrada.length === 0) {
//           $('#contenedorProductos')
//               .html('<div class="alert alert-info">No hay materiales aprobados disponibles.</div>')
//               .show();
//           $('#preguntaProveedorUnico').addClass('d-none');
//           return;
//       }

//       // ✅ Opción SÍ: Un solo proveedor
//       $('#respuestaProveedorUnicoSi').on('click', function () {
//           $('#preguntaProveedorUnico').addClass('d-none');
//           $('#contenedorProductos').show();

//           const template = document.querySelector('#templateProducto');
//           const clon = document.importNode(template.content, true);

//           clon.querySelector('.producto-titulo').textContent = 'Materiales';

//           // Ocultar bloque de cantidad/unidad
//           const detalleCantidadUnidad = clon.querySelector('.detalle-cantidad-unidad');
//           if (detalleCantidadUnidad) {
//             detalleCantidadUnidad.style.setProperty('display', 'none', 'important');
//           }
//           // Insertar lista de materiales combinados
//           const descripcionDiv = clon.querySelector('.descripcion-materiales');
//           const listaHtml = listaFiltrada.map(m =>
//               `<li>${m.DESCRIPCION} (${m.CANTIDAD} ${m.UNIDAD_MEDIDA})</li>`
//           ).join('');
//           descripcionDiv.innerHTML = `<ul class="mb-0">${listaHtml}</ul>`;

//         $('#contenedorProductos').append(clon);
//         inicializarDatepickers(); // 👈 activa los datepickers
        
//       });

//       // ✅ Opción NO: Una tarjeta por material
//       $('#respuestaProveedorUnicoNo').on('click', function () {
//           $('#preguntaProveedorUnico').addClass('d-none');
//           $('#contenedorProductos').show();

//           listaFiltrada.forEach(material => {
//               const template = document.querySelector('#templateProducto');
//               const clon = document.importNode(template.content, true);

//               clon.querySelector('.producto-titulo').textContent = material.DESCRIPCION;
//               clon.querySelector('.producto-cantidad').textContent = material.CANTIDAD;
//               clon.querySelector('.producto-unidad').textContent = material.UNIDAD_MEDIDA;

//               // Eliminar descripción combinada en modo individual
//               const descripcionDiv = clon.querySelector('.descripcion-materiales');
//               if (descripcionDiv) {
//                   descripcionDiv.remove();
//               }

//             $('#contenedorProductos').append(clon);
//             inicializarDatepickers(); // 👈 activa los datepickers
//           });
//       });

//   } catch (err) {
//       console.error('Error al procesar MATERIALES_JSON', err);
//       alertToast('Error al procesar los materiales', 'error');
//   }



  
  

// });


$('#Tablabitacora tbody').on('click', 'td>button.VISUALIZAR', async function () {
  const row = Tablabitacora.row($(this).closest('tr')).data();
  const no_mr = row.NO_MR;

  if (!no_mr) {
    alertToast('No se encontró el número de MR.', 'error');
    return;
  }

  if (row.ESTADO_APROBACION === null) {
    alertToast('La MR aún no ha sido aprobada', 'warning');
    return;
  }

  if (row.ESTADO_APROBACION === 'Rechazada') {
    alertToast('La MR fue rechazada', 'error');
    return;
  }

  $('#contenedorProductos').empty();
  $('#preguntaProveedorUnico').addClass('d-none');
  $('#contenedorProductos').hide();
  $('#respuestaProveedorUnicoSi').off('click');
  $('#respuestaProveedorUnicoNo').off('click');

  $('#noMRModal').text(no_mr || 'No disponible');
  $('#inputNoMR').val(no_mr || '');

  const modal = new bootstrap.Modal(document.getElementById('modalMateriales'));
  modal.show();

  try {
    const res = await fetch(`/api/hoja-trabajo/${no_mr}`);
    const result = await res.json();

    if (result.success && result.data.length > 0) {
      $('#contenedorProductos').show();
      $('#preguntaProveedorUnico').addClass('d-none');

      result.data.forEach((item, index) => {
        const template = document.querySelector('#templateProducto');
        const clon = document.importNode(template.content, true);

        clon.querySelector('.producto-titulo').textContent = item.DESCRIPCION || '-';
        clon.querySelector('.producto-cantidad').textContent = item.CANTIDAD || '-';
        clon.querySelector('.producto-unidad').textContent = item.UNIDAD_MEDIDA || '-';

        clon.querySelector('.descripcion-input').value = item.DESCRIPCION || '';
        clon.querySelector('.cantidad-input').value = item.CANTIDAD || '';
        clon.querySelector('.unidad-input').value = item.UNIDAD_MEDIDA || '';


        const filas = clon.querySelectorAll('.fila-cotizacion');

filas.forEach((fila) => {
  const cot = fila.getAttribute('data-cotizacion'); // "Q1", "Q2" o "Q3"

  if (cot === 'Q1') {
    fila.querySelector('.proveedor-cotizacion').value = item.PROVEEDOR_Q1 || '';
    fila.querySelector('.importe-cotizacion').value = item.SUBTOTAL_Q1 || '';
    fila.querySelector('.iva-cotizacion').value = item.IVA_Q1 || '';
    fila.querySelector('.total-cotizacion').value = item.IMPORTE_Q1 || '';
    fila.querySelector('.textarea').value = item.OBSERVACIONES_Q1 || '';
    fila.querySelector('.fecha-cotizacion').value = item.FECHA_COTIZACION_Q1 || '';
  }

  if (cot === 'Q2') {
    fila.querySelector('.proveedor-cotizacion').value = item.PROVEEDOR_Q2 || '';
    fila.querySelector('.importe-cotizacion').value = item.SUBTOTAL_Q2 || '';
    fila.querySelector('.iva-cotizacion').value = item.IVA_Q2 || '';
    fila.querySelector('.total-cotizacion').value = item.IMPORTE_Q2 || '';
    fila.querySelector('.textarea').value = item.OBSERVACIONES_Q2 || '';
    fila.querySelector('.fecha-cotizacion').value = item.FECHA_COTIZACION_Q2 || '';
  }

  if (cot === 'Q3') {
    fila.querySelector('.proveedor-cotizacion').value = item.PROVEEDOR_Q3 || '';
    fila.querySelector('.importe-cotizacion').value = item.SUBTOTAL_Q3 || '';
    fila.querySelector('.iva-cotizacion').value = item.IVA_Q3 || '';
    fila.querySelector('.total-cotizacion').value = item.IMPORTE_Q3 || '';
    fila.querySelector('.textarea').value = item.OBSERVACIONES_Q3 || '';
    fila.querySelector('.fecha-cotizacion').value = item.FECHA_COTIZACION_Q3 || '';
  }
});
      const ID_HOJA = clon.querySelector('.ID_HOJA');
      if (ID_HOJA) ID_HOJA.value = item.id || '';
              

      const proveedorSugerido = clon.querySelector('.proveedor-sugerido');
        if (proveedorSugerido) proveedorSugerido.value = item.PROVEEDOR_SUGERIDO || '';
        

        const  solicitarverificacion = clon.querySelector('.solicitar-verificacion');
        if ( solicitarverificacion) solicitarverificacion.value = item.SOLICITAR_VERIFICACION || '';

        const formaAdquisicion = clon.querySelector('.forma-adquisicion');
        if (formaAdquisicion) formaAdquisicion.value = item.FORMA_ADQUISICION || '';

        const proveedorSeleccionado = clon.querySelector('.proveedor-seleccionado');
        if (proveedorSeleccionado) proveedorSeleccionado.value = item.PROVEEDOR_SELECCIONADO || '';

        const montoFinal = clon.querySelector('.monto-final');
        if (montoFinal) montoFinal.value = item.MONTO_FINAL || '';

        const formaPago = clon.querySelector('.forma-pago');
        if (formaPago) formaPago.value = item.FORMA_PAGO || '';


        const  requierepo = clon.querySelector('.requiere-po');
        if (requierepo) requierepo.value = item.REQUIERE_PO || '';
        
        
        // const radioSi = clon.querySelector('input.requiere-po[value="si"]');
        // const radioNo = clon.querySelector('input.requiere-po[value="no"]');
        // if (item.REQUIERE_PO === 'si' && radioSi) radioSi.checked = true;
        // if (item.REQUIERE_PO === 'no' && radioNo) radioNo.checked = true;


        actualizarProveedoresSugeridos(clon, item.PROVEEDOR_SUGERIDO || '');



        $('#contenedorProductos').append(clon);
      });

      inicializarDatepickers();
      return;
    }

    // Si no hay hoja_trabajo: usar MATERIALES_JSON
    let materiales = [];
    if (Array.isArray(row.MATERIALES_JSON)) {
      materiales = row.MATERIALES_JSON;
    } else if (typeof row.MATERIALES_JSON === 'string') {
      materiales = JSON.parse(row.MATERIALES_JSON);
    }

    const listaFiltrada = materiales.filter(m => m.CHECK_VO === 'SI' && m.CHECK_MATERIAL === 'SI');

    if (listaFiltrada.length === 0) {
      $('#contenedorProductos')
        .html('<div class="alert alert-info">No hay materiales aprobados disponibles.</div>')
        .show();
      $('#preguntaProveedorUnico').addClass('d-none');
      return;
    }

    // Mostrar pregunta
    $('#preguntaProveedorUnico').removeClass('d-none');
    $('#contenedorProductos').hide();

    $('#respuestaProveedorUnicoSi').on('click', function () {
      $('#preguntaProveedorUnico').addClass('d-none');
      $('#contenedorProductos').show();

      const template = document.querySelector('#templateProducto');
      const clon = document.importNode(template.content, true);

      clon.querySelector('.producto-titulo').textContent = 'Materiales';

      const detalleCantidadUnidad = clon.querySelector('.detalle-cantidad-unidad');
      if (detalleCantidadUnidad) {
        detalleCantidadUnidad.style.setProperty('display', 'none', 'important');
      }

      const descripcionDiv = clon.querySelector('.descripcion-materiales');
      const listaHtml = listaFiltrada.map(m =>
        `<li>${m.DESCRIPCION} (${m.CANTIDAD} ${m.UNIDAD_MEDIDA})</li>`
      ).join('');
      descripcionDiv.innerHTML = `<ul class="mb-0">${listaHtml}</ul>`;

      clon.querySelector('.descripcion-input').value = listaFiltrada.map(m => m.DESCRIPCION).join(', ');
      clon.querySelector('.cantidad-input').value = listaFiltrada.map(m => m.CANTIDAD).join(', ');
      clon.querySelector('.unidad-input').value = listaFiltrada.map(m => m.UNIDAD_MEDIDA).join(', ');

      $('#contenedorProductos').append(clon);
      inicializarDatepickers();
    });

    $('#respuestaProveedorUnicoNo').on('click', function () {
      $('#preguntaProveedorUnico').addClass('d-none');
      $('#contenedorProductos').show();

      listaFiltrada.forEach(material => {
        const template = document.querySelector('#templateProducto');
        const clon = document.importNode(template.content, true);

        clon.querySelector('.producto-titulo').textContent = material.DESCRIPCION;
        clon.querySelector('.producto-cantidad').textContent = material.CANTIDAD;
        clon.querySelector('.producto-unidad').textContent = material.UNIDAD_MEDIDA;

        const descripcionDiv = clon.querySelector('.descripcion-materiales');
        if (descripcionDiv) {
          descripcionDiv.remove();
        }

        clon.querySelector('.descripcion-input').value = material.DESCRIPCION;
        clon.querySelector('.cantidad-input').value = material.CANTIDAD;
        clon.querySelector('.unidad-input').value = material.UNIDAD_MEDIDA;

        $('#contenedorProductos').append(clon);
        inicializarDatepickers();
      });
    });

  } catch (err) {
    console.error('Error al cargar hoja de trabajo:', err);
    alertToast('Error al cargar la hoja de trabajo', 'error');
  }
});



// $('#Tablabitacora tbody').on('click', 'td>button.VISUALIZAR', function () {
//   const row = Tablabitacora.row($(this).closest('tr')).data();

//   if (row.ESTADO_APROBACION === null) {
//     alertToast('La MR aún no ha sido aprobada', 'warning');
//     return;
//   }

//   if (row.ESTADO_APROBACION === 'Rechazada') {
//     alertToast('La MR fue rechazada', 'error');
//     return;
//   }

//   try {
//     let materiales = [];
//     if (Array.isArray(row.MATERIALES_JSON)) {
//       materiales = row.MATERIALES_JSON;
//     } else if (typeof row.MATERIALES_JSON === 'string') {
//       materiales = JSON.parse(row.MATERIALES_JSON);
//     }

//     const listaFiltrada = materiales.filter(m => m.CHECK_VO === 'SI' && m.CHECK_MATERIAL === 'SI');

//     $('#contenedorProductos').empty();
//     $('#preguntaProveedorUnico').removeClass('d-none');
//     $('#contenedorProductos').hide();

//     $('#respuestaProveedorUnicoSi').off('click');
//     $('#respuestaProveedorUnicoNo').off('click');

//     const modal = new bootstrap.Modal(document.getElementById('modalMateriales'));
//     modal.show();

//     $('#noMRModal').text(row.NO_MR || 'No disponible');
//     $('#inputNoMR').val(row.NO_MR || '');

//     if (listaFiltrada.length === 0) {
//       $('#contenedorProductos')
//         .html('<div class="alert alert-info">No hay materiales aprobados disponibles.</div>')
//         .show();
//       $('#preguntaProveedorUnico').addClass('d-none');
//       return;
//     }

//     // ✅ Proveedor Único (una sola tarjeta para todos)
//     $('#respuestaProveedorUnicoSi').on('click', function () {
//       $('#preguntaProveedorUnico').addClass('d-none');
//       $('#contenedorProductos').show();

//       const template = document.querySelector('#templateProducto');
//       const clon = document.importNode(template.content, true);

//       clon.querySelector('.producto-titulo').textContent = 'Materiales';

//       const detalleCantidadUnidad = clon.querySelector('.detalle-cantidad-unidad');
//       if (detalleCantidadUnidad) {
//         detalleCantidadUnidad.style.setProperty('display', 'none', 'important');
//       }

//       const descripcionDiv = clon.querySelector('.descripcion-materiales');
//       const listaHtml = listaFiltrada.map(m =>
//         `<li>${m.DESCRIPCION} (${m.CANTIDAD} ${m.UNIDAD_MEDIDA})</li>`
//       ).join('');
//       descripcionDiv.innerHTML = `<ul class="mb-0">${listaHtml}</ul>`;

//       // Asignar campos ocultos
//       clon.querySelector('.descripcion-input').value = listaFiltrada.map(m => m.DESCRIPCION).join(', ');
//       clon.querySelector('.cantidad-input').value = listaFiltrada.map(m => m.CANTIDAD).join(', ');
//       clon.querySelector('.unidad-input').value = listaFiltrada.map(m => m.UNIDAD_MEDIDA).join(', ');

//       $('#contenedorProductos').append(clon);
//       inicializarDatepickers();
//     });

//     // ✅ Proveedor por Producto (una tarjeta por cada material)
//     $('#respuestaProveedorUnicoNo').on('click', function () {
//       $('#preguntaProveedorUnico').addClass('d-none');
//       $('#contenedorProductos').show();

//       listaFiltrada.forEach(material => {
//         const template = document.querySelector('#templateProducto');
//         const clon = document.importNode(template.content, true);

//         clon.querySelector('.producto-titulo').textContent = material.DESCRIPCION;
//         clon.querySelector('.producto-cantidad').textContent = material.CANTIDAD;
//         clon.querySelector('.producto-unidad').textContent = material.UNIDAD_MEDIDA;

//         // Eliminar descripción combinada
//         const descripcionDiv = clon.querySelector('.descripcion-materiales');
//         if (descripcionDiv) {
//           descripcionDiv.remove();
//         }

//         // Asignar campos ocultos
//         clon.querySelector('.descripcion-input').value = material.DESCRIPCION;
//         clon.querySelector('.cantidad-input').value = material.CANTIDAD;
//         clon.querySelector('.unidad-input').value = material.UNIDAD_MEDIDA;

//         $('#contenedorProductos').append(clon);
//         inicializarDatepickers();
//       });
//     });

//   } catch (err) {
//     console.error('Error al procesar MATERIALES_JSON', err);
//     alertToast('Error al procesar los materiales', 'error');
//   }
// });


function actualizarProveedoresSugeridos(grupo, valorSeleccionado = null) {
  const selects = grupo.querySelectorAll('.proveedor-cotizacion');
  const proveedorSugeridoSelect = grupo.querySelector('.proveedor-sugerido');
  if (!proveedorSugeridoSelect) return;

  const proveedoresUnicos = new Map();

  selects.forEach(select => {
    const selectedOption = select.options[select.selectedIndex];
    const value = selectedOption?.value;
    const text = selectedOption?.text;

    if (value && !proveedoresUnicos.has(value)) {
      proveedoresUnicos.set(value, text);
    }
  });

  proveedorSugeridoSelect.innerHTML = '<option value="">Seleccionar proveedor sugerido</option>';
  proveedoresUnicos.forEach((text, value) => {
    const option = document.createElement('option');
    option.value = value;
    option.textContent = text;
    proveedorSugeridoSelect.appendChild(option);
  });

  // 👇 Selecciona el que venía guardado
  if (valorSeleccionado) {
    proveedorSugeridoSelect.value = valorSeleccionado;
  }
}




$(document).on('change', '.proveedor-cotizacion', function () {
  const grupo = this.closest('.grupo-producto');
  if (grupo) {
    actualizarProveedoresSugeridos(grupo);
  }
});



$('#btnGuardarTodo').on('click', function () {
  const form = document.getElementById('formularioBITACORA');
  const formData = new FormData(form);

  fetch('/guardarHOJAS', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alertToast('Hoja de trabajo guardada con éxito', 'success');
      $('#modalMateriales').modal('hide');
    } else {
      alertToast('Ocurrió un error al guardar', 'error');
    }
  })
  .catch(error => {
    console.error('Error al guardar:', error);
    alertToast('Error en la conexión con el servidor', 'error');
  });
});
