<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Visas y migracion Services') VISAS Y MIGRACION SERVICES </title>
    <meta name="description" content="@yield('description', 'Guías completas y actualizadas para tus trámites.')">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#eff6ff', 100:'#dbeafe', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8' },
                    }
                }
            }
        }
    </script>
    <style>
        .contenido-tramite h2 { font-size: 1.3rem; font-weight: 700; margin: 1.5rem 0 0.75rem; color: #1e40af; }
        .contenido-tramite h3 { font-size: 1.1rem; font-weight: 600; margin: 1.25rem 0 0.5rem; color: #1d4ed8; }
        .contenido-tramite ul, .contenido-tramite ol { padding-left: 1.5rem; margin: 0.5rem 0 1rem; }
        .contenido-tramite li { margin-bottom: 0.35rem; line-height: 1.6; }
        .contenido-tramite table { width: 100%; border-collapse: collapse; margin: 1rem 0; font-size: 0.9rem; }
        .contenido-tramite th { background: #1e40af; color: white; padding: 0.6rem 0.75rem; text-align: left; }
        .contenido-tramite td { padding: 0.5rem 0.75rem; border-bottom: 1px solid #e2e8f0; }
        .contenido-tramite tr:nth-child(even) td { background: #f1f5f9; }
        .contenido-tramite p { margin: 0.5rem 0 1rem; line-height: 1.7; }
        .blur-content { filter: blur(5px); user-select: none; pointer-events: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-blue-700 text-white shadow-lg">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('tramites.index') }}" class="flex items-center gap-2">
                <span class="text-2xl">📋</span>
                <div>
                    <div class="font-bold text-lg leading-tight">GuíasTrámites</div>
                    <div class="text-blue-200 text-xs">Información clara para tus trámites</div>
                </div>
            </a>
            <nav class="hidden sm:flex gap-4 text-sm">
                <a href="{{ route('tramites.index') }}" class="text-blue-100 hover:text-white transition">Trámites</a>
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 text-sm" role="alert">
            <div class="max-w-5xl mx-auto flex items-center gap-2">
                <span></span> {{ session('success') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 text-sm" role="alert">
            <div class="max-w-5xl mx-auto flex items-center gap-2">
                <span></span> {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Contenido principal --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 text-sm py-6 mt-8">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }}  Información orientativa.</p>
        
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
