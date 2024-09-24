
var ID_USUARIO = 0

Tablausuarios = null

$(document).ready(function() {
    $('#btnNuevoUsuario').on('click', function() {
        limpiarFormularioUsuario(); // Limpiar el formulario antes de abrir el modal

        // Inicializar Dropify
        $('#FOTO_USUARIO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });

        // Abrir el modal
        $('#modal_usuario').modal('show');
    });

    // Evento para validar contraseñas en tiempo real
    $('#PASSWORD, #PASSWORD_2').on('input', validarContrasenas);

    // Evento para mostrar/ocultar contraseñas
    $('.toggle-password').on('click', function() {
        togglePasswordVisibility($(this));
    });
});



const Modalusuario = document.getElementById('modal_usuario');

Modalusuario.addEventListener('hidden.bs.modal', event => {
    ID_USUARIO = 0;
    document.getElementById('formularioUSUARIO').reset();   
});

  




$("#guardarFormUSUARIO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioUSUARIO'))

    if (formularioValido) {

    if (ID_USUARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormUSUARIO')
            await ajaxAwaitFormData({ api: 1, ID_USUARIO: ID_USUARIO }, 'usuarioSave', 'formularioUSUARIO', 'guardarFormUSUARIO', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_USUARIO = data.usuario.ID_USUARIO
                    alertMensaje('success','Información guardada correctamente',null)
                     $('#modal_usuario').modal('hide')
                    document.getElementById('formularioUSUARIO').reset();
                    Tablausuarios.ajax.reload()

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormUSUARIO')
            await ajaxAwaitFormData({ api: 1, ID_USUARIO: ID_USUARIO }, 'usuarioSave', 'formularioUSUARIO', 'guardarFormUSUARIO', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_USUARIO = data.usuario.ID_USUARIO
                    alertMensaje('success','Información guardada correctamente',null )
                     $('#modal_usuario').modal('hide')
                    document.getElementById('formularioUSUARIO').reset();
                    Tablausuarios.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablausuarios = $("#Tablausuarios").DataTable({
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
        url: '/Tablausuarios',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablausuarios.columns.adjust().draw();
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
        { data: 'EMPLEADO_NOMBRES' },
        { data: 'EMPLEADO_CORREOS' },
        { data: 'USUARIO_TIPOS' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre / Cargo', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Correo / Télefono', className: 'all text-center' },
        { targets: 3, title: 'Tipo usuario', className: 'all text-center' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});








$('#Tablausuarios tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablausuarios.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_USUARIO: row.data().ID_USUARIO
    };

    eliminarDatoTabla(data, [Tablausuarios], 'usuarioDelete');
});





$('#Tablausuarios tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablausuarios.row(tr);
    ID_USUARIO = row.data().ID_USUARIO;


    editarDatoTabla(row.data(), 'formularioUSUARIO', 'modal_usuario',1 );


    if (row.data().FOTO_USUARIO) {

        var archivo = row.data().FOTO_USUARIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        // Obtener FOTO
        var imagenUrl = '/usuariofoto/' + row.data().ID_USUARIO + extension;

        // Mostrar Foto en el INPUT
        if ($('#FOTO_USUARIO').data('dropify')) {
            $('#FOTO_USUARIO').dropify().data('dropify').destroy();
            // $('.dropify-wrapper').css('height', 400);
            $('#FOTO_USUARIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_USUARIO').dropify().data('dropify').init();
        }
        else {
            // $('#signatariofoto').attr('data-height', 400);
            $('#FOTO_USUARIO').attr('data-default-file', imagenUrl);
            $('#FOTO_USUARIO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                },
                error: {
                    'fileSize': 'Demasiado grande ({{ value }} max).',
                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_USUARIO').dropify().data('dropify').resetPreview();
        $('#FOTO_USUARIO').dropify().data('dropify').clearElement();
    }





});














function validarContrasenas() {
    var password = $('#PASSWORD').val();
    var password2 = $('#PASSWORD_2').val();
    var mensaje = $('#PASSWORD_MENSAJE');
    var botonGuardar = $('#guardarFormUSUARIO'); // Referencia al botón de guardar

    // Reiniciar el mensaje y deshabilitar el botón
    mensaje.text('');
    mensaje.hide();
    botonGuardar.prop('disabled', true); // Desactivar el botón de guardar por defecto

    // No mostrar el mensaje si ambos campos están vacíos
    if (password.length === 0 && password2.length === 0) {
        return;
    }

    // Mostrar el mensaje solo si se ha ingresado algo en uno de los campos
    if (password.length > 0 || password2.length > 0) {
        mensaje.show();
    }

    // Validar si la longitud de la contraseña es menor a 6 caracteres
    if (password.length < 6) {
        mensaje.text('* La contraseña debe tener mínimo 6 caracteres *').css('color', 'red');
        return;
    }

    // Validar si las contraseñas no coinciden
    if (password !== password2) {
        mensaje.text('* Las contraseñas no son iguales *').css('color', 'red');
    } else {
        mensaje.text('Las contraseñas coinciden.').css('color', 'green');
        botonGuardar.prop('disabled', false); // Activar el botón de guardar si todo está correcto
    }
}

// Función global para mostrar/ocultar contraseñas
function togglePasswordVisibility(button) {
    var input = $(button.data('toggle'));
    var icon = button.find('i');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
    } else {
        input.attr('type', 'password');
        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
    }
}

// Función global para limpiar el formulario y mensajes de error
function limpiarFormularioUsuario() {
    $('#formularioUSUARIO')[0].reset(); // Resetear el formulario

    // Limpiar los campos de contraseña y mensajes
    $('#PASSWORD').val('');
    $('#PASSWORD_2').val('');
    $('#PASSWORD_MENSAJE').text('').hide();
    $('#guardarFormUSUARIO').prop('disabled', true); // Desactivar el botón de guardar por defecto

    // Reiniciar la imagen del dropify
    var drEvent = $('#FOTO_USUARIO').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}
