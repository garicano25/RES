//VARIABLES GLOBALES
var ID_AREA = 0

//TABLAS
TablaCargos = null


//LIMPIAMOS EL FORMULARIO DE AREAS CADA VEZ QUE ESTE SE CIERRE
const ModalArea = document.getElementById('ModalArea')
ModalArea.addEventListener('hidden.bs.modal', event => {
    document.getElementById('formArea').reset();
    // $('#guardarArea').text('Guardar')
    $('#guardarArea').html('Guardar').prop('disabled', false).removeClass('btn-light').addClass('btn-success');
    $('#nav-encargados-tab').prop('disabled', true)
    $('#nav-cargos-tab').prop('disabled', true)
    $('#nav-area-tab').click()
    ID_AREA = 0
})


// Para mostrar el fondo oscurecido y la imagen de carga


$("#guardarArea").click(function (e) {
    e.preventDefault();
    
    var valida = this.form.checkValidity();
    if (valida) { 

        if (ID_AREA == 0) {
            
            alertMensajeConfirm({
                title: "Desea guardar esta nueva area?",
                text: "Al guardarla, se agregara al organigrama",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true}, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        // $('#guardarArea').text('Guardar cambios')
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Areas guardada exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()
                    
                        
                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
             alertMensajeConfirm({
                title: "Desea editar el area actual?",
                text: "Al guardarla, se editara en el organigrama",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true}, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        // $('#guardarArea').text('Guardar cambios')
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Areas editada exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()

                    }, 300);  
                })
            }, 1)
        }
    }
});





$("#guardarDepartamento").click(function (e) {
    e.preventDefault();
    
    var valida = this.form.checkValidity();
    if (valida) { 

            
        alertMensajeConfirm({
            title: "Desea guardar este cargo al area actual?",
            text: "Al guardarlo, se agregara al organigrama",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDepartamento')
            await ajaxAwaitFormData({ api: 2, AREA_ID : ID_AREA  , ID_DEPARTAMENTO_AREA: 0}, 'areasSave', 'formDepartamentos', 'guardarDepartamento', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    alertToast('Departamento guardado exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()
                        TablaCargos.ajax.reload()
                    
                }, 300);  
            })
        }, 1)
    }
});

//INICIAMOS LA TABLA DE LAS AREAS
TablaAreas = $("#TablaAreas").DataTable({
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
        url: '/TablaAreas',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaAreas.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { data: 'ID_AREA' },
        { data: 'NOMBRE' },
        { data: 'ENCARGADOS' },
        { data: 'DEPARTAMENTOS' },
        { data: 'BTN_ORGANIGRAMA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Area', className: 'all' },
        { target: 2, title: 'Encargados', className: 'all' },
        { target: 3, title: 'Departamentos', className: 'all' },
        { target: 4, title: 'Organigrama', className: 'all text-center' },
        { target: 5, title: 'Editar', className: 'all text-center' },
        { target: 6, title: 'Eliminar', className: 'all text-center' },

    ]
})


$('#TablaAreas tbody').on('click', 'td>button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);
    ID_AREA = row.data().ID_AREA

    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formArea', 'ModalArea')
    $('#nav-encargados-tab').prop('disabled', false)
    $('#nav-cargos-tab').prop('disabled', false)

    //CARGAMOS LA TABLA DE LOS DEPARTAMENTOS
    TablaDepartamentos(ID_AREA)
})

$('#TablaAreas tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);
    ID_AREA = row.data().ID_AREA

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_AREA: ID_AREA
    }
    eliminarDatoTabla(data, TablaAreas, 'areasDelete')

})


function TablaDepartamentos(id_area) {

    if (TablaCargos) {
        TablaCargos.destroy()
    }

    TablaCargos = $("#TablaCargos").DataTable({
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
            url: '/TablaCargos/'+ id_area,
            beforeSend: function () {
        
            },
            complete: function () {
                TablaCargos.columns.adjust().draw()
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: 'COUNT' },
            { data: 'NOMBRE' },
            { data: 'BTN_ELIMINAR' },

        ],
        columnDefs: [
            { target: 0, title: '#', className: 'all' },
            { target: 1, title: 'Cargo', className: 'all' },
            { target: 2, title: 'Eliminar', className: 'all text-center' },
        ]
    })
}

