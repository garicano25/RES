ID_BANCO_CV = 0





document.addEventListener('DOMContentLoaded', function() {
    var avisoModalElement = document.getElementById('avisoPrivacidadModal');
    if (avisoModalElement) {
        var avisoModal = new bootstrap.Modal(avisoModalElement, {
            backdrop: 'static',
            keyboard: false
        });
        avisoModal.show();

        document.getElementById('aceptoTerminos').addEventListener('click', function() {
            avisoModal.hide();
        });

        document.getElementById('noAceptoTerminos').addEventListener('click', function() {
            window.location.href = 'http://results-in-performance.com/';
        });
    }
});









$("#guardarFormBancoCV").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioBANCO'))

    if (formularioValido) {

    if (ID_BANCO_CV == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormBancoCV')
            await ajaxAwaitFormData({ api: 1, ID_BANCO_CV: ID_BANCO_CV }, 'BancoSave', 'formularioBANCO', 'guardarFormBancoCV', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_BANCO_CV = data.bancocv.ID_BANCO_CV
                    alertMensaje('success','Información guardada correctamente',null,null, 1500)
                    $('#miModal_BANCOCV').modal('hide')
                    document.getElementById('formularioBANCO').reset();
                    Tablabancocv.ajax.reload()
                    $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
                    $('#INTERES_OPERATIVAS')[0].selectize.clear();

                         
                 })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormBancoCV')
            await ajaxAwaitFormData({ api: 1, ID_BANCO_CV: ID_BANCO_CV }, 'BancoSave', 'formularioBANCO', 'guardarFormBancoCV', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                setTimeout(() => {
                    ID_BANCO_CV = data.bancocv.ID_BANCO_CV
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    $('#miModal_BANCOCV').modal('hide')
                    document.getElementById('formularioBANCO').reset();
                    Tablabancocv.ajax.reload()
                    $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
                    $('#INTERES_OPERATIVAS')[0].selectize.clear();


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
    
});







var Tablabancocv = $("#Tablabancocv").DataTable({
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
        url: '/Tablabancocv',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabancocv.columns.adjust().draw();
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
                return meta.row + 1; // Contador que inicia en 1 y se incrementa por cada fila
            }
        },
        { data: 'CURP_CV' }, 
        { data: null,
            render: function (data, type, row) {
                return row.NOMBRE_CV + ' ' + row.PRIMER_APELLIDO_CV + ' ' + row.SEGUNDO_APELLIDO_CV;
            }
        },
        { data: 'CORREO_CV' },
        { data: 'TELEFONO1' },
        { data: 'TELEFONO2' },
        { 
            data: 'ARCHIVO_CURP_CV',
            render: function (data, type, row) {
                return '<button class="btn btn-outline-danger btn-custom rounded-pill pdf-button"data-pdf="/' + data + '"> <i class="bi bi-filetype-pdf"></i></button>';
            },
            className: 'text-center'
        },
        { 
            data: 'ARCHIVO_CV',
            render: function (data, type, row) {
                return '<button class="btn btn-outline-danger btn-custom rounded-pill pdf-button" data-pdf="/' + data + '"> <i class="bi bi-filetype-pdf"></i></button>';
            },
            className: 'text-center'
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'CURP', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre Completo', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Correo', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Teléfono 1', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Teléfono 2', className: 'all text-center nombre-column' },
        { targets: 6, title: 'CURP', className: 'all text-center nombre-column' },
        { targets: 7, title: 'CV', className: 'all text-center nombre-column' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },
        { targets: 9, title: 'Eliminar', className: 'all text-center' }
    ]
});

// Event listener para abrir el modal con el PDF
$('#Tablabancocv').on('click', '.pdf-button', function (e) {
    e.preventDefault();
    var pdfUrl = $(this).data('pdf');
    $('#pdfIframe').attr('src', pdfUrl);
    $('#pdfModal').modal('show');
});












$('#Tablabancocv tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablabancocv.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_BANCO_CV: row.data().ID_BANCO_CV
    }
    
    eliminarDatoTabla(data, [Tablabancocv], 'BancoDelete')

})

function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mesDiferencia = hoy.getMonth() - nacimiento.getMonth();
    
    if (mesDiferencia < 0 || (mesDiferencia === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}






$(document).ready(function() {

    
    var $select = $('#INTERES_ADMINISTRATIVA').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
    var selectizeInstance = $select[0].selectize;

    var $select1 = $('#INTERES_OPERATIVAS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });


    var selectizeInstance1 = $select1[0].selectize;


    $('#ULTIMO_GRADO_CV').on('change', function() {
        var gradoSeleccionado = $(this).val();
        $('#licenciatura-section').hide();
        $('#posgrado-section').hide();

        if (gradoSeleccionado === '4') { // Licenciatura
            $('#licenciatura-section').show();
        } else if (gradoSeleccionado === '5') { // Posgrado
            $('#posgrado-section').show();
        }
    });

    $('#Tablabancocv tbody').on('click', 'td>button.EDITAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablabancocv.row(tr);
        ID_BANCO_CV = row.data().ID_BANCO_CV;
        var data = row.data();

        
        var savedOptions = [];
        var intereadmon = data.INTERES_ADMINISTRATIVA;
    
        if (Array.isArray(intereadmon)) { 
            savedOptions = intereadmon;
        } else if (intereadmon && intereadmon.length > 2) { 
            try {
                savedOptions = JSON.parse(intereadmon);
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
            }
        }
        selectizeInstance.clear();
        if (Array.isArray(savedOptions)) {
            selectizeInstance.setValue(savedOptions);
        }


        var savedOptions1 = [];
        var intereope = data.INTERES_OPERATIVAS;
        if (Array.isArray(intereope)) { 
            savedOptions1 = intereope;
        } else if (intereope && intereope.length > 2) { 
            try {
                savedOptions1 = JSON.parse(intereope);
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
            }
        } 
        selectizeInstance1.clear();
        if (Array.isArray(savedOptions1)) {
            selectizeInstance1.setValue(savedOptions1);
        }




        hacerSoloLectura(row.data(), '#miModal_VACANTES');
        ID_BANCO_CV = row.data().ID_BANCO_CV;
        editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_VACANTES', 1);

        if (row.data().DIA_FECHA_CV && row.data().MES_FECHA_CV && row.data().ANIO_FECHA_CV) {
            const fechaNacimiento = `${row.data().ANIO_FECHA_CV}-${row.data().MES_FECHA_CV}-${row.data().DIA_FECHA_CV}`;
            const edad = calcularEdad(fechaNacimiento);
            $('#EDAD').val(edad).prop('disabled', true).show();
        }

        setTimeout(() => {
            $('#ANIO_FECHA_CV').val(row.data().ANIO_FECHA_CV);
        }, 100);

        if (row.data().ULTIMO_GRADO_CV === '4') {
            $('#licenciatura-section').show();
        } else if (row.data().ULTIMO_GRADO_CV === '5') {
            $('#posgrado-section').show();
        }
    });

    $('#miModal_VACANTES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_VACANTES');
        $('#licenciatura-section').hide();
        $('#posgrado-section').hide();
    });

    $('#miModal_VACANTES').on('show.bs.modal', function () {
        var html = '<option value="0" selected disabled>Seleccione una opción</option>';
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= 1950; i--) {
            html += '<option value="' + i + '">' + i + '</option>';
        }
        $('#ANIO_FECHA_CV').html(html);
    });
});
























function validarCURP(curp) {
    const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;
    return regex.test(curp);
}

document.addEventListener('DOMContentLoaded', function() {
    var curpInput = document.getElementById('CURP_CV');

    // Solo añade el listener si el elemento existe
    if (curpInput) {
        curpInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            var curp = this.value;
            var contador = document.getElementById('contador');
            if (contador) {
                contador.textContent = curp.length + '/18';
            }

            var mensaje = document.getElementById('mensaje');
            var error = document.getElementById('error');
            if (curp.length === 18) {
                if (validarCURP(curp)) {
                    if (mensaje) mensaje.textContent = 'CURP válida. Confirma tu CURP antes de continuar.';
                    if (error) error.textContent = '';
                } else {
                    if (mensaje) mensaje.textContent = '';
                    if (error) error.textContent = 'CURP inválida. Por favor, verifica el formato.';
                }
            } else {
                if (mensaje) mensaje.textContent = '';
                if (error) error.textContent = '';
            }
        });
    }
});


$(document).ready(function() {
    $('#formularioBANCO').on('submit', function(event) {
        const curp = $('#CURP_CV').val();
        if (!validarCURP(curp)) {
            $('#error').text('CURP inválida. Por favor, verifica el formato.');
            event.preventDefault();
        } else {
            $('#error').text('');
        }
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var ultimoGradoCV = document.getElementById('ULTIMO_GRADO_CV');
    if (ultimoGradoCV) {
        ultimoGradoCV.addEventListener('change', function() {
            var selectedValue = this.value;
            var licenciaturaNombre = document.getElementById('licenciatura-nombre-container');
            var licenciaturaTitulo = document.getElementById('licenciatura-titulo-container');
            var licenciaturaCedula = document.getElementById('licenciatura-cedula-container');
            var posgradoContainer = document.getElementById('posgrado-container');

            if (licenciaturaNombre) licenciaturaNombre.style.display = selectedValue === '4' ? 'block' : 'none';
            if (licenciaturaTitulo) licenciaturaTitulo.style.display = selectedValue === '4' ? 'block' : 'none';
            if (licenciaturaCedula) licenciaturaCedula.style.display = selectedValue === '4' ? 'block' : 'none';
            if (posgradoContainer) posgradoContainer.style.display = selectedValue === '5' ? 'block' : 'none';
            var posgradoNombre = document.getElementById('posgrado-nombre-container');
            var posgradoTitulo = document.getElementById('posgrado-titulo-container');
            var posgradoCedula = document.getElementById('posgrado-cedula-container');

            if (posgradoNombre) posgradoNombre.style.display = 'none';
            if (posgradoTitulo) posgradoTitulo.style.display = 'none';
            if (posgradoCedula) posgradoCedula.style.display = 'none';
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var tipoPosgradoCV = document.getElementById('TIPO_POSGRADO_CV');
    if (tipoPosgradoCV) {
        tipoPosgradoCV.addEventListener('change', function() {
            var display = this.value !== '0' ? 'block' : 'none';
            var posgradoNombre = document.getElementById('posgrado-nombre-container');
            var posgradoTitulo = document.getElementById('posgrado-titulo-container');
            var posgradoCedula = document.getElementById('posgrado-cedula-container');

            if (posgradoNombre) posgradoNombre.style.display = display;
            if (posgradoTitulo) posgradoTitulo.style.display = display;
            if (posgradoCedula) posgradoCedula.style.display = display;
        });
    }
});







document.addEventListener('DOMContentLoaded', function() {
    var archivoCurpCV = document.getElementById('ARCHIVO_CURP_CV');
    if (archivoCurpCV) {
        archivoCurpCV.addEventListener('change', function() {
            var archivo = this.files[0];
            var errorElement = document.getElementById('CURP_ERROR');
            var quitarCurp = document.getElementById('quitarCURP');
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarCurp) quitarCurp.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarCurp) quitarCurp.style.display = 'none';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var quitarCurp = document.getElementById('quitarCURP');
    if (quitarCurp) {
        quitarCurp.addEventListener('click', function() {
            var archivoCurpCV = document.getElementById('ARCHIVO_CURP_CV');
            var errorElement = document.getElementById('CURP_ERROR');
            if (archivoCurpCV) archivoCurpCV.value = '';
            if (errorElement) errorElement.style.display = 'none';
            this.style.display = 'none';
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var archivoCV = document.getElementById('ARCHIVO_CV');
    if (archivoCV) {
        archivoCV.addEventListener('change', function() {
            var archivo = this.files[0];
            var errorElement = document.getElementById('CV_ERROR');
            var quitarCV = document.getElementById('quitarCV');
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarCV) quitarCV.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarCV) quitarCV.style.display = 'none';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var quitarCV = document.getElementById('quitarCV');
    if (quitarCV) {
        quitarCV.addEventListener('click', function() {
            var archivoCV = document.getElementById('ARCHIVO_CV');
            var errorElement = document.getElementById('CV_ERROR');
            if (archivoCV) archivoCV.value = '';
            if (errorElement) errorElement.style.display = 'none';
            this.style.display = 'none';
        });
    }
});




document.addEventListener('DOMContentLoaded', function() {
    var aceptaTerminosCheckbox = document.getElementById('aceptaTerminos');
    var guardarBtn = document.getElementById('guardarFormBancoCV');

    if (aceptaTerminosCheckbox && guardarBtn) {
        aceptaTerminosCheckbox.addEventListener('change', function() {
            guardarBtn.disabled = !this.checked;
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var botonGuardar = document.getElementById('guardarFormBancoCV');
    if (botonGuardar) {
        botonGuardar.addEventListener('click', function(event) {
            var aceptaTerminosCheckbox = document.getElementById('aceptaTerminos');
            if (aceptaTerminosCheckbox && !aceptaTerminosCheckbox.checked) {
                event.preventDefault(); // Evita el envío del formulario
                alert('Debe aceptar los términos y condiciones para continuar.');
            }
        });
    }
});


  var $select = $('#INTERES_ADMINISTRATIVA').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
    var selectizeInstance = $select[0].selectize;

    var $select1 = $('#INTERES_OPERATIVAS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });


    var selectizeInstance1 = $select1[0].selectize;











