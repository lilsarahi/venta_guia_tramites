<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contactar asesor — {{ $tramite->nombre }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>

<header>
    <div class="container">
        <h1 class="logo-title">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Visas Virgen" class="logo-icon">
            VISAS Y MIGRACIÓN SERVICES
        </h1>
        <div class="menu-toggle">
            <span></span><span></span><span></span>
        </div>
        <nav id="nav">
            <a href="{{ route('tramites.index') }}">Trámites</a>
            <a href="#">Contacto</a>
        </nav>
    </div>
</header>

@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="detalle-wrap">

    <p class="breadcrumb">
        <a href="{{ route('tramites.index') }}">Inicio</a> /
        <a href="{{ route('tramites.show', $slug) }}">{{ $tramite->nombre }}</a> /
        Contactar asesor
    </p>

    <h1 class="detalle-titulo">Comenzar trámite</h1>

    <div class="detalle-descripcion">
        Para iniciar tu trámite de <strong>{{ $tramite->nombre }}</strong> y contactar
        a un asesor especializado, es necesario realizar un pago de consulta.
    </div>

    <div class="caja-pago" style="max-width: 480px; margin: 32px auto;">

        <h2>Asesoría personalizada</h2>

        <p class="subtexto" style="margin: 12px 0 20px;">
            Un asesor revisará tu caso, responderá tus dudas y te guiará
            paso a paso durante todo el proceso migratorio.
        </p>

        <div class="precio-grande">
            $500
            <span class="moneda">MXN</span>
        </div>
        <p class="nota-precio">Pago único por consulta de asesoría</p>

        <ul style="text-align:left; margin: 20px 0; padding-left: 20px; line-height: 2;">
            <li>Asesor asignado a tu trámite</li>
            <li>Revisión de tu documentación</li>
            <li>Seguimiento personalizado</li>
            <li>Comunicación directa con el asesor</li>
        </ul>

        <form action="{{ route('pago.asesor.iniciar', $slug) }}" method="POST">
            @csrf
            <button type="submit" style="width:100%; font-size:1rem; padding:14px;">
                💳 Pagar $500 MXN y continuar
            </button>
        </form>

        <a href="{{ route('tramites.show', $slug) }}"
           class="btn-cancelar"
           style="display:block; text-align:center; margin-top:14px; font-size:0.9rem;">
            ← Regresar al trámite
        </a>
    </div>

</div>

<footer></footer>

</body>
</html>