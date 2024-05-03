@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb m-b-10" style="background-color: rgb(164, 214, 94); padding: 10px; border-radius: 10px;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i> DPT  </h3>
  

  
  <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_dpt" id="abrirModalBtn" style="margin-left: auto;">
    Nuevo DPT  <i class="bi bi-plus-circle"></i> 
 </button>
</ol>


<table id="tablaDPT" class="table">
  <thead>
      <tr>
          <th>#</th>
          <th>NOMBRE PUESTO</th>
          <th>ARCHIVO PPT</th>
          <th>Editar</th>
          <th>Eliminar</th>
          <th>Visualizar Excel</th>
      </tr>
  </thead>
  <tbody>
      @foreach($data as $item)
      <tr>
          <td>{{ $item->ID_DPT }}</td>
          <td>{{ $item->NOMBRE_PUESTO }}</td>
          <td>{{ $item->ARCHIVO_DPT }}</td>
          <td>
            {{-- <button class="btn btn-primary btn-editar" data-id="{{ $item->ID_DPT }}"><i class="bi bi-pencil"></i></button></td>
             --}}

          <button class="btn btn-primary btn-visualizar" data-file="{{ route('ver-excel', ['id' => $item->ID_DPT]) }}" title="Visualizar Excel">
            <i class="bi bi-pencil"></i>
        </button>

          <td><button class="btn btn-danger btn-eliminar_DPT" data-id="{{ $item->ID_DPT }}"><i class="bi bi-trash3-fill"></i></button></td>
          <td>

              <button class="btn btn-success btn-visualizar" data-file="{{ route('ver-excel', ['id' => $item->ID_DPT]) }}" title="Visualizar Excel">
                  <i class="bi bi-file-earmark-excel"></i>
              </button>
              
              
              
          </td>
      </tr>
      @endforeach
  </tbody>
</table>


 </div>

 
</div>


  <div class="modal fade" id="exampleModal_DPT" tabindex="-1" aria-labelledby="exampleModalLabel_DPT" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_DPT">Nuevo DPT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guardar.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label>Nombre del puesto:</label>
                            <input type="text" class="form-control" name="NOMBRE_PUESTO" id="NOMBRE_PUESTO" required>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group">
                          <input type="file" name="ARCHIVO_DPT" id="ARCHIVO_DPT" required>
                      </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



  @endsection