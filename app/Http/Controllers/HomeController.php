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
        $buscar1=Correlativos::all();
        if (count($buscar1)==0) {
            $c=new Correlativos();
            $c->numero_cotizacion=8516;
            $c->fecha="2022-01-18";
            $c->save();
        }
        $buscar=Correlativos::where('fecha',$hoy)->count();
        if ($buscar == 0) {
            
            $cot=Correlativos::orderBy('id','DESC')->first();
            if(is_null($cot)){
                $inicio=0;
            }else{
                $inicio=$cot->numero_cotizacion;
            }
            //generando numeros
            for ($i=1; $i <= 26 ; $i++) { 
                $correlativo=new Correlativos();
                $correlativo->numero_cotizacion=$inicio+$i;
                $correlativo->fecha=$hoy;
                $correlativo->save();
            }
        }
        
        return view('home');
    }
}
