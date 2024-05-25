//VARIABLES
ID_FORMULARIO_DPT = 0



const ModalArea = document.getElementById('miModal_DPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_DPT = 0
    document.getElementById('formularioDPT').reset();
    $('#formularioDPT input').prop('disabled', false);
    $('#formularioDPT textarea').prop('disabled', false);
    $('#formularioDPT select').prop('disabled', false);
    
    $('.collapse').collapse('hide')
    
    $('#guardarFormDPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormDPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormDPT').css('display', 'none').prop('disabled', true);


})


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
        { data: 'DEPARTAMENTOS_AREAS_ID', name: 'DEPARTAMENTOS_AREAS_ID' }, // Utiliza el nombre correcto 'DEPARTAMENTOS_AREAS_ID'
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
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
        { target: 5, title: 'DPT', className: 'all text-center' },
        { target: 6, title: 'Editar', className: 'all text-center' },
        { target: 7, title: 'Eliminar', className: 'all text-center' },



    ]
})

$(document).ready(function () {
    // Inicializar Selectize en el select #PUESTOS_INTERACTUAN_DPT
    $('#PUESTOS_INTERACTUAN_DPT').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción'
    });

    // Función para manejar el evento de clic en el botón guardarFormDPT
    $("#guardarFormDPT").click(function (e) {
        e.preventDefault();

        if (ID_FORMULARIO_DPT == 0) {
            // Código para guardar el formulario...
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usara para la creación del DPT",
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
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del DPT',null,null, 1500);
                        $('#miModal_DPT').modal('hide');
                        document.getElementById('formularioDPT').reset();
                        TablaDPT.ajax.reload();
                        // Resetear el select #PUESTOS_INTERACTUAN_DPT después de guardar
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);
                });
            }, 1);
        } else {
            // Código para editar el formulario...
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
                        // Resetear el select #PUESTOS_INTERACTUAN_DPT después de editar
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);  
                });
            }, 1);
        }
    });
});



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

    }, function (data) {
        
        //Asignamos valores a nuestros inputs
        if (lider == 1 || lider == 2) {
            $('#PUESTO_REPORTA_DPT').val(data.REPORTA).prop('readonly', true)
            $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN[0].REPORTAN).prop('readonly', true)

        } else {

            $('#PUESTO_REPORTA_DPT').val(data.REPORTA[0].REPORTA).prop('readonly', true)
            $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN).prop('readonly', true)
        } 
    })
});





// Evento click para el botón de editar
    $('#TablaDPT tbody').on('click', 'td>button.EDITAR', function () {
        var tr = $(this).closest('tr');
        var row = TablaDPT.row(tr);
        ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT;

        // Obtener datos del formulario actual
        editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1);

        // Mostrar modal
        $("#miModal_DPT").modal("show");

        // Desbloquear opciones guardadas
        var funcionesCargo = row.data().FUNCIONES_CARGO_DPT ? row.data().FUNCIONES_CARGO_DPT.split(',') : [];
        var funcionesGestion = row.data().FUNCIONES_GESTION_DPT ? row.data().FUNCIONES_GESTION_DPT.split(',') : [];

        // Actualizar checkboxes y descripciones
        $('.toggle-switch-cargo').each(function () {
            var id = this.value;
            var tablePrefix = this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion';
            var isChecked = tablePrefix === 'cargo' ? funcionesCargo.includes(id) : funcionesGestion.includes(id);
            this.checked = isChecked;
            toggleDescription(tablePrefix, id, isChecked);
        });

        // Seleccionar opciones guardadas en el select #PUESTOS_INTERACTUAN_DPT
        var opcionesSeleccionadas = row.data().PUESTOS_INTERACTUAN_DPT ? row.data().PUESTOS_INTERACTUAN_DPT.split(',') : [];
        var selectize = $('#PUESTOS_INTERACTUAN_DPT')[0].selectize;
        opcionesSeleccionadas.forEach(function (opcion) {
            selectize.addItem(opcion);
        });
    });


// Función para alternar la descripción
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



$(document).ready(function () {
    // Abrir modal y bloquear checkboxes
    $("#nuevo_dpt").click(function (e) {
        e.preventDefault();
        // Mostrar modal
        $("#miModal_DPT").modal("show");

        // Bloquear todos los checkboxes y descripciones al abrir el modal
        $('.toggle-switch-cargo').each(function () {
            this.checked = false; // Desmarcar todos los checkboxes
            toggleDescription(this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion', this.value, false);
        });

        // Vaciar el select #PUESTOS_INTERACTUAN_DPT
        var selectize = $('#PUESTOS_INTERACTUAN_DPT')[0].selectize;
        selectize.clear();
    });

    // Event listener para los checkboxes
    document.querySelectorAll('.toggle-switch-cargo').forEach(switchInput => {
        switchInput.addEventListener('change', function () {
            const id = this.value; // Obtén el valor del checkbox
            const tablePrefix = this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion';
            toggleDescription(tablePrefix, id, this.checked);
        });
    });

    // Función para alternar la descripción
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




    