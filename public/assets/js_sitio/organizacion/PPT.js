//VARIABLES
ID_FORMULARIO_PPT = 0




const ModalArea = document.getElementById('miModal_PPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_PPT = 0
    document.getElementById('formularioPPT').reset();
    $('#formularioPPT input').prop('disabled', false);
    $('#formularioPPT textarea').prop('disabled', false);
    $('#formularioPPT select').prop('disabled', false);
    
    $('.collapse').collapse('hide')
    
    $('#guardarFormPPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormPPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormPPT').css('display', 'none').prop('disabled', true);
    $('.desabilitado').css('background','#E2EFDA').prop('disabled', true);

})




//INICIAMOS LA TABLA DE LAS AREAS
TablaPPT = $("#TablaPPT").DataTable({
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
        url: '/TablaPPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaPPT.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'ID_FORMULARIO_PPT' },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_ACCION' },
        { data: 'BTN_PPT' },
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

$("#nuevo_ppt").click(function (e) {
e.preventDefault();

$('.desabilitado').css('background','#E2EFDA');

$("#miModal_PPT").modal("show");


})


$("#guardarFormPPT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioPPT'))

    if (formularioValido) {

        if (ID_FORMULARIO_PPT == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usara para la creación del PPT",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormPPT')
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
            
                    // Swal.fire({
                    //     title: "Espere un momento!",
                    //     text: "Estamos guardando la información.",
                    //     imageUrl: "/assets/images/Gif.gif",
                    //     imageWidth: 350,
                    //     imageHeight: 305,
                    //     imageAlt: "Loader Gif",
                    //     showConfirmButton: false,

                    // });

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        
                    setTimeout(() => {

                        ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del PPT',null,null, 1500)
                        $('#miModal_PPT').modal('hide')
                        document.getElementById('formularioPPT').reset();
                        TablaPPT.ajax.reload()

                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
                alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editara la información del PPT",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormPPT')
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
            
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        
                    setTimeout(() => {

                        
                        ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                        $('#miModal_PPT').modal('hide')
                        document.getElementById('formularioPPT').reset();
                        TablaPPT.ajax.reload()


                    }, 300);  
                })
            }, 1)
        }
    
    } else {
        // Muestra un mensaje de error o realiza alguna otra acción
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

$("#DEPARTAMENTO_AREA_ID").on("change", function () {

    var valorSeleccionado = $(this).find("option:selected");
    var infoLugar = valorSeleccionado.data("lugar");
    var infoProposito = valorSeleccionado.data("proposito");
   
    
    $('#AREA_TRABAJADOR_PPT').val(infoLugar).prop('readonly', true)
    $('#PROPOSITO_FINALIDAD_PPT').val(infoProposito).prop('readonly', true)


});

$('#TablaPPT tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_FORMULARIO_PPT: row.data().ID_FORMULARIO_PPT
    }
    
    eliminarDatoTabla(data, [TablaPPT], 'PPTDelete')

})

$('#TablaPPT tbody').on('click', 'td>button.EDITAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT
    data = row.data();
    form = "formularioPPT"

   
    
    //Rellenamos los datos del formulario
    editarDatoTabla(data,form,'miModal_PPT', 1)
    mostrarCursos(data,form)
  
})


$('#TablaPPT tbody').on('click', 'td>button.REVISAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT
    data = row.data();
    form = "formularioPPT"

   
    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)
    mostrarCursos(data,form)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#revisarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})


$('#TablaPPT tbody').on('click', 'td>button.AUTORIZAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT
    data = row.data();
    form = "formularioPPT"

   
    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)
    mostrarCursos(data,form)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#AutorizarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})

$('#revisarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea marcar como revisado este PPT?",
        text: "Al revisarlo, pasara hacer autorizado ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/revisarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la revisión',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#AutorizarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea autorizar el PPT?",
        text: "Al autorizarlo, podra hacer uso del PPT ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/autorizarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la autorización',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#TablaPPT tbody').on('click', 'td>button.PPT', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato PPT?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelPPT/" + ID_FORMULARIO_PPT);
           
        
    }, 1)

})

function mostrarCursos(data,form){

 //RECORREMOS LOS CURSOS SI ES QUE EXISTE
 if ('CURSOS' in data) {
    if (data.CURSOS.length > 0) { 
      var cursos = data.CURSOS
      var count = 1    
    
        // Supongamos que 'data' es el array que contiene los objetos de datos
      cursos.forEach(function (obj) {
        
      

        // cumple = obj.CURSO_CUMPLE_PPT.toUpperCase(); 

        $('#' + form).find(`textarea[id='CURSO${count}_PPT']`).val(obj.CURSO_PPT)
    
        //   $('#' + form).find(`input[id='CURSO${count}_CUMPLE_${cumple}'][value='${obj.CURSO_CUMPLE_PPT}'][type='radio']`).prop('checked', true)


        if (obj.CURSO_DESEABLE == null) {
          
          $('#' + form).find(`input[id='CURSO${count}_REQUERIDO_PPT'][type='checkbox']`).prop('checked', true)

        } else {
          
          $('#' + form).find(`input[id='CURSO${count}_DESEABLE_PPT'][type='checkbox']`).prop('checked', true)

        }

        count++
      });


      cursosTotales = data.CURSOS.length 
      if (cursosTotales <= 10) {

        $('#cursoTemasCollapse').collapse('show')


      } else if (cursosTotales > 10 && cursosTotales <= 20) {
          $('#cursoTemasCollapse').collapse('show')
          $('#cursoTemas1Collapse').collapse('show')
          

      } else if (cursosTotales > 20 && cursosTotales <= 30) {
          $('#cursoTemasCollapse').collapse('show')
          $('#cursoTemas1Collapse').collapse('show')
          $('#cursoTemas2Collapse').collapse('show')


      } else if (cursosTotales > 30){
          
          $('.collapse').collapse('show')
      


      }

    }
  }
}



// Solo seleccionar una opcion de word,excel,power point
$('.word').on('change', function() {
    if ($(this).is(':checked')) {
        $('.word').not(this).prop('checked', false);
    }
});

$('.excel').on('change', function() {
    if ($(this).is(':checked')) {
        $('.excel').not(this).prop('checked', false);
    }
});

$('.power').on('change', function() {
    if ($(this).is(':checked')) {
        $('.power').not(this).prop('checked', false);
    }
});

//Solo seleccionar una opcion de los idomas 

$('.idioma1').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma1').not(this).prop('checked', false);
    }
});


$('.idioma2').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma2').not(this).prop('checked', false);
    }
});

$('.idioma3').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma3').not(this).prop('checked', false);
    }
});


// AGREGAR IDOMAS

document.getElementById('addIdiomaBtn').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA2').style.display = 'table-row';
    this.style.display = 'none';
    document.getElementById('addIdiomaBtn2').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn2').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn3').style.display = 'none'; // Asegura que el botón "Quitar idioma 3" esté oculto al agregar idioma 2
});

document.getElementById('addIdiomaBtn2').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA3').style.display = 'table-row';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn3').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn2').style.display = 'none'; // Oculta el botón "Quitar idioma 2" al agregar idioma 3
});

document.getElementById('removeIdiomaBtn2').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA2').style.display = 'none';
    document.getElementById('addIdiomaBtn').style.display = 'inline-block';
    document.getElementById('addIdiomaBtn2').style.display = 'none';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn3').style.display = 'none'; // Oculta el botón "Quitar idioma 3" al quitar idioma 2
});

document.getElementById('removeIdiomaBtn3').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA3').style.display = 'none';
    document.getElementById('addIdiomaBtn2').style.display = 'inline-block';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn2').style.display = 'inline-block'; // Muestra el botón "Quitar idioma 2" al quitar idioma 3
});


// check de los cursos

$('input[id^="CURSO"][id$="_REQUERIDO_PPT"], input[id^="CURSO"][id$="_DESEABLE_PPT"]').on('change', function() {

    var row = $(this).closest('tr');
    var requeridoCheckbox = row.find('input[id^="CURSO"][id$="_REQUERIDO_PPT"]');
    var deseableCheckbox = row.find('input[id^="CURSO"][id$="_DESEABLE_PPT"]');
    
    if ($(this).is(':checked')) {
        
        if ($(this).is(requeridoCheckbox)) {
            deseableCheckbox.prop('checked', false);
        } else if ($(this).is(deseableCheckbox)) {
            requeridoCheckbox.prop('checked', false);
        }

    }

});

// Habilidades y competencias funcionales
$('.innovacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.innovacion').not(this).prop('checked', false);
    }
});

$('.pasion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.pasion').not(this).prop('checked', false);
    }
});

$('.servicio').on('change', function() {
    if ($(this).is(':checked')) {
        $('.servicio').not(this).prop('checked', false);
    }
});

$('.comunicacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.comunicacion').not(this).prop('checked', false);
    }
});

$('.trabajo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.trabajo').not(this).prop('checked', false);
    }
});

$('.integridad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.integridad').not(this).prop('checked', false);
    }    
});

$('.responsabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.responsabilidad').not(this).prop('checked', false);
    }
});

$('.adaptabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.adaptabilidad').not(this).prop('checked', false);
    }
});
$('.liderazgo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.liderazgo').not(this).prop('checked', false);
    }
});

$('.decisiones').on('change', function() {
    if ($(this).is(':checked')) {
        $('.decisiones').not(this).prop('checked', false);
    }
});



document.addEventListener('DOMContentLoaded', function () {
    let puestoIndex = 0;
    const puestos = ['puesto1', 'puesto2', 'puesto3', 'puesto4', 'puesto5'];

    document.getElementById('agregapuesto').addEventListener('click', function () {
        if (puestoIndex < puestos.length) {
            document.getElementById(puestos[puestoIndex]).style.display = 'flex';
            puestoIndex++;
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.puesto');

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
