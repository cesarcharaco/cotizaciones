<html>
<head>
  @yield('title')
  <style>
    @page {
      margin: 0cm 1cm;
    }
    .fecha{
      font-family: sans-serif;
      font-size: 12px;
      margin-top: 8.5px;
      color: #000000;
      text-align: right;
      margin-right: -20px;
    }
    .cotizador{
      font-family: sans-serif;
      font-size: 11px;
      margin-left: 120px;
      margin-top: 35px;
      position: absolute;
      color: #FFFFFF;

    }
    .sello{
      margin-left: 400px;
      margin-top: -75px;
      position: absolute;

    }
    .firma{
      margin-left: 600px;
      margin-top: -120px;
      position: absolute;

    }
    .solicitante{
      font-family: sans-serif;
      font-size: 11px;
      margin-left: 11px;
      margin-top: 70px;
      color: #36347F;
    }
    .codigo{
      font-family: sans-serif;
      font-size: 20px;
      color: #FFFFFF;
      margin-right: -20px;
      margin-top: -30px;
      text-align: right;

    }
    .empresa{
      font-family: sans-serif;
      font-size: 11px;
      color: #000000;
      margin-left: : 30px;
      margin-top: 9px;
      color: #36347F;

    }
    .info{
      text-align: left;
    }
    .info2{
      text-align: right;
    }
    .observaciones{
      font-family: sans-serif;
      font-size: 11px;
      text-align: left;
      margin-top: 20px;
    }
    body{
      font-family: sans-serif;
      margin-top: 1cm;
      margin-bottom: 2cm;
      margin-left: 0cm;
      margin-right: 0cm;
    }
    .logo {
      position: absolute;
      width: 792px;
      height: 200px;
      top: -62px;
      margin-left: -40px;
    }
     /** Definir las reglas del pie de página **/
    footer {
      position: fixed; 
      bottom: 0cm; 
      left: 0cm; 
      right: 0cm;
      height: 2.4cm;
      line-height: 5px;
      page-break-after: never;
      font-size: 12px;
      margin-left: -37px;
    }
    footer .page:after {
      content: counter(page);
    }

    main {
      margin-top: 1cm;
    }
    main table tr td {
      padding: 2px;
    }
    main table tr th {
      padding: 5px;
    }
    .table-striped thead:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.05);

    }
    .table-striped tbody:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.05);

    }
    .footer{
      /*position: absolute !important;*/
    }
    /*.border_t{
       border: red 2px solid !important;
    }*/
  </style>
  @yield('css')
<body>
  @yield('title-report')
  <table width="100%">
    <tr>
      <td valign="top">
        <?php $image_path = '/img/banner_pdf2.png'; ?>
        <img src="{{ public_path() . $image_path }}" class="logo">
      </td>
      <!-- <td align="left">
        <b>
          Reporte de Envio <br>
          Boreal<br>
          mmmmmmmmmmmmmmmmm<br>
          NIT: 222222222222222<br>
          Fecha: <?php //echo date('d/m/Y g:i:s A'); ?>
        </b>
      </td> -->
    </tr>
  </table>
  
  <div class="info1">
      <div class="solicitante">
    <b><?php echo strtoupper($cotizacion[0]->nombres." ".$cotizacion[0]->apellidos);?></b> 
  </div>
  <div class="empresa">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=strtoupper($cotizacion[0]->nombre)?></b> 
  </div>  
  </div>
  <div class="info2">
    <div class="codigo">
    <b><?=$cotizacion[0]->numero_oc?></b> 
  </div>
  <div class="fecha">
    <b><?=$cotizacion[0]->fecha?></b> 
  </div>  
  </div>
  
  
  <footer>
    <div class="cotizador">
    <b>Nombre del Cotizador: <?=strtoupper($cotizacion[0]->cotizador)?></b><br><br>
    <b>Phono: <?=strtoupper($cotizacion[0]->telefono)?></b> 
  </div>
  <div class="sello">
    <?php $image_sello = '/img/boreal_sello.png'; ?>
    <img src="{{ public_path() . $image_sello }}" class="footer">
  </div>
  <div class="firma">
    <?php $image_firma = '/img/boreal_firma.png'; ?>
    <img src="{{ public_path() . $image_firma }}" class="footer">
  </div>
    <?php $image_path2 = '/img/footer2.png'; ?>
        <img src="{{ public_path() . $image_path2 }}" width="793px" height="92px" class="footer">
    <!-- <hr>
    <p>
      <span style="float: left;">Dirección: <span style="text-transform: uppercase;">kkkkkkkkkkkkkkkkkkkkk</span></span>
      <span style="float: right;">Impreso por: <span style="text-transform: uppercase;">{!! \Auth::user()->name !!} | LogistCont v1.0.1.</span></span>
    </p><br>
    <p>
      <span style="float: left;">Contacto: <a href="#" style="text-decoration: none; color: black;">kkkkkkkkkkkkk</a></span><br>       
      <span class="page" style="float: right;">Página </span>
    </p> -->
    <span class="page" style="float: right; color: #FFFFFF; margin-top: 78px;">Página </span>
  </footer>
  
  <main style="margin-top: 40px !important;">
    @yield('main')
  </main>
  <div class="observaciones">
    <span>Observaciones</span>
    <ul>
      <li>Moneda Cotizada: <?=$cotizacion[0]->moneda?></li>
      <li>Forma de pago: Órden de compra fecha 30 días factura</li>
      <li>Vigencia de la oferta: <b>15 días</b></li>
      <li>Lugar de Entrega: <?=$cotizacion[0]->lugar_entrega?></li>
      <li>Valor Cotizado es Neto, no incluye IVA</li>
    </ul>
  </div>
  
</body>
</html>