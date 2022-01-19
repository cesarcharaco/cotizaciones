@extends('layouts.app')
@section('title') Registro de cotización @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fa fa-shopping-basket"></i> Cotizaciones</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('cotizaciones.index') }}">Cotizaciones</a></li>
          <li class="breadcrumb-item active">Registro de cotización</li>
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
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de cotización: : Número de Cotización {{$correlativo}}</h3>
              <div class="float-right">
                <a href="{{ route('productos.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>
                @if($correlativo > 0)                
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar registro</button>
                @endif
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="message_error">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @if($correlativo==0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none;" id="message_error">
                  No existen correlativos disponibles para registrar una cotización
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @endif
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="correlativo">
                      Número de Cotización Boreal
                    </label>
                    <input type="text" name="numero_oc" id="numero_oc" value="{{$anio}}-{{$correlativo}}" readonly="readonly" class="form-control">
                    <input type="hidden" name="numero_cotizacion" id="numero_cotizacion" readonly="readonly" value="{{$correlativo}}"  class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-sm">
                  <div class="form-group">
                    <label for="descripcion_general">Descripción General <b style="color: red;">*</b></label>
                    <input type="text" name="descripcion_general" id="descripcion_general" class="form-control" required="required" placeholder="Ingrese la descripción de manera general" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                  @error('descripcion_general')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="empresa1">Seleccionae una Empresa ya registrada </label>
                    <select name="empresa1" id="empresa1" class="form-control select2bs4">
                      <option value="">Nueva empresa</option>
                      @foreach($empresas as $e)
                        <option value="{{$e->nombre}}">{{$e->nombre}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>  
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="empresa">Nombre de la empresa <b style="color: red;">*</b></label>
                    <input type="text" name="empresa" id="empresa" value="" placeholder="Ingrese el nombre de la empresa" class="form-control">
                  </div>
                </div>  
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="solicitante1">Seleccione un Solicitante ya registrado </label>
                    <select name="solicitante1" id="solicitante1" class="form-control select2bs4">
                      <option value="">Nuevo Solicitante</option>
                    </select>
                  </div>
                </div>  
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="solicitante">Solicitante <b style="color: red;">*</b></label>
                    <input type="text" name="solicitante" id="solicitante" value="" placeholder="Ingrese el nombre del solicitante" class="form-control">
                  </div>
                </div>  
              </div>
              @if(\Auth::getUser()->user_type=="Admin")
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cotizador">Cotizador <b style="color: red;">*</b></label>
                    <select name="cotizador" id="cotizador" class="form-control select2bs4" title="Seleccione un Cotizador">
                      @foreach($cotizadores as $c)
                        <option value="{{$c->id_usuario}}">{{$c->cotizador}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>  
              </div>
              @else
                <input type="hidden" name="cotizador" id="cotizador" value="{{\Auth::getUser()->id}}">
              @endif
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">OC Recibida </label>
                        <input type="text" name="oc_recibida" id="oc_recibida" class="form-control" placeholder="Ingrese la OC Recibida">
                      </div>
                      @error('oc_recibida')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="valor_total">Valor Total Venta Neto Ch$ </label>
                        <input type="text" name="valor_total" id="valor_total" class="form-control"placeholder="Ingrese el Valor Total Venta Neto Ch$" >
                      </div>
                      @error('valor_total')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal </label>
                        <input type="text" name="guia_boreal" id="guia_boreal" class="form-control" placeholder="Ingrese la guía boreal">
                      </div>
                      @error('guia_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="factura_boreal">Factura Boreal </label>
                        <input type="text" name="factura_boreal" id="factura_boreal" class="form-control" placeholder="Ingrese el código de la Factua Boreal">
                      </div>
                      @error('factura_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_entrega">Fecha de Entrega</label>
                        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" title ="Seleccione la fecha de entrega" >
                      </div>
                      @error('fecha_entrega')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_boreal">OC Boreal </label>
                        <input type="text" name="oc_boreal" id="oc_boreal" class="form-control"  placeholder="Ingrese la OC Boreal">
                      </div>
                      @error('oc_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
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
$(document).ready(function () {
  bsCustomFileInput.init();
});
categoria_data();
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
function categoria_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_categorias') }}",
    dataType: 'json',
    success: function(response){
      $('#id_categoria').empty();
      $.each(response, function(key, registro) {
        $('#id_categoria').append('<option value='+registro.id+'>'+registro.categoria+'</option>');
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de medio publicitario.", icon:  "error"});
    }
  });
}
//--CODIGO PARA CREAR CATEGORIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCategoria').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('categorias.store') }}",
    method: 'post',
    data: {
      categoria: $('#categoria').val()
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#categorias_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_categorias").modal('hide');
          categoria_data();
        }
      }
    }
  });

});
//seleccionando empresa
$('#empresa1').change(function(e) {
  //console.log('asasasasas'+$(this).val());
  
  var opcion=$(this).val();
  if(opcion!==""){
    $("#empresa").val($(this).val());
    $("#empresa").attr('readonly',true);
    //buscando solicitantes de la empresa seleccionada
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('solicitantes.buscar_por_empresa') }}",
    method: 'post',
    data: {
      nombre: $(this).val()
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $("#solicitante1").empty();
        $("#solicitante1").append("<option value=''>Nuevo Solicitante</option>");
        
        $.each(result, function(key, registro) {
          
        $('#solicitante1').append("<option value='"+registro.id+"'>"+registro.nombres+" "+registro.apellidos+"</option>");
        
      });
      }
    }
  });
  }else{
    
    $("#empresa").val("");
    $("#empresa").attr('readonly',false);
    $("#solicitante1").empty();
    $("#solicitante").val("");
    $("#solicitante").attr('readonly',false);
  }
});
$('#solicitante1').change(function(e) {
  var opcion=$(this).val();
  if(opcion!==""){
    $.get('/solicitantes/'+opcion+'/buscar',function (response) {
      if (response.length > 0) {
        for(var i=0; i < response.length; i++){
          $("#solicitante").val(response[i].nombres+" "+response[i].apellidos);
          $("#solicitante").attr('readonly',true);
        }
      }
        
    });
    
  }else{
    $("#solicitante").val("");
    $("#solicitante").attr('readonly',false);
  }
});
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
