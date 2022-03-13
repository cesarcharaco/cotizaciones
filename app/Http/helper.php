<?php 
function search_permits($module,$permit)
{
	/*$search="No";
	$permit=App\Models\Permits::where('permit',$permit)->where('module',$module)->first();
    if(!is_null($permit)){
    	foreach ($permit->user as $key) {    		
    		if ($key->pivot->id_user==\Auth::User()->id) {
    			$search=$key->pivot->status;
    		}
    	}
    }
	return $search;*/
    return "Si";
}

function productos_almacen($id_agencia,$id_producto){

    $valores=array();
    $valores[0]=0;
    $valores[1]=0;
    $buscar=\App\Models\Almacen::where('id_producto',$id_producto)->where('id_agencia',$id_agencia)->get();
    if(count($buscar) > 0){
        foreach ($buscar as $key) {
            $valores[0]=$key->stock;
            $valores[1]=$key->stock_min;
        }
    }
    
    return $valores;
}

function producto_stock($id_producto)
{
    $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->count();
    $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->count();
    $total=0;
    if($buscar_i > 0){
        $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->first();
        $total+=$buscar_i->stock;
    }
    if($buscar_a > 0){
        $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->get();
        foreach ($buscar_a as $key) {
            $total+=$key->stock;
        }
        
    }

    return $total;
}
function producto_disponible($id_producto)
{
    $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->count();
    $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->count();
    $total=0;
    if($buscar_i > 0){
        $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->first();
        $total+=$buscar_i->stock_disponible;
    }
    if($buscar_a > 0){
        $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->get();
        foreach ($buscar_a as $key) {
            $total+=$key->stock_disponible;
        }
        
    }

    return $total;
}
function exit_product2($id_producto){

    $cart_all=App\Models\CarritoPedido::join('productos','productos.id','=','carrito_pedido.id_product')
        ->where('carrito_pedido.id_user',\Auth::getUser()->id)
        ->select('products.*')->get();
        $i=0;
        foreach($cart_all as $key){
            if($key->id==$id_producto) $i++;
        }

        return $i;
}

function precot_espera(){
    
    $buscar=App\Models\PreCotizaciones::where('status','En Espera')->count();

    return $buscar;
}

function cot_pendientes(){
    
    $buscar=App\Models\Cotizaciones::where('status','Pendiente')->count();

    return $buscar;
}

function cot_epc(){
    
    $buscar=App\Models\Cotizaciones::where('status2','En Proceso de Compra')->count();
    //dd($buscar);
    return $buscar;
}

function cot_finalizadas(){
    $hoy=date('Y-m-d');
    $buscar=App\Models\Cotizaciones::where('status2','Finalizada')->where('fecha',$hoy)->count();

    return $buscar;
}
function codigo_en_uso()
{
    if (\Auth::getUser()->user_type=="Admin") {
        $id_user=0;
    } else {
        $id_user=\Auth::getUser()->id;
    }
    

    $buscar=\DB::table('correlativos_cotizaciones')
            ->where('id_usuario',$id_user)
            ->where('status','No Disponible')
            ->select('correlativos_cotizaciones.*')
            ->get();
    $numero="Ninguno";
    if (count($buscar) > 0) {
        foreach ($buscar as $key) {
            $encontrar=App\Models\PreCotizaciones::where('numero',$key->numero_cotizacion)->count();
            if($encontrar ==0){
                $numero=$key->numero_cotizacion;
            }
        }
        return $numero;
    } else {
        return $numero;
    }
    
}

function buscar_img($id_producto)
{
    $buscar=App\Models\Imagenes::where('id_producto',$id_producto)->first();
    if (!is_null($buscar)) {
        $img=$buscar->nombre;
    } else {
        $img="";
    }
    return $img;
}