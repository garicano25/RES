@extends('principal.maestra')

@section('contenido')


<style>
    .header {
        background-color: rgba( 225, 83, 93); /* Color de fondo personalizable con opacidad */
        padding: 20px;
        display: flex;
        align-items: center; /* Centra verticalmente */
        justify-content: space-between; /* Espacia los elementos horizontalmente */
        -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); /* Sombra */
        -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); /* Sombra */
        box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); /* Sombra */
    }

    .logo-img {
        width: 150px; /* Tamaño personalizable */
        margin-right: 15px; /* Espacio entre la imagen y el texto */
    }

    .header-text {
        flex: 1; /* Llena el espacio restante */
        display: flex;
        align-items: center; /* Centra verticalmente */
        justify-content: center; /* Centra horizontalmente */
    }

    h1 {
        margin: 0;
        color: white; /* Texto en blanco */
    }

    .form-label-puestos {
    font-size: 1.5rem; /* Tamaño de fuente más grande */
    margin: auto; /* Centra horizontalmente */
    text-align: center; /* Centra el texto horizontalmente */
    display: block; /* Asegura que el elemento ocupe todo el ancho disponible */
    width: fit-content; /* Ajusta el ancho del elemento al contenido */
}   
</style>

<header class="header mt-5 mb-4">
    <img src="/assets/images/Negroancho.png" alt="Logo" class="logo-img"> <!-- Logo a la izquierda del header -->
    <div class="header-text"> <!-- Contenedor del texto -->
        <h1>Vacantes</h1> <!-- Texto en el centro del header -->
    </div>
</header>
 


<div class="contenedor-contenido">
    <form id="formulario">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre completo" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" placeholder="correo@example.com" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
            <label for="curp" class="form-label">CURP</label>
            <input type="text" class="form-control" id="curp" placeholder="CURP" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="text" class="form-control" id="fecha_nacimiento">
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad">
        </div>
        
        <button type="button" class="btn btn-primary" id="btnSiguiente">Siguiente</button>
        
        <div class="mb-3 d-none" id="selectPuestos">
            <label for="puestos" class="form-label form-label-puestos">Vacantes</label>
            <select class="form-select" id="puestos">
                <option selected disabled>Selecciona un puesto</option>
                <option value="1">Puesto 1</option>
                <option value="2">Puesto 2</option>
                <option value="3">Puesto 3</option>
            </select>
        </div>
    </form>
</div>






@endsection