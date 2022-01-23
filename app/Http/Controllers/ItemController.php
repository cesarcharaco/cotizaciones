<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\Imagenes;
use App\Models\TasaDolar;
use App\Models\TasaIva;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //varificamos si seleccionó un producto del banco
        if(is_null($request->productos)){
            //si no seleccionó uno del banco
            $categoria=Categorias::find($request->id_categoria);
            $cat=substr($categoria->categoria, 0,3);
            //codigo aleatorio de 4 digitos
            $cod=$this->generarCodigo();
            //$codigo=$fecha.$cat.$cod;
            $codigo=$cat.$cod;
            $producto= new Productos();
            $producto->codigo=$codigo;
            $producto->detalles=$request->descripcion;
            $producto->id_categoria=$request->id_categoria;
            $producto->save();
            $id_producto=$producto->id;

            $imagenes=$request->file('imagenes');

            if (!is_null($imagenes)) {
                foreach($imagenes as $imagen){
                    $codigo=$this->generarCodigo();
                    $name=$codigo."_".$imagen->getClientOriginalName();
                    $imagen->move(public_path().'/img_productos', $name);  
                    $url ='img_productos/'.$name;
                    $img=new Imagenes();
                    $img->id_producto=$producto->id;
                    $img->nombre=$name;
                    $img->url=$url;
                    $img->save();
                }
            }
            
        }else{
            $id_producto=$request->productos;
        }
        
       //echo '-----'.$request->id_cotizacion;
        $item=new Item();
        $item->id_producto=$id_producto;
        $item->plazo_entrega=$request->plazo_entrega;
        $item->cant=$request->cant;
        $item->precio_unit=$request->precio_unit;
        $item->total_pp=$request->total_pp;
        $item->enlace1_web=$request->enlace1_web;
        $item->enlace2_web=$request->enlace2_web;
        $item->observacion=$request->observacion;
        $item->pp_ci=$request->pp_ci;
        $item->pp_si=$request->pp_si;
        $item->pda=$request->pda;
        $item->traslado=$request->traslado;
        $item->porc_uti=$request->porc_uti;
        $item->uti_x_und=$request->uti_x_und;
        $item->uti_x_total_p=$request->uti_x_total_p;
        $item->boreal=$request->boreal;
        $item->id_cotizacion=$request->id_cotizacion;
        $item->save();
        $items=Item::where('id_cotizacion',$request->id_cotizacion)->get();
        return response()->json(['message' => "Item cargado con Éxito",'icono' => 'success', 'titulo' => 'Éxito','items' => $items]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
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
}