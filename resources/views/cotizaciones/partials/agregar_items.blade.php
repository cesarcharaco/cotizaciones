@extends('layouts.app')
@section('title') Registro de Items @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fas fa-money-check-alt"></i> Cotizaciones</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('cotizaciones.index') }}">Cotizaciones</a></li>
          <li class="breadcrumb-item active">Registro de Items</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    @include('cotizaciones.partials.cargar_items')
    @include('cotizaciones.partials.editar_items')
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="{{ route('cotizaciones.registrar') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de Items</h3>
              <div class="float-right">
                <a href="{{ route('cotizaciones.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>
                
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar registro</button>
              
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="message_error">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="correlativo">
                      Número de Cotización:  {{$cotizacion->numero_oc}}
                      <input type="hidden" name="id_cotizacion" id="id_cotizacion2" value="{{$cotizacion->id}}">
                    </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="descripcion_general">Descripción General: {{$cotizacion->descripcion_general}}</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="empresa">Empresa: {{$cotizacion->solicitantes->empresas->nombre}}</label>
                  </div>
                </div>  
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="solicitante">Solicitante: {{$cotizacion->solicitantes->nombres}} {{$cotizacion->solicitantes->apellidos}} </label>
                  </div>
                </div>  
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cotizador">Cotizador: {{$cotizacion->cotizadores->cotizador}} </label>
                  </div>
                </div>  
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cotizador">Moneda: {{$cotizacion->moneda}} </label>
                  </div>
                </div>  
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-check">
                    <input type="checkbox" name="cargar_datosb" id="cargar_datosb" value="1" title="Seleccione si ya posee ya los provedores le dieron precio de los productos que cargará"  data-toggle="tooltip" data-placement="top" class="form-check-input">
                    <label for="cargar_datosb">
                      &nbsp;&nbsp;Ya posee la Guía y Órden de Compra de Boreal?
                    </label><br>
                    <small style="color: red">De ser así se procede a preparar el envío, para indicar, de los productos a enviar, aquellos que se entregarán, de ser así es obligatorio ingresar la OC Recibida</small>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">OC Recibida:  
                        <b id="ocr_obligatoria" style="display: none; color: red; position: sticky;" >*</b>
                        </label>

                        <input type="text" name="oc_recibida" id="oc_recibida" class="form-control" placeholder="Ingrese la OC Recibida" value="{{$cotizacion->oc_recibida}}"  value="{{$cotizacion->oc_recibida}}" @if($cotizacion->oc_recibida!="") readonly="readonly" @endif >
                      </div>
                      <small style="color: red">Si ingresa la órden de compra del cliente, la cotización pasará a status 'En Proceso de Compra'</small>
                      @error('oc_recibida')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_entrega">Fecha de Entrega: <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" title ="Seleccione la fecha de entrega" required="required" min="{{$cotizacion->fecha_entrega}}" value="{{$cotizacion->fecha_entrega}}" >
                      </div>
                      @error('fecha_entrega')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="valor_total">Valor Total Venta Neto: </label>
                        <input type="text" name="valor_total" id="monto_total" readonly="readonly" value="{{$monto_total}}" class="form-control"> 
                      </div>
                  </div>

              </div>
              <!-- <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                      <label for="factura_boreal">Factura Boreal: {{$cotizacion->factura_boreal}} </label>
                      <input type="text" name="factura_boreal" id="factura_boreal" class="form-control" placeholder="Ingrese el código de la Factura Boreal">
                    </div>
                    @error('factura_boreal')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
              </div> -->
              <!-- <div class="row">
                <div class="col-sm-12">
                  <label>Datos Boreal</label>
                </div>
              </div>
              @foreach($datosboreal as $key)
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal </label>
                        <input type="text" name="guia_boreal" id="guia_boreal" class="form-control" placeholder="Ingrese el código de la guía boreal" value="{{$key->guia_boreal}}">
                      </div>
                      @error('guia_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_gb">Fecha de la Guía:</label>
                        <input type="date" name="fecha_gb" id="fecha_gb" class="form-control" title="Ingrese la fecha de la guía boreal" value="{{$key->fecha_gb}}" min="{{$key->fecha_gb}}">
                      </div>
                      @error('fecha_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_gb">PDF Guía Boreal:</label>
                        <input type="file" name="url_pdf_gb" id="url_pdf_gb" class="form-control" placeholder="Ingrese el pdf de la guía boreal">
                      </div>
                      @error('url_pdf_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_boreal">OC Boreal </label>
                        <input type="text" name="oc_boreal" id="oc_boreal" class="form-control" placeholder="Ingrese el código de la OC boreal" value="{{$key->oc_boreal}}">
                      </div>
                      @error('oc_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_ocb">Fecha de la Guía:</label>
                        <input type="date" name="fecha_ocb" id="fecha_ocb" class="form-control" title="Ingrese la fecha de la OC boreal" value="{{$key->fecha_ocb}}" min="{{$key->fecha_ocb}}">
                      </div>
                      @error('fecha_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_ocb">PDF Guía Boreal:</label>
                        <input type="file" name="url_pdf_ocb" id="url_pdf_ocb" class="form-control" placeholder="Ingrese el pdf de la OC boreal">
                      </div>
                      @error('url_pdf_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
              @endforeach
              -->
              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="agregar_items_cot">Para Agregar Items a la Cotización <button type="button" id="agregar" class="btn btn-success btn-sm" title="Click para agregar items"><i class="fa fa-plus"></i></button></label>
                      </div>
                  </div>
              </div> 
              
              <div class="row">
                <div class="col-md-12">
                  <div class="card-body">
                    <table id="items" class="table table-bordered table-striped table-sm table-responsive" style="font-size: 12px; width: 100% !important;">
                      <thead>
                        <tr>
                          <th>Descripción</th>
                          <th>Imagen</th>
                          <th>Plazo Entrega</th>
                          <th>Cant.</th>
                          <th>Precio Unit.</th>
                          <th>Total</th>
                          <th>Enlace 1 <br><small>Referencia Web</small></th>
                          <th>Enlace 2 <br><small>Referencia Web</small></th>
                          <th>Observación</th>
                          <!-- <th>Precio Peso CON/IVA</th> -->
                          <th>Precio Peso SIN/IVA</th>
                          <th>Precio {{$cotizacion->moneda}}</th>
                          <th>Traslado</th>
                          <th>% UTI</th>
                          <th>UTI x Unidad</th>
                          <th>UTI x Total</th>
                          <th>Boreal</th>
                          <th>Acciones</th> 
                        </tr>
                      </thead>
                      <tbody>
                    
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- cierre de row -->


            </div>
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready( function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
$.fn.DataTable.ext.errMode='throw';
  var id_cotizacion=$("#id_cotizacion").val();
  //{ data: 'pp_ci', name: 'pp_ci' },
  var table=$('#items').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:'agregar_items',
      data:{
        id_cotizacion: id_cotizacion
      }
   },

    columns: [
      { data: 'detalles', name: 'detalles' },
      { data: 'url', name: 'url' },
      { data: 'plazo_entrega', name: 'plazo_entrega' },
      { data: 'cant', name: 'cant' },
      { data: 'precio_unit', name: 'precio_unit' },
      { data: 'total_pp', name: 'total_pp' },
      { data: 'enlace1_web', name: 'enlace1_web' },
      { data: 'enlace2_web', name: 'enlace2_web' },
      { data: 'observacion', name: 'observacion' },
      { data: 'pp_si', name: 'pp_si' },
      { data: 'pda', name: 'pda' },
      { data: 'traslado', name: 'traslado' },
      { data: 'porc_uti', name: 'porc_uti' },
      { data: 'uti_x_und', name: 'uti_x_und' },
      { data: 'uti_x_total_p', name: 'uti_x_total_p' },
      { data: 'boreal', name: 'boreal' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
  table.ajax.reload();
});
 $("#productos").on('change',function (event) {
    var id_producto=$(this).val();
    if(id_producto!==""){
        $.get('/productos/'+id_producto+'/buscar', function (data) {

          if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              
              $("#descripcion").val(data[i].detalles);
              $("#descripcion").attr('readonly',true);
              $("#categorias1").css('display','none');
              $("#categorias2").css('display','block');
              $("#id_categoria2").val(data[i].categoria);
              $("#id_categoria2").attr('readonly',true);
              $("#imagenes1").css('display','none');
              $("#imagenes2").css('display','block');
              $("#imagen").attr('src',data[i].url);
              $("#obligatorio1").text('');
              $("#obligatorio2").text('');
              $("#descripcion").removeAttr('required');
            }
          }
        });
    }else{
              $("#descripcion").val("");
              $("#descripcion").attr('readonly',false);
              $("#descripcion").attr('required',true);
              $("#categorias1").css('display','block');
              $("#categorias2").css('display','none');
              $("#id_categoria").val("");
              $("#imagenes1").css('display','block');
              $("#imagenes2").css('display','none');
              $("#imagen").attr('src',"#");
              $("#obligatorio1").html('<b style="color: red;">*</b>');
              $("#obligatorio2").html('<b style="color: red;">*</b>');
    }
  });
function calcular_item() {
  //e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var porc_uti=$("#porc_uti").val();
  
  $.ajax({
    url: "{{ route('cotizaciones.calcular_item') }}",
    method: 'post',
    data: {
      pda: $('#pda').val(),
      moneda: $("#moneda").val(),
      cant: $("#cant").val(),
      traslado: $("#traslado").val(),
      porc_uti: porc_uti,

    },
    success: function(result) {
      
      if(result.errors) {
        
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        
        $("#precio_unit_txt").text(result[0]);
        $("#precio_unit").val(result[0]);
        $("#total_pp_txt").text(result[1]);
        $("#total_pp").val(result[1]);
        $("#pp_ci_txt").text(result[2]);
        $("#pp_ci").val(result[2]);
        $("#pp_si_txt").text(result[3]);
        $("#pp_si").val(result[3]);
        $("#uti_x_und_txt").text(result[4]);
        $("#uti_x_und").val(result[4]);
        $("#uti_x_total_p_txt").text(result[5]);
        $("#uti_x_total_p").val(result[5]);
        $("#boreal_txt").text(result[6]);
        $("#boreal").val(result[6]);
        
      }
    }
  });
}
function calcular_item_e() {
  //e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var porc_uti=$("#porc_uti_e").val();
  
  $.ajax({
    url: "{{ url('../../cotizaciones/calcular_item') }}",
    method: 'post',
    data: {
      pda: $('#pda_e').val(),
      moneda: $("#moneda_e").val(),
      cant: $("#cant_e").val(),
      traslado: $("#traslado_e").val(),
      porc_uti: porc_uti,

    },
    success: function(result) {
      
      if(result.errors) {
        
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $("#precio_unit_txt_e").text(result[0]);
        $("#precio_unit_e").val(result[0]);
        $("#total_pp_txt_e").text(result[1]);
        $("#total_pp_e").val(result[1]);
        $("#pp_ci_txt_e").text(result[2]);
        $("#pp_ci_e").val(result[2]);
        $("#pp_si_txt_e").text(result[3]);
        $("#pp_si_e").val(result[3]);
        $("#uti_x_und_txt_e").text(result[4]);
        $("#uti_x_und_e").val(result[4]);
        $("#uti_x_total_p_txt_e").text(result[5]);
        $("#uti_x_total_p_e").val(result[5]);
        $("#boreal_txt_e").text(result[6]);
        $("#boreal_e").val(result[6]);
        
      }
    }
  });
}
$('#agregar').click(function () {
  $('#cargaItemsForm').trigger("reset");
  $('#cargar_item').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});

$('#SubmitCargarItem').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  console.log('...........');
  $.ajax({
    url: "{{ route('items.store') }}",
    method: 'post',
    data: {
      productos: $('#productos').val(),
      descripcion: $('#descripcion').val(),
      id_categoria: $('#id_categoria').val(),
      imagenes: $('#imagenes').val(),
      enlace1_web: $('#enlace1_web').val(),
      enlace2_web: $('#enlace2_web').val(),
      observacion: $('#observacion').val(),
      plazo_entrega: $('#plazo_entrega').val(),
      pda: $('#pda').val(),
      cant: $('#cant').val(),
      traslado: $('#traslado').val(),
      porc_uti: $('#porc_uti').val(),
      precio_unit: $('#precio_unit').val(),
      total_pp: $('#total_pp').val(),
      pp_ci: $('#pp_ci').val(),
      pp_si: $('#pp_si').val(),
      uti_x_und: $('#uti_x_und').val(),
      uti_x_total_p: $('#uti_x_total_p').val(),
      boreal: $('#boreal').val(),
      id_cotizacion: $("#id_cotizacion").val(),
    },
    success: function(result) {

      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        
        $("#productos").empty();
        $("#productos").append('<option value="">Nuevo Producto</option>');
        if (result.productos.length > 0) {
          for(var i=0; i < result.productos.length; i++){
          
            $("#productos").append("<option value='"+result.productos[i].id+"'>"+result.productos[i].detalles+"</option>");
          }
        }
        $('.alert-danger').hide();
        $("#monto_total").val(result.monto_total);
        var oTable = $('#items').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#cargar_item").modal('hide');
        }
      }
    }
  });
});
function editCotizacion(id_item){
  
  //$('#editaItemsForm').trigger("reset");
  $('#editar_item').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
  $.get('../../items/'+id_item+'/buscar', function (data) {
    //console.log(data[0].porc_uti);
    if(data.length > 0){
      for(var i=0; i < data.length; i++){
        $('#id_item').val(id_item);
        $('#descripcion_e').val(data[i].detalles);
        $('#id_categoria2_e').val(data[i].categoria);
        $('#imagenes_e').attr('url',data[i].url);
        $('#enlace1_web_e').val(data[i].enlace1_web);
        $('#enlace2_web_e').val(data[i].enlace2_web);
        $('#observacion_e').val(data[i].observacion);
        $('#plazo_entrega_e').val(data[i].plazo_entrega);
        $('#pda_e').val(data[i].pda);
        $('#cant_e').val(data[i].cant);
        $('#traslado_e').val(data[i].traslado);
        //$('#porc_uti_e').val(data[i].porc_uti);
        $("#porc_uti_e option[value="+ data[i].porc_uti +"]"). attr("selected",true);
        $("#precio_unit_txt_e").text(data[i].precio_unit);
        $("#precio_unit_e").val(data[i].precio_unit);
        $("#total_pp_txt_e").text(data[i].total_pp);
        $("#total_pp_e").val(data[i].total_pp);
        $("#pp_ci_txt_e").text(data[i].pp_ci);
        $("#pp_ci_e").val(data[i].pp_ci);
        $("#pp_si_txt_e").text(data[i].pp_si);
        $("#pp_si_e").val(data[i].pp_si);
        $("#uti_x_und_txt_e").text(data[i].uti_x_und);
        $("#uti_x_und_e").val(data[i].uti_x_und);
        $("#uti_x_total_p_txt_e").text(data[i].uti_x_total_p);
        $("#uti_x_total_p_e").val(data[i].uti_x_total_p);
        $("#boreal_txt_e").text(data[i].boreal);
        $("#boreal_e").val(data[i].boreal); 
      }
    }
  })
}

$('#SubmitEditItem').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: "{{ route('items.editar') }}",
    method: 'post',
    data: {
      enlace1_web: $('#enlace1_web_e').val(),
      enlace2_web: $('#enlace2_web_e').val(),
      observacion: $('#observacion_e').val(),
      plazo_entrega: $('#plazo_entrega_e').val(),
      pda: $('#pda_e').val(),
      cant: $('#cant_e').val(),
      traslado: $('#traslado_e').val(),
      porc_uti: $('#porc_uti_e').val(),
      precio_unit: $('#precio_unit_e').val(),
      total_pp: $('#total_pp_e').val(),
      pp_ci: $('#pp_ci_e').val(),
      pp_si: $('#pp_si_e').val(),
      uti_x_und: $('#uti_x_und_e').val(),
      uti_x_total_p: $('#uti_x_total_p_e').val(),
      boreal: $('#boreal_e').val(),
      id_item: $("#id_item").val(),
    },
    success: function(result) {

      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        //console.log(result);
        $('.alert-danger').hide();
        var oTable = $('#items').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#editar_item").modal('hide');
        }
      }
    }
  });
});
function deleteItemCotizacion(id_item){
  
  var id = id_item;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar éste Item de la cotización?',
    text: "¡Esta opción no podrá deshacerse en el futuro!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Si, Eliminar!',
    cancelButtonText: 'No, Cancelar!'
  }).then((result) => {
    if (result.isConfirmed) {
      // ajax
      $.ajax({
        type:"DELETE",
        url: "../../items/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          $("#productos").empty();
          $("#productos").append('<option value="">Nuevo Producto</option>');
          if (response.productos.length > 0) {
            for(var i=0; i < response.productos.length; i++){
              $("#productos").append("<option value='"+response.productos[i].id+"'>"+response.productos[i].detalles+"</option>");
            }
          }
          $("#monto_total").val(response.monto_total);
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#items').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Item no eliminado de la Cotización", icon:  "error"});
        }
      });
    }
  })
}
$("#cargar_datosb").on('change', function (event) {
    if ($(this).is(':checked')) {
      $("#oc_recibida").attr('required',true);
      $("#ocr_obligatoria").css('display','block');
      
    }else{
      $("#oc_recibida").removeAttr('required');
      $("#ocr_obligatoria").css('display','none');
    }
});
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
