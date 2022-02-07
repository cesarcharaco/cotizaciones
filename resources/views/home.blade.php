@extends('layouts.app')
@section('title') Home @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Portada</h1>
        Número de Cotización en uso: {{codigo_en_uso()}} 
        @if(codigo_en_uso()!="Ninguno")
        <form action="{{ route('cotizaciones.rechazar_codigo')}}"class="form-horizontal" method="POST" autocomplete="off" name="rechazarForm" id="rechazarForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
          <input type="hidden" name="numero" value="{{codigo_en_uso()}}">
          <label>Motivo</label>
          <input type="text" name="observacion" id="observacion" placeholder="Ingrese el motivo de rechazo del número asignado" class="form-control-sm" required="required" title="Ingrese el motivo de rechazo del número asignado">
              <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"> &nbsp;Rechazar</i>
              </button>
        </form>
        @endif
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Portada</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{precot_espera()}}</h3>

            <p>Pre-Cotiz. En Espera</p>
          </div>
          <div class="icon">
            <i class="fa fa-shopping-cart text-white"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{cot_pendientes()}}</h3>
            <p>Cotiz. Pendientes</p>
          </div>
          <div class="icon">
            <i class="fa fa-cart-plus text-white"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{cot_epc()}}</h3>

            <p>Cotiz. En P/D Comp.</p>
          </div>
          <div class="icon">
            <i class="fa fa-cart-plus text-white"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{cot_finalizadas()}}</h3>

            <p>Cot. Finalizadas</p>
          </div>
          <div class="icon">
            <i class="fa fa-cart-plus text-white"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
    </div>

    <!-- /.row -->
    <div class="row">
      <div class="col-md-12">
        <div class="card-header">
          <h3 class="card-title"><i class="nav-icon  fas fa-money-check-alt"></i> Pre-Cotizaciones En Espera</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
        <table id="cotizaciones_table_home" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Fecha</th>
                  <th>Número</th>
                  <th>Descripción General</th>
                  <th>Empresa</th>
                  <th>Solicitante</th>
                  <th>Cotizador</th>
                  <th>Moneda</th>
                  <th>OC Recibida</th>
                  <th>Valor Total Venta Neto</th>
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
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-header">
          <hr>
          <h3 class="card-title"><i class="nav-icon  fas fa-money-check-alt"></i> Cotizaciones en estatus ERP/COTI | En Análisis | En Proceso de Compra</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <table id="cotizaciones_d_table_home" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Número</th>
                  <th>Descripción General</th>
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

  
  var table =$('#cotizaciones_table_home').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('cotizaciones/en_espera') }}"
   },
    columns: [
      { data: 'status', name: 'status' },
      { data: 'fecha', name: 'fecha' },
      { data: 'numero', name: 'numero' },
      { data: 'descripcion_general', name: 'descripcion_general' },
      { data: 'empresa', name: 'empresa' },
      { data: 'id_solicitante', name: 'id_solicitante' },
      { data: 'cotizador', name: 'cotizador' },
      { data: 'moneda', name: 'moneda' },
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
table.ajax.reload();
$.fn.DataTable.ext.errMode='throw';
  var table2=$('#cotizaciones_d_table_home').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('cotizaciones/en_proceso') }}"
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
table2.ajax.reload();
});
</script>
@endsection
