@extends('layouts.app')
@section('title') Preparando cotización para envío @endsection
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
          <li class="breadcrumb-item active">Preparando envío</li>
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
          <form action="{{ route('cotizaciones.registrar_respuesta') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <i class="nav-icon  fa fa-shopping-basket"></i> Preparando Items para envío
              <div class="float-right">
                <a href="{{ route('cotizaciones.definitivas') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>
                @if($cotizacion->status2!="Lista para Contestar")
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-envelope"></i> Enviar</button>
                @endif
              
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
              @if($cotizacion->status2!="Lista para Contestar")
              <div class="row">
                <div class="col-md-12">
                  <label for="lugar_entrega">Lugar de Entrega</label>
                  <input type="text" name="lugar_entrega" id="lugar_entrega" title="Ingrese el lugar d entrega de los productos" placeholder="Ej: Av. X calle A" class="form-control">
                </div>
              </div>
              @endif
              <div class="row">
                @if($cotizacion->status2!="Lista para Contestar")
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">OC Recibida: </label>
                        <input type="text" name="oc_recibida" id="oc_recibida" class="form-control" placeholder="Ingrese la OC Recibida" value="{{$cotizacion->oc_recibida}}" @if($cotizacion->oc_recibida=="") required="required" @else readonly="readonly" @endif >
                      </div>
                      @error('oc_recibida')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  @else
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_recibida">Modo de Responder:</label><br>
                        <a href="{{ route('cotizaciones.generar_reporte_envio',$cotizacion->id)}}" target="_blank" class="btn btn-primary btn-sm" title="Descarga el pdf para enviarlo por correo electronico"><i class="fas fa-download"></i> Descargar PDF</a>
                        <a href="#" onclick="respuestaViaTelefonica(<?=$cotizacion->id?>)" class="btn btn-success btn-sm" title="Presione si responderá Vía Telefónica"><i class="fas fa-phone"></i> Vía Telefónica</a>

                    </div>
                  </div>
                  @endif
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
                        <input type="text" name="valor_total" id="monto_total" readonly="readonly" value="{{$cotizacion->valor_total}}" class="form-control"> 
                      </div>
                  </div>
              </div>
              @if($cotizacion->status2!="Lista para Contestar")
              <div class="row">
                <div class="col-sm-12">
                  <label>Datos Boreal</label>
                </div>
              </div>
              @if(count($datosboreal) > 0 && $cotizacion->status=="Entrega Parcial")
              @foreach($datosboreal as $key)
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal: <b style="color: red;">*</b></label>
                        <input type="text" name="guia_boreal" id="guia_boreal" class="form-control" placeholder="Ingrese el código de la guía boreal" value="{{$key->guia_boreal}}">
                      </div>
                      @error('guia_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_gb">Fecha de la Guía: <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_gb" id="fecha_gb" class="form-control" title="Ingrese la fecha de la guía boreal" value="{{$key->fecha_gb}}" min="{{$key->fecha_gb}}">
                      </div>
                      @error('fecha_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_gb">PDF Guía Boreal: <b style="color: red;">*</b></label>
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
                        <label for="oc_boreal">OC Boreal: <b style="color: red;">*</b></label>
                        <input type="text" name="oc_boreal" id="oc_boreal" class="form-control" placeholder="Ingrese el código de la OC boreal" value="{{$key->oc_boreal}}">
                      </div>
                      @error('oc_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_ocb">Fecha de la Guía: <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_ocb" id="fecha_ocb" class="form-control" title="Ingrese la fecha de la OC boreal" value="{{$key->fecha_ocb}}" min="{{$key->fecha_ocb}}">
                      </div>
                      @error('fecha_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_ocb">PDF Guía Boreal: <b style="color: red;">*</b></label>
                        <input type="file" name="url_pdf_ocb" id="url_pdf_ocb" class="form-control" placeholder="Ingrese el pdf de la OC boreal">
                      </div>
                      @error('url_pdf_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
              @endforeach
              @else
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="guia_boreal">Guía Boreal: <b style="color: red;">*</b></label>
                        <input type="text" name="guia_boreal" id="guia_boreal" class="form-control" placeholder="Ingrese el código de la guía boreal" value="" required="required">
                      </div>
                      @error('guia_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_gb">Fecha de la Guía: <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_gb" id="fecha_gb" class="form-control" title="Ingrese la fecha de la guía boreal" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" required="required">
                      </div>
                      @error('fecha_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_gb">PDF Guía Boreal: <b style="color: red;">*</b></label>
                        <input type="file" name="url_pdf_gb" id="url_pdf_gb" class="form-control" placeholder="Ingrese el pdf de la guía boreal" required="required">
                      </div>
                      @error('url_pdf_gb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="oc_boreal">OC Boreal: <b style="color: red;">*</b></label>
                        <input type="text" name="oc_boreal" id="oc_boreal" class="form-control" placeholder="Ingrese el código de la OC boreal" value="" required="required">
                      </div>
                      @error('oc_boreal')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="fecha_ocb">Fecha de la Guía: <b style="color: red;">*</b></label>
                        <input type="date" name="fecha_ocb" id="fecha_ocb" class="form-control" title="Ingrese la fecha de la OC boreal" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}">
                      </div>
                      @error('fecha_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="url_pdf_ocb">PDF Guía Boreal: <b style="color: red;">*</b></label>
                        <input type="file" name="url_pdf_ocb" id="url_pdf_ocb" class="form-control" placeholder="Ingrese el pdf de la OC boreal" required="required">
                      </div>
                      @error('url_pdf_ocb')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
              @endif
            @endif
             <div class="row">
               
             </div>
              <!-- <div class="row">
                <div class="col-md-12"> -->
                  <!-- <div class="card-body"> -->
                    <table id="items3" class="table table-bordered table-striped table-sm table-responsive" style="font-size: 12px; width: 100% !important">
                      <thead>
                        <tr>
                          <th>Enviar</th>
                          <th>Cant. Enviar</th>
                          <th>Cantidad</th>
                          <th>Descripción</th>
                          <th>Imagen</th>
                          <th>Precio/Moneda</th>
                          <th>Precio C/IVA</th>
                          <th>Precio S/IVA</th>
                          <th>Precio Unitario</th>
                          <th>Total Por Item</th>
                          <th>Plazo Entrega</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  <!-- </div> -->
                <!-- </div> -->
              <!-- </div> --><!-- cierre de row -->


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
  var id=$("#id_cotizacion").val();
  var table=$('#items3').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: true,
    ajax: {
      url:"preparar_envio",
   },
    columns: [
      { data: 'enviado', name: 'enviado' },
      { data: 'cant_enviado', name: 'cant_enviado' },
      { data: 'cant', name: 'cant' },
      { data: 'detalles', name: 'detalles' },
      { data: 'imagen', name: 'imagen' },
      { data: 'pda', name: 'pda' },
      { data: 'pp_ci', name: 'pp_ci' },
      { data: 'pp_si', name: 'pp_si' },
      { data: 'precio_unit', name: 'moneda' },
      { data: 'total_pp', name: 'total_pp' },
      { data: 'plazo_entrega', name: 'plazo_entrega' },
    ],
    order: [[0, 'desc']]
  });
  table.ajax.reload();
});
   
function respuestaViaTelefonica(id_cotizacion) {
  var id = id_cotizacion;
  Swal.fire({
    title: '¿Estás seguro que ha comunicado con el solicitante sobre la información de la cotización?',
    text: "¡Su status será cambiado a Contestada-En Análisis!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Si, Cambiar!',
    cancelButtonText: 'No, Cancelar!'
  }).then((result) => {
    if (result.isConfirmed) {
      // ajax
      $.ajax({
        type:"get",
        url: "../../cotizaciones/"+id+"/contestada",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#items3').dataTable();
          oTable.fnDraw(false);
          var url = "../../cotizaciones/definitivas";    
          $(location).attr('href',url);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "No se pudo realizar el cambio de status de la cotización", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
