@extends('layouts.app')
@section('title') Cotizaciones @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon  fas fa-money-check-alt"></i> Cotizaciones</h1>
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
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon  fas fa-money-check-alt"></i> Cotizaciones registradas</h3>
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
              @if(search_permits('Cotizaciones','Registrar')=="Si")
              
              <a href="{!! route('cotizaciones.create') !!}" class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Crear Cotización">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              <a href="{!! route('cotizaciones.definitivas') !!}" class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Listar las Cotizaciones Definitivas">
                <i class="fa fa-list"> &nbsp;Listar Definitivas</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Cotizaciones','Ver mismo usuario')=="Si" || search_permits('Cotizaciones','Ver todos los usuarios')=="Si" || search_permits('Cotizaciones','Editar mismo usuario')=="Si" || search_permits('Cotizaciones','Editar todos los usuarios')=="Si" || search_permits('Cotizaciones','Eliminar mismo usuario')=="Si" || search_permits('Cotizaciones','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="cotizaciones_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Número</th>
                  <th>Descripción General</th>
                  <th>Empresa</th>
                  <th>Solicitante</th>
                  <th>Cotizador</th>
                  <th>OC Recibida</th>
                  <th>Valor Total Venta Neto Ch$</th>
                  <th>Guía Boreal</th>
                  <th>Factura Boreal</th>
                  <th>Fecha Entrega</th>
                  <th>OC Boreal</th>
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
                <h5><i class="icon fas fa-ban"></i> ¡Alerta!</h5>
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
  $('#cotizaciones_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('cotizaciones') }}"
   },
    columns: [
      { data: 'fecha', name: 'fecha' },
      { data: 'numero', name: 'numero' },
      { data: 'descripcion_general', name: 'descripcion_general' },
      { data: 'empresa', name: 'empresa' },
      { data: 'solicitante', name: 'solicitante' },
      { data: 'cotizador', name: 'cotizador' },
      { data: 'oc_recibida', name: 'oc_recibida' },
      { data: 'valor_total', name: 'valor_total' },
      { data: 'guia_boreal', name: 'guia_boreal' },
      { data: 'factura_boreal', name: 'factura_boreal' },
      { data: 'fecha_entrega', name: 'fecha_entrega' },
      { data: 'oc_boreal', name: 'oc_boreal' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR ESTADOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCotizacion').click(function () {
  $('#cotizacionForm').trigger("reset");
  $('#create_cotizaciones').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR ESTADOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCotizacion').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('cotizaciones.store') }}",
    method: 'post',
    data: {
      fecha: $('#fecha').val(),
      numero: $('#numero').val(),
      descripcion_general: $('#descripcion_general').val(),
      empresa: $('#empresa').val(),
      solicitante: $('#solicitante').val(),
      cotizador: $('#cotizador').val(),
      oc_recibida: $('#oc_recibida').val(),
      valor_total: $('#valor_total').val(),
      guia_boreal: $('#guia_boreal').val(),
      factura_boreal: $('#factura_boreal').val(),
      fecha_entrega: $('#fecha_entrega').val(),
      oc_boreal: $('#oc_boreal').val(),
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
        var oTable = $('#cotizaciones_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_cotizaciones").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR ESTADO ---------------------//
$('body').on('click', '#editCotizacion', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "cotizaciones/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_cotizaciones').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_cotizacion_edit').val(data[0].id);
      $('#fecha_edit').val(date[0].fecha);
      $('#numero_edit').val(date[0].numero);
      $('#descripcion_general_edit').val(date[0].descripcion_general);
      $('#empresa_edit').val(date[0].empresa);
      $('#solicitante_edit').val(date[0].solicitante);
      $('#cotizador_edit').val(date[0].cotizador);
      $('#oc_recibida_edit').val(date[0].oc_recibida);
      $('#valor_total_edit').val(date[0].valor_total);
      $('#guia_boreal_edit').val(date[0].guia_boreal);
      $('#factura_boreal_edit').val(date[0].factura_boreal);
      $('#fecha_entrega_edit').val(date[0].fecha_entrega);
      $('#oc_boreal_edit').val(date[0].oc_boreal);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditCotizacion').click(function(e) {
  e.preventDefault();
  var id = $('#id_cotizacion_edit').val();
  $.ajax({
    method:'PUT',
    url: "cotizaciones/"+id+"",
    data: {
      id_cotizacion: $('#id_cotizacion_edit').val(),
      fecha: $('#fecha_edit').val(),
      numero: $('#numero_edit').val(),
      descripcion_general: $('#descripcion_general_edit').val(),
      empresa: $('#empresa_edit').val(),
      solicitante: $('#solicitante_edit').val(),
      cotizador: $('#cotizador_edit').val(),
      oc_recibida: $('#oc_recibida_edit').val(),
      valor_total: $('#valor_total_edit').val(),
      guia_boreal: $('#guia_boreal_edit').val(),
      factura_boreal: $('#factura_boreal_edit').val(),
      fecha_entrega: $('#fecha_entrega_edit').val(),
      oc_boreal: $('#oc_boreal_edit').val(),
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#cotizaciones_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_cotizaciones").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteCotizacion(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta cotización?',
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
        url: "cotizaciones/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#cotizaciones_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Cotización no eliminada", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
