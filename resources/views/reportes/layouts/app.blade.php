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
      margin-bottom: 2cm
      margin-left: 0cm;
      margin-right: 0cm;
    }
    .logo {
      position: absolute;
      width: 210px;
      height: 150px;
      top: -40px;
    }
     /** Definir las reglas del pie de página **/
    footer {
      position: fixed; 
      bottom: 0cm; 
      left: 0cm; 
      right: 0cm;
      height: 2cm;
      line-height: 5px;
      page-break-after: never;
      font-size: 12px;
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
  </style>
  @yield('css')
<body>
  @yield('title-report')
  <table width="100%">
    <tr>
      <td valign="top">
        <?php $image_path = '/img/boreal.png'; ?>
        <img src="{{ public_path() . $image_path }}" class="logo">
      </td>
      <td align="right">
        <b>
          {!! $title !!}<br>
          {!! setting_company()->company_name !!}<br>
          {!! setting_company()->name_optional !!}<br>
          NIT: {!! setting_company()->registry_number !!}<br>
          Fecha: <?php echo date('d/m/Y g:i:s A'); ?>
        </b>
      </td>
    </tr>
  </table>
  <footer>
    <hr>
    <p>
      <span style="float: left;">Dirección: <span style="text-transform: uppercase;">{!! setting_company()->municipalities->departments->department !!}, {!! setting_company()->municipalities->municipality !!}, {!! setting_company()->countries->name !!}.</span></span>
      <span style="float: right;">Impreso por: <span style="text-transform: uppercase;">{!! \Auth::user()->username !!} | LogistCont v1.0.1.</span></span>
    </p><br>
    <p>
      <span style="float: left;">Contacto: <a href="#" style="text-decoration: none; color: black;">{!! setting_company()->email !!}</a></span><br>       
      <span class="page" style="float: right;">Página </span>
    </p>
  </footer>
  
  <main>
    @yield('main')
  </main>
</body>
</html>