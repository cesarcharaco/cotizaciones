<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreCotizaciones extends Model
{
    use HasFactory;

    protected $table='pre_cotizaciones';
    
     protected $fillable=['fecha','numero','descripcion_general','empresa','solicitante','cotizador','oc_recibida','valor_total','guia_boreal','factura_boreal','fecha_entrega','oc_boreal'];
}
