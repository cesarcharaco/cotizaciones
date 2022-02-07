<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosBoreal extends Model
{
    use HasFactory;

    protected $table='datos_boreal';

    protected $fillable=['id_cotizacion','guia_boreal','fecha_gb','nombre_pdf_gb','url_pdf_gb','oc_boreal','fecha_ocb','nombre_pdf_ocr','url_pdf_ocb'];

    public function cotizacion()
    {
    	return $this->belongsTo('App\Models\Cotizaciones','id_cotizacion','id');
    }
}
