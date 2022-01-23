<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreCotizaciones;
use App\Models\Empresas;
use App\Models\Cotizadores;
use App\Models\Correlativos;
use App\Models\Solicitantes;
use App\Models\Cotizaciones;
use App\Models\Productos;
use App\Models\Tasas;
use App\Models\TasaIva;
use App\Models\Categorias;
use App\Models\Imagenes;
use Alert;
//use Datatables;
class PreCotizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request()->ajax()) {
            $precotizaciones=PreCotizaciones::all();
            return datatables()->of($precotizaciones)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="cotizaciones/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizacion" onClick="deleteCotizacion('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('cotizaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hoy=date('Y-m-d');
        $cot=Correlativos::where('status','No Disponible')->where('fecha',$hoy)->get();
        if (count($cot) > 0) {
            foreach ($cot as $c) {
            $buscar=Correlativos::where('numero_cotizacion',$c->numero_cotizacion)->count();
                if ($buscar ==0) {
                    $c->status="Disponible";
                    $c->id_usuario=0;
                    $c->save();
                }
            }
        }else{
            $this->cargar_correlativos();
        }
        

        do{
            $cot=Correlativos::where('status','Disponible')->where('fecha',$hoy)->first();
            if(is_null($cot)){ 
                $correlativo=0; 
                $pre_cot=0;
            }else{
                $correlativo=$cot->numero_cotizacion;
                $pre_cot=PreCotizaciones::where('id',$correlativo)->count();    
            }
        }while($pre_cot > 0);
        $cot2=Correlativos::where('numero_cotizacion',$correlativo)->first();
        $cot2->status="No Disponible";
        $cot2->id_usuario=\Auth::getUser()->id;
        $cot2->save();
        $anio=date('Y');
        $empresas=Empresas::all();
        $cotizadores=Cotizadores::all();
        return view('cotizaciones.partials.create',compact('empresas','cotizadores','correlativo','anio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $buscar=PreCotizaciones::where('numero',$request->numero_cotizacion)->count();
        if ($buscar > 0) {
            # ya el numero fue registrado en una cotizacion
        } else {
            # se puede registrar la cotizacion
            
            if (!is_null($request->empresa1)) {
                # si no es nulo la empresa seleccionada es de las registradas
                $empresa=Empresas::where('nombre',$request->empresa)->first();
                $id_empresa=$empresa->id;
            } else {
                # si es nulo entonces se registra la empresa
                $empresa=new Empresas();
                $empresa->nombre=$request->empresa;
                $empresa->save();
                $id_empresa=$empresa->id;
            }

            if (!is_null($request->solicitante1)) {
                # si no es nulo el solicitante seleccionado es de los registrados
                $id_solicitante=$request->solicitante1;
                $solicitante=Solicitantes::find($request->solicitante1);

            } else {
                $solicitante=new Solicitantes();
                $solicitante->nombres=$request->solicitante;
                $solicitante->id_empresa=$id_empresa;
                $solicitante->save();
                $id_solicitante=$solicitante->id;
            }
            
            $cotizador=Cotizadores::where('id_usuario',$request->cotizador)->first();
            //registrando precotizacion
            
            $pre_cotizacion=new PreCotizaciones();
            $pre_cotizacion->fecha=date('Y-m-d');
            $pre_cotizacion->numero=$request->numero_cotizacion;
            $pre_cotizacion->descripcion_general=$request->descripcion_general;
            $pre_cotizacion->empresa=$empresa->nombre;
            $pre_cotizacion->solicitante=$solicitante->nombres." ".$solicitante->apellidos;
            $pre_cotizacion->cotizador=$cotizador->cotizador;
            $pre_cotizacion->moneda=$request->moneda;
            $pre_cotizacion->oc_recibida=$request->oc_recibida;
            $pre_cotizacion->valor_total=$request->valor_total;
            $pre_cotizacion->guia_boreal=$request->guia_boreal;
            $pre_cotizacion->factura_boreal=$request->factura_boreal;
            $pre_cotizacion->fecha_entrega=$request->fecha_entrega;
            $pre_cotizacion->oc_boreal=$request->oc_boreal;
            $pre_cotizacion->save();
            //registrando cotizacion
            $cotizacion=new Cotizaciones();
            $cotizacion->fecha=date('Y-m-d');
            $cotizacion->numero_oc=$request->numero_oc;
            $cotizacion->descripcion_general=$request->descripcion_general;
            $cotizacion->id_solicitante=$id_solicitante;
            $cotizacion->id_cotizador=$cotizador->id;
            $cotizacion->moneda=$request->moneda;
            $cotizacion->oc_recibida=$request->oc_recibida;
            $cotizacion->valor_total=$request->valor_total;
            $cotizacion->guia_boreal=$request->guia_boreal;
            $cotizacion->factura_boreal=$request->factura_boreal;
            $cotizacion->fecha_entrega=$request->fecha_entrega;
            $cotizacion->oc_boreal=$request->oc_boreal;
            $cotizacion->save();

            Alert::success('Excelente!!', 'Cotización registrada con éxito.')->persistent(true);
                return redirect()->to('cotizaciones');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cargar_correlativos()
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
    }

    public function definitivas()
    {

        if(request()->ajax()) {
            $cotizaciones=\DB::table('cotizaciones')
            ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
            ->join('empresas','empresas.id','=','solicitantes.id_empresa')
            ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
            ->select('cotizaciones.*','empresas.nombre','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')->get();

            return datatables()->of($cotizaciones)
                ->addColumn('action', function ($row) {
                    $agregar_item = '<a href="../cotizaciones/'.$row->id.'/agregar_items" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-plus"></i></a>';
                    
                    return $agregar_item;
                })->rawColumns(['action'])
                ->editColumn('id_solicitante',function($row){
                    $solicitante=$row->nombres." ".$row->apellidos;
                    return $solicitante;
                })
                ->editColumn('id_cotizador',function($row){
                    $cotizador=$row->cotizador;
                    return $cotizador;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('cotizaciones.definitivas');
    }

    public function agregar_items($id_cotizacion)
    {
        /*$items=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select('items.*','productos.detalles')->get();
            dd($items);*/
       if(request()->ajax()) {
            
            $items=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select('items.*','productos.detalles')->get();


            return datatables()->of($items)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="cotizaciones/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizacion" onClick="deleteCotizacion('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })
                ->addColumn('url', function ($row) {
                    $buscar=Imagenes::where('id_producto',$row->id_producto)->first();
                    if (is_null($buscar)) {
                        $url="No registrada";
                    } else {
                        $url=$buscar->url;
                    }
                    return $url;
                })
                ->rawColumns(['action','url'])
                ->addIndexColumn()
                ->make(true);
            }
        $cotizacion=Cotizaciones::find($id_cotizacion);
        $categorias=Categorias::all();
        $productos=Productos::where('status','Activo')->get();
        $tasas=Tasas::where('status','Activa')->where('moneda',$cotizacion->moneda)->first();
        $tasaiva=TasaIva::where('status_i','Activa')->first();
        if(is_null($tasas) || is_null($tasaiva)){
            Alert::warning('Alerta!!', 'No se pueden Agregar items miemtras no exista una Tasa de la moneda de la Cotización y/o Tasa de IVA activa')->persistent(true);
            return redirect()->to('cotizaciones');
        }else{

            return view('cotizaciones.partials.agregar_items',compact('cotizacion','productos','tasas','tasaiva','categorias'));
        }
    }

    public function calcular_item(Request $request)
    {
        $tasa=Tasas::where('moneda',$request->moneda)->where('status','Activa')->first();
        $tasaiva=TasaIva::where('status_i','Activa')->first();
       
        //precio con iva
        $pp_ci=$tasa->tasa*$request->pda;
        //precio sin iva
        $pp_si=$pp_ci/(1+($tasaiva->tasa_i/100));
        //traslado por unidad
        if ($request->cant==0) {
            $traslado_x_und=0;
        } else {
            $traslado_x_und=$request->traslado/$request->cant;
        }
        $porc=$request->porc_uti/100;
        //precio unitario
        $precio_unit=($pp_si*(1+$porc))+$traslado_x_und;
        //total por producto
        $total_pp=$precio_unit*$request->cant;
        //uti por und
        $uti_x_und=$precio_unit-$pp_ci;
        //uti total de items
        $uti_x_total_p=$uti_x_und*$request->cant;
        //boreal
        $boreal=$uti_x_total_p;

        $datos=array();
        $precio_unit=round($precio_unit,2);
        $total_pp=round($total_pp,2);
        $pp_ci=round($pp_ci,2);
        $pp_si=round($pp_si,2);
        $uti_x_und=round($uti_x_und,2);
        $uti_x_total_p=round($uti_x_total_p,2);
        $boreal=round($boreal,2);

        $datos[0]=$precio_unit;
        $datos[1]=$total_pp;
        $datos[2]=$pp_ci;
        $datos[3]=$pp_si;
        $datos[4]=$uti_x_und;
        $datos[5]=$uti_x_total_p;
        $datos[6]=$boreal;

        return $datos;

    }
    
}
