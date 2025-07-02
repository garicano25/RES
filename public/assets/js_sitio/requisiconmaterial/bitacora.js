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
        { targets: '_all', className: 'text-center' }, 
        { targets: 0, width: '150px' },
        { targets: 1, width: '150px' },
        { targets: 2, width: '200px' },
        { targets: 3, width: '250px' },
        { targets: 4, width: '250px' },
        { targets: 5, width: '250px' },
        { targets: 6, width: '250px' },
        { targets: 7, width: '200px' },
        { targets: 8, width: '250px' },
        { targets: 9, width: '150px' },
        { targets: 10, width: '300px' },
        { targets: 11, width: '200px' },
        { targets: 12, width: '300px' },
      { targets: 13, width: '300px' },
      { targets: 14, width: '300px' },
        

    ],
    columns: [
        { data: 'BTN_EDITAR' },
        { data: 'BTN_NO_MR' },
        { data: 'NO_MR' },
        { data: 'FECHA_SOLICITUD_MR' },
        { data: 'SOLICITANTE_MR' },
        {
          data: 'JUSTIFICACION_MR',
          className: 'col-justificacion', // Clase solo para esta columna
        },
        { data: 'AREA_SOLICITANTE_MR' },
        { data: 'FECHA_VISTO_MR' },
        { data: 'VISTO_BUENO' },
        { data: 'FECHA_APRUEBA_MR' },
        { data: 'QUIEN_APROBACION' },
        { data: 'PRIORIDAD_MR' },

        {
          data: null,
          render: function (data) {
              let estado = data.ESTADO_FINAL || '';
              let clase = '';
      
              if (estado === 'Finalizada') {
                  clase = 'select-finalizada';
              } else if (estado === 'En proceso') {
                  clase = 'select-en-proceso';
              } else {
                  estado = 'Sin datos';
                  clase = 'select-sin-datos';
              }
      
              return `
                  <select class="form-select ${clase}" disabled>
                      <option value="Sin datos" ${estado === "Sin datos" ? "selected" : ""}>Sin datos</option>
                      <option value="En proceso" ${estado === "En proceso" ? "selected" : ""}>En proceso</option>
                      <option value="Finalizada" ${estado === "Finalizada" ? "selected" : ""}>Finalizada</option>
                  </select>`;
          }
      },
      
      
      
        {
            data: null,
            render: () => `<textarea type="text" class="form-control" style="width: 100%" rowas="5"></textarea>`
        },
        {
            data: null,
            render: () => `<input type="text" class="form-control mydatepicker " placeholder="aaaa-mm-dd">
`
        },
          { data: 'MATERIALES_JSON', visible: false }, 
    { data: 'ESTADO_APROBACION', visible: false } 
        
       
  ],
  createdRow: function (row, data, dataIndex) {
    $(row).css('background-color', data.COLOR);
}

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


$(document).ready(function () {
  $('#GENERARPDF').on('click', function (e) {
      e.preventDefault();

      if (!ID_FORMULARIO_MR) {
          alert("No se ha seleccionado una MR válida.");
          return;
      }

      const url = `/mr/${ID_FORMULARIO_MR}/generar-pdf`;
      window.open(url, '_blank');
  });
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






function inicializarDatepickers() {
  $('.mydatepicker').datepicker({
    format: 'yyyy-mm-dd', // Formato de fecha
                weekStart: 1, // Día que inicia la semana, 1 = Lunes
                autoclose: true, // Cierra automáticamente el calendario
                todayHighlight: true, // Marca el día de hoy en el calendario
                language: 'es' // Configura el idioma en español
  });
}




const ModalArea = document.getElementById('modalMateriales')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    document.getElementById('formularioBITACORA').reset();
   

})



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
    
          const esProveedorUnico = result.data[0]?.ES_UNICO_PROVEEDOR === 'SI';

          document.getElementById('esProveedorUnico').value = esProveedorUnico ? 'SI' : 'NO';

              result.data.forEach((item) => {
          const template = document.querySelector('#templateProducto');
          const clon = document.importNode(template.content, true);

          const descripcionDiv = clon.querySelector('.descripcion-materiales');
          const titulo = clon.querySelector('.producto-titulo');
          const cantSpan = clon.querySelector('.producto-cantidad');
          const unidadSpan = clon.querySelector('.producto-unidad');
          const detalleCantidadUnidad = clon.querySelector('.detalle-cantidad-unidad');

          

          if (esProveedorUnico) {
            // Limpiar bloque visual
            if (titulo) titulo.textContent = '';
            if (cantSpan) cantSpan.textContent = '';
            if (unidadSpan) unidadSpan.textContent = '';
            if (detalleCantidadUnidad) detalleCantidadUnidad.remove();

            // Usar JSON de materiales
            const materiales = JSON.parse(item.MATERIALES_HOJA_JSON || '[]');
            const inputsHtml = materiales.map(m => `
              <div class="row mb-2">
                <div class="col-4">
                  <label class="form-label">Descripción</label>
                  <input type="text" class="form-control" name="DESCRIPCION[]" value="${m.DESCRIPCION}" readonly>
                </div>
                <div class="col-1">
                  <label class="form-label">Cantidad</label>
                  <input type="number" class="form-control" name="CANTIDAD[]" value="${m.CANTIDAD}" readonly>
                </div>
                <div class="col-1">
                  <label class="form-label">Unidad</label>
                  <input type="text" class="form-control" name="UNIDAD_MEDIDA[]" value="${m.UNIDAD_MEDIDA}" readonly>
                </div>
                <div class="col-1">
                  <label class="form-label">Cantidad Real </label>
                  <input type="number" class="form-control" name="CANTIDAD_REAL[]" value="${m.CANTIDAD_REAL}" min="0" step="any" required>
                </div>
                <div class="col-1">
                  <label class="form-label">Precio Unitario Q1</label>
                  <input type="number" class="form-control" name="PRECIO_UNITARIO[]" value="${m.PRECIO_UNITARIO}" min="0" step="0.01" required>
                </div>
            
               <div class="col-1">
                  <label class="form-label">Precio Unitario Q2</label>
                </div>

            
                <div class="col-1">
                  <label class="form-label">Precio Unitario Q3</label>
                  <input type="number" class="form-control" name="PRECIO_UNITARIO_Q3[]" value="${m.PRECIO_UNITARIO_Q3}" min="0" step="0.01" required>
                </div>



              </div>
            `).join('');
            if (descripcionDiv) descripcionDiv.innerHTML = inputsHtml;


                  
          if (clon.querySelector('.descripcion-input')) clon.querySelector('.descripcion-input').remove();
          if (clon.querySelector('.cantidad-input')) clon.querySelector('.cantidad-input').remove();
                if (clon.querySelector('.unidad-input')) clon.querySelector('.unidad-input').remove();
                
            
            
            // Ocultar columnas específicas
            $(clon).find('.th-cantidadmr, .th-cantidadreal, .th-preciounitario').hide();
            $(clon).find('.td-cotizacionq1-cantidadmr, .td-cotizacionq1-cantidadreal, .td-cotizacionq1-preciounitario').hide();
            $(clon).find('.td-cotizacionq2-cantidadmr, .td-cotizacionq2-cantidadreal, .td-cotizacionq2-preciounitario').hide();
            $(clon).find('.td-cotizacionq3-cantidadmr, .td-cotizacionq3-cantidadreal, .td-cotizacionq3-preciounitario').hide();

          } else {
            // Procesamiento normal (NO proveedor único)
            const descripcion = item.DESCRIPCION || '';
            const cantidad = item.CANTIDAD || '';
            const unidad = item.UNIDAD_MEDIDA || '';

            const descripciones = descripcion.split('*#');
            const cantidades = cantidad.split('*#');
            const unidades = unidad.split('*#');

            if (descripciones.length === 1) {
              if (titulo) titulo.textContent = descripciones[0] || '-';
              if (cantSpan) cantSpan.textContent = cantidades[0] || '-';
              if (unidadSpan) unidadSpan.textContent = unidades[0] || '-';
              if (descripcionDiv) descripcionDiv.innerHTML = '';
            } else {
              const listaHtml = descripciones.map((desc, i) => {
                const cant = cantidades[i] || '-';
                const uni = unidades[i] || '-';
                return `<li>${desc} (${cant} ${uni})</li>`;
              }).join('');
              if (descripcionDiv) descripcionDiv.innerHTML = `<ul class="mb-0">${listaHtml}</ul>`;

              if (titulo) titulo.textContent = '';
              if (cantSpan) cantSpan.textContent = '';
              if (unidadSpan) unidadSpan.textContent = '';
              if (detalleCantidadUnidad) detalleCantidadUnidad.remove();
            }

            clon.querySelector('.descripcion-input').value = item.DESCRIPCION || '';
            clon.querySelector('.cantidad-input').value = item.CANTIDAD || '';
            clon.querySelector('.unidad-input').value = item.UNIDAD_MEDIDA || '';
          }
            
    
            const filas = clon.querySelectorAll('.fila-cotizacion');
    
            filas.forEach((fila) => {
              const cot = fila.getAttribute('data-cotizacion'); 
    
              if (cot === 'Q1') {
                fila.querySelector('.proveedor-cotizacionq1').value = item.PROVEEDOR_Q1 || '';
                fila.querySelector('.cantidadmr-cotizacionq1').value = item.CANTIDAD_MRQ1 || '';
                fila.querySelector('.cantidadreal-cotizacionq1').value = item.CANTIDAD_REALQ1 || '';
                fila.querySelector('.preciounitario-cotizacionq1').value = item.PRECIO_UNITARIOQ1 || '';
                fila.querySelector('.importe-cotizacionq1').value = item.SUBTOTAL_Q1 || '';
                fila.querySelector('.iva-cotizacionq1').value = item.IVA_Q1 || '';
                fila.querySelector('.total-cotizacionq1').value = item.IMPORTE_Q1 || '';
                fila.querySelector('.textareaq1').value = item.OBSERVACIONES_Q1 || '';
                fila.querySelector('.fecha-cotizacionq1').value = item.FECHA_COTIZACION_Q1 || '';
    
                const inputFile = fila.querySelector('.doc-cotizacionq1');
                const contenedor = inputFile?.closest('.input-group');
                if (contenedor && item.DOCUMENTO_Q1) {
                  const link = document.createElement('a');
                  link.href = `/mostrarcotizacionq1/${item.id}`;
                  link.target = "_blank";
                  link.textContent = "Ver documento actual";
                  link.classList.add('btn', 'btn-outline-primary', 'btn-sm', 'ms-2');
                  contenedor.appendChild(link);
                }
    
              }
    
              if (cot === 'Q2') {
                fila.querySelector('.proveedor-cotizacionq2').value = item.PROVEEDOR_Q2 || '';
                fila.querySelector('.cantidadmr-cotizacionq2').value = item.CANTIDAD_MRQ2 || '';
                fila.querySelector('.cantidadreal-cotizacionq2').value = item.CANTIDAD_REALQ2 || '';
                fila.querySelector('.preciounitario-cotizacionq2').value = item.PRECIO_UNITARIOQ2 || '';
                fila.querySelector('.importe-cotizacionq2').value = item.SUBTOTAL_Q2 || '';
                fila.querySelector('.iva-cotizacionq2').value = item.IVA_Q2 || '';
                fila.querySelector('.total-cotizacionq2').value = item.IMPORTE_Q2 || '';
                fila.querySelector('.textareaq2').value = item.OBSERVACIONES_Q2 || '';
                fila.querySelector('.fecha-cotizacionq2').value = item.FECHA_COTIZACION_Q2 || '';
    
    
                const inputFile = fila.querySelector('.doc-cotizacionq2');
                const contenedor = inputFile?.closest('.input-group');
                if (contenedor && item.DOCUMENTO_Q2) {
                  const link = document.createElement('a');
                  link.href = `/mostrarcotizacionq2/${item.id}`;
                  link.target = "_blank";
                  link.textContent = "Ver documento actual";
                  link.classList.add('btn', 'btn-outline-primary', 'btn-sm', 'ms-2');
                  contenedor.appendChild(link);
                }
    
    
              }
    
              if (cot === 'Q3') {
                fila.querySelector('.proveedor-cotizacionq3').value = item.PROVEEDOR_Q3 || '';
    
                fila.querySelector('.cantidadmr-cotizacionq3').value = item.CANTIDAD_MRQ3 || '';
                fila.querySelector('.cantidadreal-cotizacionq3').value = item.CANTIDAD_REALQ3 || '';
                fila.querySelector('.preciounitario-cotizacionq3').value = item.PRECIO_UNITARIOQ3 || '';
    
                fila.querySelector('.importe-cotizacionq3').value = item.SUBTOTAL_Q3 || '';
                fila.querySelector('.iva-cotizacionq3').value = item.IVA_Q3 || '';
                fila.querySelector('.total-cotizacionq3').value = item.IMPORTE_Q3 || '';
                fila.querySelector('.textareaq3').value = item.OBSERVACIONES_Q3 || '';
                fila.querySelector('.fecha-cotizacionq3').value = item.FECHA_COTIZACION_Q3 || '';
                const inputFile = fila.querySelector('.doc-cotizacionq3');
                const contenedor = inputFile?.closest('.input-group');
                if (contenedor && item.DOCUMENTO_Q3) {
                  const link = document.createElement('a');
                  link.href = `/mostrarcotizacionq3/${item.id}`;
                  link.target = "_blank";
                  link.textContent = "Ver documento actual";
                  link.classList.add('btn', 'btn-outline-primary', 'btn-sm', 'ms-2');
                  contenedor.appendChild(link);
                }
    
    
              }
    
            });
    
              const ID_HOJA = clon.querySelector('.ID_HOJA');
             if (ID_HOJA) ID_HOJA.value = item.id || '';
                  
    
          const proveedorSugerido = clon.querySelector('.proveedor-sugerido');
            if (proveedorSugerido) proveedorSugerido.value = item.PROVEEDOR_SUGERIDO || '';
            
    
             const solicitarverificacion = clon.querySelector('.solicitar-verificacion');
            if (solicitarverificacion) {
              solicitarverificacion.value = item.SOLICITAR_VERIFICACION || '';
            
              const aprobacionDireccion = clon.querySelector('.aprobacion-direccion-hoja');
              if (aprobacionDireccion) {
                aprobacionDireccion.style.display = (solicitarverificacion.value === 'Sí') ? 'block' : 'none';
              }
            }
            
                
            const solicitarmatriz = clon.querySelector('.REQUIERE_MATRIZ');
            if (solicitarmatriz) {
              solicitarmatriz.value = item.REQUIERE_MATRIZ || '';
            
              const aprobacionDireccion1 = clon.querySelector('.aprobacion-direccion-hoja');
              if (aprobacionDireccion1) {
                aprobacionDireccion1.style.display = (solicitarmatriz.value === 'Sí') ? 'none' : 'block';
              }
                }
                


    
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
    
    
            const  fechaverificacion = clon.querySelector('.fecha-verificacion');
            if (fechaverificacion) fechaverificacion.value = item.FECHA_VERIFICACION || '';
            
            
            
            const  fechaaprobacion = clon.querySelector('.fecha-aprobacion');
            if (fechaaprobacion) fechaaprobacion.value = item.FECHA_APROBACION || '';
            
            
    
            const estadoaprobacion = clon.querySelector('.estado-aprobacion');
            if (estadoaprobacion) {
              estadoaprobacion.value = item.ESTADO_APROBACION || '';
              cambiarColor(estadoaprobacion); 
            }
            
    
            const requierecomentarios = clon.querySelector('.requiere-comentario');
            if (requierecomentarios) {
              requierecomentarios.value = item.REQUIERE_COMENTARIO || '';
              requierecomentario(requierecomentarios); 
            }
            
    
            const  comentarioaprobacion = clon.querySelector('.comentario-aprobacion');
            if (comentarioaprobacion) comentarioaprobacion.value = item.COMENTARIO_APROBACION || '';
            
    
            const  motivorechazo = clon.querySelector('.motivo-rechazo');
            if (motivorechazo) motivorechazo.value = item.MOTIVO_RECHAZO || '';
            
    
    
            actualizarProveedoresSugeridos(clon, item.PROVEEDOR_SUGERIDO || '');
    
            actualizarProveedoresseleccionado(clon, item.PROVEEDOR_SELECCIONADO || '');
    
    
        
            $('#contenedorProductos').append(clon);
    
    
            
            inicializarSelectizeEnClon(clon);
          
    
          });
    
          inicializarDatepickers();
        
          inicializarSumaImportes();
          inicializarCantidadPorPrecio();

          return;
        }
    


  
    


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

    $('#preguntaProveedorUnico').removeClass('d-none');
    $('#contenedorProductos').hide();
 

  $('#respuestaProveedorUnicoSi').on('click', function () {
  $('#esProveedorUnico').val('SI');

  $('#preguntaProveedorUnico').addClass('d-none');
  $('#contenedorProductos').show();

  const template = document.querySelector('#templateProducto');
  const clon = document.importNode(template.content, true);

  // Quita encabezado visual
  const header = clon.querySelector('.card-header');
  if (header) header.remove();

  // Elimina inputs ocultos si existen
  if (clon.querySelector('.descripcion-input')) clon.querySelector('.descripcion-input').remove();
  if (clon.querySelector('.cantidad-input')) clon.querySelector('.cantidad-input').remove();
  if (clon.querySelector('.unidad-input')) clon.querySelector('.unidad-input').remove();

  // Agrega inputs visibles por material
  const descripcionDiv = clon.querySelector('.descripcion-materiales');
  if (descripcionDiv) {
    const inputsHtml = listaFiltrada.map(m => {
      return `
        <div class="row mb-2">
          <div class="col-4">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="DESCRIPCION[]" value="${m.DESCRIPCION}" readonly>
          </div>
          <div class="col-1">
            <label class="form-label">Cantidad</label>
            <input type="number" class="form-control" name="CANTIDAD[]" value="${m.CANTIDAD}" readonly>
          </div>
          <div class="col-1">
            <label class="form-label">Unidad</label>
            <input type="text" class="form-control" name="UNIDAD_MEDIDA[]" value="${m.UNIDAD_MEDIDA}" readonly>
          </div>
          <div class="col-1">
            <label class="form-label">Cantidad Real </label>
            <input type="number" class="form-control" name="CANTIDAD_REAL[]" min="0" step="any" required>
          </div>
          <div class="col-1">
            <label class="form-label">Precio Unitario Q1</label>
            <input type="number" class="form-control" name="PRECIO_UNITARIO[]" min="0" step="0.01" required>
          </div>


        
          <div class="col-1">
            <label class="form-label">Precio Unitario Q2</label>
            <input type="number" class="form-control" name="PRECIO_UNITARIO_Q2[]" min="0" step="0.01" required>
          </div>

       
        

          <div class="col-1">
            <label class="form-label">Precio Unitario Q3</label>
            <input type="number" class="form-control" name="PRECIO_UNITARIO_Q3[]" min="0" step="0.01" required>
          </div>


        </div>
      `;
    }).join('');
    descripcionDiv.innerHTML = inputsHtml;
  }

  const form = document.getElementById('formularioBITACORA');
  if (form) {
    let existingJsonInput = form.querySelector('input[name="MATERIALES_HOJA_JSON[]"]');
    if (existingJsonInput) existingJsonInput.remove(); 

    const nuevasDescripciones = Array.from(document.querySelectorAll('input[name="DESCRIPCION[]"]')).map(input => input.value);
    const nuevasCantidades = Array.from(document.querySelectorAll('input[name="CANTIDAD[]"]')).map(input => input.value);
    const nuevasUnidades = Array.from(document.querySelectorAll('input[name="UNIDAD_MEDIDA[]"]')).map(input => input.value);
    const nuevasCantidadesReales = Array.from(document.querySelectorAll('input[name="CANTIDAD_REAL[]"]')).map(input => input.value);
    const nuevosPreciosUnitarios = Array.from(document.querySelectorAll('input[name="PRECIO_UNITARIO[]"]')).map(input => input.value);




    const nuevosPreciosUnitariosQ2 = Array.from(document.querySelectorAll('input[name="PRECIO_UNITARIO_Q2[]"]')).map(input => input.value);


    const nuevosPreciosUnitariosQ3 = Array.from(document.querySelectorAll('input[name="PRECIO_UNITARIO_Q3[]"]')).map(input => input.value);

    

    const materialesCompletos = nuevasDescripciones.map((_, i) => ({
      DESCRIPCION: nuevasDescripciones[i],
      CANTIDAD: nuevasCantidades[i],
      UNIDAD_MEDIDA: nuevasUnidades[i],
      CANTIDAD_REAL: nuevasCantidadesReales[i],
      PRECIO_UNITARIO: nuevosPreciosUnitarios[i],
      PRECIO_UNITARIO_Q2: nuevosPreciosUnitariosQ2[i],
      PRECIO_UNITARIO_Q3: nuevosPreciosUnitariosQ3[i]


    }));

    const inputHidden = document.createElement('input');
    inputHidden.type = 'hidden';
    inputHidden.name = 'MATERIALES_HOJA_JSON[]';
    inputHidden.value = JSON.stringify(materialesCompletos);
    form.appendChild(inputHidden);
  }

  const $clon = $(clon);
  $clon.find('.th-cantidadmr, .th-cantidadreal, .th-preciounitario').hide();
  $clon.find('.td-cotizacionq1-cantidadmr, .td-cotizacionq1-cantidadreal, .td-cotizacionq1-preciounitario').hide();
  $clon.find('.td-cotizacionq2-cantidadmr, .td-cotizacionq2-cantidadreal, .td-cotizacionq2-preciounitario').hide();
  $clon.find('.td-cotizacionq3-cantidadmr, .td-cotizacionq3-cantidadreal, .td-cotizacionq3-preciounitario').hide();

    $('#contenedorProductos').append($clon);
    

  inicializarSelectizeEnClon($clon[0]);
  actualizarProveedoresSugeridos($clon[0]);
  actualizarProveedoresseleccionado($clon[0]);
  inicializarDatepickers();
  inicializarSumaImportes();
});



    $('#respuestaProveedorUnicoNo').on('click', function () {
      $('#esProveedorUnico').val('NO'); 

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


        clon.querySelector('.cantidadmr-cotizacionq1').value = material.CANTIDAD || '';
        clon.querySelector('.cantidadmr-cotizacionq2').value = material.CANTIDAD || '';
        clon.querySelector('.cantidadmr-cotizacionq3').value = material.CANTIDAD || '';

        

        $('#contenedorProductos').append(clon);
        inicializarSelectizeEnClon(clon);
        actualizarProveedoresSugeridos(clon);
        actualizarProveedoresseleccionado(clon);


        inicializarDatepickers();
        inicializarSumaImportes();
        inicializarCantidadPorPrecio();

      });


    });

  } catch (err) {
    console.error('Error al cargar hoja de trabajo:', err);
    alertToast('Error al cargar la hoja de trabajo', 'error');
  }
});









function actualizarProveedoresSugeridos(grupo, valorSeleccionado = null) {
  if (!grupo) return; 

  const selects = grupo.querySelectorAll('.proveedor-cotizacionq1, .proveedor-cotizacionq2, .proveedor-cotizacionq3');
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

  if (valorSeleccionado) {
    proveedorSugeridoSelect.value = valorSeleccionado;
  } else {
    const valores = Array.from(selects).map(sel => sel.value).filter(v => v);
    if (valores.length === 3 && new Set(valores).size === 1) {
      proveedorSugeridoSelect.value = valores[0];
    }
  }
}








function actualizarProveedoresseleccionado(grupo, valorSeleccionado = null) {
  if (!grupo) return; 

  const selects = grupo.querySelectorAll('.proveedor-cotizacionq1, .proveedor-cotizacionq2, .proveedor-cotizacionq3');
  const proveedorSugeridoSelect = grupo.querySelector('.proveedor-seleccionado');
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

  proveedorSugeridoSelect.innerHTML = '<option value="">Proveedor seleccionado</option>';
  proveedoresUnicos.forEach((text, value) => {
    const option = document.createElement('option');
    option.value = value;
    option.textContent = text;
    proveedorSugeridoSelect.appendChild(option);
  });

  if (valorSeleccionado) {
    proveedorSugeridoSelect.value = valorSeleccionado;
  } else {
    const valores = Array.from(selects).map(sel => sel.value).filter(v => v);
    if (valores.length === 3 && new Set(valores).size === 1) {
      proveedorSugeridoSelect.value = valores[0];
    }
  }
}










function inicializarSelectizeEnClon(clon) {
  if (!clon) return;

  const clases = [
    '.proveedor-cotizacionq1',
    '.proveedor-cotizacionq2',
    '.proveedor-cotizacionq3'
  ];

  clases.forEach((clase) => {
    const select = clon.querySelector(clase);

    if (select) {
      if ($(select)[0].selectize) {
        $(select)[0].selectize.destroy();
      }

      const selectize = $(select).selectize({
        allowEmptyOption: true,
        dropdownParent: 'body',
        sortField: 'text'
      })[0].selectize;

      const valorActual = select.value;
      if (valorActual) selectize.setValue(valorActual);
    }
  });
}




$(document).on('change', '.proveedor-cotizacionq1, .proveedor-cotizacionq2, .proveedor-cotizacionq3', function () {
  const grupo = this.closest('.grupo-producto');
  if (grupo) {
    actualizarProveedoresSugeridos(grupo);
  }
});




$(document).on('change', '.proveedor-cotizacionq1, .proveedor-cotizacionq2, .proveedor-cotizacionq3', function () {
  const grupo = this.closest('.grupo-producto');
  if (grupo) {
    actualizarProveedoresseleccionado(grupo);
  }
});






$('#btnGuardarTodo').on('click', function () {
  Swal.fire({
    title: '¿Deseas guardar la información?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, guardar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById('formularioBITACORA');

      // Mostrar alerta de guardando
      Swal.fire({
        title: 'Guardando información...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Borrar input previo
      const existente = form.querySelector('input[name="MATERIALES_HOJA_JSON[]"]');
      if (existente) existente.remove();

      // Recolectar datos actuales ingresados
      const descripciones = Array.from(form.querySelectorAll('input[name="DESCRIPCION[]"]')).map(e => e.value);
      const cantidades = Array.from(form.querySelectorAll('input[name="CANTIDAD[]"]')).map(e => e.value);
      const unidades = Array.from(form.querySelectorAll('input[name="UNIDAD_MEDIDA[]"]')).map(e => e.value);
      const reales = Array.from(form.querySelectorAll('input[name="CANTIDAD_REAL[]"]')).map(e => e.value);
      const precios = Array.from(form.querySelectorAll('input[name="PRECIO_UNITARIO[]"]')).map(e => e.value);
      const preciosQ2 = Array.from(form.querySelectorAll('input[name="PRECIO_UNITARIO_Q2[]"]')).map(e => e.value);
      const preciosQ3 = Array.from(form.querySelectorAll('input[name="PRECIO_UNITARIO_Q3[]"]')).map(e => e.value);

    
      const materialesJson = descripciones.map((_, i) => ({
        
        DESCRIPCION: descripciones[i],
        CANTIDAD: cantidades[i],
        UNIDAD_MEDIDA: unidades[i],
        CANTIDAD_REAL: reales[i],
        PRECIO_UNITARIO: precios[i],
        PRECIO_UNITARIO_Q2: preciosQ2[i],
        PRECIO_UNITARIO_Q3: preciosQ3[i]

      }));

      const inputHidden = document.createElement('input');
      inputHidden.type = 'hidden';
      inputHidden.name = 'MATERIALES_HOJA_JSON[]';
      inputHidden.value = JSON.stringify(materialesJson);
      form.appendChild(inputHidden);

      // Enviar
      const formData = new FormData(form);
      fetch('/guardarHOJAS', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          Swal.close(); // Cerrar alerta de carga

          if (data.success) {
            Swal.fire('Éxito', 'Hoja de trabajo guardada con éxito', 'success');
            $('#modalMateriales').modal('hide');
          } else {
            Swal.fire('Error', 'Ocurrió un error al guardar', 'error');
          }
        })
        .catch(error => {
          console.error('Error al guardar:', error);
          Swal.close();
          Swal.fire('Error', 'Error en la conexión con el servidor', 'error');
        });
    }
  });
});




$('form').on('submit', function (e) {
  const formData = new FormData(this);
  for (const pair of formData.entries()) {
    console.log(pair[0], pair[1]);
  }
});


/// QUITAR COMENTARIO CUANDO YA ESTEN LAS FECHAS CORRECTAS

// function asignarFechaVerificacion() {
//   document.querySelectorAll('.solicitar-verificacion').forEach((select) => {
//     select.addEventListener('change', function () {
//       const container = this.closest('.col-md-4').parentElement;
//       const fechaInput = container.querySelector('.fecha-verificacion');
//       const inputGroup = fechaInput.closest('.input-group');

//       if (!fechaInput || !inputGroup) return;

//       if (this.value === 'Sí') {
//         const hoy = new Date().toISOString().split('T')[0];
//         $(fechaInput).datepicker('setDate', hoy);

//         // Agrega capa que bloquea interacción
//         inputGroup.classList.add('bloquear-interaccion');
//       } else {
//         // Limpia y permite interacción
//         $(fechaInput).datepicker('clearDates');
//         inputGroup.classList.remove('bloquear-interaccion');
//       }
//     });
//   });
// }



// function bloquearFechaDesdeInicio() {
//   document.querySelectorAll('.fecha-verificacion').forEach((input) => {
//     input.classList.add('input-bloqueado');
//   });
// }



$(document).on('change', '.estado-aprobacion', function () {
  cambiarColor(this);
});


$(document).on('change', '.requiere-comentario', function () {
  requierecomentario(this);
});


function cambiarColor(select) {
  const bloque = select.closest('.bloque-aprobacion');
  if (!bloque) return;

  const container = bloque.querySelector('.estado-container');
  const motivoContainer = bloque.querySelector('.motivo-rechazo-hoja');
  const textarea = bloque.querySelector('.motivo-rechazo');

  if (select.value === "Aprobada") {
    if (container) {
      container.style.backgroundColor = "green";
      container.style.color = "white";
    }
    if (motivoContainer) motivoContainer.style.display = "none";
    if (textarea) textarea.removeAttribute('required');
  } else if (select.value === "Rechazada") {
    if (container) {
      container.style.backgroundColor = "red";
      container.style.color = "white";
    }
    if (motivoContainer) motivoContainer.style.display = "block";
    if (textarea) textarea.setAttribute('required', 'required');
  } else {
    if (container) {
      container.style.backgroundColor = "transparent";
      container.style.color = "black";
    }
    if (motivoContainer) motivoContainer.style.display = "none";
    if (textarea) textarea.removeAttribute('required');
  }
}



function requierecomentario(select) {
  const bloque = select.closest('.bloque-aprobacion');
  if (!bloque) return;

  const motivoContainer = bloque.querySelector('.comentario-aprobacion-hoja');
  const textarea = bloque.querySelector('.comentario-aprobacion');

  if (select.value === "Sí") {
    if (motivoContainer) motivoContainer.style.display = "block";
    if (textarea) textarea.setAttribute('required', 'required');
  } else {
    if (motivoContainer) motivoContainer.style.display = "none";
    if (textarea) textarea.removeAttribute('required');
  }
}







function inicializarSumaImportes() {
  document.addEventListener('input', function (e) {
    const tipos = ['q1', 'q2', 'q3'];

    tipos.forEach(tipo => {
      if (
        e.target.classList.contains(`importe-cotizacion${tipo}`) ||
        e.target.classList.contains(`iva-cotizacion${tipo}`)
      ) {
        const grupo = e.target.closest('.grupo-producto');
        if (!grupo) return;

        const subtotalInput = grupo.querySelector(`.importe-cotizacion${tipo}`);
        const ivaInput = grupo.querySelector(`.iva-cotizacion${tipo}`);
        const totalInput = grupo.querySelector(`.total-cotizacion${tipo}`);

        if (!subtotalInput || !ivaInput || !totalInput) return;

        const subtotalStr = subtotalInput.value.trim();
        const ivaStr = ivaInput.value.trim();

        const subtotal = parseFloat(subtotalStr) || 0;
        const iva = parseFloat(ivaStr) || 0;
        const suma = subtotal + iva;

        const decimalesSubtotal = (subtotalStr.split('.')[1] || '').length;
        const decimalesIva = (ivaStr.split('.')[1] || '').length;
        const maxDecimales = Math.max(decimalesSubtotal, decimalesIva);

        totalInput.value = suma.toFixed(maxDecimales);
      }
    });
  });
}


function inicializarCantidadPorPrecio() {
  document.addEventListener('input', function (e) {
    const tipos = ['q1', 'q2', 'q3'];

    tipos.forEach(tipo => {
      if (
        e.target.classList.contains(`cantidadreal-cotizacion${tipo}`) ||
        e.target.classList.contains(`preciounitario-cotizacion${tipo}`)
      ) {
        const grupo = e.target.closest('.grupo-producto');
        if (!grupo) return;

        const cantidadInput = grupo.querySelector(`.cantidadreal-cotizacion${tipo}`);
        const precioInput = grupo.querySelector(`.preciounitario-cotizacion${tipo}`);
        const subtotalInput = grupo.querySelector(`.importe-cotizacion${tipo}`);

        if (!cantidadInput || !precioInput || !subtotalInput) return;

        const cantidadStr = cantidadInput.value.trim();
        const precioStr = precioInput.value.trim();

        const cantidad = parseFloat(cantidadStr) || 0;
        const precio = parseFloat(precioStr) || 0;
        const subtotal = cantidad * precio;

        const decimalesCantidad = (cantidadStr.split('.')[1] || '').length;
        const decimalesPrecio = (precioStr.split('.')[1] || '').length;
        const maxDecimales = Math.max(decimalesCantidad, decimalesPrecio);

        subtotalInput.value = subtotal.toFixed(maxDecimales);
      }
    });
  });
}
