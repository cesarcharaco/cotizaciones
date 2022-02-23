<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizadoresController;
use App\Http\Controllers\SolicitantesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\PreCotizacionesController;
use App\Http\Controllers\TasasController;
use App\Http\Controllers\TasaIvaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware('guest')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});

Auth::routes();
Route::group(['middleware' => ['web', 'auth']], function() {
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	
	Route::get('/cotizaciones/definitivas',[PreCotizacionesController::class,'definitivas'])->name('cotizaciones.definitivas');
	Route::get('/cotizaciones/{id_cotizacion}/agregar_items',[PreCotizacionesController::class,'agregar_items'])->name('cotizaciones.agregar_items');

	Route::post('/solicitantes/buscar_por_empresa',[SolicitantesController::class,'buscar_por_empresa'])->name('solicitantes.buscar_por_empresa');
	Route::get('/solicitantes/{id_solicitante}/buscar',[SolicitantesController::class,'buscar_solicitante']);
	
	Route::get('productos/imagenes',[ProductosController::class,'imagenes'])->name('productos.imagenes');
	Route::post('/productos/registrar',[ProductosController::class,'registrar'])->name('productos.registrar');
	Route::post('/productos/eliminar_imagen',[ProductosController::class,'eliminar_imagen'])->name('eliminar_imagen');
	Route::post('/productos/mostrar', [ProductosController::class,'mostrar'])->name('productos.mostrar_producto');
	Route::get('/buscar_categorias',[ProductosController::class, 'buscar_categorias']);
	Route::get('/productos/{id_producto}/buscar',[ProductosController::class,'buscar_producto']);
	Route::post('/cotizaciones/calcular_item',[PreCotizacionesController::class,'calcular_item'])->name('cotizaciones.calcular_item');
	Route::post('/cotizaciones/cambiar_status',[PreCotizacionesController::class,'cambiar_status'])->name('cotizaciones.cambiar_status');
	Route::get('/items/{id_item}/buscar',[ItemController::class,'buscar_item']);
	Route::post('/items/editar',[ItemController::class,'editar'])->name('items.editar');
	Route::post('/cotizaciones/registrar',[PreCotizacionesController::class,'registrar'])->name('cotizaciones.registrar');
	Route::get('cotizaciones/{id_cotizacion}/preparar_envio',[PreCotizacionesController::class,'preparar_envio'])->name('cotizaciones.preparar_envio');
	Route::post('cotizaciones/rechazar_codigo',[PreCotizacionesController::class,'rechazar_codigo'])->name('cotizaciones.rechazar_codigo');
	Route::get('cotizaciones/en_espera',[PreCotizacionesController::class,'en_espera'])->name('cotizaciones.en_espera');
	Route::get('cotizaciones/en_proceso',[PreCotizacionesController::class,'en_proceso'])->name('cotizaciones.en_proceso');
	Route::get('cotizaciones/{id_cotizacion}/contestada',[PreCotizacionesController::class,'contestada'])->name('cotizaciones.contestada');
	Route::post('cotizaciones/registrar_respuesta',[PreCotizacionesController::class,'registrar_respuesta'])->name('cotizaciones.registrar_respuesta');
	Route::post('cotizaciones/status',[PreCotizacionesController::class,'status'])->name('cotizaciones.status');
	Route::get('cotizaciones/{id_cotizacion}/generar_reporte_envio',[ReportesController::class,'generar_reporte_envio'])->name('cotizaciones.generar_reporte_envio');

	Route::resource('/cotizadores',CotizadoresController::class);
	Route::resource('/solicitantes',SolicitantesController::class);
	Route::resource('/cotizaciones',PreCotizacionesController::class);
	Route::resource('/productos',ProductosController::class);
	Route::resource('/categorias',CategoriasController::class);
	Route::resource('/tasas',TasasController::class);
	Route::resource('/tasasiva',TasaIvaController::class);
	Route::resource('/items',ItemController::class);
	
});