<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table='items';

    protected $fillable=['id_producto','plazo_entrega','cant','precio_unit','total_pp','enlace1_web','enlace2_web','observacion','pp_ci','pp_si','pda','traslado','porc_uti','uti_x_und','uti_x_total_p','boreal','id_cotizacion'];

    public function productos()
    {
    	return $this->belongsTo('App\Models\Productos','id_producto','id');
    }

	public function cotizacion()
    {
    	return $this->belongsTo('App\Models\Cotizaciones','id_cotizacion','id');
    }    
}
