<?php

use App\Http\Controllers\PagoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RF-07: Webhook de MercadoPago
| Debe excluir CSRF. MP envía POST con datos del pago confirmado.
|--------------------------------------------------------------------------
*/
Route::post('/mercadopago/webhook', [PagoController::class, 'webhook'])
    ->name('mercadopago.webhook');
