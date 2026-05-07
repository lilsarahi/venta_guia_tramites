<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\PagoController;

// Route::get('/', function () {
//      return view('tramites.index');
//  });

Route::get('/', [TramiteController::class, 'index'])->name('tramites.index');


// // RF-02, RF-03, RF-04, RF-05: Ver trámite con contenido parcial/bloqueado
// Route::get('/tramite/{tramite}', [TramiteController::class, 'show'])->name('tramites.show');

// // RF-06: Iniciar proceso de pago (MercadoPago Checkout Pro)
// Route::post('/tramite/{tramite}/pagar', [PagoController::class, 'iniciarPago'])->name('pago.iniciar');

// // RF-07, RF-08: Callbacks de MercadoPago
// Route::get('/tramite/{tramite}/exito',    [PagoController::class, 'exito']   )->name('pago.exito');
// Route::get('/tramite/{tramite}/fallido',  [PagoController::class, 'fallido'] )->name('pago.fallido');
// Route::get('/tramite/{tramite}/pendiente',[PagoController::class, 'pendiente'])->name('pago.pendiente');

// // RF-10: Descargar guía completa en PDF
// Route::get('/tramite/{tramite}/descargar', [TramiteController::class, 'descargarPdf'])->name('tramites.descargar');



// Route::get('/tramites/{slug}', [TramiteController::class, 'show'])
//     ->name('tramites.show');

// Route::get('/tramites/{slug}/acceso/{token}', [TramiteController::class, 'acceso'])
//     ->middleware('verificar.pago.token')
//     ->name('tramites.acceso');

// Route::post('/tramites/{slug}/pagar', [PagoController::class, 'iniciarPago'])
//     ->name('pago.iniciar');

// Route::get('/pago/{slug}/exito', [PagoController::class, 'exito'])
//     ->name('pago.exito');

// Route::get('/pago/{slug}/fallido', [PagoController::class, 'fallido'])
//     ->name('pago.fallido');

// Route::get('/pago/{slug}/pendiente', [PagoController::class, 'pendiente'])
//     ->name('pago.pendiente');

// Route::post('/webhook/mercadopago', [PagoController::class, 'webhook'])
//     ->name('mercadopago.webhook');



//Route::get('/', [TramiteController::class, 'index']);

Route::get('/tramites/{slug}', [TramiteController::class, 'show'])
    ->name('tramites.show');

Route::get('/tramites/{slug}/acceso/{token}', [TramiteController::class, 'acceso'])
    ->name('tramites.acceso');

Route::get('/tramites/{slug}/pdf/{token}', [TramiteController::class, 'descargarPdf'])
    ->name('tramites.pdf');

Route::get('/tramites/{slug}/acceso/{token}', 
    [TramiteController::class, 'acceso']
)->middleware('verificar.pago.token')
 ->name('tramites.acceso');

/*
|--------------------------------------------------------------------------
| RUTAS DE PAGO
|--------------------------------------------------------------------------
*/

Route::post('/tramite/{slug}/pagar', [PagoController::class, 'iniciarPago'])
    ->name('pago.iniciar');

Route::get('/tramite/{slug}/pago/exito', [PagoController::class, 'exito'])
    ->name('pago.exito');

Route::get('/tramite/{slug}/pago/fallido', [PagoController::class, 'fallido'])
    ->name('pago.fallido');

Route::get('/tramite/{slug}/pago/pendiente', [PagoController::class, 'pendiente'])
    ->name('pago.pendiente');

Route::post('/api/mercadopago/webhook', [PagoController::class, 'webhook'])
    ->name('mercadopago.webhook');

Route::get('/tramite/{slug}/descargar', [App\Http\Controllers\TramiteController::class, 'descargar'])
    ->name('tramites.descargar');

Route::get('/tramite/{slug}/acceso/{token}', 
    [App\Http\Controllers\TramiteController::class, 'acceso']
)->name('tramites.acceso');

Route::get('/tramite/{slug}/pdf/{token}', 
    [App\Http\Controllers\TramiteController::class, 'descargarPdf']
)->name('tramites.pdf');

Route::get('/tramites/{slug}/solicitud', [TramiteController::class, 'solicitudForm'])->name('tramites.solicitud');

Route::get('/tramites/{slug}/solicitud', [TramiteController::class, 'solicitudForm'])->name('tramites.solicitud');
Route::post('/tramites/{slug}/solicitud', [TramiteController::class, 'solicitudEnviar'])->name('tramites.solicitud.enviar');