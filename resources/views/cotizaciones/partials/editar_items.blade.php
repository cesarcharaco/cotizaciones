<div class="modal fade" id="editar_item">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-chart-bar"></i> Editar item de cotización</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="editItemsForm" id="editItemsForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <input type="hidden" name="id_item" id="id_item">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="descripcion">Descripción<span id="obligatorio2_e"><b style="color: red;">*</b></span></label>
                <input type="text" name="descripcion" id="descripcion_e" class="form-control" placeholder="Ingrese la descripción del producto" required="required" readonly="readonly">
              </div>              
            </div>
            
            <div class="col-sm-4" id="categorias2_e">
              <div class="form-group">
                <label for="categoria">Categoría</label>
                <input type="text" name="id_categoria2" id="id_categoria2_e" class="form-control" readonly="readonly">
              </div>              
            </div>
            <!-- <div class="col-sm-4" id="imagenes1_e" style="display: block;">
              <label for="descripcion">Imagen </label>
              <div class="input-group">
                  <div class="custom-file">
                      <input type="file" class="custom-file-input" id="imagenes_e" name="imagenes[]" accept="image/jpeg,image/jpg,image/png">
                      <label class="custom-file-label" for="imagenes">Seleccionar archivo...</label>
                    </div>
                  </div>
                  
            </div> -->
            <div class="col-sm-4" id="imagenes2_e">
              <label for="descripcion">Imagen</label>
                <div>
                  <img id="imagen_e" src="#" alt="Imagen de Producto">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="enlace1_web">Enlace 1 Referencia WEB<b style="color: red;">*</b></label>
                <input type="text" name="enlace1_web" id="enlace1_web_e" class="form-control" required="required" placeholder="Ingrese el 1er enlace de referencia web">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="enlace2_web">Enlace 2 Referencia WEB</label>
                <input type="text" placeholder="Ingrese el 2do enlace de referencia web" name="enlace2_web" id="enlace2_web_e" class="form-control" >
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="observacion">Observación</label>
                <input type="text" placeholder="Ingrese la Observación en cuanto a las referencias del producto" name="observacion" id="observacion_e" class="form-control" required="required">
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="plazo_entrega">Plazo de entrega <b style="color: red;">*</b></label>
                <input type="text" name="plazo_entrega" id="plazo_entrega_e" class="form-control" required="required" placeholder="Ingrese el plazo de entrega del producto">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="pda">Precio en {{$cotizacion->moneda}} <b style="color: red;">*</b></label>
                <input type="hidden" name="moneda" id="moneda_e" value="{{$cotizacion->moneda}}">
                <input type="number" value="0" min="0" name="pda" id="pda_e" class="form-control" required="required" onkeyup="calcular_item_e()">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="cant">Cantidad <b style="color: red;">*</b></label>
                <input type="number" min="1" value="1" name="cant" id="cant_e" class="form-control" required="required" onkeyup="calcular_item_e()">
              </div>              
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="traslado">Traslado<b style="color: red;">*</b></label>
                <input type="number" name="traslado" id="traslado_e" class="form-control" required="required" placeholder="Ingrese el monto del traslado" min="0" value="0" onkeyup="calcular_item_e()">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="porc_uti">% de Utilidad</label>
                <select name="porc_uti" id="porc_uti_e" title="Seleccione el procentaje de utilidad" class="form-control select2bs4" onchange="calcular_item_e()">
                  @for($i=0; $i<=100; $i++)
                    <option value="{{$i}}">{{$i}} %</option>
                  @endfor
                </select>
              </div>              
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <table id="totales_e" class="table table-bordered table-striped table-sm table-responsive">
                  <thead>
                    <tr>
                      <th>Precio Unit.</th>
                      <th>Total</th>
                      <th>Precio Pesos CON/IVA</th>
                      <th>Precio Pesos SIN/IVA</th>
                      <th>UTI x Unidad</th>
                      <th>UTI x Total</th>
                      <th>Boreal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td align="center"><span id="precio_unit_txt_e"></span><input type="hidden" name="precio_unit" id="precio_unit_e" ></td>
                      <td align="center"><span id="total_pp_txt_e"></span><input type="hidden" name="total_pp" id="total_pp_e" ></td>
                      <td align="center"><span id="pp_ci_txt_e"></span><input type="hidden" name="pp_ci" id="pp_ci_e" ></td>
                      <td align="center"><span id="pp_si_txt_e"></span><input type="hidden" name="pp_si" id="pp_si_e" ></td>
                      <td align="center"><span id="uti_x_und_txt_e"></span><input type="hidden" name="uti_x_und" id="uti_x_und_e" ></td>
                      <td align="center"><span id="uti_x_total_p_txt_e"></span><input type="hidden" name="uti_x_total_p" id="uti_x_total_p_e" ></td>
                      <td align="center"><span id="boreal_txt_e"></span><input type="hidden" name="boreal" id="boreal_e" ></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitEditItem" class="btn btn-info"><i class="fa fa-save"></i> Modificar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

                 