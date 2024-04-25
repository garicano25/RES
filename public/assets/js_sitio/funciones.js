
//CONFIGURACIONES DE TOOLTIP DE BOOTSTRAP
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


function configAjaxAwait(config) {

    const defaults = {
        alertBefore: false,
        response: true,
        callbackBefore: false,
        callbackAfter: false,
        returnData: true,
        WithoutResponseData: false,
        resetForm: false,
        ajaxComplete: () => { },
        ajaxError: () => { },
    }

    Object.entries(defaults).forEach(([key, value]) => {
        config[key] = config[key] ?? value;
    });
    return config;
}

if (window.innerWidth <= 768) {
    position = 'top';
} else {
    position = 'top';
    // position = 'top-start';
}

const Toast = Swal.mixin({
    toast: true,
    position: position,
    showConfirmButton: false,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

async function ajax(dataJson, apiURL,
    config = {
        alertBefore: false
    },
    //Callback
    callbackBefore = function (data) {
        alertMsj({
            title: 'Espera un momento...',
            text: 'Estamos cargando tu solicitud, esto puede demorar un rato',
            icon: 'info',
            showCancelButton: false
        })
    },

    callbackSuccess = function (data) {
        // console.log('callback ajaxAwait por defecto')
    }
) {
    return new Promise(function (resolve, reject) {
        //Configura la funcion misma
        config = configAjaxAwait(config)


        $.ajax({
            url: `${apiURL}`,
            data: dataJson,
            dataType: 'json',
            type: 'POST',
            beforeSend: function () {
                config.callbackBefore ? callbackBefore() : 1;
            },
            success: function (data) {
                let row = data;
                try {
                    if (config.response) {
                        if (mensajeAjax(row)) {
                            config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
                            config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
                        }
                    } else {
                        config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
                        config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
                    }
                } catch (error) {
                    alertMensaje('error', 'Error', 'Datos/Configuración erronea', error);
                    console.error(error);
                }

            },
            error: function (jqXHR, exception, data) {
                alertErrorAJAX(jqXHR, exception, data)
                // console.log('Error')
            },
        })
    });
}




function alertMensaje(icon = 'success', title = '¡Completado!', text = 'Datos completados', footer = null, html = null, timer = null) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        html: html,
        footer: footer,
        timer: timer
        // width: 'auto',
    })
}

function alertMsj(options, callback = function () { }) {

    if (!options.hasOwnProperty('title'))
        options['title'] = "¿Desea realizar esta acción?"

    if (!options.hasOwnProperty('text'))
        options['text'] = "Probablemente no podrá revertirlo"

    if (!options.hasOwnProperty('icon'))
        options['icon'] = 'warning'

    if (!options.hasOwnProperty('showCancelButton'))
        options['showCancelButton'] = true

    if (!options.hasOwnProperty('confirmButtonColor'))
        options['confirmButtonColor'] = '#3085d6'

    if (!options.hasOwnProperty('cancelButtonColor'))
        options['cancelButtonColor'] = '#d33'

    if (!options.hasOwnProperty('confirmButtonText'))
        options['confirmButtonText'] = 'Aceptar'

    if (!options.hasOwnProperty('cancelButtonText'))
        options['cancelButtonText'] = 'Cancelar'

    if (!options.hasOwnProperty('allowOutsideClick'))
        options['allowOutsideClick'] = false
    // if (!options.hasOwnProperty('timer'))
    //   options['timer'] = 4000
    // if (!options.hasOwnProperty('timerProgressBar'))
    //   options['timerProgressBar'] = true
    //
    Swal.fire(options).then((result) => {
        callback(result);
    })
}


function mensajeAjax(data, modulo = null) {
    if (modulo != null) {
        text = ' No pudimos cargar'
    }

    try {
        switch (data['response']['code']) {
            case 1:
                return 1;
                break;
            case 2:
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Ha ocurrido un error!',
                    footer: 'Respuesta: ' + data['response']['msj']
                })
                break;
           
            default:
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un problema!',
                    footer: 'No sabemos que pasó, reporta este problema...'
                })
        }
    } catch (error) {
        alertMensaje('warning', 'Error:', 'No se puedo resolver un conflicto interno con validación, si el problema persiste reporte al encargado de area de esto.', '[Error: api no valida, "response: {code: XXXX}", no existe]')
        return 0
    }
    return 0;
}


function alertMensajeConfirm(options, callback = function () { }, set = 0, callbackDenied = function () { }, callbackCanceled = function () {

}) {

    //Options si existe
    switch (set) {
        case 1:
            if (!options.hasOwnProperty('title'))
                options['title'] = "¿Desea realizar esta acción?"

            if (!options.hasOwnProperty('text'))
                options['text'] = "Probablemente no podrá revertirlo"

            if (!options.hasOwnProperty('icon'))
                options['icon'] = 'warning'

            if (!options.hasOwnProperty('showCancelButton'))
                options['showCancelButton'] = true

            if (!options.hasOwnProperty('confirmButtonColor'))
                options['confirmButtonColor'] = '#3085d6'

            if (!options.hasOwnProperty('cancelButtonColor'))
                options['cancelButtonColor'] = '#d33'

            if (!options.hasOwnProperty('confirmButtonText'))
                options['confirmButtonText'] = 'Aceptar'

            if (!options.hasOwnProperty('cancelButtonText'))
                options['cancelButtonText'] = 'Cancelar'

            if (!options.hasOwnProperty('allowOutsideClick'))
                options['allowOutsideClick'] = false
            // if (options.hasOwnProperty('timer'))
            //   options['timer'] = 4000
            // if (options.hasOwnProperty('timerProgressBar'))
            //   options['timerProgressBar'] = true
            //
            break;
        default:
            if (!options) {
                options = {
                    title: "¿Desea realizar esta acción?",
                    text: "Probablemente no podrá revertirlo",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    // allowOutsideClick: false
                    // timer: 4000,
                    // timerProgressBar: true,
                    //   showDenyButton: true,
                    // denyButtonText: `Don't save`,
                    // denyButtonColor: "#d33";
                }
            }
            break;
    }


    Swal.fire(options).then((result) => {
        if (result.isConfirmed || result.dismiss === "timer") {
            callback()
        } else if (result.isDenied) {
            callbackDenied();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            callbackCanceled();
        }
    })
}




function alertSelectTable(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 2000) {
    Toast.fire({
        icon: icon,
        title: msj,
        timer: timer,
        // width: 'auto'
    });
}

function alertErrorAJAX(jqXHR, exception, data) {
    var msg = '';
    //Status AJAX
    // console.log(jqXHR, exception, data)

    switch (jqXHR.status) {
        case 0:
            if (exception != 'abort') {
                alertToast('Sin conexión a internet', 'warning'); return 0
            };
        case 404: //console.log('Requested page not found. [404]'); return 0;
        case 500: alertToast('Internal Server Error', 'info'); return 0;
    }

    switch (exception) {
        case 'parsererror': alertMensaje('info', 'Error del servidor', 'Algo ha pasado, estamos trabajando para resolverlo', 'Mensaje de error: ' + data); return 0
        case 'timeout': //console.log('timeout'); return 0
        case 'abort': return 0
    }

    //console.log(jqXHR.responseText);

}


function alertSelectTable(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 2000) {
    Toast.fire({
        icon: icon,
        title: msj,
        timer: timer,
        // width: 'auto'
    });
}

function alertToast(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 3000) {
    Toast.fire({
        icon: icon,
        title: msj,
        timer: timer,
        // width: 'auto'
    });
}


function mensajeAjax(data, modulo = null) {
    if (modulo != null) {
        text = ' No pudimos cargar'
    }

    try {
        switch (data['response']['code']) {
            case 1:
                return 1;
                break;
            case 2:
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Ha ocurrido un error!',
                    footer: 'Respuesta: ' + data['response']['msj']
                })
                break;
            case "repetido":
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Usted ya está registrado!',
                    footer: 'Utilice su CURP para registrarse en una nueva prueba'
                })
                break;
            case "login":
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Respuesta: ' + data['response']['msj']
                })
                break;
            case "Token": case "Usernovalid":
                alertMensajeConfirm({
                    title: "¡Sesión no valida!",
                    text: "El token de su sesión ha caducado, vuelva iniciar sesión",
                    footer: "Redireccionando pantalla...",
                    icon: "info",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: false,
                    allowOutsideClick: false,
                    timer: 4000,
                    timerProgressBar: true,
                }, function () {
                    destroySession();
                    window.location.replace(http + servidor + "/" + appname + "/vista/login/");
                })

                break;
            case "turnero":
                alertMensajeConfirm({
                    title: "Oops",
                    text: `${data['response']['msj']}`,
                    footer: "Tal vez deberias intentarlo nuevamente",
                    icon: "warning",
                })

                break;
            default:
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un problema!',
                    footer: 'No sabemos que pasó, reporta este problema...'
                })
        }
    } catch (error) {
        alertMensaje('warning', 'Error:', 'No se puedo resolver un conflicto interno con validación, si el problema persiste reporte al encargado de area de esto.', '[Error: api no valida, "response: {code: XXXX}", no existe]')
        return 0
    }
    return 0;
}


function validarFormulario(form) {
    
    var formulario = form;

    // Busca todos los elementos input dentro del formulario y agrega la clase
    formulario.find('input').addClass('validar');


    // Busca todos los elementos con la clase "validar"
    var campos = $('.validar');
    var formularioValido = true;

    // Recorre los campos para verificar que tengan un valor no vacío
    campos.each(function () {
        if ($(this).val().trim() === '') {
            formularioValido = false;
            return false; // Detiene la iteración si se encuentra un campo vacío
        }
    });

    return formularioValido;
}



