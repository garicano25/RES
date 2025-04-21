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
        { targets: 1, width: '200px' },
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
    ],
    columns: [
        { data: 'BTN_EDITAR' },
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
        }
        
       
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