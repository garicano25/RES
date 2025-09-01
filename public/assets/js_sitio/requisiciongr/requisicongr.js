


// var Tablabitacoragr = $("#Tablabitacoragr").DataTable({
//     language: {
//         url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
//     },
//     scrollX: true,
//     autoWidth: false,
//     responsive: false,
//     paging: true,
//     searching: true,
//     info: false,
//     lengthChange: true,
//     lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
//     ajax: {
//         dataType: 'json',
//         method: 'GET',
//         url: '/Tablabitacoragr',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             Tablabitacoragr.columns.adjust().draw();
//             ocultarCarga();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     columnDefs: [
       
        

//     ],
//     columns: [
      
//   ],
//   createdRow: function (row, data, dataIndex) {
//     $(row).css('background-color', data.COLOR);
//   },

// drawCallback: function () {
//     const topScroll = document.querySelector('.tabla-scroll-top');
//     const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
//     const table = document.querySelector('#Tablabitacoragr');
//     const scrollBody = document.querySelector('.dataTables_scrollBody');

//     if (!topScroll || !scrollInner || !table || !scrollBody) return;

//     const tableWidth = table.scrollWidth;

//     scrollInner.style.width = tableWidth + 'px';

//     let syncingTop = false;
//     let syncingBottom = false;

//     topScroll.addEventListener('scroll', function () {
//         if (syncingTop) return;
//         syncingBottom = true;
//         scrollBody.scrollLeft = topScroll.scrollLeft;
//         syncingBottom = false;
//     });

//     scrollBody.addEventListener('scroll', function () {
//         if (syncingBottom) return;
//         syncingTop = true;
//         topScroll.scrollLeft = scrollBody.scrollLeft;
//         syncingTop = false;
//     });
// }


// });


const modalgr = document.getElementById('modalGR')
modalgr.addEventListener('hidden.bs.modal', event => {
    
    
    document.getElementById('formulariorecepciongr').reset();
   

})









var Tablabitacoragr = $("#Tablabitacoragr").DataTable({
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
        url: '/Tablabitacoragr',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoragr.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', defaultContent: 'N/A' },
        { targets: 0, width: '250px', className: 'text-center'  },
        { targets: 1, width: '250px',className: 'text-center'  },
        { targets: 2, width: '200px',className: 'text-center'  },
        { targets: 3, width: '250px', className: 'text-center' },
        { targets: 4, width: '600px' },
        { targets: 5, width: '250px',className: 'text-center'  },
        { targets: 6, width: '800px', className: 'col-bien-servicio' }
    ],
    columns: [
        { data: 'NO_MR' },
        { data: 'FECHA_APRUEBA_MR' },
        { data: 'NO_PO' },
        { data: 'FECHA_APROBACION_PO' },
        { data: 'PROVEEDOR' },
        { data: 'FECHA_ENTREGA_PO' },
        { data: 'BIEN_SERVICIO' },
         {
        data: null,
        className: "text-center",
        defaultContent: '<button class="btn btn-sm btn-primary btn-gr">Ver GR</button>'
    }
    ],
    createdRow: function (row, data, dataIndex) {
        $(row).css('background-color', data.COLOR);
    },
    drawCallback: function () {
        const topScroll = document.querySelector('.tabla-scroll-top');
        const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
        const table = document.querySelector('#Tablabitacoragr');
        const scrollBody = document.querySelector('.dataTables_scrollBody');

        if (!topScroll || !scrollInner || !table || !scrollBody) return;

        const tableWidth = table.scrollWidth;
        scrollInner.style.width = tableWidth + 'px';

        let syncingTop = false;
        let syncingBottom = false;

        topScroll.addEventListener('scroll', function () {
            if (syncingTop) return;
            syncingBottom = true;
            scrollBody.scrollLeft = topScroll.scrollLeft;
            syncingBottom = false;
        });

        scrollBody.addEventListener('scroll', function () {
            if (syncingBottom) return;
            syncingTop = true;
            topScroll.scrollLeft = scrollBody.scrollLeft;
            syncingTop = false;
        });
    }
});

$(document).on('click', '.btn-ver-mas-materiales', function() {
    let $btn = $(this);
    let $extra = $btn.siblings('.extra-materiales');
    if ($extra.is(':visible')) {
        $extra.hide();
        $btn.text('Ver más');
    } else {
        $extra.show();
        $btn.text('Ver menos');
    }
});






// $('#Tablabitacoragr tbody').on('click', 'button.btn-gr', function () {
//     var data = Tablabitacoragr.row($(this).parents('tr')).data();

//     $('#modal_no_mr').val(data.NO_MR ?? '');
//     $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
//     $('#modal_no_po').val(data.NO_PO ?? '');
//     $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
//     $('#PROVEEDOR_EQUIPO').val(data.PROVEEDOR_KEY ?? '');
//     $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
//     $('#modal_usuario_nombre').val(data.USUARIO_NOMBRE ?? '');

//     let contenedor = $("#modal_bien_servicio");
//     contenedor.empty();

//     if (data.BIEN_SERVICIO) {
//         $(data.BIEN_SERVICIO).each(function (index) {
//             const texto = $(this).text().trim();

//             let limpio = texto.replace(/^•\s*/, "");
//             let partes = limpio.split(" - $ ");
//             let descYcantidad = partes[0];
//             let precio = partes[1] ?? "";
//             let match = descYcantidad.match(/^(.*)\((\d+)\)$/);
//             let descripcion = match ? match[1].trim() : descYcantidad.trim();
//             let cantidad = match ? match[2] : 0;

//           let bloque = $(`
//               <div class="border rounded p-3 mb-3 bg-light">
//                 <div class="row mb-2">
//                   <div class="col-3">
//                     <label class="form-label">Descripción</label>
//                     <textarea class="form-control" name="DESCRIPCION[]" rows="2" readonly>${escapeHtml(descripcion)}</textarea>
//                   </div>
//                   <div class="col-2">
//                     <label class="form-label">Cantidad</label>
//                     <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${cantidad}" readonly>
//                   </div>
//                   <div class="col-2">
//                     <label class="form-label">Cantidad Rechazada</label>
//                     <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="0" min="0">
//                   </div>
//                   <div class="col-2">
//                     <label class="form-label">Cantidad Aceptada</label>
//                     <input type="number" class="form-control cantidad-aceptada" name="CANTIDAD_ACEPTADA[]" value="0" min="0" max="${cantidad}">
//                   </div>
//                   <div class="col-3">
//                     <label class="form-label">Precio Unitario</label>
//                     <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${precio}" readonly>
//                   </div>
//                 </div>

//                 <div class="row mb-2 comentario-diferencia" style="display:none;">
//                   <div class="col-12">
//                     <label class="form-label">Comentario por diferencia en cantidad</label>
//                     <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2"></textarea>
//                   </div>
//                 </div>

//                 <div class="row mb-2">
//                   <div class="col-6">
//                     <label class="form-label">Cumple lo especificado el B o S</label>
//                     <select class="form-control" name="CUMPLE[]">
//                       <option value="">Seleccione</option>
//                       <option value="Sí">Sí</option>
//                       <option value="No">No</option>
//                     </select>
//                   </div>
//                   <div class="col-6">
//                     <label class="form-label">Comentario especificación</label>
//                     <textarea class="form-control" name="COMENTARIO_CUMPLE[]" rows="2"></textarea>
//                   </div>
//                 </div>

//                 <div class="row mb-2">
//                   <div class="col-6">
//                     <label class="form-label">Estado del B o S</label>
//                     <select class="form-control" name="ESTADO_FISICO[]">
//                       <option value="">Seleccione</option>
//                       <option value="BUEN_ESTADO">En buen estado</option>
//                       <option value="MAL_ESTADO">Mal estado</option>
//                     </select>
//                   </div>
//                   <div class="col-6">
//                     <label class="form-label">Comentario Estado</label>
//                     <textarea class="form-control" name="COMENTARIO_ESTADO[]" rows="2"></textarea>
//                   </div>
//                 </div>

//                 <div class="row mb-2">
//                   <div class="col-12">
//                     <label class="form-label">Tipo</label>
//                     <select class="form-control" name="TIPO_BS[]">
//                       <option value="">Seleccione</option>
//                       <option value="Bien">Bien</option>
//                       <option value="Servicio">Servicio</option>
//                     </select>
//                   </div>
//                 </div>
//               </div>
//             `);




//             contenedor.append(bloque);

//           bloque.find(".cantidad-aceptada").on("input", function () {
//                 let cant = parseFloat(bloque.find(".cantidad").val());
//                 let aceptada = parseFloat($(this).val());

//                 if (aceptada > cant) {
//                     $(this).val(cant);
//                     aceptada = cant;
//                 }

//                 if (!isNaN(cant) && !isNaN(aceptada) && cant !== aceptada) {
//                     bloque.find(".comentario-diferencia").show();
//                 } else {
//                     bloque.find(".comentario-diferencia").hide();
//                 }
//             });

//         });
//     } else {
//         contenedor.html('<div class="text-muted">No hay bienes o servicios</div>');
//     }

//     $('#modalGR').modal('show');
// });






$('#Tablabitacoragr tbody').on('click', 'button.btn-gr', function () {
    var data = Tablabitacoragr.row($(this).parents('tr')).data();

    // Cabecera base
    let requestData = {
        NO_MR: data.NO_MR ?? '',
        NO_PO: data.NO_PO ?? '',
        PROVEEDOR: data.PROVEEDOR_KEY ?? '',
        _token: $('input[name="_token"]').val()
    };

    $.post('/consultar-gr', requestData, function(resp) {
        let contenedor = $("#modal_bien_servicio");
        contenedor.empty();

        // ==========================
        // Caso: YA EXISTE GR
        // ==========================
        if (resp.existe) {
            let cab = resp.cabecera;

          
          $('#ID_GR').val(cab.ID_GR ?? '');

            $('#modal_no_mr').val(cab.NO_MR);
            $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
            $('#modal_no_po').val(cab.NO_PO ?? '');
            $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
            $('#PROVEEDOR_EQUIPO').val(cab.PROVEEDOR_KEY ?? '');
            $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
            $('#modal_usuario_nombre').val(cab.USUARIO_SOLICITO ?? '');
            $('#DESDE_ACREDITACION').val(cab.FECHA_EMISION ?? '');
            $('#NO_RECEPCION').val(cab.NO_RECEPCION ?? '');

            // Detalle guardado
            resp.detalle.forEach(det => {
                let bloque = $(`
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="row mb-2">
                          <div class="col-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="DESCRIPCION[]" rows="2" readonly>${det.DESCRIPCION}</textarea>
                          </div>
                          <div class="col-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${det.CANTIDAD}" readonly>
                          </div>
                          <div class="col-2">
                            <label class="form-label">Cantidad Rechazada</label>
                            <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="${det.CANTIDAD_RECHAZADA}">
                          </div>
                          <div class="col-2">
                            <label class="form-label">Cantidad Aceptada</label>
                            <input type="number" class="form-control cantidad-aceptada" name="CANTIDAD_ACEPTADA[]" value="${det.CANTIDAD_ACEPTADA}">
                          </div>
                          <div class="col-3">
                            <label class="form-label">Precio Unitario</label>
                            <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${det.PRECIO_UNITARIO}" readonly>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-6">
                            <label class="form-label">Cumple</label>
                            <select class="form-control" name="CUMPLE[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.CUMPLE=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.CUMPLE=="No"?"selected":""}>No</option>
                            </select>
                          </div>
                          <div class="col-6">
                            <label class="form-label">Comentario especificación</label>
                            <textarea class="form-control" name="COMENTARIO_CUMPLE[]" rows="2">${det.COMENTARIO_CUMPLE??""}</textarea>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-6">
                            <label class="form-label">Estado</label>
                            <select class="form-control" name="ESTADO_FISICO[]">
                              <option value="">Seleccione</option>
                              <option value="BUEN_ESTADO" ${det.ESTADO_FISICO=="BUEN_ESTADO"?"selected":""}>En buen estado</option>
                              <option value="MAL_ESTADO" ${det.ESTADO_FISICO=="MAL_ESTADO"?"selected":""}>Mal estado</option>
                            </select>
                          </div>
                          <div class="col-6">
                            <label class="form-label">Comentario Estado</label>
                            <textarea class="form-control" name="COMENTARIO_ESTADO[]" rows="2">${det.COMENTARIO_ESTADO??""}</textarea>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-12">
                            <label class="form-label">Tipo</label>
                            <select class="form-control" name="TIPO_BS[]">
                              <option value="">Seleccione</option>
                              <option value="Bien" ${det.TIPO_BS=="Bien"?"selected":""}>Bien</option>
                              <option value="Servicio" ${det.TIPO_BS=="Servicio"?"selected":""}>Servicio</option>
                            </select>
                          </div>
                        </div>
                    </div>
                `);
                contenedor.append(bloque);
            });

        // ==========================
        // Caso: NO EXISTE GR
        // ==========================
        } else {
            $('#modal_no_mr').val(data.NO_MR ?? '');
            $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
            $('#modal_no_po').val(data.NO_PO ?? '');
            $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
            $('#PROVEEDOR_EQUIPO').val(data.PROVEEDOR_KEY ?? '');
            $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
            $('#modal_usuario_nombre').val(data.USUARIO_NOMBRE ?? '');

            // === Lógica original ===
            if (data.BIEN_SERVICIO) {
                $(data.BIEN_SERVICIO).each(function (index) {
                    const texto = $(this).text().trim();

                    let limpio = texto.replace(/^•\s*/, "");
                    let partes = limpio.split(" - $ ");
                    let descYcantidad = partes[0];
                    let precio = partes[1] ?? "";
                    let match = descYcantidad.match(/^(.*)\((\d+)\)$/);
                    let descripcion = match ? match[1].trim() : descYcantidad.trim();
                    let cantidad = match ? match[2] : 0;

                    let bloque = $(`
                        <div class="border rounded p-3 mb-3 bg-light">
                          <div class="row mb-2">
                            <div class="col-3">
                              <label class="form-label">Descripción</label>
                              <textarea class="form-control" name="DESCRIPCION[]" rows="2" readonly>${escapeHtml(descripcion)}</textarea>
                            </div>
                            <div class="col-2">
                              <label class="form-label">Cantidad</label>
                              <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${cantidad}" readonly>
                            </div>
                            <div class="col-2">
                              <label class="form-label">Cantidad Rechazada</label>
                              <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="0" min="0">
                            </div>
                            <div class="col-2">
                              <label class="form-label">Cantidad Aceptada</label>
                              <input type="number" class="form-control cantidad-aceptada" name="CANTIDAD_ACEPTADA[]" value="0" min="0" max="${cantidad}">
                            </div>
                            <div class="col-3">
                              <label class="form-label">Precio Unitario</label>
                              <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${precio}" readonly>
                            </div>
                          </div>

                          <div class="row mb-2 comentario-diferencia" style="display:none;">
                            <div class="col-12">
                              <label class="form-label">Comentario por diferencia en cantidad</label>
                              <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2"></textarea>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-6">
                              <label class="form-label">Cumple lo especificado el B o S</label>
                              <select class="form-control" name="CUMPLE[]">
                                <option value="">Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                              </select>
                            </div>
                            <div class="col-6">
                              <label class="form-label">Comentario especificación</label>
                              <textarea class="form-control" name="COMENTARIO_CUMPLE[]" rows="2"></textarea>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-6">
                              <label class="form-label">Estado del B o S</label>
                              <select class="form-control" name="ESTADO_FISICO[]">
                                <option value="">Seleccione</option>
                                <option value="BUEN_ESTADO">En buen estado</option>
                                <option value="MAL_ESTADO">Mal estado</option>
                              </select>
                            </div>
                            <div class="col-6">
                              <label class="form-label">Comentario Estado</label>
                              <textarea class="form-control" name="COMENTARIO_ESTADO[]" rows="2"></textarea>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-12">
                              <label class="form-label">Tipo</label>
                              <select class="form-control" name="TIPO_BS[]">
                                <option value="">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Servicio">Servicio</option>
                              </select>
                            </div>
                          </div>
                        </div>
                    `);

                    contenedor.append(bloque);

                    bloque.find(".cantidad-aceptada").on("input", function () {
                        let cant = parseFloat(bloque.find(".cantidad").val());
                        let aceptada = parseFloat($(this).val());

                        if (aceptada > cant) {
                            $(this).val(cant);
                            aceptada = cant;
                        }

                        if (!isNaN(cant) && !isNaN(aceptada) && cant !== aceptada) {
                            bloque.find(".comentario-diferencia").show();
                        } else {
                            bloque.find(".comentario-diferencia").hide();
                        }
                    });
                });
            } else {
                contenedor.html('<div class="text-muted">No hay bienes o servicios</div>');
            }
        }

        $('#modalGR').modal('show');
    });
});








$('#btnGuardarGR').on('click', function () {
    let formData = $("#formulariorecepciongr").serialize();

    $.ajax({
        url: '/guardarGR',
        method: 'POST',
        data: formData,
        success: function (resp) {
            if (resp.ok) {
                Swal.fire('Éxito', 'GR guardada con número ' + resp.no_gr, 'success');
                $('#modalGR').modal('hide');
                Tablabitacoragr.ajax.reload();
            } else {
                Swal.fire('Error', resp.msg, 'error');
            }
        }
    });
});
