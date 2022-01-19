<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;
    protected $table='cotizaciones';
    
     protected $fillable=['fecha','numero_oc','descripcion_general','id_solicitante','id_cotizador','oc_recibida','valor_total','guia_boreal','factura_boreal','fecha_entrega','oc_boreal'];

     public function solicitantes(){

        return $this->belongsTo('App\Models\Solicitantes','id_solicitante','id');
    }

    public function cotizadores(){

        return $this->belongsTo('App\Models\Cotizadores','id_cotizador','id');
    }
}
