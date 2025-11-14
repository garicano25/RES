
// $(document).ready(function () {
//     $.ajax({
//         url: '/verificarBloqueoPorVerificacion',
//         method: 'GET',
//         success: function (response) {
//             if (response.bloqueado) {
//                 const botones = [
//                     '#NUEVA_CERTIFICACION',
//                     '#guardarCertificaciones',
//                     '#NUEVO_CONTACTO',
//                     '#guardarCONTACTOS',
//                     '#NUEVA_CUENTA',
//                     '#guardarCuentas',
//                     '#NUEVO_DOCUMENTO',
//                     '#guardarDOCUMENTOS',
//                     '#guardarALTA',
//                     '#NUEVA_REFERENCIA',
//                     '#guardarREFERENCIAS',
//                     '#SOLICITAR_VERIFICACION'

//                 ];

//                 botones.forEach(id => {
//                     $(id).hide();
//                 });
//             }
//         },
//         error: function () {
//             console.warn('No se pudo verificar el estado de la validación.');
//         }
//     });
// });


$(document).ready(function () {
    $.ajax({
        url: '/verificarBloqueoPorVerificacion',
        method: 'GET',
        success: function (response) {
            if (response.bloqueado) {
                const botones = [
                    '#NUEVA_CERTIFICACION',
                    '#guardarCertificaciones',
                    '#NUEVO_CONTACTO',
                    '#guardarCONTACTOS',
                    '#NUEVA_CUENTA',
                    '#guardarCuentas',
                    '#NUEVO_DOCUMENTO',
                    '#guardarDOCUMENTOS',
                    '#guardarALTA',
                    '#NUEVA_REFERENCIA',
                    '#guardarREFERENCIAS',
                    '#SOLICITAR_VERIFICACION'
                ];

                botones.forEach(id => {
                    $(id).hide();
                });

                const btnDeshabilitado = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

                setTimeout(() => {
                    $('.EDITAR').each(function () {
                        $(this).replaceWith(btnDeshabilitado);
                    });
                }, 1000); 
            }
        },
        error: function () {
            console.warn('No se pudo verificar el estado de la validación.');
        }
    });
});



$('#SOLICITAR_VERIFICACION').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: '¿Estás seguro de solicitar verificación?',
        text: 'Una vez enviada la solicitud ya no podrá editar ni guardar datos en los módulos.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar solicitud',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire({
                title: 'Mandando solicitud...',
                text: 'Por favor espere un momento.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/solicitarValidacion',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.close();

                    if (response.status === 'incompleto') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Faltan datos por completar',
                            html: response.faltantes.join('<br>')
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Solicitud enviada',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            willClose: () => {
                                location.reload(); 
                            }
                        });
                    }
                },
                error: function () {
                    Swal.close();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo enviar la solicitud.'
                    });
                }
            });
        }
    });
});





