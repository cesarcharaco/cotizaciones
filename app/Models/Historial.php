<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table='historial_cotizaciones';

    protected $fillable=['id_usuario','operacion','id_cotizacion','observacion'];

    public function usuarios()
    {
    	return $this->belongsTo('App\Models\User','id_usuario');
    }
}
