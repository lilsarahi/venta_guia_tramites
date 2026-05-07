<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visas y Migración Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>

<header>
    <div class="container">
        <h1 class="logo-title">
            <img
                src="{{ asset('img/logo.jpg') }}"
                alt="Logo Visas Virgen"
                class="logo-icon"
            >
           
            VISAS Y MIGRACIÓN SERVICES 
        </h1>

        <div class="menu-toggle">
            <span></span><span></span><span></span>
        </div>

        <nav id="nav">
            <a href="#">Contacto</a>
        </nav>
    </div>
</header>

{{-- Alertas flash --}}
@if (session('success'))
    <div class="alert alert-success"> {{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error"> {{ session('error') }}</div>
@endif
@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<section class="hero-banner">
    <img src="{{ asset('img/bandera.jpg') }}" alt="México y USA" class="hero-image">
    <div class="hero-text">
        <h2>LOS EXPERTOS EN MIGRACIÓN</h2>
        <h1>HAZLO AHORA Y VIAJA DESPUÉS… HAZLO AHORA Y DEJA EL ESTRÉS</h1>
    </div>
</section>

<section class="hero">
    <p class="hero-extra">
        Todos los trámites que se presentan a continuación son procesos en los que en "Visas y Migración" contamos con amplia experiencia. Por ello, te ofrecemos una guía rápida y sencilla para que tu trámite sea exitoso.
    </p>
</section>

<section class="section">
    <h3>Trámites disponibles</h3>

    <div class="cards">
        @forelse($tramites as $tramite)
            <div class="card">
                <div class="card-image">
                    <p class="card-gancho">{{ $tramite->gancho }}</p>
                </div>
                <div class="card-content">
                    <h4>{{ $tramite->nombre }}</h4>
                    <p>{{ Str::limit($tramite->descripcion_corta, 100) }}</p>
                    <a href="{{ route('tramites.show', $tramite->slug) }}">
                        <button>Ver guía</button>
                    </a>
                </div>
            </div>
        @empty
            <p style="color:#fff;text-align:center;grid-column:1/-1;">
                No hay trámites disponibles por el momento.
            </p>
        @endforelse
    </div>
</section>

<footer></footer>

</body>
</html>
