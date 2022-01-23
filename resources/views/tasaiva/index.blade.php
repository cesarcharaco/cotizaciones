@extends('layouts.app')
@section('title') Tasas de IVA @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-chart-bar"></i> Tasas de IVA</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Tasas de IVA</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('tasaiva.partials.create')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-chart-bar"></i> Tasas de IVA registradas</h3>
            <div class="card-tools">
              @if(search_permits('TasasIVA','Imprimir PDF')=="Si" || search_permits('TasasIVA','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('TasasIVA','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('tasasiva.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('TasasIVA','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('tasasiva.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('TasasIVA','Registrar')=="Si")
              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_tasasiva" data-tooltip="tooltip" data-placement="top" title="Crear TasasIVA" id="createNewTasaIVA">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('TasasIVA','Ver mismo usuario')=="Si" || search_permits('TasasIVA','Ver todos los usuarios')=="Si" || search_permits('TasasIVA','Editar mismo usuario')=="Si" || search_permits('TasasIVA','Editar todos los usuarios')=="Si" || search_permits('TasasIVA','Eliminar mismo usuario')=="Si" || search_permits('TasasIVA','Eliminar todos los usuarios')=="Si") 
          <div class="card-body">
            <table id="tasaiva_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Tasa</th>
                  <th>Fecha</th>
                  <th>Status</th>
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
<script>$(document).ready( function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#tasaiva_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('tasasiva') }}"
   },
    columns: [
      { data: 'tasa_i', name: 'tasa_i' },
      { data: 'fecha_i', name: 'fecha_i' },
      { data: 'status_i', name: 'status_i' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewTasaIVA').click(function () {
  $('#tasaIVAForm').trigger("reset");
  $('#create_tasasiva').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR CATEGORIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateTasaIVA').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('tasasiva.store') }}",
    method: 'post',
    data: {
      tasa_i: $('#tasa_i').val(),
      fecha_i: $('#fecha_i').val(),
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
        var oTable = $('#tasaiva_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_tasasiva").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA ELIMINAR CATEGORIA ---------------------//
function deleteTasaIVA(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta Tasa de IVA?',
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
        url: "tasasiva/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#tasaiva_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          
          Swal.fire({title: "Error del servidor", text:  "Tasa de IVA no eliminada", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
