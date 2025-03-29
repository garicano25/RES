@extends('principal.maestra')

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
                    <h5 class="card-title mb-4">Catálogo asesores</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Asesores') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo categorías</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Categorías') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>



        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo vacantes</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/CatálogoDeVacantes') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo género</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Género') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo áreas de interés</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Área_interes') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo pruebas de conocimientos</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Pruebas-conocimientos') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-4">Catálogo anuncios</h5>
                    <a class="btn btn-primary mt-3" href="{{ url('/Anuncios') }}">Ver Catálogo</a>
                </div>
            </div>
        </div>







    </div>
</div>



@endsection