//VARIABLES
ID_CATALOGO_VACANTE = 0




const ModalArea = document.getElementById('miModal_vacantes');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_CATALOGO_VACANTE = 0;
    document.getElementById('formularioVACANTES').reset();
    document.getElementById('inputs-container').innerHTML = '';
});





$("#guardarFormvacantes").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioVACANTES'))

    if (formularioValido) {

    if (ID_CATALOGO_VACANTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
    
});


var Tablavacantes = $("#Tablavacantes").DataTable({
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
        url: '/Tablavacantes',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablavacantes.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
    columns: [
        { data: 'ID_CATALOGO_VACANTE' },
        { data: 'CATEGORIA_VACANTE' },
        { data: 'LUGAR_VACANTE' },
        { data: 'DESCRIPCION_VACANTE' },
        { 
            data: 'created_at',
            render: function(data, type, row) {
                return data.split(' ')[0]; 
            }
        },
        { data: 'FECHA_EXPIRACION' },
        { data: null,
            render: function (data, type, row) {
                return row.BTN_EDITAR + ' ' + row.BTN_VISUALIZAR + ' ' + row.BTN_ELIMINAR;
            }
        }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center descripcion-column' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center descripcion-column' },

        {
            targets: 3,
            title: 'Descripción de la vacantes',
            className: 'all text-center descripcion-column',
            render: function(data, type, row, meta) {
                if (type === 'display' && data.length > 100) {
                    return data.substr(0, 201) + '...'; 
                }
                return data;
            }
        },
        { targets: 4, title: 'Fecha de publicación', className: 'all text-center descripcion-column' },
        { targets: 5, title: 'Fecha de expiración', className: 'all text-center descripcion-column' },
        { targets: 6, title: 'Botones', className: 'all text-center' }
    ]
});



$('#Tablavacantes tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_CATALOGO_VACANTE: row.data().ID_CATALOGO_VACANTE
    }
    
    eliminarDatoTabla(data, [Tablavacantes], 'VacanteDelete')

})


$('#Tablavacantes tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);
    ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;

    // Llamar a la función para cargar los datos del formulario
    editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes', 1);

    // Cargar los requerimientos existentes
    cargarRequerimientos(row.data().REQUERIMIENTO);
});

function cargarRequerimientos(requerimientos) {
    const contenedor = document.getElementById('inputs-container');
    contenedor.innerHTML = ''; // Limpiar el contenedor

    requerimientos.forEach(function(requerimiento) {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-10">
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" value="${requerimiento.NOMBRE_REQUERIMINETO}" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
            </div>
        `;
        contenedor.appendChild(divInput);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divInput);
        });
    });
}


document.addEventListener("DOMContentLoaded", function() {
    const botonAgregar = document.getElementById('botonAgregar');
    botonAgregar.addEventListener('click', function(e) {
        e.preventDefault();
        agregarInput();
    });

    function agregarInput() {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-10">
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
            </div>
        `;
        const contenedor = document.getElementById('inputs-container');
        contenedor.appendChild(divInput);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divInput);
        });
    }
});





document.addEventListener("DOMContentLoaded", function() {
    const postularseButtons = document.querySelectorAll('.postularse-btn');

    postularseButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const curpInputDiv = this.nextElementSibling;
            if (curpInputDiv.style.display === 'none' || curpInputDiv.style.display === '') {
                curpInputDiv.style.display = 'block';
            } else {
                curpInputDiv.style.display = 'none';
            }
        });
    });
});