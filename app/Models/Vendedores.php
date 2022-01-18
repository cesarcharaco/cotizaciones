<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agencias;
use App\Models\Pedidos;
class Vendedores extends Model
{
    use HasFactory;

    protected $table='vendedores';

    protected $fillable=['vendedor','telefono','correo'];

    
}
