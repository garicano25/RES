

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
        <div id="organigrama-container">



        </div>

 
 </div>

@endsection