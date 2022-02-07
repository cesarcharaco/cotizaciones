<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Imagenes;
use App\Models\Solicitantes;
use App\Models\Cotizadores;
use App\Models\User;
use App\Models\PreCotizaciones;
use App\Models\Cotizaciones;
use App\Models\Item;
use App\Models\Tasas;
use App\Models\TasaIva;
use PDF;
use Alerts;
class ReportesController extends Controller
{
    public function generar_reporte_envio($id_cotizacion)
    {
    	dd($id_cotizacion);
    }
}
