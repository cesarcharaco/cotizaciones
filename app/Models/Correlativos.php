<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correlativos extends Model
{
    use HasFactory;

    protected $table='correlativos_cotizaciones';

    protected $fillable=['numero_cotizacion','status','fecha','id_usuario'];
}
