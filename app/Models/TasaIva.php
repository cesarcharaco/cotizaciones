<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasaIva extends Model
{
    use HasFactory;

    protected $table='tasa_ivas';

    protected $fillable=['tasa_i','fecha_i','status_i'];
}
