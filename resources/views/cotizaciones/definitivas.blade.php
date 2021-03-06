@extends('layouts.app')
@section('title') Cotizaciones Definitivas @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon  fas fa-money-check-alt"></i> Cotizaciones Definitivas</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Cotizaciones</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('cotizaciones.partials.status')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon  fas fa-money-check-alt"></i> Cotizaciones Definitivas registradas</h3>
            <div class="card-tools">
              @if(search_permits('Cotizaciones','Imprimir PDF')=="Si" || search_permits('Cotizaciones','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Cotizaciones','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('cotizaciones.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Cotizaciones','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('cotizaciones.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              
            </div>
          </div>
          @if(search_permits('Cotizaciones','Ver mismo usuario')=="Si" || search_permits('Cotizaciones','Ver todos los usuarios')=="Si" || search_permits('Cotizaciones','Editar mismo usuario')=="Si" || search_permits('Cotizaciones','Editar todos los usuarios')=="Si" || search_permits('Cotizaciones','Eliminar mismo usuario')=="Si" || search_permits('Cotizaciones','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="cotizaciones_d_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>N??mero</th>
                  <th>Descripci??n General</th>
                  <th>Status</th>
                  <th>Status/COTI</th>
                  <th>Empresa</th>
                  <th>Solicitante</th>
                  <th>Cotizador</th>
                  <th>Moneda</th>
                  <th>OC Recibida</th>
                  <th>Valor Total Venta Neto</th>
                  <th>Factura Boreal</th>
                  <th>Fecha Entrega</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
          @else
          <div class="row">
            <div class="col-12">                          
              <div class="alert alert-danger alert-dismissible text-center">
                <h5><i class="icon fas fa-ban"></i> ??Alerta!</h5>
                ACCESO RESTRINGIDO, NO POSEE PERMISO.
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
$(document).ready( function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.fn.DataTable.ext.errMode='throw';
  var table=$('#cotizaciones_d_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('cotizaciones/definitivas') }}"
   },
    columns: [
      { data: 'fecha', name: 'fecha' },
      { data: 'numero_oc', name: 'numero_oc' },
      { data: 'descripcion_general', name: 'descripcion_general' },
      { data: 'status', name: 'status' },
      { data: 'status2', name: 'status2' },
      { data: 'nombre', name: 'nombre' },
      { data: 'id_solicitante', name: 'id_solicitante' },
      { data: 'id_cotizador', name: 'id_cotizador' },
      { data: 'moneda', name: 'moneda' },
      { data: 'oc_recibida', name: 'oc_recibida' },
      { data: 'valor_total', name: 'valor_total' },
      { data: 'factura_boreal', name: 'factura_boreal' },
      { data: 'fecha_entrega', name: 'fecha_entrega' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
table.ajax.reload();
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteCotizacion(id){
  var id = id;
  Swal.fire({
    title: '??Est??s seguro que desea eliminar a esta cotizaci??n?',
    text: "??Esta opci??n no podr?? deshacerse en el futuro!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '??Si, Eliminar!',
    cancelButtonText: 'No, Cancelar!'
  }).then((result) => {
    if (result.isConfirmed) {
      // ajax
      $.ajax({
        type:"DELETE",
        url: "cotizaciones/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#cotizaciones_d_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Cotizaci??n no eliminada", icon:  "error"});
        }
      });
    }
  })
}
function changeStatusCotizacion(id_cotizacion) {
  $("#id_cotizacion_status").val(id_cotizacion);
  $('#changeStatusForm').trigger("reset");
  $('#status_cotizacion').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
}
$('#SubmitStatusCotizacion').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('cotizaciones.status') }}",
    method: 'post',
    data: {
      status: $('#status').val(),
      observacion: $('#observacion').val(),
      id_cotizacion: $("#id_cotizacion_status").val()
    },
    success: function(result) {
      console.log(result);
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#cotizaciones_d_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#status_cotizacion").modal('hide');
        }
      }
    }
  });
});

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
