<div class="modal fade" id="create_cotizadores">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Crear Cotizador</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate name="cotizadorForm" id="cotizadorForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="cotizador">Nombres y Apellidos <b style="color: red;">*</b></label>
                <input type="text" name="cotizador" id="cotizador" class="form-control" required="required" placeholder="Ingrese los nombres y apellidos del cotizador" >
              </div>
              @error('cotizador')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="rut">RUT <b style="color: red;">*</b></label>
                <input type="text" name="rut" id="rut" class="form-control" required="required" placeholder="Ingrese el RUT del cotizador" >
              </div>
              @error('rut')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="telefono">Teléfono: </label>
                <input type="text" name="telefono" id="telefono" class="form-control" required="required" placeholder="Ingrese el teléfono del cotizador">
              </div>
              @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="correo">Correo: <b style="color: red;">*</b></label>
                <input type="email" name="correo" id="correo" class="form-control" required="required" placeholder="Ingrese el correo del cotizador">
              </div>
              @error('correo')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="username">Nombre de Usuario: <b style="color: red;">*</b></label>
                <input type="text" name="username" id="username" class="form-control" required="required" placeholder="Ingrese el Nombre de Usuario" >
              </div>
              @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateCotizador" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->