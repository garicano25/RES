

@extends('principal.maestra')

@section('contenido')


  

    <div class="contenedor-contenido">
        <div id="toolbar">
            <input type="text" id="textoNodo" placeholder="Texto del Nodo">
            <input type="color" id="colorNodo">
            <input type="color" id="colorTexto" value="#000000">
            <button id="agregarNodo">Agregar Nodo</button>
            <button id="agregarRelacion">Agregar Relación</button>
        </div>
        <div id="organigrama-container"></div>

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            let organigrama = new joint.dia.Graph();
            let paper = new joint.dia.Paper({
                el: document.getElementById('organigrama-container'),
                width: '100%',
                height: 600,
                gridSize: 10,
                model: organigrama,
                interactive: function(cellView) {
                    if (cellView.model instanceof joint.dia.Link) {
                        return {
                            vertexAdd: false,
                            vertexMove: false,
                            arrowheadMove: false,
                            labelMove: false,
                            linkMove: false,
                            linkTools: false,
                            boundaryMove: false,
                        };
                    }
                    return true;
                },
                defaultLink: new joint.shapes.standard.Link({
                    attrs: {
                        line: {
                            stroke: '#000',
                            strokeWidth: 2,
                            targetMarker: {
                                type: 'path',
                                fill: '#000',
                                stroke: '#000',
                                d: 'M 10 -5 0 0 10 5 Z'
                            }
                        }
                    },
                    deleteButton: {
                        cursor: 'pointer',
                        ref: 'line',
                        refX: 0.5,
                        refY: -10,
                        text: 'x',
                        fill: 'red',
                        fontSize: 18,
                        'font-weight': 'bold',
                        'text-anchor': 'middle'
                    }
                }),
                validateConnection: function(cellViewS, magnetS, cellViewT, magnetT, end, linkView) {
                    if (magnetS && magnetS.getAttribute('port-group') === 'out' &&
                        magnetT && magnetT.getAttribute('port-group') === 'in') {
                        return true;
                    }
                    return false;
                }
            });

            let toolbar = document.getElementById('toolbar');
            let textoNodoInput = document.getElementById('textoNodo');
            let colorNodoInput = document.getElementById('colorNodo');
            let colorTextoInput = document.getElementById('colorTexto');
            let agregarNodoBtn = document.getElementById('agregarNodo');
            let agregarRelacionBtn = document.getElementById('agregarRelacion');

            let sourceNode = null;
            let targetNode = null;

            agregarNodoBtn.addEventListener('click', function() {
                let texto = textoNodoInput.value;
                let colorNodo = colorNodoInput.value;
                let colorTexto = colorTextoInput.value;

                let textWidth = getTextWidth(texto, 'bold 12px Arial');
                let textHeight = 20;
                let nodeWidth = textWidth + 40;
                let nodeHeight = textHeight + 20;

                let rect = new joint.shapes.standard.Rectangle({
                    position: { x: 100, y: 100 },
                    size: { width: nodeWidth, height: nodeHeight },
                    attrs: {
                        body: {
                            fill: colorNodo,
                            stroke: '#999',
                            rx: 10,
                            ry: 10
                        },
                        label: {
                            text: texto,
                            fill: colorTexto,
                            refX: '50%',
                            refY: '50%',
                            fontSize: 12,
                            textAnchor: 'middle',
                            textVerticalAnchor: 'middle'
                        },
                        deleteButton: {
                            cursor: 'pointer',
                            ref: 'rect',
                            refX: '100%',
                            refY: 0,
                            text: 'x',
                            fill: 'red',
                            fontSize: 18,
                            class: 'delete-button'
                        }
                    }
                });

                organigrama.addCell(rect);
            });

            agregarRelacionBtn.addEventListener('click', function() {
                if (sourceNode && targetNode) {
                    let link = new joint.shapes.standard.Link({
                        source: { id: sourceNode.id },
                        target: { id: targetNode.id },
                    });

                    organigrama.addCell(link);
                    sourceNode = null;
                    targetNode = null;
                } else {
                    alert('Selecciona dos nodos para establecer una relación.');
                }
            });

            paper.on('cell:pointerdown', function(cellView, evt) {
                let cell = cellView.model;
                if (cell.isElement()) {
                    if (!sourceNode) {
                        sourceNode = cell;
                    } else if (!targetNode) {
                        targetNode = cell;
                    }
                }
            });

            paper.on('blank:pointerdown', function(evt, x, y) {
                sourceNode = null;
                targetNode = null;
            });

            paper.on('element:contextmenu', function(cellView, evt) {
                evt.preventDefault();
                let cell = cellView.model;
                showContextMenu(cell, cellView, evt.clientX, evt.clientY);
            });

            paper.on('link:contextmenu', function(cellView, evt) {
                evt.preventDefault();
                let cell = cellView.model;
                showContextMenu(cell, cellView, evt.clientX, evt.clientY);
            });

            function getTextWidth(text, font) {
                let canvas = document.createElement('canvas');
                let context = canvas.getContext('2d');
                context.font = font;
                let metrics = context.measureText(text);
                return metrics.width;
            }

            function showContextMenu(cell, cellView, x, y) {
                let menu = document.createElement('div');
                menu.classList.add('context-menu');
                if (cell instanceof joint.dia.Link) {
                    menu.innerHTML = `
                        <div class="context-menu-item">Eliminar </div>
                        <div class="context-menu-item">Editar </div>
                    `;
                } else {
                    menu.innerHTML = `
                        <div class="context-menu-item">Eliminar </div>
                        <div class="context-menu-item">Editar </div>
                    `;
                }
                let bbox = cellView.getBBox();
                menu.style.top = bbox.y + bbox.height / 2 + 'px';
                menu.style.left = bbox.x + bbox.width + 'px';
                document.body.appendChild(menu);

                menu.addEventListener('click', function(e) {
                    if (cell instanceof joint.dia.Link) {
                        if (e.target.textContent === 'Eliminar ') {
                            organigrama.getCell(cell.id).remove();
                        } else if (e.target.textContent === 'Editar ') {
                            // Agrega aquí la lógica para editar la flecha
                            alert('Editar Flecha');
                        }
                    } else {
                        if (e.target.textContent === 'Eliminar ') {
                            organigrama.getCell(cell.id).remove();
                        } else if (e.target.textContent === 'Editar ') {
                            // Agrega aquí la lógica para editar el nodo
                            alert('Editar Nodo');
                        }
                    }
                    menu.remove();
                });

                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target)) {
                        menu.remove();
                    }
                });
            }
        });
    </script>


@endsection