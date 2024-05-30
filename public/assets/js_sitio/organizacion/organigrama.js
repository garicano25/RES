//VARIABLES GLOBALES
var ID_AREA = 0

//TABLAS
TablaCargos = null
TablaEncargado = null

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

$('#nav-encargados-tab').on('click', function () { TablaEncargado.columns.adjust().draw() })

// ======================== AREAS =================================
$("#guardarArea").click(function (e) {
    e.preventDefault();
    
    var valida = this.form.checkValidity();
    if (valida) { 

        if (ID_AREA == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar esta nueva área?",
                text: "Al guardarla, se agregara al organigrama",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true}, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Área guardada exitosamente', 'success', 3000)

                        //Cargamos las tablas
                        TablaAreas.ajax.reload()
                        TablaEncargados(ID_AREA)
                        TablaDepartamentos(ID_AREA)

                        
                        
                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
             alertMensajeConfirm({
                title: "¿Desea editar el área actual?",
                text: "Al guardarla, se editara en el organigrama",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true}, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Área editada exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()

                    }, 300);  
                })
            }, 1)
        }
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
        { target: 1, title: 'Área', className: 'all' },
        { target: 2, title: 'Líderes de categorías', className: 'all' },
        { target: 3, title: 'Categorías', className: 'all' },
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
    TablaEncargados(ID_AREA)
    TablaDepartamentos(ID_AREA)

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
        
    }, function (data) {

        swal.close()
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

// ======================== ENCARGADOS DE LAS AREAS =================================

$("#guardarEncargado").click(function (e) {
    e.preventDefault();
    
    var valida = this.form.checkValidity();
    if (valida) { 

            
        alertMensajeConfirm({
            title: "¿Desea agregar este Líder de categoría al área actual?",
            text: "Al guardarlo, se agregara al organigrama",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarEncargado')
            await ajaxAwaitFormData({ api: 3, AREA_ID : ID_AREA  , ID_ENCARGADO_AREA: 0}, 'areasSave', 'formEncargado', 'guardarEncargado', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    alertToast('Líder guardado exitosamente', 'success', 3000)
                    // TablaAreas.ajax.reload()
                    TablaEncargado.ajax.reload()
                    $('#NOMBRE_CARGO').val('')
                    
                }, 300);  
            })
        }, 1)
    }
});


function TablaEncargados(id_area) {

    if (TablaEncargado != null) {
        TablaEncargado.destroy()
        
    }   

    TablaEncargado = $("#TablaEncargados").DataTable({
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
                TablaEncargado.columns.adjust().draw()
            
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: 'COUNT' },
            { data: 'NOMBRE_CARGO' },
            { data: 'BTN_ELIMINAR' },

        ],
        columnDefs: [
            { target: 0, title: '#', className: 'all' },
            { target: 1, title: 'Nombre de la categoría', className: 'all' },
            { target: 2, title: 'Eliminar', className: 'all text-center' },
        ]
    })

}

$('input[name="TIENE_ENCARGADO"]').change(function() {
	
	var valor = $(this).val();
	
	if (valor === '1') {
		
        $('#ENCARGADO_AREA_ID').prop('required', true).prop('disabled', false);

	} else if (valor === '0') {
			
        $('#ENCARGADO_AREA_ID').prop('required', false).prop('disabled', true);

	}
});

$('#nav-cargos-tab').on('click', function () {
    
    TablaCargos.columns.adjust().draw()    
    ajaxAwait({}, '/listaEncagadosAreas/' + ID_AREA, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
		
        $('#ENCARGADO_AREA_ID').html('<option value="">Consultando...</option>').prop('disabled', true);
        
    }, function (data) {
         
		$('#ENCARGADO_AREA_ID').html(data.opciones).prop('disabled', false);
        
    })

})




// ======================== DEPARTAMENTOS DE LAS AREAS  =================================

$("#guardarDepartamento").click(function (e) {
    e.preventDefault();
    
    var valida = this.form.checkValidity();
    if (valida) { 

            
        alertMensajeConfirm({
            title: "¿Desea guardar esta categoría al área actual?",
            text: "Al guardarlo, se agregara al organigrama",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDepartamento')
            await ajaxAwaitFormData({ api: 2, AREA_ID : ID_AREA  , ID_DEPARTAMENTO_AREA: 0}, 'areasSave', 'formDepartamentos', 'guardarDepartamento', { callbackAfter: true}, false, function (data) {
                    
                setTimeout(() => {

                    alertToast('Categoría guardada exitosamente', 'success', 3000)
                    TablaAreas.ajax.reload()
                    TablaCargos.ajax.reload()
                    
                    $('#formDepartamentos').trigger("reset");
                    
                }, 300);  
            })
        }, 1)
    }
});



function TablaDepartamentos(id_area) {

    if (TablaCargos != null) {
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
            { target: 1, title: 'Categoria', className: 'all' },
            { target: 2, title: 'Eliminar', className: 'all text-center' },
        ]
    })

}


$('#TablaCargos').on('click', 'button.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaCargos.row(tr);

    var data = {
        api: 2,
        ID_DEPARTAMENTO_AREA: row.data().ID_DEPARTAMENTO_AREA
    };

    eliminarDatoTabla(data, [TablaCargos, TablaAreas], 'areasDelete');
    

});




  