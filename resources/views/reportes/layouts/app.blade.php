<html>
<head>
  @yield('title')
  <style>
    @page {
      margin: 0cm 1cm;
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
        <?php $image_path = '/img/banner_pdf.png'; ?>
        <img src="{{ public_path() . $image_path }}" class="logo">
      </td>
      <td align="right">
        <!-- <b>
          Reporte de Envio <br>
          Boreal<br>
          mmmmmmmmmmmmmmmmm<br>
          NIT: 222222222222222<br>
          Fecha: <?php //echo date('d/m/Y g:i:s A'); ?>
        </b> -->
      </td>
    </tr>
  </table>
  <footer>
    <?php $image_path2 = '/img/footer.png'; ?>
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
  
  <main style="margin-top: 170px !important;">
    @yield('main')
  </main>
</body>
</html>