@extends('reportes.layouts.app')
@section('title')
  <title>Reporte de Medios publicitarios</title>
@endsection
@section('title-report')
  @php echo 'Medios publicitarios registrados' @endphp
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
  	@for($i=1;$i < 100; $i++)
  		<tr style=" font-size: 8; ">
  			<td style="background-color: #DADADA;">{{$i}}</td>
  			<td align="justify"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. </td>
  			<td style="background-color: #DADADA"></td>
  			<td></td>
  			<td style="background-color: #DADADA"></td>
  			<td></td>
  			<td style="background-color: #DADADA"></td>
  		</tr>
  	@endfor
  </tbody>
  </table>
@endsection