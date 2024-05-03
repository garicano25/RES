@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i> DPT  </h3>
  

    <a href="{{ url('/') }}" class="btn btn-light waves-effect waves-light botonnuevo_dpt" style="margin-left: auto;">
      Nuevo DPT <i class="bi bi-plus-circle"></i>
  </a>




  @endsection