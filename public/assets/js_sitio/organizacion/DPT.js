    var contadorFunciones = 0;

    function agregarFuncion() {
        contadorFunciones++;
        var inputHTML = '<div class="row mb-3">' +
                            '<div class="col-1 d-flex align-items-center justify-content-center">' +
                                '<span>' + contadorFunciones + '</span>' +
                            '</div>' +
                            '<div class="col-10">' +
                                '<input type="text" id="FUNCION_CLAVE_CARGO_DPT' + contadorFunciones + '" name="FUNCION_CLAVE_CARGO_DPT' + contadorFunciones + '" class="form-control text-center">' +
                            '</div>' +
                            '<div class="col-1">' +
                                '<button class="btn btn-danger" onclick="eliminarFuncion(this)"><i class="bi bi-trash"></i></button>' +
                            '</div>' +
                        '</div>';

        document.getElementById('funciones-responsabilidades-cargo').insertAdjacentHTML('beforeend', inputHTML);
    }

    function eliminarFuncion(elemento) {
        var contadorEliminado = elemento.parentElement.parentElement.firstElementChild.firstElementChild.innerText;
        contadorFunciones--;
        elemento.parentElement.parentElement.remove();
        actualizarContadores(contadorEliminado);
    }

    function actualizarContadores(contadorEliminado) {
        var contadores = document.querySelectorAll('#funciones-responsabilidades-cargo .col-1 span');
        contadores.forEach(function(contador, index) {
            if (parseInt(contador.innerText) > parseInt(contadorEliminado)) {
                contador.innerText = parseInt(contador.innerText) - 1;
            }
        });
    }



    var contadorFunciones1 = 0;

    function agregarFuncion1() {
        contadorFunciones1++;
        var inputHTML = '<div class="row mb-3">' +
                            '<div class="col-1 d-flex align-items-center justify-content-center">' +
                                '<span>' + contadorFunciones1 + '</span>' +
                            '</div>' +
                            '<div class="col-10">' +
                                '<input type="text" id="FUNCION_CLAVE_GESTION_DPT' + contadorFunciones1 + '" name="FUNCION_CLAVE_CARGO_DPT' + contadorFunciones1 + '" class="form-control text-center">' +
                            '</div>' +
                            '<div class="col-1">' +
                                '<button class="btn btn-danger" onclick="eliminarFuncion1(this)"><i class="bi bi-trash"></i></button>' +
                            '</div>' +
                        '</div>';

        document.getElementById('funciones-responsabilidades-gestion').insertAdjacentHTML('beforeend', inputHTML);
    }

    function eliminarFuncion1(elemento) {
        var contadorEliminado1 = elemento.parentElement.parentElement.firstElementChild.firstElementChild.innerText;
        contadorFunciones1--;
        elemento.parentElement.parentElement.remove();
        actualizarContadores1(contadorEliminado1);
    }

    function actualizarContadores1(contadorEliminado1) {
        var contadores1 = document.querySelectorAll('#funciones-responsabilidades-gestion.col-1 span');
        contadores1.forEach(function(contador1, index) {
            if (parseInt(contador1.innerText) > parseInt(contadorEliminado1)) {
                contador1.innerText = parseInt(contador1.innerText) - 1;
            }
        });
    }