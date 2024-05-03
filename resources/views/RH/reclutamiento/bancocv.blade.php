@extends('principal.maestra')

@section('contenido')


<style>
    .header {
        background-color: rgb(255, 255, 255); 
        padding: 20px;
        display: flex;
        align-items: center; 
        justify-content: space-between; 
        -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
        -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
        box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); 
    }

    .logo-img {
        width: 150px;
        margin-right: 15px; 
    }

    .header-text {
        flex: 1; 
        display: flex;
        align-items: center; 
        justify-content: center; 
    }

    h1 {
        margin: 0;
        color: rgb(0, 0, 0); 
        font-family: Poppins;

    }
    .form-label-puestos {
        font-family: Poppins;

    font-size: 1.5rem; 
    e fuente más grande 
    margin: auto;
    text-align: center;
    display: block; 
    width: fit-content; 
}   
</style>

<header class="header mt-5 mb-4">
    <img src="/assets/images/Negroancho.png" alt="Logo" class="logo-img"> 
    <div class="header-text">
        <h1>Vacantes</h1> 
    </div>
</header>
 


<div class="contenedor-contenido">
    <form id="formulario">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control"  name="NOMBRE_VACANTE"    id="NOMBRE_VACANTE" placeholder="Nombre completo" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" name="CORREO_VACANTE" id="CORREO_VACANTE" placeholder="correo@example.com" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" class="form-control"  name="TELEFONO_VACANTE" id="TELEFONO_VACANTE" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
            <label for="curp" class="form-label">CURP</label>
            <input type="text" class="form-control" name="CURP_VACANTE"  id="CURP_VACANTE" placeholder="CURP" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="FECHA_NACIMIENTO_VACANTE"  id="FECHA_NACIMIENTO_VACANTE"  required> 
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" name="EDAD_VACANTE" class="form-control" id="EDAD_VACANTE"  required>
        </div>
        
        <button type="button" class="btn btn-danger" id="btnSiguiente">Siguiente</button>
        
        <br><br>


        <div class="mb-3 d-none" id="selectPuestos">
            <label for="puestos" class="form-label form-label-puestos">Vacantes</label>
            <select class="form-select"  name="PUESTO_VACANTES" id="PUESTO_VACANTES" required>
                <option selected disabled>Selecciona un puesto</option>
                <option value="1">Asistente RRHH</option>
                <option value="2">Asistente de planeación y logística</option>
                <option value="3">Intendente</option>
                <option value="4">Asistente contable</option>
                <option value="5">Asistente de nómina</option>
                <option value="6">Asistente de compras</option>
                <option value="7">Almacenista</option>
                <option value="8">Consultor</option>
                <option value="9">Instructor - Facilitador</option>
                <option value="10">Ejecutivo de ventas</option>
                <option value="11">Desarrollador de Software</option>

            </select>
        </div>
            
        </div>
    </form>
</div>



@endsection


