@extends('principal.maestra')

@section('contenido')


<div class="md:flex flex-col md:flex-row md:min-h-screen w-full mx-auto">
    
    <!-- * * * * * * * * * * * * * -->
    <!-- Start of GoJS sample code -->
    
    <script src="./release/go.js"></script>
    <div id="allSampleContent" class="p-4 w-full">

  <style type="text/css">
    #myOverviewDiv {
      position: absolute;
      width: 200px;
      height: 100px;
      top: 10px;
      left: 10px;
      background-color: #73a453;
      z-index: 300; /* make sure its in front */
      border: solid 1px #153cff;
    }
  </style>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet" type="text/css">
    <script id="code">
    function init() {

      // Since 2.2 you can also author concise templates with method chaining instead of GraphObject.make
      // For details, see https://gojs.net/latest/intro/buildingObjects.html
      const $ = go.GraphObject.make;  // for conciseness in defining templates

      // some constants that will be reused within templates
      var mt8 = new go.Margin(8, 0, 0, 0);
      var mt4 = new go.Margin(4, 0, 0, 0);
      var mr8 = new go.Margin(0, 8, 0, 0);
      var ml8 = new go.Margin(0, 0, 0, 8);
      var roundedRectangleParams = {
        parameter1: 2,  // set the rounded corner
        spot1: go.Spot.TopLeft, spot2: go.Spot.BottomRight  // make content go all the way to inside edges of rounded corners
      };

      myDiagram =
        $(go.Diagram, "myDiagramDiv",  // the DIV HTML element
          {
            // Put the diagram contents at the top center of the viewport
            initialDocumentSpot: go.Spot.Top,
            initialViewportSpot: go.Spot.Top,
            // OR: Scroll to show a particular node, once the layout has determined where that node is
            // "InitialLayoutCompleted": e => {
            //  var node = e.diagram.findNodeForKey(28);
            //  if (node !== null) e.diagram.commandHandler.scrollToPart(node);
            // },
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
            font: "12px Roboto, sans-serif", stroke: "rgba(0, 0, 0, .60)",
            visible: false  // only show textblocks when there is corresponding data for them
          },
          new go.Binding("visible", field, val => val !== undefined)
        ];
      }
      
      // define Converters to be used for Bindings
      function theNationFlagConverter(nation) {
        return "../" + nation + ".webp";
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
            new go.Binding("fill", "isHighlighted", h => h ? "gold" : "#ffffff").ofObject()
          ),
          $(go.Panel, "Vertical",
            $(go.Panel, "Horizontal",
              { margin: 8 },
              // $(go.Picture,  // flag image, only visible if a nation is specified
              //   { margin: mr8, visible: false, desiredSize: new go.Size(50, 50) },
              //   new go.Binding("source", "nation", theNationFlagConverter),
              //   new go.Binding("visible", "nation", nat => nat !== undefined)
              // ),
              $(go.Panel, "Table",
                $(go.TextBlock,
                  {
                    row: 0, alignment: go.Spot.Left,
                    font: "16px Roboto, sans-serif",
                    stroke: "rgba(0, 0, 0, .87)",
                    maxSize: new go.Size(200, NaN)
                  },
                  new go.Binding("text", "name")
                ),
                $(go.TextBlock, textStyle("title"),
                  {
                    row: 1, alignment: go.Spot.Left,
                    maxSize: new go.Size(200, NaN)
                  },
                  new go.Binding("text", "title"),
                  new go.Binding("margin", "title", head => mt4),
                ),
                $("PanelExpanderButton", "INFO",
                  { row: 0, column: 1, rowSpan: 1, margin: ml8 }
                )
              )
            ),
            $(go.Shape, "LineH",
              {
                stroke: "rgba(0, 0, 0, .60)", strokeWidth: 2,
                height: 1, stretch: go.GraphObject.Horizontal
              },
              new go.Binding("visible").ofObject("INFO")  // only visible when info is expanded
            ),
            $(go.Panel, "Vertical",
              {
                name: "INFO",  // identify to the PanelExpanderButton
                stretch: go.GraphObject.Horizontal,  // take up whole available width
                margin: 8,
                defaultAlignment: go.Spot.Left,  // thus no need to specify alignment on each element
              },
              $(go.TextBlock, textStyle("boss"),
    
                new go.Binding("margin", "headOf", head => mt4), // some space above if there is also a headOf value
                new go.Binding("text", "boss", boss => {
                  var boss = myDiagram.model.findNodeDataForKey(boss);
                  if (boss !== null) {
                    return "Reporta: " + boss.name;
                  }
                  return "";
                })
              ),
              $(go.TextBlock, textStyle("headOf"),
                new go.Binding("text", "headOf", head => "Head of: " + head),
                new go.Binding("margin", "headOf", head => mt4),
              ),
              $(go.TextBlock, textStyle("personal"),
                new go.Binding("text", "personal", head => "Cantidad de Personal: " + head),
                new go.Binding("margin", "personal", head => mt4),
              ),
              $(go.TextBlock, textStyle("auxiliares"),
                new go.Binding("text", "auxiliares", head => "Cantidad de Auxiliares: " + head),
                new go.Binding("margin", "auxiliares", head => mt4),
              ),

            )
          )
        );

      // define the Link template, a simple orthogonal line
      myDiagram.linkTemplate =
        $(go.Link, go.Link.Orthogonal,
          { corner: 5, selectable: false },
          $(go.Shape, { strokeWidth: 3, stroke: "#424242" }));  // dark gray, rounded corner links


      // set up the nodeDataArray, describing each person/position
      var nodeDataArray = [
        { key: 0, name:            "Asamblea               ", nation: "enfermera", title: "Asamblea de Socios" },
        { key: 1, boss: 0,   name: "Directorio             ", nation: "Ireland", title: "Ignacio F. Escuti - Alejandro Sarria"},
        { key: 3, boss: 1,   name: "Coordinacion General   ", nation: "Denmark", title: "Susana Lopez" },
        { key: 4, boss: 3,   name: "RRHH                   ", nation: "Denmark", title: "Ayelen Bianchetti", personal: 1, auxiliares: 1},
        { key: 5, boss: 3,   name: "Administracion         ", nation: "Denmark", },
        { key: 6, boss: 5,   name: "Contabilidad y Finanzas", nation: "Denmark", title: "Natalia Lobo" },
        { key: 8, boss: 6,   name: "Tesoreria              ", nation: "Denmark", personal: 1},
        { key: 16, boss: 6,  name: "Contabilidad           ", nation: "Denmark", personal: 1, auxiliares: "Externo" },
        { key: 9, boss: 6,   name: "Cobranzas              ", nation: "Denmark",  personal: 0},
        { key: 7, boss: 3,   name: "Sistemas               ", nation: "Denmark", title: "Harvey Morales", auxiliares: 1 },
        { key: 10, boss: 5,  name: "Prestaciones Medicas   ", nation: "Denmark", title: "Gonzalo Avalos" },
        { key: 21, boss: 10, name: "Liquidaciones          ", nation: "Denmark", personal: 1},
        { key: 22, boss: 10, name: "Auditoria              ", nation: "Denmark"},
        { key: 23, boss: 10, name: "Facturación            ", nation: "Denmark", personal: 3},
        { key: 24, boss: 10, name: "Convenios              ", nation: "Denmark",  personal: 1},
        { key: 11, boss: 5,  name: "Compras                ", nation: "Denmark", title: "Gonzalo Avalos   " },
        { key: 25, boss: 11, name: "Farmacia               ", nation: "Denmark", personal: 3, auxiliares: 1},
        { key: 26, boss: 11, name: "Compras Generales      ", nation: "Denmark",  },
        { key: 27, boss: 26, name: "Medicamentos y Descartables", nation: "Denmark", personal: 1 },
        { key: 28, boss: 26, name: "Equipamiento, Reparacion y Mantenimiento", nation: "Denmark"},
        { key: 12, boss: 3,  name: "Secretaria             ", nation: "Denmark"},
        { key: 43, boss: 12, name: "Ambulatorio            ", nation: "Denmark", title: "Andrea Rodriguez " },
        { key: 41, boss: 43, name: "Secretaria Ambulatoria ", nation: "Denmark",personal: 7, auxiliares: 4 },
        { key: 41, boss: 43, name: "Central de Turnos      ", nation: "Denmark", personal: 2 , auxiliares: 4},
        { key: 42, boss: 12, name: "Archivo                ", nation: "Denmark",  personal: 1, title: "Andrea Rodriguez " },
        { key: 49, boss: 12, name: "Telefonista            ", nation: "Denmark", title: "Andrea Rodriguez ", personal: 5 },
        { key: 17, boss: 12, name: "Internado              ", nation: "Denmark", personal: 2 },
        { key: 13, boss: 3,  name: "Enfermeria             ", nation: "enfermera"},
        { key: 18, boss: 13, name: "Enfermeria de Piso     ", nation: "enfermera", title: "Cistina Valentino ",personal: 25 },
        { key: 19, boss: 13, name: "Enfermeria de UTI/UCO  ", nation: "enfermera", title: "Selva Coccio",personal: 25 },
        { key: 20, boss: 13, name: "Enfermeria de Guardia Central", nation: "enfermera", title: "Selva Coccio", personal: 5 },
        { key: 14, boss: 3,  name: "Cirugia                ", nation: "Denmark", title: "Anahi Escalerandi" },
        { key: 29, boss: 14, name: "Mucamas                ", nation: "Denmark",personal: 2 },
        { key: 30, boss: 14, name: "Instrumentador         ", nation: "Denmark",personal: 7},
        { key: 31, boss: 14, name: "Circulares             ", nation: "Denmark",personal: 4 },
        { key: 31, boss: 14, name: "Central de Esterilización", personal: 1 },
        { key: 15, boss: 3,  name: "Auxiliar               ", nation: "Denmark" },
        { key: 32, boss: 15, name: "Mantenimiento          ", nation: "Denmark", title: "Jorge Ferreyra" },
        { key: 38, boss: 32, name: "Mantenimiento Edilicio ", nation: "Denmark",personal: 2 },
        { key: 39, boss: 32, name: "Mantenimiento Equipamiento e Instrumantal Medico", nation: "Denmark",personal: 1 },
        { key: 40, boss: 15, name: "Cocina                 ", nation: "Denmark", title: "Belen Palaveccino ",personal: 3 },
        { key: 34, boss: 15, name: "Mucamas                ", nation: "Denmark", title: "Cristina Valentino ",personal: 9 },
        { key: 35, boss: 15, name: "Lavadero               ", nation: "Denmark", title: "Cristina Valentino ",personal: 4 },
        { key: 36, boss: 15, name: "Camillero              ", nation: "Denmark", title: "Cristina Valentino ",personal: 3 },
        { key: 37, boss: 15, name: "Seguridad              ", nation: "Denmark", personal: 1 },


      ];

      // create the Model with data for the tree, and assign to the Diagram
      myDiagram.model =
        new go.TreeModel(
          {
            nodeParentKeyProperty: "boss",  // this property refers to the parent node data
            nodeDataArray: nodeDataArray
          });

      // Overview
      myOverview =
        $(go.Overview, "myOverviewDiv",  // the HTML DIV element for the Overview
          { observed: myDiagram, contentAlignment: go.Spot.Center });   // tell it which Diagram to show and pan
    }

    // the Search functionality highlights all of the nodes that have at least one data property match a RegExp
    function searchDiagram() {  // called by button
      var input = document.getElementById("mySearch");
      if (!input) return;
      myDiagram.focus();

      myDiagram.startTransaction("highlight search");

      if (input.value) {
        // search four different data properties for the string, any of which may match for success
        // create a case insensitive RegExp from what the user typed
        var safe = input.value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        var regex = new RegExp(safe, "i");
        var results = myDiagram.findNodesByExample({ name: regex },
          { nation: regex },
          { title: regex },
          { headOf: regex },
          { personal: regex },
          { auxiliares: regex },
          );
        myDiagram.highlightCollection(results);
        // try to center the diagram at the first node that was found
        if (results.count > 0) myDiagram.centerRect(results.first().actualBounds);
      } else {  // empty string only clears highlighteds collection
        myDiagram.clearHighlighteds();
      }

      myDiagram.commitTransaction("highlight search");
    }
    window.addEventListener('DOMContentLoaded', init);
  </script>

<div id="sample" style="position: relative;">
  <div id="myDiagramDiv" style="background-color: #ffffff; border: solid 1px black; width: 100%; height: 77rem"></div>
  <div id="myOverviewDiv"></div> <!-- Styled in a <style> tag at the top of the html page -->

</div>

@endsection