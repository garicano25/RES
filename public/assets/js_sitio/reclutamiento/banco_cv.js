ID_BANCO_CV = 0



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


$(document).ready(function() {
    $('#Tablabancocv tbody').on('click', 'td>button.EDITAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablabancocv.row(tr);
        
        console.log(row.data().ANIO_FECHA_CV)
        hacerSoloLectura(row.data(), '#miModal_VACANTES');

        ID_BANCO_CV = row.data().ID_BANCO_CV;
        editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_VACANTES',1);
 
        if (row.data().DIA_FECHA_CV && row.data().MES_FECHA_CV && row.data().ANIO_FECHA_CV) {
            const fechaNacimiento = `${row.data().ANIO_FECHA_CV}-${row.data().MES_FECHA_CV}-${row.data().DIA_FECHA_CV}`;
            const edad = calcularEdad(fechaNacimiento);
            $('#EDAD').val(edad).prop('disabled', true).show();
        }

        setTimeout(() => {
            $('#ANIO_FECHA_CV').val(row.data().ANIO_FECHA_CV);
        }, 100);
    });
    

    $('#miModal_VACANTES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_VACANTES');
    });

    $('#miModal_VACANTES').on('show.bs.modal', function () {
                          
        var html = '<option value="0" selected disabled>Seleccione una opción</option>'
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= 1950; i--) {
            html +='<option value="' + i + '">' + i + '</option>';
        }


        $('#ANIO_FECHA_CV').html(html);


    });
  
});






function validarCURP(curp) {
    const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;
    return regex.test(curp);
}

document.getElementById('CURP_CV').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    var curp = this.value;
    var contador = document.getElementById('contador');
    contador.textContent = curp.length + '/18';

    var mensaje = document.getElementById('mensaje');
    var error = document.getElementById('error');
    if (curp.length === 18) {
        if (validarCURP(curp)) {
            mensaje.textContent = 'CURP válida. Confirma tu CURP antes de continuar.';
            error.textContent = '';
        } else {
            mensaje.textContent = '';
            error.textContent = 'CURP inválida. Por favor, verifica el formato.';
        }
    } else {
        mensaje.textContent = '';
        error.textContent = '';
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






const ModalArea = document.getElementById('miModal_BANCOCV')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_BANCO_CV = 0
    document.getElementById('formularioBANCO').reset();
   

})