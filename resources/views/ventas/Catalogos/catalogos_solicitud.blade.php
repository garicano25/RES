@extends('principal.maestraventas')

@section('contenido')

<style>
    .card-body {
        height: 250px; 
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .card-title {
        text-align: center;
    }
    .btn {
        margin-top: auto; 
    }
</style>


<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo medio de contacto</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Catálogo_medio_contacto') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo Giro de la empresa</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Catálogo_giro_empresa') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>



        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo necesidad del servicio</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Catálogo_necesidad_servicio') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>
 {{--
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo funciones y responsabilidades del sistema integrado de gestión (SIG)</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Funcionesgestión') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo competencias básicas o cardinales</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Competencias-básicas') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo competencias gerenciales</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Competencias-gerenciales') }}">Ver Catálogo</a>
                </div>
            </div>
        </div> --}}










    </div>
</div>



@endsection
