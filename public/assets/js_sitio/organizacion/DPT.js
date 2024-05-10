//VARIABLES
ID_FORMULARIO_DPT = 0
var contactos = [];



const ModalArea = document.getElementById('miModal_DPT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_DPT = 0
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
        { data: 'DEPARTAMENTOS_AREAS_ID' },
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_ACCION' },
        { data: 'BTN_DPT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
        
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Puesto', className: 'all' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Autorizado por', className: 'all text-center' },
        { target: 5, title: 'Accion', className: 'all text-center' },
        { target: 6, title: 'DPT', className: 'all text-center' },
        { target: 7, title: 'Editar', className: 'all text-center' },
        { target: 8, title: 'Eliminar', className: 'all text-center' },


    ]
})

$("#guardarFormDPT").click(function (e) {
    e.preventDefault();
    
    var formData = new FormData($('#formularioDPT')[0]);

          

    // Recopila los datos de los contactos predeterminados
    var contactos = [];
    $(".funciones-responsabilidades-cargo").each(function() {
        var contacto = {
            'FUNCION_CLAVE_GESTION_DPT': $(this).find("input[name='FUNCION_CLAVE_GESTION_DPT']").val(),

        };
        contactos.push(contacto);
    });

    formData.append('FUNCIONES_CARGO_DPT',JSON.stringify(contactos));

    
    if (ID_FORMULARIO_DPT == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se usara para la creación del DPT",
            icon: "question",
        },async function () { 
            
            await loaderbtn('guardarFormDPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT }, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true}, false, function (data) {
                
                setTimeout(() => {
                    
                    ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del DPT')
                    $('miModal_DPT').modal('hide')
                    document.getElementById('formularioDPT').reset();
                    TablaDPT.ajax.reload()
                    
                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
        alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información del DPT",
            icon: "question",
        },async function () { 
            
            await loaderbtn('guardarFormDPT')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT }, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true}, false, function (data) {
                
                setTimeout(() => {
                    
                    
                    ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    $('miModal_DPT').modal('hide')
                    document.getElementById('formularioDPT').reset();
                    TablaDPT.ajax.reload()
                    
                    
                    
                }, 300);  
            })
        }, 1)
    }
    
});



























document.addEventListener("DOMContentLoaded", function() {
    const botonAgregar = document.getElementById('botonagregarContacto');
    botonAgregar.addEventListener('click', agregarContacto);

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarlistadecontacto','m-3');
        divContacto.innerHTML = `
       
            <div class="col-lg-12 col-sm-1">
                    
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label>Área contacto: *</label>
                        <input type="text" class="form-control" name="FUNCION_CLAVE_GESTION_DPT" required>
                    </div>
                </div>
                
             
                <div class="col-lg-3 col-sm-6">
                
                <div class="col-1">
                    <div class="form-group" style="text-align: center;">
                        <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar contacto <i class="fa fa-trash"></i></button>
                    </div>
                </div>
            
        `;
        const contenedor = document.querySelector('.funciones-responsabilidades-cargo');
        contenedor.appendChild(divContacto);

        const botonEliminar = divContacto.querySelector('.botonEliminarContacto');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divContacto);
        });
    }
});



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
    $('#botonagregargestion').on('click', function(e){
        e.preventDefault();

        contadorFunciones1++;
        var inputHTML = '<div class="row mb-3">' +
                            '<div class="col-1 d-flex align-items-center justify-content-center">' +
                                '<span>' + contadorFunciones1 + '</span>' +
                            '</div>' +
                            '<div class="col-10">' +
                                '<input type="text" id="FUNCION_CLAVE_GESTION_DPT' + contadorFunciones1 + '" name="FUNCION_CLAVE_GESTION_DPT' + contadorFunciones1 + '" class="form-control text-center">' +
                            '</div>' +
                            '<div class="col-1">' +
                                '<button class="btn btn-danger" onclick="eliminarFuncion1(this)"><i class="bi bi-trash"></i></button>' +
                            '</div>' +
                        '</div>';

        document.getElementById('funciones-responsabilidades-gestion').insertAdjacentHTML('beforeend', inputHTML);
    })

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


    