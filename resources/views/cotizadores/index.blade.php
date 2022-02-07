@extends('layouts.app')
@section('title') Cotizadores @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-user"></i> Cotizadores</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Cotizadores</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('cotizadores.partials.create')
    @include('cotizadores.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-user"></i> Cotizadores registrados</h3>
            <div class="card-tools">
              @if(search_permits('Cotizadores','Imprimir PDF')=="Si" || search_permits('Cotizadores','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Cotizadores','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('cotizadores.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Cotizadores','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('cotizadores.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Cotizadores','Registrar')=="Si")
              {{-- <a href="{!! route('cotizadores.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar cotizador"><i class="fas fa-edit"></i> Registrar cotizadores</a> --}}

              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_cotizadores" data-tooltip="tooltip" data-placement="top" title="Crear Cotizadores">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Cotizadores','Ver mismo usuario')=="Si" || search_permits('Cotizadores','Ver todos los usuarios')=="Si" || search_permits('Cotizadores','Editar mismo usuario')=="Si" || search_permits('Cotizadores','Editar todos los usuarios')=="Si" || search_permits('Cotizadores','Eliminar mismo usuario')=="Si" || search_permits('Cotizadores','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="cotizadores_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Nombres y Apellidos</th>
                  <th>RUT</th>
                  <th>Teléfono</th>
                  <th>Correo</th>
                  <th>Nombre de Usuario</th>
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
  /*$.fn.DataTable.ext.errMode='throw';
  var table=*/
  $('#cotizadores_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('cotizadores') }}"
   },
    columns: [
      { data: 'cotizador', name: 'cotizador' },
      { data: 'rut', name: 'rut' },
      { data: 'telefono', name: 'telefono' },
      { data: 'correo', name: 'correo' },
      { data: 'username', name: 'username' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
//table.ajax.reload();
});

//--CODIGO PARA CREAR PBX (LEVANTAR EL MODAL) ---------------------//
$('#createNewCotizador').click(function () {
  $('#cotizadorForm').trigger("reset");
  $('#create_cotizadores').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR PBX (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCotizador').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });

  $.ajax({
    url: "{{ route('cotizadores.store') }}",
    method: 'post',
    data: {
      cotizador: $('#cotizador').val(),
      rut: $('#rut').val(),
      telefono: $('#telefono').val(),
      correo: $('#correo').val(),
      username: $('#username').val(),
    },
    success: function(result) {
      //console.log(result);
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#cotizadores_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_cotizadores").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR AGENCIA ---------------------//
$('body').on('click', '#editCotizador', function () {
  var id = $(this).data('id');
  
  $.ajax({
    method:"GET",
    url: "cotizadores/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_cotizadores').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_cotizador_edit').val(data.id);
      $('#cotizador_edit').val(data.cotizador);
      $('#rut_edit').val(data.rut);
      $('#telefono_edit').val(data.telefono);
      $('#correo_edit').val(data.correo);
      $('#username_edit').val(data.name);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditCotizador').click(function(e) {
  e.preventDefault();
  var id = $('#id_cotizador_edit').val();
  var reset;
  if ($("#reset_clave").is(':checked')) {
    reset=1;
  }else{
    reset=null;
  }
  $.ajax({
    method:'PUT',
    url: "cotizadores/"+id+"",
    data: {
      id_cotizador: $('#id_cotizador_edit').val(),
      cotizador: $('#cotizador_edit').val(),
      rut: $('#rut_edit').val(),
      telefono: $('#telefono_edit').val(),
      correo: $('#correo_edit').val(),
      username: $('#username_edit').val(),
      reset_clave: reset
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#cotizadores_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_cotizadores").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteCotizador(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a este cotizador?',
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
        url: "cotizadores/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#cotizadores_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Cotizador no eliminado", icon:  "error"});
        }
      });
    }
  })
}
 
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
