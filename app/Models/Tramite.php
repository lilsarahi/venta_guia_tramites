<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'nombre',
        'descripcion_corta',
        'contenido_completo',
        'precio',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
