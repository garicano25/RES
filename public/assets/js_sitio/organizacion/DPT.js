//VARIABLES
ID_FORMULARIO_DPT = 0


const ModalArea = document.getElementById('miModal_DPT');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_DPT = 0;
    document.getElementById('formularioDPT').reset();
    $('#formularioDPT input').prop('disabled', false);
    $('#formularioDPT textarea').prop('disabled', false);
    $('#formularioDPT select').prop('disabled', false);

    $('.collapse').collapse('hide');

    $('#guardarFormDPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormDPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormDPT').css('display', 'none').prop('disabled', true);

    // Resetea la tabla
    $('#tbodyFucnionesCargo').empty();
    $('#tbodyFuncionesGestion').empty();
});



TablaDPT = $("#TablaDPT").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
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
        url: '/TablaDPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaDPT.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'ID_FORMULARIO_DPT' },
        { data: 'NOMBRE_CATEGORIA' }, 
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_ACCION' },
        { data: 'BTN_DPT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
        
        
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Nombre categoría', className: 'all' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Autorizado por', className: 'all text-center' },
        { target: 5, title: 'Estatus', className: 'all text-center' },
        { target: 6, title: 'Descargar', className: 'all text-center' },
        { target: 7, title: 'Editar', className: 'all text-center' },
        { target: 8, title: 'Inactivo', className: 'all text-center' },



    ]
})


$("#guardarFormDPT").click(function (e) {
        e.preventDefault();

        formularioValido = validarFormulario($('#formularioDPT'))

     if (formularioValido) {

        if (ID_FORMULARIO_DPT == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usara para la creación del DPT",
                icon: "question",
            }, async function () { 
                await loaderbtn('guardarFormDPT');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT}, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT;
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del DPT',null,null, 1500);
                        $('#miModal_DPT').modal('hide');
                        document.getElementById('formularioDPT').reset();
                        TablaDPT.ajax.reload();
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);
                });
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editara la información del DPT",
                icon: "question",
            }, async function () { 
                await loaderbtn('guardarFormDPT');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT }, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#miModal_DPT').modal('hide');
                        document.getElementById('formularioDPT').reset();
                        TablaDPT.ajax.reload();
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);  
                });
            }, 1);
        }
         } else {
        // Muestra un mensaje de error o realiza alguna otra acción
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
});



var info = ''
$("#DEPARTAMENTOS_AREAS_ID").on("change", function () {

    var valorSeleccionado = $(this).find("option:selected");

    //Obtenemos valores
    var infoLugar = valorSeleccionado.data("lugar");
    var infoProposito = valorSeleccionado.data("proposito");
    var infoLider = valorSeleccionado.data("lider");
    var textoSeleccionado = valorSeleccionado.text();

    //Asignamos valores 
    $('#AREA_TRABAJO_DPT').val(infoLugar).prop('readonly', true)
    $('#PROPOSITO_FINALIDAD_DPT').val(infoProposito).prop('readonly', true)


    //Creamos la ruta de consulta 
    lider = textoSeleccionado.toUpperCase() == 'DIRECTOR' ? 2 : parseInt(infoLider)
    ruta = '/infoReportan/' + parseInt($(this).val()) + '/' + lider

    //Realizamos la peticion para consultar la informacion
    ajaxAwait({}, ruta , 'GET', { callbackAfter: true, callbackBefore: true }, () => {

        $('#PUESTO_REPORTA_DPT').val('Consultando información...').prop('readonly', true)
        $('#PUESTO_LE_REPORTAN_DPT').val('Consultando información...').prop('readonly', true)
        $('#PUESTOS_DIRECTOS_DPT').val('Consultando información...').prop('readonly', true)


    }, function (data) {
            info = data


            $('#tbodyFucnionesCargo').empty();
            
            //FUNCIONES DE CARG0
            $.each(data.FUNCIONES, function(index, funcion) {
                let rowHtml = '';
            
                if (funcion.TIPO == 'generica') {
                    rowHtml = `<tr>
                        <td id="desc-cargo-${funcion.ID}" class="description blocked">
                            ${funcion.DESCRIPCION}
                        </td>
                        <td>
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </td>
                    </tr>`;
                } else {
                    rowHtml = `<tr>
                        <td id="desc-cargo-${funcion.ID}" class="description active">
                            ${funcion.DESCRIPCION}
                        </td>
                        <td>
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </td>
                    </tr>`;
                }
            
                $('#tbodyFucnionesCargo').append(rowHtml);
            });

                //FUNCIONES DE GESTIONES

            // $('#tbodyFuncionesGestion').empty();

          
            //  $.each(data.GESTIONES, function(index, gestion) {
            //     let rowHtml = '';
            
            //     if (gestion.TIPO == 'generica') {
            //         rowHtml = `<tr>
            //             <td id="desc-gestion-${gestion.ID}" class="description blocked">
            //                 ${gestion.DESCRIPCION}
            //             </td>
            //             <td>
            //                 <div class="switch-container">
            //                     <label class="switch">
            //                         <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_GESTION_DPT[]" value="${gestion.ID}">
            //                         <span class="slider"></span>
            //                     </label>
            //                 </div>
            //             </td>
            //         </tr>`;
            //     } else {
            //         rowHtml = `<tr>
            //             <td id="desc-gestion-${gestion.ID}" class="description active">
            //                 ${gestion.DESCRIPCION}
            //             </td>
            //             <td>
            //                 <div class="switch-container">
            //                     <label class="switch">
            //                         <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_GESTION_DPT[]" value="${gestion.ID}" checked>
            //                         <span class="slider"></span>
            //                     </label>
            //                 </div>
            //             </td>
            //         </tr>`;
            //     }
            
            //     $('#tbodyFuncionesGestion').append(rowHtml);
            // });
        
        

        //CONSUILTAMOS LOS REPONSABLES DE CADA CATEGORIA
        if (lider == 1 || lider == 2) {
            $('#PUESTO_REPORTA_DPT').val(data.REPORTA).prop('readonly', true)
            $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN[0].REPORTAN).prop('readonly', true)
            $('#PUESTOS_DIRECTOS_DPT').val(data.REPORTAN[0].TOTAL).prop('readonly', true)


        } else {

            $('#PUESTO_REPORTA_DPT').val(data.REPORTA[0].REPORTA).prop('readonly', true)
            $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN).prop('readonly', true)
            $('#PUESTOS_DIRECTOS_DPT').val(0).prop('readonly', true)

        }  
    })
});





//FUNCION EDITAR   Y QUE SE MUESTREN LOS SELECT

$(document).ready(function () {
    // Inicializar Selectize
    var $select = $('#PUESTOS_INTERACTUAN_DPT').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
        onItemAdd: function(value, $item) {
            contarPuestosInderectos();
        },
        onItemRemove: function(value) {
            contarPuestosInderectos();
        }
    });

    var selectizeInstance = $select[0].selectize;

    $('#TablaDPT tbody').on('click', 'td>button.EDITAR', function () {
        var tr = $(this).closest('tr');
        var row = TablaDPT.row(tr);
        ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT;
        var form = "formularioDPT";
        var data = row.data();
        
        var savedOptions = [];

        var puestosInteractuan = data.PUESTOS_INTERACTUAN_DPT;

        if (Array.isArray(puestosInteractuan)) { 
            savedOptions = puestosInteractuan;
        } else if (puestosInteractuan && puestosInteractuan.length > 2) { 
            try {
                savedOptions = JSON.parse(puestosInteractuan);
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
            }
        } else {
            console.warn("PUESTOS_INTERACTUAN_DPT está vacío o no tiene un formato JSON válido.");
        }
        
        selectizeInstance.clear();

        if (Array.isArray(savedOptions)) {
            selectizeInstance.setValue(savedOptions);
        }

        editarDatoTabla(data, form, 'miModal_DPT', 1);
        mostrarFunciones(data, form);
    });



    //Funciones para contar el numero de puestos Inderectos que interactuan con una categia
    function contarPuestosInderectos() {
        var count = $select[0].selectize.items.length;
        $('#PUESTOS_INDIRECTOS_DPT').val(count);
    }
});



function toggleDescription(tablePrefix, id, checked) {
    const description = document.getElementById(`desc-${tablePrefix}-${id}`);
    if (description) {
        if (checked) {
            description.classList.remove('blocked');
            description.classList.add('active');
        } else {
            description.classList.remove('active');
            description.classList.add('blocked');
        }
    }
}

// MARCAR LOS CHECK Y QUE SE PONGAN LAS LETRAS EN NEGRO 
$(document).on('change', '.toggle-switch-cargo', function() {
    let isChecked = $(this).is(':checked');
    let descripcionTd = $(this).closest('tr').find('.description');

    if (isChecked) {
        descripcionTd.removeClass('blocked').addClass('active');
    } else {
        descripcionTd.removeClass('active').addClass('blocked');
    }
});





$('#TablaDPT tbody').on('click', 'td>button.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaDPT.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1, 
        ID_FORMULARIO_DPT: row.data().ID_FORMULARIO_DPT
    }
    
    eliminarDatoTabla(data, [TablaDPT], 'dptDelete');
})



// $('#TablaDPT tbody').on('click', 'td>button.REVISAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#revisarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })


// $('#TablaDPT tbody').on('click', 'td>button.AUTORIZAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#AutorizarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })

// $('#revisarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea marcar como revisado este DPT?",
//         text: "Al revisarlo, pasara hacer autorizado ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/revisarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la revisión',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


// $('#AutorizarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea autorizar el DPT?",
//         text: "Al autorizarlo, podra hacer uso del DPT ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/autorizarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la autorización',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


$('#TablaDPT tbody').on('click', 'td>button.DPT', function () {


    var tr = $(this).closest('tr');
    var row = TablaDPT.row(tr);
    ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato DPT?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelDPT/" + ID_FORMULARIO_DPT);
           
        
    }, 1)

})





// NO SELECCIONAR LA MISMA CATEGORIA EN LAS RELACIONES INTERNAS
document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.area-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});

// NO SELECCIONAR LOS MISMOS DE RELACIONES EXTERNAS 

document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.externa-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});


// NO SELECCIONAR LAS MISMAS Competencias básicas o cardinales 
document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.cardinales-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});

// NO SELECCIONAR LAS MISMAS Competencias gerenciales o de mandos medios

document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.gerenciales-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});




// CREAR UN NUEVO DPT
$(document).ready(function () {
    $("#nuevo_dpt").click(function (e) {
        e.preventDefault();
        $("#miModal_DPT").modal("show");

        $('.toggle-switch-cargo').each(function () {
            this.checked = false; 
            toggleDescription(this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion', this.value, false);
        });

        var selectize = $('#PUESTOS_INTERACTUAN_DPT')[0].selectize;
        selectize.clear();
    });

    document.querySelectorAll('.toggle-switch-cargo').forEach(switchInput => {
        switchInput.addEventListener('change', function () {
            const id = this.value; 
            const tablePrefix = this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion';
            toggleDescription(tablePrefix, id, this.checked);
        });
    });

    function toggleDescription(tablePrefix, id, checked) {
        const description = document.getElementById(`desc-${tablePrefix}-${id}`);
        if (description) {
            if (checked) {
                description.classList.remove('blocked');
                description.classList.add('active');
            } else {
                description.classList.remove('active');
                description.classList.add('blocked');
            }
        }
    }
});


function mostrarFunciones(data,form){

    if ('INTERNAS' in data) {

        if (data.INTERNAS.length > 0) { 
          var cursos = data.INTERNAS
          var count = 1    
  
            // Supongamos que 'data' es el array que contiene los objetos de datos
          cursos.forEach(function (obj) {
  
  
            
            // Acceder a las propiedades de cada objeto    INTERNAS_CONQUIEN1_DPT  INTERNAS_PARAQUE1_DPT   INTERNAS_FRECUENCIA1_DPT
            $('#' + form).find(`select[id='INTERNAS_CONQUIEN${count}_DPT']`).val(obj.INTERNAS_CONQUIEN_DPT)
            $('#' + form).find(`textarea[id='INTERNAS_PARAQUE${count}_DPT']`).val(obj.INTERNAS_PARAQUE_DPT)
            $('#' + form).find(`select[id='INTERNAS_FRECUENCIA${count}_DPT']`).val(obj.INTERNAS_FRECUENCIA_DPT)
  
            count++
          });
        }
      }
  
      
      if ('EXTERNAS' in data) {
  
        if (data.EXTERNAS.length > 0) { 
          var cursos1 = data.EXTERNAS
          var count = 1    
  
            // Supongamos que 'data' es el array que contiene los objetos de datos
          cursos1.forEach(function (obj) {
  
            // Acceder a las propiedades de cada objeto    INTERNAS_CONQUIEN1_DPT  INTERNAS_PARAQUE1_DPT   INTERNAS_FRECUENCIA1_DPT
            $('#' + form).find(`select[id='EXTERNAS_CONQUIEN${count}_DPT']`).val(obj.EXTERNAS_CONQUIEN_DPT)
            $('#' + form).find(`textarea[id='EXTERNAS_PARAQUE${count}_DPT']`).val(obj.EXTERNAS_PARAQUE_DPT)
            $('#' + form).find(`select[id='EXTERNAS_FRECUENCIA${count}_DPT']`).val(obj.EXTERNAS_FRECUENCIA_DPT)
  
            count++
          });
        }
      }

}


$(document).ready(function() {
    // Capturar el cambio en el select de nivel jerárquico
    $('#NIVEL_JERARQUICO_DPT').on('change', function() {
        var descripcion = $(this).find('option:selected').data('descripcion');
        $('#DESCRIPCION_NIVEL_JERARQUICO').text(descripcion);
    });
});











$(document).ready(function() {
    var contadorCompetencias = 1;

    $('#agregarCompetencia').on('click', function(e) {
        e.preventDefault(); // Evitar que se envíe el formulario al hacer clic en el botón

        var idCompetencia = 'COMPETENCIA' + contadorCompetencias;

        // Mostrar el siguiente tr según el contador
        $('#' + idCompetencia).fadeIn();

        contadorCompetencias++;

        // Si se alcanza COMPETENCIA8, ocultar el botón "Agregar Competencia"
        if (contadorCompetencias > 8) {
            $('#agregarCompetencia').hide();
        }
    });

    // Manejar el cambio en los selects para mostrar la descripción
    $('select[id^="NOMBRE_COMPETENCIA"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var descripcion = selectedOption.data('descripcion');
        var competenciaId = $(this).attr('id').replace('NOMBRE_COMPETENCIA', 'DESCRIPCION_COMPETENCIA');
        $('#' + competenciaId).val(descripcion);
    });
});





$(document).ready(function() {
    var contadorCompetencias1 = 1;

    $('#agregarCompetencia1').on('click', function(e) {
        e.preventDefault(); // Evitar que se envíe el formulario al hacer clic en el botón

        var idCompetencia1 = 'GERENCIALES' + contadorCompetencias1;

        // Mostrar el siguiente tr según el contador
        $('#' + idCompetencia1).fadeIn();

        contadorCompetencias1++;

        // Si se alcanza COMPETENCIA8, ocultar el botón "Agregar Competencia"
        if (contadorCompetencias1 > 4) {
            $('#agregarCompetencia1').hide();
        }
    });

    // Manejar el cambio en los selects para mostrar la descripción
    $('select[id^="NOMBRE_COMPETENCIA"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var descripcion = selectedOption.data('descripcion');
        var competenciaId = $(this).attr('id').replace('NOMBRE_COMPETENCIA', 'DESCRIPCION_COMPETENCIA');
        $('#' + competenciaId).val(descripcion);
    });
});


