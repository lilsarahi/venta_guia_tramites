<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'slug',
        'token_acceso',
        'mp_preference_id',
        'mp_payment_id',
        'estado',
        'monto',
        'pagado_en'
    ];

    protected $casts = [
        'pagado_en' => 'datetime',
    ];
}