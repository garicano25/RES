


const modalgr = document.getElementById('modalGR');

modalgr.addEventListener('hidden.bs.modal', event => {
    document.getElementById('formulariorecepciongr').reset();

    $('#ID_GR').val('');

    $('#modal_bien_servicio').empty();
  
    $('.comentario-diferencia').hide();

  
});








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














$('#Tablabitacoragr tbody').on('click', 'button.btn-gr', function () {
    var data = Tablabitacoragr.row($(this).parents('tr')).data();

    let requestData = {
        NO_MR: data.NO_MR ?? '',
        NO_PO: data.NO_PO ?? '',
        PROVEEDOR: data.PROVEEDOR_KEY ?? '',
        _token: $('input[name="_token"]').val()
    };

    $.post('/consultar-gr', requestData, function (resp) {
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
            $('#MANDAR_USUARIO_VOBO').val(cab.MANDAR_USUARIO_VOBO ?? '');
            $('#FECHA_VOUSUARIO').val(cab.FECHA_VOUSUARIO ?? '');
            $('#VO_BO_USUARIO').val(cab.VO_BO_USUARIO ?? '');



            resp.detalle.forEach(det => {
                let bloque = $(`
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="row mb-2">
                          <div class="col-3 mt-2">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="DESCRIPCION[]" rows="2" >${det.DESCRIPCION}</textarea>
                          </div>

                          <div class="col-3 mt-2">
                            <label class="form-label">¿Está en inventario?</label>
                            <select class="form-control en_inventario" name="EN_INVENTARIO[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.EN_INVENTARIO=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.EN_INVENTARIO == "No" ? "selected" : ""}>No</option>
                              
                            </select>
                          </div>
                          <div class="col-6 bloque-inventario" style="display:${det.INVENTARIO_ID ? 'block' : 'none'};">
                            <div class="row">
                              <div class="col-6 mt-2">
                                <label class="form-label">Tipo Inventario</label>
                                <select class="form-control tipo_inventario" name="TIPO_INVENTARIO[]">
                                  <option value="">Seleccione</option>
                                  ${resp.tipoinventario ? resp.tipoinventario.map(t => 
                                    `<option value="${t.ID_CATALOGO_TIPOINVENTARIO}" ${det.TIPO_EQUIPO == t.DESCRIPCION_TIPO ? "selected" : ""}>${t.DESCRIPCION_TIPO}</option>`
                                  ).join("") : ""}
                                </select>
                              </div>
                              <div class="col-6 mt-2">
                                <label class="form-label">Inventario</label>
                                <select class="form-control inventario" name="INVENTARIO[]">
                                  <option value="">Seleccione</option>
                                  ${resp.inventario ? resp.inventario
                                    .filter(inv => inv.TIPO_EQUIPO == det.TIPO_EQUIPO)
                                    .map(inv =>
                                      `<option value="${inv.ID_FORMULARIO_INVENTARIO}" ${det.INVENTARIO_ID == inv.ID_FORMULARIO_INVENTARIO ? "selected" : ""}>${inv.DESCRIPCION_EQUIPO}</option>`
                                    ).join("") : ""}
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-4 mt-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${det.CANTIDAD}" readonly>
                          </div>
                          <div class="col-4 mt-2">
                            <label class="form-label">Precio Unitario</label>
                            <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${det.PRECIO_UNITARIO}" readonly>
                          </div>
                          <div class="col-4 mt-2">
                            <label class="form-label">Precio Total</label>
                            <input type="text" class="form-control precio_total_mr" name="PRECIO_TOTAL_MR[]" value="${det.PRECIO_TOTAL_MR ?? 0}" readonly>
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-3 mt-2">
                            <label class="form-label">Cantidad Rechazada</label>
                            <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="${det.CANTIDAD_RECHAZADA}">
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Cantidad Aceptada</label>
                            <input type="number" class="form-control cantidad_aceptada" name="CANTIDAD_ACEPTADA[]" value="${det.CANTIDAD_ACEPTADA}">
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Precio Unitario GR</label>
                            <input type="text" class="form-control precio_unitario_gr" name="PRECIO_UNITARIO_GR[]" value="${det.PRECIO_UNITARIO_GR ?? 0}" readonly>
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Precio Total GR</label>
                            <input type="text" class="form-control precio_total_gr" name="PRECIO_TOTAL_GR[]" value="${det.PRECIO_TOTAL_GR ?? 0}" readonly>
                          </div>
                        </div>

                        <div class="row mb-2 comentario-diferencia" style="display:${det.CANTIDAD != det.CANTIDAD_ACEPTADA ? 'block' : 'none'};">
                          <div class="col-12 mt-2">
                            <label class="form-label">Comentario por diferencia en cantidad</label>
                            <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2">${det.COMENTARIO_DIFERENCIA ?? ""}</textarea>
                          </div>
                        </div>
                      <div class="row mb-2">
                          <div class="col-6 mt-2">
                            <label class="form-label">Cumple</label>
                            <select class="form-control" name="CUMPLE[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.CUMPLE=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.CUMPLE=="No"?"selected":""}>No</option>
                            </select>
                          </div>
                          <div class="col-6 mt-2">
                            <label class="form-label">Comentario especificación</label>
                            <textarea class="form-control" name="COMENTARIO_CUMPLE[]" rows="2">${det.COMENTARIO_CUMPLE??""}</textarea>
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-6 mt-2">
                            <label class="form-label">Estado</label>
                            <select class="form-control" name="ESTADO_BS[]">
                              <option value="">Seleccione</option>
                              <option value="BUEN_ESTADO" ${det.ESTADO_BS=="BUEN_ESTADO"?"selected":""}>En buen estado</option>
                              <option value="MAL_ESTADO" ${det.ESTADO_BS=="MAL_ESTADO"?"selected":""}>Mal estado</option>
                            </select>
                          </div>
                          <div class="col-6 mt-2">
                            <label class="form-label">Comentario Estado</label>
                            <textarea class="form-control" name="COMENTARIO_ESTADO[]" rows="2">${det.COMENTARIO_ESTADO??""}</textarea>
                          </div>
                        </div>

                          <div class="row mb-3">
                          <div class="col-12 text-center">
                            <h4>Vo.Bo usuario</h4>
                          </div>
                        </div>
                          <div class="row mb-2">
                          <div class="col-2 mt-2">
                            <label class="form-label">Cantidad aceptada por usuario</label>
                            <input type="number" class="form-control" name="CANTIDAD_ACEPTADA_USUARIO[]" value="${det.CANTIDAD_ACEPTADA_USUARIO}">
                          </div>
                          <div class="col-2 mt-2">
                            <label class="form-label">Cumple lo especificado usuario</label>
                            <select class="form-control" name="CUMPLE_ESPECIFICADO_USUARIO[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.CUMPLE_ESPECIFICADO_USUARIO=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.CUMPLE_ESPECIFICADO_USUARIO=="No"?"selected":""}>No</option>
                            </select>
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Comentario especificación usuario</label>
                            <textarea class="form-control" name="COMENTARIO_CUMPLE_USUARIO[]" rows="2">${det.COMENTARIO_CUMPLE_USUARIO??""}</textarea>
                          </div>
                         <div class="col-2 mt-2">
                            <label class="form-label">Estado del B o S usuario</label>
                            <select class="form-control" name="ESTADO_BS_USUARIO[]">
                              <option value="">Seleccione</option>
                                 <option value="BUEN_ESTADO" ${det.ESTADO_BS_USUARIO=="BUEN_ESTADO"?"selected":""}>En buen estado</option>
                              <option value="MAL_ESTADO" ${det.ESTADO_BS_USUARIO=="MAL_ESTADO"?"selected":""}>Mal estado</option>
                            </select>
                          </div>

                          <div class="col-3 mt-2">
                            <label class="form-label">Comentario estado usuario</label>
                            <textarea class="form-control" name="COMENTARIO_ESTADO_USUARIO[]" rows="2">${det.COMENTARIO_ESTADO_USUARIO??""}</textarea>
                          </div>
                        </div>



                        

                        <div class="row mb-2">
                          <div class="col-12 mt-2">
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

                calcularTotales(bloque);

                bloque.find(".cantidad_aceptada").on("input", function () {
                    calcularTotales(bloque);
                    let cant = parseFloat(bloque.find(".cantidad").val()) || 0;
                    let aceptada = parseFloat($(this).val()) || 0;
                    bloque.find(".comentario-diferencia").toggle(cant !== aceptada);
                });

                bloque.find(".en_inventario").on("change", function () {
                    if ($(this).val() === "Sí") {
                        bloque.find(".bloque-inventario").show();
                    } else {
                        bloque.find(".bloque-inventario").hide();
                        bloque.find(".tipo_inventario").val("");
                        bloque.find(".inventario").empty().append('<option value="">Seleccione</option>');
                    }
                });

                bloque.find(".tipo_inventario").on("change", function () {
                    let tipoDesc = $(this).find("option:selected").text();
                    let inventarioSelect = bloque.find(".inventario");
                    inventarioSelect.empty().append('<option value="">Seleccione</option>');

                    if (tipoDesc) {
                        resp.inventario
                            .filter(inv => inv.TIPO_EQUIPO == tipoDesc)
                            .forEach(inv => {
                                inventarioSelect.append(
                                    `<option value="${inv.ID_FORMULARIO_INVENTARIO}">${inv.DESCRIPCION_EQUIPO}</option>`
                                );
                            });
                    }
                });
            });

        // ==========================
        // Caso: NO EXISTE GR
        // ==========================
        } else {
            $('#ID_GR').val(""); 
            $('#modal_no_mr').val(data.NO_MR ?? '');
            $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
            $('#modal_no_po').val(data.NO_PO ?? '');
            $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
            $('#PROVEEDOR_EQUIPO').val(data.PROVEEDOR_KEY ?? '');
            $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
            $('#modal_usuario_nombre').val(data.USUARIO_NOMBRE ?? '');

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
                            <div class="col-3 mt-2">
                              <label class="form-label">Descripción</label>
                              <textarea class="form-control" name="DESCRIPCION[]" rows="2" >${escapeHtml(descripcion)}</textarea>
                            </div>

                            <div class="col-3 mt-2">
                              <label class="form-label">¿Está en inventario?</label>  
                              <select class="form-control en_inventario" name="EN_INVENTARIO[]">
                                <option value="" >Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                              </select>
                            </div>
                              <div class="col-6 bloque-inventario" style="display:none;">
                                <div class="row">
                                  <div class="col-6 mt-2">
                                    <label class="form-label">Tipo Inventario</label>
                                    <select class="form-control tipo_inventario" name="TIPO_INVENTARIO[]">
                                      <option value="">Seleccione</option>
                                      ${resp.tipoinventario.map(t => 
                                        `<option value="${t.ID_CATALOGO_TIPOINVENTARIO}">${t.DESCRIPCION_TIPO}</option>`
                                      ).join("")}
                                    </select>
                                  </div>
                                  <div class="col-6 mt-2">
                                    <label class="form-label">Inventario</label>
                                    <select class="form-control inventario" name="INVENTARIO[]">
                                      <option value="">Seleccione</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            <div class="col-4 mt-2">
                              <label class="form-label">Cantidad</label>
                              <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${cantidad}" readonly>
                            </div>
                            <div class="col-4 mt-2">
                              <label class="form-label">Precio Unitario</label>
                              <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${precio}" readonly>
                            </div>
                            <div class="col-4 mt-2">
                              <label class="form-label">Precio Total</label>
                              <input type="text" class="form-control precio_total_mr" name="PRECIO_TOTAL_MR[]" value="0" readonly>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-3 mt-2">
                              <label class="form-label">Cantidad Rechazada</label>
                              <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="0" min="0">
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Cantidad Aceptada</label>
                              <input type="number" class="form-control cantidad_aceptada" name="CANTIDAD_ACEPTADA[]" value="0" min="0" max="${cantidad}">
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Precio Unitario GR</label>
                              <input type="text" class="form-control precio_unitario_gr" name="PRECIO_UNITARIO_GR[]" value="0" readonly>
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Precio Total GR</label>
                              <input type="text" class="form-control precio_total_gr" name="PRECIO_TOTAL_GR[]" value="0" readonly>
                            </div>
                          </div>

                          <div class="row mb-2 comentario-diferencia" style="display:none;">
                            <div class="col-12 mt-2">
                              <label class="form-label">Comentario por diferencia en cantidad</label>
                              <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2"></textarea>
                            </div>
                          </div>

                        <div class="row mb-2">
                            <div class="col-6 mt-2">
                              <label class="form-label">Cumple lo especificado el B o S</label>
                              <select class="form-control" name="CUMPLE[]">
                                <option value="">Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                              </select>
                            </div>
                            <div class="col-6 mt-2">
                              <label class="form-label">Comentario especificación</label>
                              <textarea class="form-control" name="COMENTARIO_CUMPLE[]" rows="2"></textarea>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-6 mt-2">
                              <label class="form-label">Estado del B o S</label>
                              <select class="form-control" name="ESTADO_BS[]">
                                <option value="">Seleccione</option>
                                <option value="BUEN_ESTADO">En buen estado</option>
                                <option value="MAL_ESTADO">Mal estado</option>
                              </select>
                            </div>
                            <div class="col-6 mt-2">
                              <label class="form-label">Comentario Estado</label>
                              <textarea class="form-control" name="COMENTARIO_ESTADO[]" rows="2"></textarea>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <div class="col-12 mt-2">
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

                  calcularTotales(bloque);

                
                    bloque.find(".cantidad_aceptada").on("input", function () {
                        calcularTotales(bloque);
                        let cant = parseFloat(bloque.find(".cantidad").val()) || 0;
                        let aceptada = parseFloat($(this).val()) || 0;
                        bloque.find(".comentario-diferencia").toggle(cant !== aceptada);
                    });

                    bloque.find(".en_inventario").on("change", function () {
                        if ($(this).val() === "Sí") {
                            bloque.find(".bloque-inventario").show();
                        } else {
                            bloque.find(".bloque-inventario").hide();
                            bloque.find(".tipo_inventario").val("");
                            bloque.find(".inventario").empty().append('<option value="">Seleccione</option>');
                        }
                    });

                    bloque.find(".tipo_inventario").on("change", function () {
                        let tipoDesc = $(this).find("option:selected").text();
                        let inventarioSelect = bloque.find(".inventario");
                        inventarioSelect.empty().append('<option value="">Seleccione</option>');

                        if (tipoDesc) {
                            resp.inventario
                                .filter(inv => inv.TIPO_EQUIPO == tipoDesc)
                                .forEach(inv => {
                                    inventarioSelect.append(
                                        `<option value="${inv.ID_FORMULARIO_INVENTARIO}">${inv.DESCRIPCION_EQUIPO}</option>`
                                    );
                                });
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



function calcularTotales(bloque) {
      let cantidad = parseFloat(bloque.find(".cantidad").val()) || 0;
      let precioUnit = parseFloat(bloque.find(".precio_unitario").val()) || 0;

    
      let totalMr = cantidad * precioUnit;
      bloque.find(".precio_total_mr").val(totalMr.toFixed(2));
      
      let aceptada = parseFloat(bloque.find(".cantidad_aceptada").val()) || 0;

      let precioUnitGr = (aceptada > 0) ? (totalMr / aceptada) : 0;
      bloque.find(".precio_unitario_gr").val(precioUnitGr.toFixed(2));

      let totalGr = aceptada * precioUnitGr;
      bloque.find(".precio_total_gr").val(totalGr.toFixed(2));
  
      if (cantidad !== aceptada) {
          bloque.find(".comentario-diferencia").show();
      } else {
          bloque.find(".comentario-diferencia").hide();
      }
}








$('#btnGuardarGR').on('click', function () {
    let formData = $("#formulariorecepciongr").serialize();

    Swal.fire({
        title: '¿Desea guardar la GR?',
        text: "Confirme para continuar",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/guardarGR',
                method: 'POST',
                data: formData,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Guardando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (resp) {
                    Swal.close(); 

                    if (resp.ok) {
                        Swal.fire('Éxito', 'GR guardada', 'success');
                        $('#modalGR').modal('hide');
                        Tablabitacoragr.ajax.reload();
                    } else {
                        Swal.fire('Error', resp.msg, 'error');
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire('Error', 'Ocurrió un problema al guardar la GR', 'error');
                }
            });
        }
    });
});

