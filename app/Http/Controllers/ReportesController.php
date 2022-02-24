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
ini_set('max_execution_time', '3600');
class ReportesController extends Controller
{
    public function generar_reporte_envio($id_cotizacion)
    {
    	//dd($id_cotizacion);
        $cot=Cotizaciones::find($id_cotizacion);
        if ($cot->status2=='Lista para Contestar') {
            $cot->status="Contestada";
            $cot->status2="En Análisis";
            $cot->save();
        }
        
        $cotizacion=\DB::table('cotizaciones')
                    ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
                    ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
                    ->where('cotizaciones.id','=',$id_cotizacion)
                    ->select('cotizaciones.*','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')
                    ->get();
        $items=\DB::table('items')
                ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
                ->join('productos','productos.id','=','items.id_producto')
                ->where('items.id_cotizacion',$id_cotizacion)
                ->select('items.*','productos.detalles')
                ->get();
        //dd($cotizacion);

    	/*$pdf = PDF::loadView('reports/pdf/advertising', array('advertising'=>$advertising));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('advertising-'.date('d-m-Y').'.pdf');*/
        $pdf = PDF::loadView('reportes/envio', array('cotizacion'=>$cotizacion,'items' => $items));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('ReporteCotizacion-'.date('d-m-Y').'.pdf');
    }
}
