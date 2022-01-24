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
    
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="{{ route('cotizaciones.store') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
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
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">OC Recibida: {{$cotizacion->oc_recibida}} </label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="valor_total">Valor Total Venta Neto Ch$: {{$cotizacion->valor_total}} </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal: {{$cotizacion->guia_boreal}} </label>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="factura_boreal">Factura Boreal: {{$cotizacion->factura_boreal}} </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_entrega">Fecha de Entrega: {{$cotizacion->fecha_entrega}} </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_boreal">OC Boreal: {{$cotizacion->oc_boreal}} </label>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="agregar_items_cot">Para Agregar Items a la Cotización <button type="button" id="agregar" class="btn btn-success btn-sm" title="Click para agegar items"><i class="fa fa-plus"></i></button></label>
                      </div>
                  </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <div class="card-body">
                    <table id="items" class="table table-bordered table-striped table-sm table-responsive" style="font-size: 12px;">
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
                          <th>Precio Peso CON/IVA</th>
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

  var id_cotizacion=$("#id_cotizacion").val();
  mi:url=
  $('#items').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:'{{ url("cotizaciones/\''+id_cotizacion+'\'/agregar_items") }}'
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
      { data: 'pp_ci', name: 'pp_ci' },
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
        console.log(result);
        $('.alert-danger').hide();
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

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
