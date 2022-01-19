<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresas;

class Solicitantes extends Model
{
    use HasFactory;

    protected $table='solicitantes';

    protected $fillable=['nombres','apellidos','celular','direccion','localidad','id_empresa'];

    public function empresas(){

        return $this->belongsTo('App\Models\Empresas','id_empresa','id');
    }

    public function cotizaciones()
    {
    	return $this->hasMany('App\Models\Cotizaciones','id_solicitante','id');
    }
}
