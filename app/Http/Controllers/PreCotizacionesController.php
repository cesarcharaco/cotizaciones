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
use App\Models\DatosBoreal;
use App\Models\Item;
use App\Models\Historial;
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
            if (\Auth::getUser()->user_type=="Admin") {
                $precotizaciones=PreCotizaciones::all();
            } else {
                $cot=Cotizadores::where('id_usuario',\Auth::getUser()->id)->first();
                $precotizaciones=PreCotizaciones::where('cotizador',$cot->cotizador)->get();
            }
            
            return datatables()->of($precotizaciones)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="cotizaciones/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizacion" onClick="deleteCotizacion('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    $change_status = ' <a href="javascript:void(0);" id="change_status-cotizacion" onClick="changeStatusCotizacion('.$row->id.')" class="delete btn btn-info btn-xs"><i class="fa fa-bug"></i></a>';
                    if ($row->status=="En Espera") {
                        return $edit . $delete . $change_status;
                    }else{
                        return '<b>Procesando</b>';
                    }
                    
                    
                })
                ->editColumn('id_solicitante',function($row){
                    $sol=Solicitantes::find($row->id_solicitante);

                    $solicitante=$sol->nombres." ".$sol->apellidos;
                    return $solicitante;
                })
                ->rawColumns(['action'])
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
        
        $correlativo=Correlativos::where('status','Disponible')->count();
        if ($correlativo == 0) {
            $this->cargar_correlativos();
            Alert::warning('Alerta!!', 'No existen correlativos disponibles para la fecha, intente nuevamente')->persistent(true);
                return redirect()->to('/cotizaciones');
        } else {
           if (\Auth::getUser()->user_type=="Admin") {
            $id_usuario=0;
            } else {
                $id_usuario=\Auth::getUser()->id;
            }
            //do{
                $cot=Correlativos::where('status','No Disponible')->where('id_usuario',$id_usuario)->orderBy('id','DESC')->first();
                if (is_null($cot)) {
                    $cot=Correlativos::where('status','Disponible')->first();
                    $cot->status="No Disponible";
                    $cot->id_usuario=$id_usuario;
                    $cot->save();
                    $correlativo=$cot->numero_cotizacion;
                    /*Registro de historial de operaciones*/
                    $h=new Historial();
                    $h->id_usuario=$id_usuario;
                    $h->observacion="Asignación de número de cotización:".$correlativo;
                    $h->save();
                    /*-----------------------------------*/
                    
                } else {
                    $correlativo=$cot->numero_cotizacion;
                } 
                $buscar=PreCotizaciones::where('numero',$correlativo)->count();
                
                if ($buscar>0) {
                    $cot=Correlativos::where('status','Disponible')->first();
                    if (!is_null($cot)) {
                        $cot->status="No Disponible";
                        $cot->id_usuario=$id_usuario;
                        $cot->save();
                        $correlativo=$cot->numero_cotizacion;
                        /*Registro de historial de operaciones*/
                    $h=new Historial();
                    $h->id_usuario=$id_usuario;
                    $h->observacion="Asignación de número de cotización:".$correlativo;
                    $h->save();
                    /*-----------------------------------*/
                    } else {
                         Alert::warning('Alerta!!', 'No existen correlativos disponibles, intente otra vez')->persistent(true);
                        return redirect()->to('home');
                    }
                    
                }
            //}while($buscar > 0);
            $anio=date('Y');
            $empresas=Empresas::all();
            $cotizadores=Cotizadores::all();

            return view('cotizaciones.partials.create',compact('empresas','cotizadores','correlativo','anio'));
        }
        
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
        //dd($request->cargar_items);
        $buscar=PreCotizaciones::where('numero',$request->numero_cotizacion)->count();
        if ($buscar > 0) {
            # ya el numero fue registrado en una cotizacion
            Alert::warning('Alerta!!', 'Ya el número fue utilizado en una Cotización.')->persistent(true);
                return redirect()->to('cotizaciones');
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
                $solicitante=Solicitantes::find($request->solicitante1);
                $id_solicitante=$request->solicitante1;

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
            $pre_cotizacion->id_solicitante=$id_solicitante;
            $pre_cotizacion->cotizador=$cotizador->cotizador;
            $pre_cotizacion->moneda=$request->moneda;
            $pre_cotizacion->factura_boreal=$request->factura_boreal;
            $pre_cotizacion->fecha_entrega=$request->fecha_entrega;
            if (!is_null($request->cargar_items)) {
                $pre_cotizacion->status="Procesar";
            }
            $pre_cotizacion->save();
            
            

            //en caso de que la factura sea registrada
            if (is_null($request->cargar_items)) {
                Alert::success('Excelente!!', 'Cotización registrada con éxito.')->persistent(true);
                return redirect()->to('cotizaciones');     
            } else {
                //en caso de teer precios del proveedor se debe registrar la cotizacion para poder cargar los items
                $anio=date('Y');

                $cotizacion=new Cotizaciones();
                $cotizacion->fecha=date('Y-m-d');
                $cotizacion->numero_oc=$anio."-".$request->numero_cotizacion;
                $cotizacion->descripcion_general=$request->descripcion_general;
                $cotizacion->id_solicitante=$id_solicitante;
                $cotizacion->id_cotizador=$cotizador->id;
                $cotizacion->moneda=$request->moneda;
                $cotizacion->fecha_entrega=$request->fecha_entrega;
                $cotizacion->status="Pendiente";
                $cotizacion->status2="ERP/COTI";
                $cotizacion->save();

                Alert::success('Excelente!!', 'Cotización registrada con éxito, Proceda a cargar los items.')->persistent(true);
                return redirect()->to('cotizaciones/'.$cotizacion->id.'/agregar_items');     
            }
            
            
            
        }//cierre primer condicional            
    }//cierre de la funcion

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
    }

    public function definitivas()
    {

        if(request()->ajax()) {
            if (\Auth::getUser()->user_type=="Admin") {
                $cotizaciones=\DB::table('cotizaciones')
            ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
            ->join('empresas','empresas.id','=','solicitantes.id_empresa')
            ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
            ->select('cotizaciones.*','empresas.nombre','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')->get();
            } else {
                $cot=Cotizadores::where('id_usuario',\Auth::getUser()->id)->first();
                $cotizaciones=\DB::table('cotizaciones')
                ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
                ->join('empresas','empresas.id','=','solicitantes.id_empresa')
                ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
                ->where('id_cotizador',$cot->id)
                ->select('cotizaciones.*','empresas.nombre','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')->get();
            }
            

            return datatables()->of($cotizaciones)
                ->addColumn('action', function ($row) {
                    $agregar_item = '<a href="../cotizaciones/'.$row->id.'/agregar_items" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-plus"></i></a>';
                    $enviar = '<a href="../cotizaciones/'.$row->id.'/preparar_envio" data-id="'.$row->id.'" class="btn btn-success btn-xs" id="ParaEnviarCotizacion"><i class="fa fa-envelope"></i></a>';
                    $ver_datos= ' <a href="javascript:void(0);" id="ver_datos_boreal" onClick="verDatosBoreal('.$row->id.')" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>';

                    $change_status = ' <a href="javascript:void(0);" id="change_status-cotizacion" onClick="changeStatusCotizacion('.$row->id.')" class="delete btn btn-info btn-xs"><i class="fa fa-bug"></i></a>';
                    $descargar='<a href="../cotizaciones/'.$row->id.'/generar_reporte_envio" target="_blank" class="btn btn-primary btn-xs" title="Descarga el pdf para enviarlo por correo electronico"><i class="fas fa-download"></i></a>';
                    if ($row->status2=="ERP/COTI") {
                        
                        return $agregar_item;    
                        
                    }
                    if ($row->status2=="Lista para Contestar") {
                        return $enviar;
                    }
                    if ($row->status2=="En Análisis") {
                        return $change_status." ".$descargar;
                    }
                    if ($row->status2=="En Proceso de Compra") {
                        return $enviar;
                    }
                    if ($row->status2=="Finalizada") {
                        # code...
                    }
                    
                    if($row->status2=="Entrega Parcial" ){
                        return $ver_datos;
                    }
                    if($row->status2=="Entrega Completa" ){
                        return $ver_datos;
                    }
                    
                    
                    //return $agregar_item;
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
        $id_cotizacion=intval($id_cotizacion);
        $cotizacion=Cotizaciones::find($id_cotizacion);
        $datosboreal=DatosBoreal::where('id_cotizacion',$id_cotizacion)->get();
        //dd($cotizacion);
        $categorias=Categorias::all();
        $tasas=Tasas::where('status','Activa')->where('moneda',$cotizacion->moneda)->first();
        $tasaiva=TasaIva::where('status_i','Activa')->first();
        $items2=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select(\DB::raw('sum(items.total_pp) AS monto_total'))->first();
        if (is_null($items2)) {
            $monto_total=0;
        } else {
            $monto_total=$items2->monto_total;
        }
        $productos1=Productos::where('status','Activo')->get();
        $id_producto=array();
        foreach ($productos1 as $key) {
            $id_producto[]=$key->id;
        }
        
        $items3=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select('items.id_producto')->get();
            
            $id_producto2=array();
            $id_producto3=array();
        if (count($items3) > 0) {
            foreach ($items3 as $key) {
                $id_producto2[]=$key->id_producto;
            }
            $id_producto3=array_diff($id_producto, $id_producto2);

        
            $productos=Productos::where('status','Activo')->whereIn('id',$id_producto3)->get();
        } else {
            $productos=Productos::where('status','Activo')->whereIn('id',$id_producto)->get();
        }
        
        //dd($productos);
        if(request()->ajax()) {
            
            $items=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select('items.*','productos.detalles')->get();


            return datatables()->of($items)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editItem"  onClick="editCotizacion('.$row->id.')"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizacion" onClick="deleteItemCotizacion('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
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
                ->rawColumns(['url','action'])
                ->addIndexColumn()
                ->make(true);
            }
        if(is_null($tasas) || is_null($tasaiva)){
            Alert::warning('Alerta!!', 'No se pueden Agregar items miemtras no exista una Tasa de la moneda de la Cotización y/o Tasa de IVA activa')->persistent(true);
            return redirect()->to('cotizaciones');
        }else{

            return view('cotizaciones.partials.agregar_items',compact('cotizacion','productos','tasas','tasaiva','categorias','monto_total','datosboreal'));
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
    
    public function cambiar_status(Request $request)
    {
        

        $buscar=PreCotizaciones::find($request->id);
        if ($buscar->status=="En Espera") {
            $buscar->status="Procesar";
        } else {
            $buscar->status="En Espera";
        }
        $buscar->save();

        $anio=substr($buscar->fecha,0,4);
        $cotizador=Cotizadores::where('cotizador',$buscar->cotizador)->first();
        $buscar2=Cotizaciones::where('numero_oc',$anio."-".$buscar->numero)->count();
        if($buscar2 == 0){
            $cotizacion=new Cotizaciones();
            $cotizacion->fecha=$buscar->fecha;
            $cotizacion->numero_oc=$anio."-".$buscar->numero;
            $cotizacion->descripcion_general=$buscar->descripcion_general;
            $cotizacion->id_solicitante=$buscar->id_solicitante;
            $cotizacion->id_cotizador=$cotizador->id;
            $cotizacion->moneda=$buscar->moneda;
            $cotizacion->fecha_entrega=$buscar->fecha_entrega;
            
            $cotizacion->save();
            
        }

        return response()->json(['message' => 'La cotización está lista para procesar, puede dirigirse a la Lista de Definidas para continuar con el proceso','icono' => 'success', 'titulo' => 'Éxito']);
                //guardando pdfs
        //gb
        

    }
    public function registrar(Request $request)
    {
        
        $buscar_items=Item::where('id_cotizacion',$request->id_cotizacion)->count();
        if ($buscar_items > 0) {
            if (!is_null($request->oc_recibida)) {
                $buscar=Cotizaciones::where('oc_recibida',$request->oc_recibida)->where('id','<>',$request->id_cotizacion)->count();
                $encontrada=$buscar;
            } else {
                $encontrada=0;
            }
            if($encontrada==0){
                
                $cotizacion=Cotizaciones::find($request->id_cotizacion);
                $cotizacion->valor_total=$request->valor_total;
                $cotizacion->oc_recibida=$request->oc_recibida;
                $cotizacion->fecha_entrega=$request->fecha_entrega;
                $mensaje="";
                if(!is_null($request->oc_recibida) || !is_null($request->cargar_datosb)){
                    $cotizacion->status="Adjudicada";
                    $cotizacion->status2="En Proceso de Compra";
                    $status="En Proceso de Compra";
                    $mensaje.="considerando que ya posee la información:";

                }else{
                    $cotizacion->status="Pendiente";
                    $cotizacion->status2="Lista para Contestar";
                    $status="Lista para Contestar";
                }
                $cotizacion->save();
                if (!is_null($request->cargar_datosb)) {
                    $mensaje.=" - Guía y Órden de Compra Boreal";
                }
                if (!is_null($request->oc_recibida) ){
                    $mensaje.=" - OC Recibida";
                }
                
                //dd($mensaje);
                if (is_null($request->cargar_datosb) && is_null($request->oc_recibida)) {
                    Alert::success('Excelente!!', 'Items registrados y cambio de status a '.$status)->persistent(true);
                        return redirect()->to('cotizaciones/definitivas');
                } else {
                    

                    Alert::success('Excelente!!', 'Items registrados y cambio de status a '.$status.",".$mensaje.". Proceda a indicar los productos a entregar.")->persistent(true);

                        return redirect()->to('cotizaciones/'.$cotizacion->id.'/preparar_envio');
                }
            }else{
                Alert::warning('Alerta!!', 'La Órden Recibida ya ha sido registrada, verifique')->persistent(true);
                    return redirect()->back();    
            }
        } else {
            Alert::warning('Alerta!!', 'No se han cargado Items para la cotización')->persistent(true);
                    return redirect()->back();
        }
        
        
    }

    public function preparar_envio($id_cotizacion)
    {
        
        $cotizacion=Cotizaciones::find($id_cotizacion);
        $items=Item::where('id_cotizacion',$id_cotizacion)->get();
        $i=1;
        $datosboreal=DatosBoreal::where('id_cotizacion',$cotizacion->id)->get();
        if(request()->ajax()) {
            
            $items=\DB::table('items')
            ->join('productos','productos.id','=','items.id_producto')
            ->join('cotizaciones','cotizaciones.id','=','items.id_cotizacion')
            ->where('items.id_cotizacion',$id_cotizacion)
            ->select('items.*','productos.detalles','cotizaciones.status2')->get();


            return datatables()->of($items)
                ->addColumn('enviado', function ($row) {
                    if ($row->status2=="Lista para Contestar") {
                        $enviado='<input type="hidden" name="enviado[]" id="enviado'.$row->id.'" class="form-control" >';
                    } else {
                        $enviado='<select name="enviado[]" id="enviado'.$row->id.'" class="form-control" title="Seleccione si va enviar éste producto">
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                              </select>';
                    }
                    
                    
                    return $enviado;
                })
                ->addColumn('cant_enviado', function($row)
                {
                    if ($row->status2=="Lista para Contestar") {
                        $cant_enviado='<input type="hidden" min="1" max="'.$row->cant.'" name="cant_enviado[]" id="cant_enviado<'.$row->id.'" value="'.$row->cant.'" class="form-control input-sm"><input type="hidden" name="id_producto[]" value="'.$row->id.'" >';
                    } else {
                        $cant_enviado='<input type="number" min="1" max="'.$row->cant.'" name="cant_enviado[]" id="cant_enviado<'.$row->id.'" value="'.$row->cant.'" class="form-control input-sm"><input type="hidden" name="id_producto[]" value="'.$row->id.'" >';
                    }
                    

                    return $cant_enviado;
                })
                ->addColumn('imagen', function ($row) {
                    $buscar=Imagenes::where('id_producto',$row->id_producto)->first();
                    if (is_null($buscar)) {
                        $url="No registrada";
                    } else {
                        $url=$buscar->url;
                    }
                    return $url;
                })
                ->rawColumns(['enviado','cant_enviado','imagen'])
                ->addIndexColumn()
                ->make(true);
            }

        return view('cotizaciones.partials.preparar_envio',compact('cotizacion','items','i','datosboreal'));           
    }
    
    protected function generarCodigo() {
     $key = '';
     $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $max = strlen($pattern)-1;
     for($i=0;$i < 4;$i++){
        $key .= $pattern=mt_rand(0,$max);
    }
     return $key;
    }
    public function rechazar_codigo(Request $request)
    {
        //dd($request->numero);

        \DB::table('correlativos_cotizaciones')
                ->where('numero_cotizacion', $request->numero)
                ->update(['status' => 'Disponible','id_usuario' => NULL]);
        Alert::success('Excelente!!', 'Número de Cotización Disponible Nuevamente')->persistent(true);
        $h=new Historial();
        $h->id_usuario=\Auth::getUser()->id;
        $h->observacion="Rehazo de código: (".$request->numero.") MOTIVO: ".$request->observacion;
        $h->save();
                return redirect()->back();
    }

    public function en_espera()
    {
        if(request()->ajax()) {
            if (\Auth::getUser()->user_type=="Admin") {
                $precotizaciones=PreCotizaciones::where('status','En Espera')->get();
            } else {
                $cot=Cotizadores::where('id_usuario',\Auth::getUser()->id)->first();
                $precotizaciones=PreCotizaciones::where('status','En Espera')->where('cotizador',$cot->cotizador)->get();
            }
            
            return datatables()->of($precotizaciones)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="cotizaciones/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizacion" onClick="deleteCotizacion('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    $change_status = ' <a href="javascript:void(0);" id="change_status-cotizacion" onClick="changeStatusCotizacion('.$row->id.')" class="delete btn btn-info btn-xs"><i class="fa fa-bug"></i></a>';
                    if ($row->status=="En Espera") {
                        return $edit . $delete . $change_status;
                    }else{
                        return '<b>Procesando</b>';
                    }
                    
                    
                })
                ->editColumn('id_solicitante',function($row){
                    $sol=Solicitantes::find($row->id_solicitante);

                    $solicitante=$sol->nombres." ".$sol->apellidos;
                    return $solicitante;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function en_proceso()
    {
        
        if(request()->ajax()) {
            if (\Auth::getUser()->user_type=="Admin") {
                $cotizaciones=\DB::table('cotizaciones')
                            ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
                            ->join('empresas','empresas.id','=','solicitantes.id_empresa')
                            ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
                            ->where(function($query){
                                $query->where('cotizaciones.status2','ERP/COTI')
                                ->orWhere('cotizaciones.status2','En Análisis')
                                ->orWhere('cotizaciones.status2','En Proceso de Compra');
                            })
                            ->select('cotizaciones.*','empresas.nombre','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')->get();
            } else {
                $cot=Cotizadores::where('id_usuario',\Auth::getUser()->id)->first();
                $cotizaciones=\DB::table('cotizaciones')
                        ->join('solicitantes','solicitantes.id','=','cotizaciones.id_solicitante')
                        ->join('empresas','empresas.id','=','solicitantes.id_empresa')
                        ->join('cotizadores','cotizadores.id','=','cotizaciones.id_cotizador')
                        ->where(function($query){
                            $query->where('cotizaciones.status2','ERP/COTI')
                            ->orWhere('cotizaciones.status2','En Análisis')
                            ->orWhere('cotizaciones.status2','En Proceso de Compra');
                        })
                        ->where('cotizaciones.id_cotizador',$cot->id)
                        ->select('cotizaciones.*','empresas.nombre','solicitantes.nombres','solicitantes.apellidos','cotizadores.cotizador')->get();
            }
            

            return datatables()->of($cotizaciones)
                ->addColumn('action', function ($row) {
                    $agregar_item = '<a href="../cotizaciones/'.$row->id.'/agregar_items" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizacion"><i class="fa fa-plus"></i></a>';
                    $enviar = '<a href="../cotizaciones/'.$row->id.'/preparar_envio" data-id="'.$row->id.'" class="btn btn-success btn-xs" id="ParaEnviarCotizacion"><i class="fa fa-envelope"></i></a>';
                    $ver_datos= ' <a href="javascript:void(0);" id="ver_datos_boreal" onClick="verDatosBoreal('.$row->id.')" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>';
                    /*if ($row->status=="Pendiente" && $row->status2=="ERP/COTI") {
                        
                        return $agregar_item;    
                        
                    } else {
                        if($row->status2=="Entrega Parcial" || $row->status2=="Entrega Completa" || $row->status2=="Finalizada"){
                        return $ver_datos;
                        }else{
                            if($status2=="Lista para Contestar"){
                                return $enviar;
                            }
                        }
                    }*/
                    
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
    }

    public function registrar_respuesta(Request $request)
    {
        //dd($request->all());
        
        $buscar=Cotizaciones::where('oc_recibida',$request->oc_recibida)->where('id','<>',$request->id_cotizacion)->count();
        if ($buscar == 0) {
            $buscar2=DatosBoreal::where('guia_boreal',$request->guia_boreal)->where('id_cotizacion','<>',$request->id_cotizacion)->count();
            if ($buscar2 == 0) {
                $buscar3=DatosBoreal::where('oc_boreal',$request->oc_boreal)->where('id_cotizacion','<>',$request->id_cotizacion)->count();
                if ($buscar3 == 0) {
                    $cot=Cotizaciones::find($request->id_cotizacion);
                    $cot->oc_recibida=$request->oc_recibida;
                    $cot->fecha_entrega=$request->fecha_entrega;
                    $cot->valor_total=$request->valor_total;
                    $cot->lugar_entrega=$request->lugar_entrega;
                    
                    //registrando datos boreales
                    $datosboreal= new DatosBoreal();
                    $datosboreal->id_cotizacion=$request->id_cotizacion;
                    $datosboreal->guia_boreal=$request->guia_boreal;
                    $datosboreal->fecha_gb=$request->fecha_gb;
                    $datosboreal->oc_boreal=$request->oc_boreal;
                    $datosboreal->fecha_ocb=$request->fecha_ocb;

                    //registrando pdf de guia boreal
                    $codigo=$this->generarCodigo();
                    $url_pdf_gb=$request->file('url_pdf_gb');
                    $name_gb=$codigo."_".$url_pdf_gb->getClientOriginalName();
                    $url_pdf_gb->move(public_path().'/pdfs', $name_gb);  
                    $url_gb ='pdfs/'.$name_gb;
                    $datosboreal->nombre_pdf_gb=$name_gb;
                    $datosboreal->url_pdf_gb=$url_gb;
                    //registrando pdf de oc boreal
                    $codigo=$this->generarCodigo();
                    $url_pdf_ocb=$request->file('url_pdf_ocb');
                    $name_ocb=$codigo."_".$url_pdf_ocb->getClientOriginalName();
                    $url_pdf_ocb->move(public_path().'/pdfs', $name_ocb);  
                    $url_gb ='pdfs/'.$name_ocb;
                    $datosboreal->nombre_pdf_ocb=$name_ocb;
                    $datosboreal->url_pdf_ocb=$url_gb;

                    $datosboreal->save();
                    //-------------------------------------
                    //actualizando registros de cantidades en los items
                    $items=Item::where('id_cotizacion',$request->id_cotizacion)->get();
                    $i=0;
                    $cont=0;//contador para saber si se estan enviando los que se registraron
                    $cont2=0;//contador para saber cuantos se desean enviar
                    //dd($items);
                    foreach ($items as $key) {
                        if ($key->id_producto==$request->id_producto[$i] && $key->cant!=$request->cant_enviado[$i]) {
                            //contando si al menos uno de ellos varia
                            $cont++;
                        }
                        if ($key->id_producto==$request->id_producto[$i] && $request->enviado[$i]=="Si") {
                            //contando si van a ser enviados
                            $key->enviado=$request->enviado[$i];
                            $key->cant_enviado=$request->cant_enviado[$i];
                            $key->save();
                        }else{
                            $key->enviado=$request->enviado[$i];
                            $key->cant_enviado=$request->cant_enviado[$i];
                            $key->save();
                            $cont++;
                        }
                        $i++;  
                    }

                    if ($cot->status2=="Lista para Contestar") {
                        $cot->status="Contestada";
                        $status2="En Análisis";
                        $mensaje="La Cotización ha sido preparada para ser enviada en PDF al solicitante, y la misma quedará en Análisis para poder enviar los Items";
                    } else {
                        if ($cot->status2=="En Proceso de Compra") {
                            if ($cont!=0 || $cont2!=0) {
                                
                            $status2="Entrega Parcial";
                            $mensaje="La Cotización ha sido preparada para enviar PDF con Items , sin embargo no se han enviado todos los solicitados, la misma pasará a status: Entrega Parcial";
                            } else {
                                
                                if ($cont==0 || $cont2==0) {
                                    $status2="Entrega Completa";
                                    $mensaje="La Cotización ha sido preparada para enviar PDF con Items, la misma pasará a status: Entrega Completa, solo a espera de la Factura Boreal";
                                }
                            }
                        }
                    }
                    
                    
                    $cot->status2=$status2;
                    $cot->save();

                    Alert::success('Éxito!!', $mensaje)->persistent(true);
                    return redirect()->to('cotizaciones/definitivas');
                } else {
                    Alert::warning('Alerta!!', 'La Órden Boreal ya ha sido registrada, verifique')->persistent(true);
                    return redirect()->to('cotizaciones/definitivas');    
                }
            } else {
                Alert::warning('Alerta!!', 'La Guía Boreal ya ha sido registrada, verifique')->persistent(true);
                    return redirect()->to('cotizaciones/definitivas');    
            }
        } else {
            Alert::warning('Alerta!!', 'La Órden Recibida ya ha sido registrada, verifique')->persistent(true);
                    return redirect()->to('cotizaciones/definitivas');    
        }
        
    }

    public function contestada($id_cotizacion)
    {
        $cotizacion=Cotizaciones::find($id_cotizacion);
        $cotizacion->status="Contestada";
        $cotizacion->status2="En Análisis";
        $cotizacion->save();

        $c=Cotizaciones::where('id',$id_cotizacion)->get();

        return response()->json(['message' => 'La cotización fue contestada y ahora se encuentra en Análisis, en espera de respuesta del cliente','icono' => 'success', 'titulo' => 'Éxito']);

    }

    public function status(Request $request)
    {

        $cot=Cotizaciones::find($request->id_cotizacion);
        if ($request->status=="Adjudicada") {
            $cot->status=$request->status;
            $cot->status2="En Proceso de Compra";

        } else {
            $cot->status=$request->status;
            $cot->status2="Finalizada";
        }
        $cot->save();
        $h=new Historial();
        $h->id_usuario=\Auth::getUser()->id;
        $h->id_cotizacion=$request->id_cotizacion;
        $h->observacion=$request->observacion;
        $h->save();

        return response()->json(['message' => 'La cotización ha recibido status de '.$request->status,'icono' => 'success', 'titulo' => 'Éxito']);
    }
}
