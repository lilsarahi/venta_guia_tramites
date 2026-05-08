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
                <div class="card-img-wrap">
                    @if(!empty($tramite->imagen))
                        <img src="{{ asset('img/tramites/' . $tramite->imagen) }}" alt="{{ $tramite->nombre }}">
                    @else
                        <img src="{{ asset('img/tramites/default.jpg') }}" alt="{{ $tramite->nombre }}">
                    @endif
                    <div class="card-img-overlay"></div>
                    @if(!empty($tramite->categoria))
                        <span class="card-pill">{{ $tramite->categoria }}</span>
                    @endif
                </div>
                <div class="card-content">
                    <h4>{{ $tramite->nombre }}</h4>
                    <p>{{ $tramite->gancho }}</p>
                    <a href="{{ route('tramites.show', $tramite->slug) }}" class="btn-ver">
                        Ver guía &rarr;
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