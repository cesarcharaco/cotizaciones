<div class="modal fade" id="status_cotizacion">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Cambiar Status de Cotización</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="changeStatusForm" id="changeStatusForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <input type="hidden" name="id_cotizacion" id="id_cotizacion_status">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="status">Status <b style="color: red;">*</b></label>
                <select name="status" id="status" title="Seleccione el status de la Cotización según la Decisión del Solicitante" class="form-control select2bs4">
                  <option value="Adjudicada">Adjudicada</option>
                  <option value="Negada">Negada</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="observacion">Observación <b style="color: red;">*</b></label>
                <input type="text" name="observacion" id="observacion" title="Ingrese el Motivo del Cambio de status" class="form-control" required="required">
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitStatusCotizacion" class="btn btn-info"><i class="fa fa-save"></i> Cambiar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->