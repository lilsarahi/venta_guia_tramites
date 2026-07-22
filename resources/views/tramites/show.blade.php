<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tramite->nombre }} - Visas y Migración Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

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

    {{-- ── HERO CON IMAGEN ── --}}
    <div class="detalle-hero">
        @if(!empty($tramite->imagen))
            <img
                src="{{ asset('img/tramites/' . $tramite->imagen) }}"
                alt="{{ $tramite->nombre }}"
                class="detalle-hero-img"
            >
        @endif
        <div class="detalle-hero-overlay"></div>

        @if(!empty($tramite->categoria))
            <span class="detalle-hero-pill">{{ $tramite->categoria }}</span>
        @endif

        @if($accesoDesbloqueado && $token)
            <span class="detalle-hero-badge-paid">✓ Acceso desbloqueado</span>
        @endif

        <div class="detalle-hero-content">
            <p class="breadcrumb">
                <a href="{{ route('tramites.index') }}">Inicio</a> / {{ $tramite->nombre }}
            </p>
            <h1 class="detalle-titulo">{{ $tramite->nombre }}</h1>

            @if($accesoDesbloqueado && $token)
                <div class="detalle-hero-actions">
                    <a href="{{ route('tramites.pdf', [$slug, $token]) }}" class="btn-pdf">
                        📥Descargar guía en PDF
                    </a>
                    @if(!empty($tramite->video))
                        <button onclick="document.getElementById('modal-video').style.display='flex'" class="btn-video">
                            ▶ Ver video
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- ── MODAL VIDEO ── --}}
    @if($accesoDesbloqueado && $token && !empty($tramite->video))
        <div id="modal-video" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:999; align-items:center; justify-content:center;">
            <div style="position:relative; width:90%; max-width:800px;">
                <button onclick="cerrarVideo()" style="position:absolute; top:-40px; right:0; background:none; border:none; color:white; font-size:28px; cursor:pointer;">✕</button>
                <video id="player-video" controls style="width:100%; border-radius:12px;">
                    <source src="{{ asset('videos/' . $tramite->video) }}" type="video/mp4">
                </video>
            </div>
        </div>
    @endif

    {{-- ── DESCRIPCIÓN ── --}}
    <div class="detalle-descripcion">
        {{ $tramite->descripcion_corta }}
    </div>

    @if($accesoDesbloqueado && $token)

        {{-- ── CONTENIDO DESBLOQUEADO ── --}}
        <div class="contenido-tramite">

            <div class="contenido-header">
                <div class="contenido-header-icon">📋</div>
                <div>
                    <div class="contenido-header-title">Guía completa</div>
                    <div class="contenido-header-sub">Información oficial actualizada</div>
                </div>
            </div>

            <div class="contenido-info-general">
                <p>{{ $tramite->informacion_general }}</p>
            </div>

            @foreach($tramite->categorias_documentos as $categoria)
                <div class="contenido-seccion">
                    <div class="contenido-seccion-label"> {{ $categoria->titulo }}</div>
                    <ul class="doc-list">
                        @foreach($categoria->documentos as $index => $doc)
                            <li class="doc-item">
                                <span class="doc-num">{{ $index + 1 }}</span>
                                {{ $doc }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            @if(!empty($tramite->avisos))
                <div class="contenido-seccion">
                    <div class="contenido-seccion-label">⚠️ Avisos importantes</div>
                    @foreach($tramite->avisos as $aviso)
                        <div class="aviso-card">
                            
                            {{ $aviso }}
                        </div>
                    @endforeach
                </div>
            @endif

            @if(!empty($tramite->preguntas_frecuentes))
                <div class="contenido-seccion">
                    <div class="contenido-seccion-label">💬 Preguntas frecuentes en la entrevista</div>
                    <ul class="doc-list">
                        @foreach($tramite->preguntas_frecuentes as $index => $pregunta)
                            <li class="doc-item">
                                <span class="doc-num">{{ $index + 1 }}</span>
                                {{ $pregunta }}
                            </li>
                        @endforeach
                    </ul>
                    @if($tramite->nota_preguntas)
                        <p class="nota-preguntas"><em>{{ $tramite->nota_preguntas }}</em></p>
                    @endif
                </div>
            @endif

            @if(!empty($tramite->liga_oficial))
                <div class="contenido-seccion">
                    <div class="contenido-seccion-label">🔗 Sitio oficial</div>
                    <a href="{{ $tramite->liga_oficial }}" target="_blank" class="link-oficial">
                        {{ $tramite->liga_oficial }} ↗
                    </a>
                </div>
            @endif

        </div>

    @else

        {{-- ── VISTA BLOQUEADA ── --}}
        <div class="preview-blur">
            <p>{{ $tramite->informacion_general }}</p>
        </div>

        <div class="caja-pago">
            <div class="lock-icon">🔒</div>
            <h2>Guía completa</h2>
            <div class="precio-grande">
                ${{ number_format($tramite->precio, 0) }}
                <span class="moneda">MXN</span>
            </div>
            <p class="nota-precio">Pago único, sin suscripción</p>

            <div class="pago-btns">
                <form action="{{ route('pago.iniciar', $tramite->slug) }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;">💳 Pagar y ver guía completa</button>
                </form>

                <a href="{{ route('tramites.pago.asesor', $tramite->slug) }}" class="btn-comenzar">
                    🧾 Comenzar trámite
                </a>
            </div>
        </div>

        <div class="incluye">
            <h3>¿Qué incluye esta guía?</h3>
            <div class="incluye-grid">
                <div class="incluye-item">
                    <span class="incluye-check">✓</span>
                    Lista completa de requisitos
                </div>
                <div class="incluye-item">
                    <span class="incluye-check">✓</span>
                    Documentos oficiales actualizados
                </div>
                <div class="incluye-item">
                    <span class="incluye-check">✓</span>
                    PDF descargable
                </div>
                <div class="incluye-item">
                    <span class="incluye-check">✓</span>
                    Acceso inmediato
                </div>
            </div>
        </div>

    @endif

</div>

<footer></footer>

<script>
function cerrarVideo() {
    const modal = document.getElementById('modal-video');
    const player = document.getElementById('player-video');
    if (modal) modal.style.display = 'none';
    if (player) player.pause();
}
const modalVideo = document.getElementById('modal-video');
if (modalVideo) {
    modalVideo.addEventListener('click', function(e) {
        if (e.target === this) cerrarVideo();
    });
}
</script>

</body>
</html>