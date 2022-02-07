@extends('layouts.app')
@section('title') Registro de cotización @endsection
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
    @include('cotizaciones.partials.info') 
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="{{ route('cotizaciones.store') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de cotización: Número de Cotización {{$correlativo}}</h3>
              <div class="float-right">
                <a href="{{ route('cotizaciones.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>
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
                <div class="col-sm-12">
                  <div class="form-check">
                    <input type="checkbox" name="cargar_items" id="cargar_items" value="1" title="Seleccione si ya posee ya los provedores le dieron precio de los productos que cargará"  data-toggle="tooltip" data-placement="top" class="form-check-input">
                    <label for="cargar_items">
                      &nbsp;&nbsp;Ya tiene precios del Proveedor?
                    </label>
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="moneda">Moneda <b style="color: red;">*</b></label>
                    <select name="moneda" id="moneda" class="form-control select2bs4" required="required" title="seleccione la moneda">
                      <option value="Dolar">Dolar</option>
                      <option value="Euro">Euro</option>
                      <option value="Lira">Lira</option>
                      <option value="Peso">Peso</option>
                    </select>
                  </div>
                  @error('moneda')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_entrega">Fecha de Entrega <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" title ="Seleccione la fecha de entrega" required="required" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" >
                      </div>
                      @error('fecha_entrega')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
              <!-- <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="factura_boreal">Factura Boreal </label>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="posee_fb" id="posee_fb" title="Si posee el código de la Factura Boreal, entonces la cotización pasará a status de Finalizada inmediatamente y deberá completar todos los demás campos obligatoriamente" data-toggle="tooltip" data-placement="right"> <small>Posee la Factura</small>
                        <input type="text" name="factura_boreal" id="factura_boreal" class="form-control" placeholder="Ingrese el código de la Factura Boreal" disabled="disabled"  title="Si posee el código de la Factura Boreal, entonces la cotización pasará a status de Finalizada inmediatamente y deberá completar todos los demás campos obligatoriamente" data-toggle="tooltip" data-placement="right">
                      </div>
                      @error('factura_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-md-8" align="right">
                    <a class="btn btn-info btn-sm btn-circle text-white" data-toggle="modal" data-target="#help_cot" data-tooltip="tooltip" data-placement="top" style="width: 30px; height: 30px; padding: 6px 0px; border-radius: 15px;" title="Ayuda con el registro de cotización" id="ver_info">
                    <i class="fas fa-question-circle"></i>
              </a>
                  </div>
              </div> -->
              <div class="row">
                  <!-- <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">OC Recibida </label>
                        <input type="checkbox" name="posee_ocr" id="posee_ocr" title="Si posee el código de la OC, de ser así la cotización pasará a status de Lista para Contestar pero si además posee la Factura Boreal el status será Finalizada inmediatamente" data-toggle="tooltip" data-placement="right"> <small>Posee la OC Recibida</small>
                        <input type="text" name="oc_recibida" id="oc_recibida" class="form-control" placeholder="Ingrese la OC Recibida" disabled="disabled"  title="Si posee el código de la OC, de ser así la cotización pasará a status de Lista para Contestar pero si además posee la Factura Boreal el status será Finalizada inmediatamente" data-toggle="tooltip" data-placement="right">
                      </div>
                      @error('oc_recibida')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div> -->
                  
                  <!-- <div class="col-sm-4">
                    <div class="form-group">
                        <label for="valor_total">Valor Total Venta Neto</label>
                        <input type="text" name="valor_total" id="valor_total" class="form-control"placeholder="Ingrese el Valor Total Venta Neto" >
                      </div>
                      @error('valor_total')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div> -->
              </div>
              <!-- <div class="row">
                <div class="col-sm-12">
                  <label>Datos Boreal</label>
                </div>
              </div>
              
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal </label>
                        <input type="text" name="guia_boreal" id="guia_boreal" class="form-control" placeholder="Ingrese el código de la guía boreal" disabled="disabled" >
                      </div>
                      @error('guia_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_gb">Fecha de la Guía:</label>
                        <input type="date" name="fecha_gb" id="fecha_gb" class="form-control" title="Ingrese la fecha de la guía boreal" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" disabled="disabled">
                      </div>
                      @error('fecha_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_gb">PDF Guía Boreal:</label>
                        <input type="file" name="url_pdf_gb" id="url_pdf_gb" class="form-control" placeholder="Ingrese el pdf de la guía boreal" disabled="disabled" accept="application/pdf">
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
                        <input type="text" name="oc_boreal" id="oc_boreal" class="form-control" placeholder="Ingrese el código de la OC boreal" value="" disabled="disabled">
                      </div>
                      @error('oc_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_ocb">Fecha de la OC Boreal:</label>
                        <input type="date" name="fecha_ocb" id="fecha_ocb" class="form-control" title="Ingrese la fecha de la OC boreal" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" disabled="disabled">
                      </div>
                      @error('fecha_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_ocb">PDF OC Boreal:</label>
                        <input type="file" name="url_pdf_ocb" id="url_pdf_ocb" class="form-control" placeholder="Ingrese el pdf de la OC boreal" disabled="disabled" accept="application/pdf">
                      </div>
                      @error('url_pdf_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div> -->

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
$("#posee_fb").on('change', function (event) {
    if ($(this).is(':checked')) {
      $("#factura_boreal").attr('disabled',false);
      $("#factura_boreal").attr('required', true);
      $("#oc_recibida").attr('disabled',false);
      $("#oc_recibida").attr('required', true);
      $("#guia_boreal").attr('disabled',false);
      $("#guia_boreal").attr('required', true);
      $("#fecha_gb").attr('disabled',false);
      $("#fecha_gb").attr('required', true);
      $("#url_pdf_gb").attr('disabled',false);
      $("#url_pdf_gb").attr('required', true);
      $("#oc_boreal").attr('disabled',false);
      $("#oc_boreal").attr('required', true);
      $("#fecha_ocb").attr('disabled',false);
      $("#fecha_ocb").attr('required', true);
      $("#url_pdf_ocb").attr('disabled',false);
      $("#url_pdf_ocb").attr('required', true);
    } else {
      $("#factura_boreal").attr('disabled',true);
      $("#factura_boreal").removeAttr('required');
      $("#oc_recibida").attr('disabled',true);
      $("#oc_recibida").removeAttr('required');
      $("#guia_boreal").attr('disabled',true);
      $("#guia_boreal").removeAttr('required');
      $("#fecha_gb").attr('disabled',true);
      $("#fecha_gb").removeAttr('required');
      $("#url_pdf_gb").attr('disabled',true);
      $("#url_pdf_gb").removeAttr('required');
      $("#oc_boreal").attr('disabled',true);
      $("#oc_boreal").removeAttr('required');
      $("#fecha_ocb").attr('disabled',true);
      $("#fecha_ocb").removeAttr('required');
      $("#url_pdf_ocb").attr('disabled',true);
      $("#url_pdf_ocb").removeAttr('required');
    }
});
$("#posee_ocr").on('change', function (event) {
    if ($(this).is(':checked')) {
      
      $("#oc_recibida").attr('disabled',false);
      $("#oc_recibida").attr('required',true);
      $("#guia_boreal").attr('disabled',false);
      $("#guia_boreal").attr('required',true);
      $("#fecha_gb").attr('disabled',false);
      $("#fecha_gb").attr('required',true);
      $("#url_pdf_gb").attr('disabled',false);
      $("#url_pdf_gb").attr('required',true);
      $("#oc_boreal").attr('disabled',false);
      $("#oc_boreal").attr('required',true);
      $("#fecha_ocb").attr('disabled',false);
      $("#fecha_ocb").attr('required',true);
      $("#url_pdf_ocb").attr('disabled',false);
      $("#url_pdf_ocb").attr('required',true);
    } else {
      
      $("#oc_recibida").attr('disabled',true);
      $("#oc_recibida").removeAttr('required');
      $("#guia_boreal").attr('disabled',true);
      $("#guia_boreal").removeAttr('required');
      $("#fecha_gb").attr('disabled',true);
      $("#fecha_gb").removeAttr('required');
      $("#url_pdf_gb").attr('disabled',true);
      $("#url_pdf_gb").removeAttr('required');
      $("#oc_boreal").attr('disabled',true);
      $("#oc_boreal").removeAttr('required');
      $("#fecha_ocb").attr('disabled',true);
      $("#fecha_ocb").removeAttr('required');
      $("#url_pdf_ocb").attr('disabled',true);
      $("#url_pdf_ocb").removeAttr('required');
    }
});
$('#ver_info').click(function () {
  
  $('#info').modal({backdrop: 'static', keyboard: true, show: true});
  
});

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
