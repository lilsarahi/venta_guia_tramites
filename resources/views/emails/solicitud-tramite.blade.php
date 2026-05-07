<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
            color: #1f2937;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            max-width: 580px;
            margin: auto;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            background: #091d55;
            color: white;
            padding: 24px 32px;
        }
        .header h1 {
            margin: 0 0 4px;
            font-size: 20px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            color: rgba(255,255,255,0.65);
        }
        .badge {
            background: #d41212;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 999px;
            display: inline-block;
            margin: 20px 32px 0;
        }
        .seccion {
            padding: 16px 32px 0;
        }
        .seccion-titulo {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
        }
        .campo {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }
        .campo:last-child {
            border-bottom: none;
        }
        .campo-label {
            color: #6b7280;
            font-weight: 500;
            min-width: 160px;
        }
        .campo-valor {
            color: #1f2937;
            font-weight: 600;
            text-align: right;
        }
        .footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 16px 32px;
            margin-top: 24px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }
        .costo {
            background: #fff3f3;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 12px 20px;
            margin: 20px 32px;
            text-align: center;
            font-size: 15px;
            color: #7f1d1d;
        }
        .costo strong {
            font-size: 20px;
            color: #d41212;
        }
    </style>
</head>
<body>
<div class="card">

    <div class="header">
        <h1>Visas y Migración Services</h1>
        <p>Nueva solicitud de asesoría</p>
    </div>

    <span class="badge">{{ $tramiteNombre }}</span>

    {{-- DATOS PERSONALES --}}
    <div class="seccion">
        <p class="seccion-titulo">Datos del interesado</p>

        <div class="campo">
            <span class="campo-label">Nombre completo</span>
            <span class="campo-valor">{{ $datos['nombre'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Fecha de nacimiento</span>
            <span class="campo-valor">{{ \Carbon\Carbon::parse($datos['fecha_nac'])->format('d/m/Y') }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Teléfono</span>
            <span class="campo-valor">{{ $datos['telefono'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Correo electrónico</span>
            <span class="campo-valor">{{ $datos['correo'] }}</span>
        </div>
    </div>

    {{-- DIRECCIÓN --}}
    <div class="seccion" style="padding-top:20px;">
        <p class="seccion-titulo">Dirección</p>

        <div class="campo">
            <span class="campo-label">Calle y número</span>
            <span class="campo-valor">{{ $datos['calle'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Colonia</span>
            <span class="campo-valor">{{ $datos['colonia'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Municipio</span>
            <span class="campo-valor">{{ $datos['municipio'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Estado</span>
            <span class="campo-valor">{{ $datos['estado'] }}</span>
        </div>
        <div class="campo">
            <span class="campo-label">Código postal</span>
            <span class="campo-valor">{{ $datos['cp'] }}</span>
        </div>
    </div>

    

</div>
</body>
</html>