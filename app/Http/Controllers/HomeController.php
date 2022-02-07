<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correlativos;
use App\Models\PreCotizaciones;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hoy=date('Y-m-d');
        $buscar=Correlativos::all();
        if (count($buscar) == 0) {
            $inicio=8516;
            //generando numeros
            for ($i=1; $i <= 26 ; $i++) { 
                $correlativo=new Correlativos();
                $correlativo->numero_cotizacion=$inicio+$i;
                $correlativo->fecha=$hoy;
                $correlativo->save();
            }
        }else{
            $buscar=Correlativos::where('status','Disponible')->count();
            if($buscar==0){
                $cot=Correlativos::orderBy('id','DESC')->first();
                for ($i=1; $i <= 26 ; $i++) { 
                $correlativo=new Correlativos();
                $correlativo->numero_cotizacion=$cot->numero_cotizacion+$i;
                $correlativo->fecha=$hoy;
                $correlativo->save();
            }

            }else{
                if ($buscar <= 6) {
                    $fin=26-$buscar;
                    $cot=Correlativos::orderBy('id','DESC')->first();
                    for ($i=1; $i <= $fin ; $i++) { 
                        $correlativo=new Correlativos();
                        $correlativo->numero_cotizacion=$cot->numero_cotizacion+$i;
                        $correlativo->fecha=$hoy;
                        $correlativo->save();
                    }
                }

            }
        }
        
        return view('home');
    }
}
