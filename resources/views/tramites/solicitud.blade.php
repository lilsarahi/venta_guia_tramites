<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud — {{ $tramite->nombre }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>

<header>
    <div class="container">
        <h1 class="logo-title">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="logo-icon">
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

<div class="detalle-wrap">

    <p class="breadcrumb">
        <a href="{{ route('tramites.index') }}">Inicio</a> /
        <a href="{{ route('tramites.show', $slug) }}">{{ $tramite->nombre }}</a> /
        Solicitud
    </p>

    <h1 class="detalle-titulo">Comenzar trámite</h1>

    @if(!session('enviado'))
        <div class="detalle-descripcion">
            Completa el siguiente formulario y un asesor se comunicará contigo a la brevedad.
        </div>
    @endif

    <div class="contenido-tramite">

    @if(session('enviado'))

        <div class="mensaje-enviado">
            <div class="enviado-icono">✅</div>
            <h2>¡Formulario enviado!</h2>
            <p>Un asesor se comunicará contigo a la brevedad.</p>
            <a href="{{ route('tramites.index') }}" class="btn-enviar" style="display:inline-block; margin-top:20px; text-decoration:none; padding:12px 32px;">
                Volver al inicio
            </a>
        </div>

    @else

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tramites.solicitud.enviar', [$slug, $token]) }}" method="POST">
            @csrf

            <div class="campo-form">
                <label>Nombre completo</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Juan Pérez García" required>
            </div>

            <div class="campo-form">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nac" value="{{ old('fecha_nac') }}" required>
            </div>

            <div class="campo-form">
                <label>Teléfono</label>
                <input type="tel" name="telefono" id="telefono"
                       value="{{ old('telefono') }}"
                       placeholder="Ej. 3312345678"
                       maxlength="10"
                       pattern="\d{10}"
                       inputmode="numeric"
                       required>
                <span id="telefono-error" style="display:none; font-size:0.8rem; color:#c0392b;">
                    Debe componerse de 10 dígitos.
                </span>
            </div>

            <div class="campo-form">
                <label>Correo electrónico</label>
                <input type="email" name="correo" id="correo"
                       value="{{ old('correo') }}"
                       placeholder="Ej. juan@gmail.com"
                       required>
                <span id="correo-error" style="display:none; font-size:0.8rem; color:#c0392b;">
                    Ingresa un correo válido.
                </span>
            </div>

            <div class="direccion-separador">
                <p class="direccion-titulo">Dirección actual</p>

                <div class="grid-cp">
                    <div class="campo-form">
                        <label>Código postal</label>
                        <input type="text" name="cp" id="cp" value="{{ old('cp') }}"
                               placeholder="Ej. 44100" maxlength="5"
                               autocomplete="off" required>
                        <span id="cp-cargando" style="display:none; font-size:0.8rem; color:#666;">
                            🔍 Buscando...
                        </span>
                        <span id="cp-error" style="display:none; font-size:0.8rem; color:#c0392b;"></span>
                    </div>
                    <div class="campo-form">
                        <label>Colonia</label>
                        {{-- Se reemplaza dinámicamente por JS --}}
                        <input type="text" name="colonia" id="colonia-input"
                               value="{{ old('colonia') }}" placeholder="Ej. Centro" required>
                        <select name="colonia" id="colonia-select"
                                style="display:none; width:100%; padding:10px 14px; border:1px solid #ccc; border-radius:8px; font-size:0.95rem;">
                        </select>
                    </div>
                </div>

                <div class="campo-form">
                    <label>Calle y número</label>
                    <input type="text" name="calle" value="{{ old('calle') }}" placeholder="Ej. Av. Juárez 123" required>
                </div>

                <div class="grid-2">
                    <div class="campo-form">
                        <label>Municipio</label>
                        <input type="text" name="municipio" id="municipio"
                               value="{{ old('municipio') }}" placeholder="Ej. Guadalajara" required>
                    </div>
                    <div class="campo-form">
                        <label>Estado</label>
                        <input type="text" name="estado" id="estado"
                               value="{{ old('estado') }}" placeholder="Ej. Jalisco" required>
                    </div>
                </div>
            </div>

            {{-- <div class="nota-envio">
                <p> Al enviar este formulario, un asesor se comunicará contigo a la brevedad</p>
                <p class="nota-costo">Costo de asesoría: <strong>$500 MXN</strong></p>
            </div> --}}

            <div class="form-acciones">
                <button type="submit" class="btn-enviar">Enviar solicitud</button>
                <a href="{{ route('tramites.show', $slug) }}" class="btn-cancelar">Cancelar</a>
            </div>

        </form>

    @endif

</div>

     

<footer></footer>

</body>
</html>