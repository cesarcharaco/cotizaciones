<div class="modal fade" id="create_tasas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-chart-line"></i> Registrar Tasa </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="tasasForm" id="tasasForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="tasa">Tasa <b style="color: red;">*</b></label>
                <input type="number" name="tasa" id="tasa" class="form-control" required="required" placeholder="Ingrese la tasa del " min="0" step="0.2" >
              </div>
              @error('tasa')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="moneda">Moneda <b style="color: red;">*</b></label>
                <select name="moneda" id="moneda" class="form-control select2bs4" required="required" title="seleccione la moneda">
                  <option value="Dolar">Dolar</option>
                  <option value="Euro">Euro</option>
                  <option value="Lira">Lira</option>
                </select>
              </div>
              @error('moneda')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="fecha">Fecha <b style="color: red;">*</b></label>
                <input type="date" name="fecha" id="fecha" class="form-control" required="required" value="{{date('Y-m-d')}}" >
              </div>
              @error('fecha')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateTasas" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->