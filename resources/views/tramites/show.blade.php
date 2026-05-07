<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tramite->nombre }} - Visas y Migración Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<script>
function cerrarVideo() {
    document.getElementById('modal-video').style.display = 'none';
    document.getElementById('player-video').pause();
}

document.getElementById('modal-video')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarVideo();
});
</script>

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

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif
@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="detalle-wrap">

    <p class="breadcrumb">
        <a href="{{ route('tramites.index') }}">Inicio</a> / {{ $tramite->nombre }}
    </p>

    <h1 class="detalle-titulo">{{ $tramite->nombre }}</h1>

    <div class="detalle-descripcion">
        {{ $tramite->descripcion_corta }}
    </div>

    @if($accesoDesbloqueado && $token)

        <div class="badge-desbloqueado">
            <span><strong>Pago confirmado.</strong> Tienes acceso completo a la información.</span>
        </div>

        <a href="{{ route('tramites.pdf', [$slug, $token]) }}" class="btn-pdf">
            📥 Descargar guía en PDF
        </a>
        @if(!empty($tramite->video))
            <button onclick="document.getElementById('modal-video').style.display='flex'" class="btn-video">
                ▶ Ver video informativo
            </button>

            <div id="modal-video" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:999; align-items:center; justify-content:center;">
                <div style="position:relative; width:90%; max-width:800px;">
                    <button onclick="cerrarVideo()" style="position:absolute; top:-40px; right:0; background:none; border:none; color:white; font-size:28px; cursor:pointer;">✕</button>
                    <video id="player-video" controls style="width:100%; border-radius:12px;">
                        <source src="{{ asset('videos/' . $tramite->video) }}" type="video/mp4">
                    </video>
                </div>
            </div>
        @endif

        <div class="contenido-tramite">
            <p>{{ $tramite->informacion_general }}</p>

            @foreach($tramite->categorias_documentos as $categoria)
                <h3>{{ $categoria->titulo }}</h3>
                <ul>
                    @foreach($categoria->documentos as $doc)
                        <li>{{ $doc }}</li>
                    @endforeach
                </ul>
            @endforeach

            @if(!empty($tramite->avisos))
                <div class="aviso-importante">
                    @foreach($tramite->avisos as $aviso)
                        <p>NOTA: {{ $aviso }}</p>
                    @endforeach
                </div>
            @endif

            @if(!empty($tramite->preguntas_frecuentes))
                <h3>Preguntas frecuentes en la entrevista</h3>
                <ul>
                    @foreach($tramite->preguntas_frecuentes as $pregunta)
                        <li>{{ $pregunta }}</li>
                    @endforeach
                </ul>
                @if($tramite->nota_preguntas)
                    <p><em>{{ $tramite->nota_preguntas }}</em></p>
                @endif
            @endif

            @if(!empty($tramite->liga_oficial))
                <p>🔗 Sitio oficial:
                    <a href="{{ $tramite->liga_oficial }}" target="_blank">{{ $tramite->liga_oficial }}</a>
                </p>
            @endif
        </div>

    @else

        <div class="preview-blur">
            <p>{{ $tramite->informacion_general }}</p>
        </div>
{{-- 
        <div class="caja-pago">
            <div class="lock-icon">🔒</div>
            <h2>Guía completa</h2>
            <div class="precio-grande">
                ${{ number_format($tramite->precio, 0) }}
                <span class="moneda">MXN</span>
            </div>
            <p class="nota-precio">Pago único, sin suscripción</p>
            <form action="{{ route('pago.iniciar', $tramite->slug) }}" method="POST">
                @csrf
                <button type="submit">💳 Pagar y ver guía completa</button>
            </form>
        </div> --}}

        <div class="caja-pago">
            <div class="lock-icon">🔒</div>
            <h2>Guía completa</h2>
            <div class="precio-grande">
                ${{ number_format($tramite->precio, 0) }}
                <span class="moneda">MXN</span>
            </div>
            <p class="nota-precio">Pago único, sin suscripción</p>

            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
                <form action="{{ route('pago.iniciar', $tramite->slug) }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;">💳 Pagar y ver guía completa</button>
                </form>

                <a href="{{ route('tramites.solicitud', $tramite->slug) }}" class="btn-comenzar">
                    🧾 Comenzar trámite
                </a>
            </div>
        </div>

        <div class="incluye">
            <h3>¿Qué incluye esta guía?</h3>
            <ul>
                <li>Lista completa de requisitos por tipo de trámite</li>
                <li>Documentos oficiales actualizados</li>
                <li>PDF imprimible descargable</li>
            </ul>
        </div>

    @endif

</div>

<footer></footer>

</body>
</html>