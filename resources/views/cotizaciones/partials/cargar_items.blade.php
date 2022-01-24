<div class="modal fade" id="cargar_item">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-chart-bar"></i> Cargar item a cotización</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="cargaItemsForm" id="cargaItemsForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="Productos">Banco de Productos</label>
                <select name="productos" id="productos" title="Seleccione un producto" class="form-control select2bs4">
                  <option value="">Nuevo Producto</option>
                      @foreach($productos as $p)
                        <option value="{{$p->id}}">{{$p->detalles}}</option>
                      @endforeach
                </select>
                <input type="text" name="id_cotizacion" id="id_cotizacion" value="{{$cotizacion->id}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="descripcion">Descripción<span id="obligatorio2"><b style="color: red;">*</b></span></label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripción del producto" required="required">
              </div>              
            </div>
            <div class="col-sm-4" id="categorias1" style="display: block;">
              <div class="form-group">
                <label for="categoria">Categoría<span id="obligatorio2"><b style="color: red;">*</b></span></label>
                <select name="id_categoria" id="id_categoria" title="Seleccione la Categoría" class="form-control select2bs4">
                  @foreach($categorias as $key)
                    <option value="{{$key->id}}">{{$key->categoria}}</option>
                  @endforeach
                </select>
              </div>              
            </div>
            <div class="col-sm-4" id="categorias2" style="display: none;">
              <div class="form-group">
                <label for="categoria">Categoría</label>
                <input type="text" name="id_categoria2" id="id_categoria2" class="form-control">
              </div>              
            </div>
            <div class="col-sm-4" id="imagenes1" style="display: block;">
              <label for="descripcion">Imagen </label>
              <div class="input-group">
                  <div class="custom-file">
                      <input type="file" class="custom-file-input" id="imagenes" name="imagenes[]" accept="image/jpeg,image/jpg,image/png">
                      <label class="custom-file-label" for="imagenes">Seleccionar archivo...</label>
                    </div>
                  </div>
                  <!-- <div>
                    <img src="#" alt="Imagen de Producto">
                  </div> -->
            </div>
            <div class="col-sm-4" id="imagenes2" style="display: none;">
              <label for="descripcion">Imagen</label>
                <div>
                  <img id="imagen" src="#" alt="Imagen de Producto">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="enlace1_web">Enlace 1 Referencia WEB<b style="color: red;">*</b></label>
                <input type="text" name="enlace1_web" id="enlace1_web" class="form-control" required="required" placeholder="Ingrese el 1er enlace de referencia web">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="enlace2_web">Enlace 2 Referencia WEB</label>
                <input type="text" placeholder="Ingrese el 2do enlace de referencia web" name="enlace2_web" id="enlace2_web" class="form-control" >
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="observacion">Observación</label>
                <input type="text" placeholder="Ingrese la Observación en cuanto a las referencias del producto" name="observacion" id="observacion" class="form-control" required="required">
              </div>              
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="plazo_entrega">Plazo de entrega <b style="color: red;">*</b></label>
                <input type="text" name="plazo_entrega" id="plazo_entrega" class="form-control" required="required" placeholder="Ingrese el plazo de entrega del producto">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="pda">Precio en {{$cotizacion->moneda}} <b style="color: red;">*</b></label>
                <input type="hidden" name="moneda" id="moneda" value="{{$cotizacion->moneda}}">
                <input type="number" value="0" min="0" name="pda" id="pda" class="form-control" required="required" onkeyup="calcular_item()">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="cant">Cantidad <b style="color: red;">*</b></label>
                <input type="number" min="1" value="1" name="cant" id="cant" class="form-control" required="required" onkeyup="calcular_item()">
              </div>              
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="traslado">Traslado<b style="color: red;">*</b></label>
                <input type="number" name="traslado" id="traslado" class="form-control" required="required" placeholder="Ingrese el monto del traslado" min="0" value="0" onkeyup="calcular_item()">
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="porc_uti">% de Utilidad</label>
                <select name="porc_uti" id="porc_uti" title="Seleccione el procentaje de utilidad" class="form-control select2bs4" onchange="calcular_item()">
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
                <table id="totales" class="table table-bordered table-striped table-sm table-responsive">
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
                      <td align="center"><span id="precio_unit_txt"></span><input type="hidden" name="precio_unit" id="precio_unit" ></td>
                      <td align="center"><span id="total_pp_txt"></span><input type="hidden" name="total_pp" id="total_pp" ></td>
                      <td align="center"><span id="pp_ci_txt"></span><input type="hidden" name="pp_ci" id="pp_ci" ></td>
                      <td align="center"><span id="pp_si_txt"></span><input type="hidden" name="pp_si" id="pp_si" ></td>
                      <td align="center"><span id="uti_x_und_txt"></span><input type="hidden" name="uti_x_und" id="uti_x_und" ></td>
                      <td align="center"><span id="uti_x_total_p_txt"></span><input type="hidden" name="uti_x_total_p" id="uti_x_total_p" ></td>
                      <td align="center"><span id="boreal_txt"></span><input type="hidden" name="boreal" id="boreal" ></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCargarItem" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

                 