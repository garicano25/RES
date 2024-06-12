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
    document.getElementById('licenciatura-container').style.display = selectedValue === '4' ? 'block' : 'none';
    document.getElementById('posgrado-container').style.display = selectedValue === '5' ? 'block' : 'none';
    document.getElementById('posgrado-nombre-container').style.display = 'none';
});

document.getElementById('TIPO_POSGRADO_CV').addEventListener('change', function() {
    document.getElementById('posgrado-nombre-container').style.display = this.value !== '0' ? 'block' : 'none';
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



$(document).ready(function() {
    $('#addTelefonoBtn').click(function() {
        $('#additionalTelefonoFields').show();
        $(this).hide();
    });
});