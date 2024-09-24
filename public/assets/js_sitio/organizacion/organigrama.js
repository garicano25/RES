//VARIABLES GLOBALES
var ID_AREA = 0

//TABLAS
TablaCategorias = null

function resetDiagram() {
  
    document.getElementById("myDiagramDiv").innerHTML = "";

    if (myDiagram) {
        myDiagram.div = null;
        myDiagram = null;
    }
    
    if (myOverview) {
        myOverview.div = null;
        myOverview = null;
    }
}

//FUNCION PARA EL ORGANIGRAMA
function init(dataJsonOrganigrama) {
    
      
          const $ = go.GraphObject.make; 

          // some constants that will be reused within templates
          var mt8 = new go.Margin(8, 0, 0, 0);
          var mt4 = new go.Margin(4, 0, 0, 0);
          var mr8 = new go.Margin(0, 8, 0, 0);
          var ml8 = new go.Margin(0, 0, 0, 8);
          var roundedRectangleParams = {
            parameter1: 15,  // set the rounded corner
            spot1: go.Spot.TopLeft, spot2: go.Spot.BottomRight  
          };

            // Function to determine color based on boss
          function determineColor(boss) {
            switch (boss) { 
              case 1: return "#09ABDD";  //Direccion
              case 2: return "#94B732";  //Intermediarios de areas
              case 3: return "#0A3E62";  //Areas
              case 4: return "#94B732";  //Intermediarios de cargos
              case 5: return "#B4C7E7";  //Cargos
              default: return "#ffffff"; 
            }
          }

          myDiagram =
            $(go.Diagram, "myDiagramDiv",  // the DIV HTML element
              {
                // Put the diagram contents at the top center of the viewport
                initialDocumentSpot: go.Spot.Top,
                initialViewportSpot: go.Spot.Top,
                layout:
                  $(go.TreeLayout,  // use a TreeLayout to position all of the nodes
                    {
                      isOngoing: false,  // don't relayout when expanding/collapsing panels
                      treeStyle: go.TreeLayout.StyleLastParents,
                      // properties for most of the tree:
                      angle: 90,
                      layerSpacing: 45,
                      // properties for the "last parents":
                      alternateAngle: 0,
                      alternateAlignment: go.TreeLayout.AlignmentStart,
                      alternateNodeIndent: 12,
                      alternateNodeIndentPastParent: 1,
                      alternateNodeSpacing: 20,
                      alternateLayerSpacing: 40,
                      alternateLayerSpacingParentOverlap: 1,
                      alternatePortSpot: new go.Spot(0.001, 1, 20, 0),
                      alternateChildPortSpot: go.Spot.Left
                    })
              });

          // This function provides a common style for most of the TextBlocks.
          // Some of these values may be overridden in a particular TextBlock.
          function textStyle(field) {
            return [
              {
                font: "12px Roboto, sans-serif", stroke: "#ffffff",
                visible: false  // only show textblocks when there is corresponding data for them
              },
              new go.Binding("visible", field, val => val !== undefined)
            ];
          }

        
          // define the Node template
          myDiagram.nodeTemplate =
            $(go.Node, "Auto",
              {
                locationSpot: go.Spot.Top,
                isShadowed: true, shadowBlur: 1,
                shadowOffset: new go.Point(0, 1),
                shadowColor: "rgba(0, 0, 0, .14)",
                selectionAdornmentTemplate:  // selection adornment to match shape of nodes
                  $(go.Adornment, "Auto",
                    $(go.Shape, "RoundedRectangle", roundedRectangleParams,
                      { fill: null, stroke: "#7986cb", strokeWidth: 3 }
                    ),
                    $(go.Placeholder)
                  )  // end Adornment
              },
              $(go.Shape, "RoundedRectangle", roundedRectangleParams,
                { name: "SHAPE", fill: "#ffffff", strokeWidth: 0 },
                // gold if highlighted, white otherwise
              new go.Binding("fill", "type", determineColor)

              ),
              $(go.Panel, "Vertical",
                $(go.Panel, "Horizontal",
                  { margin: 30 },
                  $(go.Panel, "Table",
                    $(go.TextBlock,
                      {
                        row: 0, alignment: go.Spot.Right,
                        font: "30px Roboto, sans-serif",
                        stroke: "#ffffff",
                        maxSize: new go.Size(500, NaN)
                      },
                      new go.Binding("text", "name")
                    ),
                  )
                ),
              )
            );

          // define the Link template, a simple orthogonal line
          myDiagram.linkTemplate =
            $(go.Link, go.Link.Orthogonal,
              { corner: 2, selectable: false },
              $(go.Shape, { strokeWidth: 3, stroke: "#000000" }));  // dark gray, rounded corner links



          // create the Model with data for the tree, and assign to the Diagram
          myDiagram.model =
            new go.TreeModel(
              {
                nodeParentKeyProperty: "boss",  // this property refers to the parent node data
                nodeDataArray: dataJsonOrganigrama
              });

          // Overview
          myOverview =
            $(go.Overview, "myOverviewDiv",  // the HTML DIV element for the Overview
              { observed: myDiagram, contentAlignment: go.Spot.Center });   // tell it which Diagram to show and pan
    
}


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


const ModalOrganigrama = document.getElementById('modalOrganigrama')
ModalOrganigrama.addEventListener('hidden.bs.modal', event => {
    resetDiagram()
    $('.body').css('padding-right', '0px')
})

$('#nav-encargados-tab').on('click', function () { TablaCategorias.columns.adjust().draw() })

// ======================== AREAS =================================
$("#guardarArea").click(function (e) {
    e.preventDefault();
    
    formularioValido = validarFormulario($('#formArea'))

    if (formularioValido) {

        if (ID_AREA == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar esta nueva área?",
                text: "Al guardarla, se agregara al organigrama",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true }, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Área guardada exitosamente', 'success', 3000)

                        //Cargamos las tablas
                        TablaAreas.ajax.reload()
                        TablaEncargados(ID_AREA)

                        
                        
                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar el área actual?",
                text: "Al guardarla, se editara en el organigrama",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true }, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        alertToast('Área editada exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()

                    }, 300);
                })
            }, 1)
        }
    } else {
        // Muestra un mensaje de error o realiza alguna otra acción
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

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
        { data: 'COUNT' },
        { data: 'NOMBRE' },
        { data: 'LIDERES' },
        { data: 'CATEGORIAS' },
        { data: 'BTN_ORGANIGRAMA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },

    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Área', className: 'all' },
        { target: 2, title: 'Líderes de categorías', className: 'all' },
        { target: 3, title: 'Categorías', className: 'all' },
        { target: 4, title: 'Organigrama', className: 'all text-center' },
        { target: 5, title: 'Editar', className: 'all text-center' },
        { target: 6, title: 'Estado', className: 'all text-center' },

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
    TablaEncargados(ID_AREA)

})

$('#TablaAreas tbody').on('click', 'td>button.ELIMINAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);

    data = {
        api: 1,
        ELIMINAR: 1,
        ID_AREA: row.data().ID_AREA
    }
    
    eliminarDatoTabla(data, [TablaAreas], 'areasDelete')

})


$('#TablaAreas tbody').on('click', 'td>button.ORGANIGRAMA', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);

    $('#TituloModalOrganigrma').text('Organigrama del área de: '+ row.data().NOMBRE)

    url = '/getDataOrganigrama/' + row.data().ID_AREA + '/' + 0

    ajaxAwait({}, url , 'GET', { callbackAfter: true, callbackBefore: true }, () => {
		
        Swal.fire({
            icon: 'info',
            title: 'Espere un momento',
            text: 'Estamos cargando la información para el organigrama',
            showConfirmButton: false
        })

        $('.swal2-popup').addClass('ld ld-breath')
        
    }, function (data) {

        swal.close()
        $('.swal2-popup').removeClass('ld ld-breath')
        dataJsonOrganigrama = JSON.parse(data.data)
        //Ejcutamos la funcion que crear el organigrama
        init(dataJsonOrganigrama)
            
        $('#modalOrganigrama').modal('show')

        
    })

    
  
})



$('#verOrganigramaGeneral').on('click', function () {


    $('#TituloModalOrganigrma').text('Organigrama General ')

    url = '/getDataOrganigrama/' + 0 + '/' + 1

    ajaxAwait({}, url , 'GET', { callbackAfter: true, callbackBefore: true }, () => {
		
        Swal.fire({
            icon: 'info',
            title: 'Espere un momento',
            text: 'Estamos cargando la información para el organigrama',
            showConfirmButton: false
        })
        
    }, function (data) {

        swal.close()
        dataJsonOrganigrama = JSON.parse(data.data)
        //Ejcutamos la funcion que crear el organigrama
        init(dataJsonOrganigrama)
            
        $('#modalOrganigrama').modal('show')

        
    })

    
  
})

// ======================== FUNCIONALIDADES DE LAS CATEGORIAS DE  AREAS =================================

$('#CATEGORIA').on('change', function (e) {

    var valorSeleccionado = $(this).find("option:selected");
    var esLider = valorSeleccionado.data("lider");
    
    if (esLider == 1) {
        $('#esLiderText').text('Es líder: Si')
        $('#LIDER').prop('disabled', true).prop('required', false)
        $('#LIDER').val('')
        $('#ES_LIDER').val(1)

    } else {
        $('#esLiderText').text('Es líder: No')
        $('#LIDER').prop('disabled', false).prop('required', true)
        $('#LIDER').val('')
        $('#ES_LIDER').val(0)
    }
})


$("#guardarEncargado").click(function (e) {
    e.preventDefault();
    
  

        
    alertMensajeConfirm({
        title: "¿Desea agregar esta categoría al area actual?",
        text: "Al guardarlo, se agregara al organigrama",
        icon: "question",
    },async function () { 

        await loaderbtn('guardarEncargado')

        await ajaxAwaitFormData({ api: 2, AREA_ID : ID_AREA, NUEVO: 1 }, 'areasSave', 'formCategoria', 'guardarEncargado', { callbackAfter: true}, false, function (data) {
                
            setTimeout(() => {
                
                document.getElementById('formCategoria').reset();
                $('#esLiderText').text('Categoría')

                alertToast('Categoría agregada exitosamente', 'success', 3000)

                TablaAreas.ajax.reload()
                TablaCategorias.ajax.reload()
                
                
            }, 300);  
        })
    }, 1)
    
});


function TablaEncargados(id_area) {

    if (TablaCategorias != null) {
        TablaCategorias.destroy()
        
    }   

    TablaCategorias = $("#TablaEncargados").DataTable({
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
            url: '/TablaEncargados/'+ id_area,
            beforeSend: function () {
        
            },
            complete: function () {
                TablaCategorias.columns.adjust().draw()
            
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: 'COUNT' },
            { data: 'NOMBRE' },
            { data: 'ES_LIDER' },
            { data: 'BTN_ACTIVO' }

        ],
        columnDefs: [
            { target: 0, title: '#', className: 'all' },
            { target: 1, title: 'Nombre de la categoría', className: 'all' },
            { target: 2, title: 'Es líder', className: 'all text-center' },
            { target: 3, title: 'Estado', className: 'all text-center' },

        ]
    })

}



$('#TablaEncargados').on('click', 'button.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaCategorias.row(tr);
    
    console.log('sds')
    var data = {
        api: 3,
        ID_ENCARGADO_AREA: row.data().ID_ENCARGADO_AREA
    };

    eliminarDatoTabla(data, [TablaCategorias], 'areasDelete');
    

});



  