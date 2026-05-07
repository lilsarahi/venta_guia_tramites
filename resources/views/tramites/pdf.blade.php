<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $tramite->nombre }}</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>

    <img src="{{ public_path('img/membrete.jpg') }}"
     style="position:fixed; top:-20pt; left:0; width:100%; height:110%; z-index:-1;">

    <div class="contenido">

        <h1 class="tramite-titulo">{{ $tramite->nombre }}</h1>

        <div class="info-general">
            {{ $tramite->informacion_general }}
        </div>

        @foreach($tramite->categorias_documentos as $categoria)
            <h3>{{ $categoria->titulo }}</h3>
            <ul>
                @foreach($categoria->documentos as $doc)
                    <li>{{ $doc }}</li>
                @endforeach
            </ul>
        @endforeach

        @if(!empty($tramite->avisos))
            @foreach($tramite->avisos as $aviso)
                <div class="aviso">NOTA: {{ $aviso }}</div>
            @endforeach
        @endif

        @if(!empty($tramite->preguntas_frecuentes))
            <h3>Preguntas frecuentes en la entrevista</h3>
            <ul>
                @foreach($tramite->preguntas_frecuentes as $pregunta)
                    <li>{{ $pregunta }}</li>
                @endforeach
            </ul>
            @if($tramite->nota_preguntas)
                <p class="preguntas-nota">{{ $tramite->nota_preguntas }}</p>
            @endif
        @endif

        @if(!empty($tramite->liga_oficial))
            <p class="liga">Sitio oficial: {{ $tramite->liga_oficial }}</p>
        @endif

    </div>

</body>
</html>