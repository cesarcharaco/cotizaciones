<div class="modal fade" id="edit_cotizadores">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Cotizador</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate>
        
        <div class="modal-body">
           <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
           <input type="hidden" name="id_cotizador_x" value="" id="id_cotizador_edit" placeholder="" />
        <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="cotizador">Nombres y Apellidos<b style="color: red;">*</b></label>
                <input type="text" name="cotizador" id="cotizador_edit" class="form-control" required="required" placeholder="Ingrese los Nombres y Apellidos del cotizador" >
              </div>
              @error('cotizador')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="rut">RUT <b style="color: red;">*</b></label>
                <input type="text" name="rut" id="rut_edit" class="form-control" required="required" placeholder="Ingrese el RUT del cotizador" >
              </div>
              @error('rut')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="telefono">Celular <b style="color: red;">*</b></label>
                <input type="text" name="telefono" id="telefono_edit" class="form-control" required="required" placeholder="Ingrese el teléfono del cotizador" >
              </div>
              @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="correo">Correo <b style="color: red;">*</b></label>
                <input type="email"  name="correo" id="correo_edit" class="form-control" required="required" placeholder="Ingrese el correo del cotizador" >
              </div>
              @error('correo')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="username">Nombre de Usuario: <b style="color: red;">*</b></label>
                <input type="text" name="username" id="username_edit" class="form-control" required="required" placeholder="Ingrese la Nombre de Usuario del cotizador">
              </div>
              @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="status">Status: <b style="color: red;">*</b></label>
                <select name="status" id="status_edit" class="form-control" required="required" title="Seleccione el status del Cotizador">
                  <option value="Activo">Activo</option>
                  <option value="Suspendido">Suspendido</option>
                </select>
              </div>
              @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <small>Si desea resetear la clave: </small><input type="checkbox" name="reset_clave" id="reset_clave" value="1" title="Seleccione si desea resetear la clave" >
          </div>
        <div class="row">
          <div class="col-sm-4" id="clave_nueva" style="display: none;">
            <label for="clave">Clave Nueva</label>
            <input type="password" name="clave_nueva" id="clave" placeholder="Ej:Nombre123." class="form-control" minlength="8">
          </div>
          <div class="col-sm-4" id="clave_nueva2" style="display: none;">
            <label for="clave2">Repita la Clave</label>
            <input type="password" name="clave_nueva2" id="clave2" placeholder="Ej:Nombre123." class="form-control" minlength="8">
          </div>
        </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times"></i>Cerrar</button>
          <button type="submit" id="SubmitEditCotizador" class="btn btn-info"><i class="fa fa-save"></i>Guardar</button>
        </div>
      </form> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->