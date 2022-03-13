@extends('reportes.layouts.app')
@section('title')
  <title>Reporte de Solicitud de Cotización</title>
@endsection
@section('title-report')
  @php echo 'Cotización registrada' @endphp
@endsection

@section('main')
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="text-align: center; border-collapse: collapse !important;top: 90px !important; font: sans-serif !important;" class="table table-bordered table-striped">
  <thead>
    <tr style="text-transform: uppercase; color: #FFFFFF; background-color: #36347F; font-size: 8; " >
      <th style="width: 5%;">Item</th>
      <th style="width: 35%;">Descripción</th>
      <th style="width: 20%;">Imagen</th>
      <th style="width: 10%;">Plazo de Entrega</th>
      <th style="width: 10%;">Cantidad</th>
      <th style="width: 10%;">Precio Unit.</th>
      <th style="width: 10%;">Total</th>
    </tr>      
  </thead>
  <tbody>
    <?php $i=1; ?>
  	@foreach($items as $key)
  		<tr style=" font-size: 8; ">
  			<td style="background-color: #DADADA;">{{$i++}}</td>
  			<td align="justify">{{$key->detalles}}</td>
  			<td style="background-color: #DADADA">
          @if(buscar_img($key->id)!="")
          @php $url="/img_productos/".buscar_img($key->id); @endphp
          <?php $x=public_path() . '/img_productos/26341713_reloj.jpg'; ?>
          <img src="{{public_path() . $url}}" style="width: 50px; height: 50px;">
          
          @else
            No Encontrada
          @endif
          </td>
  			<td>{{$key->plazo_entrega}}</td>
  			<td style="background-color: #DADADA">{{$key->cant}}</td>
  			<td>{{$key->precio_unit}}</td>
  			<td style="background-color: #DADADA">{{$key->total_pp}}</td>
  		</tr>
  	@endforeach 3133928
  </tbody>
  </table>
@endsection