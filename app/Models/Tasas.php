<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasas extends Model
{
    use HasFactory;

    protected $table='tasas';

    protected $fillable=['tasa','moneda','fecha','status'];
}
