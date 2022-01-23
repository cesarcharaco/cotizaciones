<div class="modal fade" id="create_tasasiva">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-chart-bar"></i> Registrar Tasa de IVA</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="tasaIVAForm" id="tasaIVAForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="tasa">Tasa (%)<b style="color: red;">*</b></label>
                <input type="number" name="tasa_i" id="tasa_i" class="form-control" required="required" placeholder="Ingrese la tasa del iva" min="0" step="0.2" maxlength="3" max="100" onkeyup="if (this.value.length > 3) {this.value = this.value.slice(0,3); } if(this.value > 100){ $('#error').text('El valor no puede exceder a 100');this.value = this.value.slice(0,2); }else{$('#error').text('');}" >
                <span id="error"></span>
              </div>
              @error('tasa_i')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="fecha">Fecha <b style="color: red;">*</b></label>
                <input type="date" name="fecha_i" id="fecha_i" class="form-control" required="required" value="{{date('Y-m-d')}}" >
              </div>
              @error('fecha_i')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateTasaIVA" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->