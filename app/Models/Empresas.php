<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    protected $table='empresas';

    protected $fillable=['nombre','rut','descripcion'];

    public function solicitante()
    {
    	return $this->hasMany('App\Models\Solicitantes','id_empresa','id');
    }
}
