ID_BANCO_CV = 0




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
                    document.getElementById('formularioBANCO').reset();
                         
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
                    document.getElementById('formularioBANCO').reset();
                


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
        { data: 'ID_BANCO_CV' },
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
                return '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/' + data + '"> <i class="bi bi-filetype-pdf"></i></button>';
            },
            className: 'text-center'
        },
        { 
            data: 'ARCHIVO_CV',
            render: function (data, type, row) {
                return '<button class="btn btn-danger btn-custom rounded-pill pdf-button" data-pdf="/' + data + '"> <i class="bi bi-filetype-pdf"></i></button>';
            },
            className: 'text-center'
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
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

$('#Tablabancocv tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablabancocv.row(tr);
    var data = row.data();

    // Ocultar todos los campos del formulario inicialmente
    $('#formularioBANCO input, #formularioBANCO select, #formularioBANCO textarea').hide();

    // Mostrar y llenar los inputs de tipo text y number que tengan datos
    $('#formularioBANCO input[type="text"], #formularioBANCO input[type="number"], #formularioBANCO textarea').each(function () {
        var inputName = $(this).attr('name');
        if (inputName && data[inputName]) {
            $(this).val(data[inputName]).prop('disabled', true).show();
        } else {
            $(this).val('').hide();
        }
    });

    // Mostrar y llenar los select que tengan datos
    $('#formularioBANCO select').each(function () {
        var selectName = $(this).attr('name');
        if (selectName && data[selectName]) {
            $(this).val(data[selectName]).prop('disabled', true).show();
        } else {
            $(this).val('').hide();
        }
    });

    // Mostrar y llenar los radio buttons que tengan datos
    $('#formularioBANCO input[type="radio"]').each(function () {
        var radioName = $(this).attr('name');
        if (radioName && data[radioName]) {
            if ($(this).val() == data[radioName]) {
                $(this).prop('checked', true);
            }
            $(this).prop('disabled', true).show();
        } else {
            $(this).hide();
        }
    });

    // Mostrar y llenar los checkboxes que tengan datos
    $('#formularioBANCO input[type="checkbox"]').each(function () {
        var checkboxName = $(this).attr('name');
        if (checkboxName && data[checkboxName]) {
            $(this).prop('checked', data[checkboxName] == 1 ? true : false);
            $(this).prop('disabled', true).show();
        } else {
            $(this).hide();
        }
    });

    // Calcular y mostrar la edad
    if (data.DIA_FECHA_CV && data.MES_FECHA_CV && data.ANO_FECHA_CV) {
        const fechaNacimiento = `${data.ANO_FECHA_CV}-${data.MES_FECHA_CV}-${data.DIA_FECHA_CV}`;
        const edad = calcularEdad(fechaNacimiento);
        $('#EDAD').val(edad).prop('disabled', true).show();
    }

    // Mostrar el modal
    $('#miModal_VACANTES').modal('show');
});

document.getElementById('CURP_CV').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    var curp = this.value;
    var contador = document.getElementById('contador');
    contador.textContent = curp.length + '/18';

    var mensaje = document.getElementById('mensaje');
    if (curp.length === 18) {
        mensaje.textContent = 'Confirma tu CURP antes de continuar';
    } else {
        mensaje.textContent = '';
    }
});


document.getElementById('ULTIMO_GRADO_CV').addEventListener('change', function() {
    var selectedValue = this.value;
    
    document.getElementById('licenciatura-nombre-container').style.display = selectedValue === '4' ? 'block' : 'none';
    document.getElementById('licenciatura-titulo-container').style.display = selectedValue === '4' ? 'block' : 'none';
    document.getElementById('licenciatura-cedula-container').style.display = selectedValue === '4' ? 'block' : 'none';
    
    document.getElementById('posgrado-container').style.display = selectedValue === '5' ? 'block' : 'none';
    document.getElementById('posgrado-nombre-container').style.display = 'none';
    document.getElementById('posgrado-titulo-container').style.display = 'none';
    document.getElementById('posgrado-cedula-container').style.display = 'none';
});

document.getElementById('TIPO_POSGRADO_CV').addEventListener('change', function() {
    var display = this.value !== '0' ? 'block' : 'none';
    document.getElementById('posgrado-nombre-container').style.display = display;
    document.getElementById('posgrado-titulo-container').style.display = display;
    document.getElementById('posgrado-cedula-container').style.display = display;
});




document.addEventListener('DOMContentLoaded', function() {
    var avisoModal = new bootstrap.Modal(document.getElementById('avisoPrivacidadModal'), {
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
});



document.getElementById('ARCHIVO_CURP_CV').addEventListener('change', function() {
    var archivo = this.files[0];
    var errorElement = document.getElementById('CURP_ERROR');
    if (archivo && archivo.type === 'application/pdf') {
        errorElement.style.display = 'none';
        document.getElementById('quitarCURP').style.display = 'block';
    } else {
        errorElement.style.display = 'block';
        this.value = '';
        document.getElementById('quitarCURP').style.display = 'none';
    }
});

document.getElementById('quitarCURP').addEventListener('click', function() {
    document.getElementById('ARCHIVO_CURP_CV').value = '';
    document.getElementById('CURP_ERROR').style.display = 'none';
    this.style.display = 'none';
});

document.getElementById('ARCHIVO_CV').addEventListener('change', function() {
    var archivo = this.files[0];
    var errorElement = document.getElementById('CV_ERROR');
    if (archivo && archivo.type === 'application/pdf') {
        errorElement.style.display = 'none';
        document.getElementById('quitarCV').style.display = 'block';
    } else {
        errorElement.style.display = 'block';
        this.value = '';
        document.getElementById('quitarCV').style.display = 'none';
    }
});

document.getElementById('quitarCV').addEventListener('click', function() {
    document.getElementById('ARCHIVO_CV').value = '';
    document.getElementById('CV_ERROR').style.display = 'none';
    this.style.display = 'none';
});



document.getElementById('aceptaTerminos').addEventListener('change', function() {
    var guardarBtn = document.getElementById('guardarFormBancoCV');
    guardarBtn.disabled = !this.checked;
});

document.getElementById('guardarFormBancoCV').addEventListener('click', function(event) {
    var aceptaTerminos = document.getElementById('aceptaTerminos').checked;
    if (!aceptaTerminos) {
        event.preventDefault(); // Evita el envío del formulario
        alert('Debe aceptar los términos y condiciones para continuar.');
    }
});
