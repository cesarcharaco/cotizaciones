<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cotizaciones;
class Cotizadores extends Model
{
    use HasFactory;

    protected $table='cotizadores';

    protected $fillable=['cotizador','rut','telefono','correo','id_usuario'];

    public function cotizaciones()
    {
    	return $this->hasMany('App\Models\Cotizaciones','id_cotizador','id');
    }
    
    public function usuarios()
    {
    	return $this->belongsTo('App\Models\Cotizaciones','id_usuario','id');
    }
}
