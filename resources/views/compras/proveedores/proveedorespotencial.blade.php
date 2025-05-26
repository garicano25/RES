@extends('principal.maestracompras')

@section('contenido')



<style>
  .fila-verde {
    background-color: #d4edda !important;
  }
</style>

<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i> &nbsp; Banco de proveedores
    </h3>

  </ol>

  <div class="card-body">
    <table id="Tabladirectorio" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>
</div>


<div class="modal fade" id="miModal_POTENCIALES" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioDIRECTORIO" style="background-color: #ffffff;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Proveedores</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {!! csrf_field() !!}


          <input type="hidden" class="form-control" id="ID_FORMULARIO_DIRECTORIO" name="ID_FORMULARIO_DIRECTORIO" value="0">


          <div class="col-12">
            <div class="row">
              <div class="col-4 mb-3">
                <label>Tipo de Persona *</label>
                <select class="form-control" name="TIPO_PERSONA" id="TIPO_PERSONA" required>
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="1">Nacional</option>
                  <option value="2">Extranjera</option>
                </select>
              </div>

              <div class="col-4 mb-3">
                <label>Razón social/Nombre *</label>
                <input type="text" class="form-control" id="RAZON_SOCIAL" name="RAZON_SOCIAL" required>
              </div>
              <div class="col-4 mb-3">
                <label for="RFC_LABEL">RFC *</label>
                <input type="text" class="form-control" id="RFC_PROVEEDOR" name="RFC_PROVEEDOR" required>
              </div>
              <div class="col-6 mb-3">
                <label>Nombre comercial </label>
                <input type="text" class="form-control" id="NOMBRE_COMERCIAL" name="NOMBRE_COMERCIAL">
              </div>

              <div class="col-6 mb-3">
                <label>Giro * </label>
                <input type="text" class="form-control" id="GIRO_PROVEEDOR" name="GIRO_PROVEEDOR" required>
              </div>
            </div>
          </div>


          <div class="mb-3">
            <h4><b>Domicilio</b></label>
          </div>

          <div class="col-12" id="DOMICILIO_NACIONAL" style="display: block;">
            <div class="row">

              <div class="col-3 mb-3">
                <label>Código Postal *</label>
                <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL">
              </div>
              <div class="col-4 mb-3">
                <label>Tipo de Vialidad *</label>
                <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA">
              </div>
              <div class="col-5 mb-3">
                <label>Nombre de la Vialidad *</label>
                <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA">
              </div>

              <div class="col-3 mb-3">
                <label>Número Exterior</label>
                <input type="text" class="form-control" name="NUMERO_EXTERIOR_EMPRESA" id="NUMERO_EXTERIOR_EMPRESA">
              </div>
              <div class="col-3 mb-3">
                <label>Número Interior</label>
                <input type="text" class="form-control" name="NUMERO_INTERIOR_EMPRESA" id="NUMERO_INTERIOR_EMPRESA">
              </div>
              <div class="col-6 mb-3">
                <label>Nombre de la colonia *</label>
                <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA">
                  <option value="">Seleccione una opción</option>
                </select>
              </div>
              <div class="col-6 mb-3">
                <label>Nombre de la Localidad *</label>
                <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA">
              </div>


              <div class="col-6 mb-3">
                <label>Nombre del municipio o demarcación territorial *</label>
                <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA">
              </div>
              <div class="col-6 mb-3">
                <label>Nombre de la Entidad Federativa *</label>
                <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA">
              </div>
              <div class="col-6 mb-3">
                <label>País *</label>
                <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA">
              </div>



              <div class="col-6 mb-3">
                <label>Entre Calle</label>
                <input type="text" class="form-control" name="ENTRE_CALLE_EMPRESA" id="ENTRE_CALLE_EMPRESA">
              </div>
              <div class="col-6 mb-3">
                <label>Y Calle</label>
                <input type="text" class="form-control" name="ENTRE_CALLE2_EMPRESA" id="ENTRE_CALLE2_EMPRESA">
              </div>
            </div>
          </div>


          <div class="col-12" id="DOMICILIO_ERXTRANJERO" style="display: none;">

            <div class="row">

              <div class="col-12 mb-3">
                <label>Domicilio *</label>
                <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" id="DOMICILIO_EXTRANJERO">
              </div>
              <div class="col-6 mb-3">
                <label>Código Postal</label>
                <input type="text" class="form-control" name="CODIGO_EXTRANJERO" id="CODIGO_EXTRANJERO">
              </div>
              <div class="col-6 mb-3">
                <label>Ciudad *</label>
                <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" id="CIUDAD_EXTRANJERO">
              </div>

              <div class="col-6 mb-3">
                <label>Estado/Departamento/Provincia</label>
                <input type="text" class="form-control" name="ESTADO_EXTRANJERO" id="ESTADO_EXTRANJERO">
              </div>

              <div class="col-6 mb-3">
                <label>País *</label>
                <input type="text" class="form-control" name="PAIS_EXTRANJERO" id="PAIS_EXTRANJERO">
              </div>

            </div>
          </div>



          <div class="mb-3">
            <h4><b>Contacto</b></label>
          </div>



          <div class="col-12">
            <div class="row">

              <div class="col-7 mb-3">
                <label>Nombre *</label>
                <input type="text" class="form-control" name="NOMBRE_DIRECTORIO" id="NOMBRE_DIRECTORIO" required>
              </div>
              <div class="col-5 mb-3">
                <label>Cargo *</label>
                <input type="text" class="form-control" name="CARGO_DIRECTORIO" id="CARGO_DIRECTORIO" required>
              </div>
              <div class="col-4 mb-3">
                <label>Teléfono *</label>
                <input type="text" class="form-control" name="TELEFONO_DIRECOTORIO" id="TELEFONO_DIRECOTORIO" required>
              </div>
              <div class="col-4 mb-3">
                <label>Extensión </label>
                <input type="text" class="form-control" name="EXSTENSION_DIRECTORIO" id="EXSTENSION_DIRECTORIO">
              </div>
              <div class="col-4 mb-3">
                <label>Celular </label>
                <input type="text" class="form-control" name="CELULAR_DIRECTORIO" id="CELULAR_DIRECTORIO">
              </div>

              <div class="col-12 mb-3">
                <label>Correo electrónico *</label>
                <input type="text" class="form-control" name="CORREO_DIRECTORIO" id="CORREO_DIRECTORIO" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="mb-3">
              <div class="row">
                <div class="col-6 mb-3">
                  <label>Añada servicios</label>
                  <button id="botonAgregarservicio" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                    <i class="bi bi-plus-circle-fill"></i>
                  </button>
                </div>
              </div>
              <div class="serviciodiv mt-4"></div>
            </div>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="guardarDIRECTORIO">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>


@endsection