<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudTramite;

class TramiteController extends Controller
{
    private function cargarTramites(): array
    {
        $archivos = glob(resource_path('data/tramites/*.json'));

        return collect($archivos)
            ->map(fn($archivo) => json_decode(file_get_contents($archivo)))
            ->filter(fn($t) => $t->activo ?? false)
            ->values()
            ->toArray();
    }

    private function cargarTramite(string $slug): ?object
    {
        $archivo = resource_path("data/tramites/{$slug}.json");

        if (!file_exists($archivo)) {
            return null;
        }

        return json_decode(file_get_contents($archivo));
    }

    public function index()
    {
        $tramites = $this->cargarTramites();
        return view('tramites.index', compact('tramites'));
    }

   public function show(string $slug)
{
    $archivo = resource_path("data/tramites/{$slug}.json");

    if (!file_exists($archivo)) {
        abort(404);
    }

    $tramite = json_decode(file_get_contents($archivo));

    $accesoDesbloqueado = false;
    $token = null; // 🔥 SIEMPRE definimos token

    return view('tramites.show', compact(
        'tramite',
        'slug',
        'accesoDesbloqueado',
        'token'
    ));
}

    /**
     * Acceso permanente con token
     */
    public function acceso(string $slug, string $token)
{
    $tramite = $this->cargarTramite($slug);

    if (!$tramite) {
        abort(404);
    }

    $pago = Pago::where('slug', $slug)
        ->where('token_acceso', $token)
        ->where('estado', 'completado')
        ->first();

    if (!$pago) {
        return redirect()->route('tramites.show', $slug)
            ->with('error', 'Acceso no válido o pago no confirmado.');
    }

    $accesoDesbloqueado = true;

    // 🔥 AQUÍ enviamos también el token a la vista
    return view('tramites.show', compact(
        'tramite',
        'accesoDesbloqueado',
        'slug',
        'token'
    ));
}

    public function descargarPdf(string $slug, string $token)
{
    $pago = Pago::where('slug', $slug)
        ->where('token_acceso', $token)
        ->where('estado', 'completado')
        ->first();

    if (!$pago) {
        return redirect()->route('tramites.show', $slug)
            ->with('error', 'Acceso no válido.');
    }

    $tramite = $this->cargarTramite($slug);

    if (!$tramite) {
        abort(404);
    }

    $pdf = Pdf::loadView('tramites.pdf', compact('tramite'))
    ->setPaper('letter', 'portrait');

    return $pdf->download("guia-{$slug}.pdf");
}

public function solicitudForm(string $slug)
{
    $tramite = $this->cargarTramite($slug);

    if (!$tramite) {
        abort(404);
    }

    return view('tramites.solicitud', compact('tramite', 'slug'));
}



public function solicitudEnviar(Request $request, string $slug)
{
    $tramite = $this->cargarTramite($slug);

    if (!$tramite) {
        abort(404);
    }

    $request->validate([
        'nombre'    => 'required|string|max:255',
        'fecha_nac' => 'required|date',
        'telefono'  => 'required|string|max:20',
        'correo'    => 'required|email|max:255',
        'cp'        => 'required|string|max:10',
        'colonia'   => 'required|string|max:255',
        'calle'     => 'required|string|max:255',
        'municipio' => 'required|string|max:255',
        'estado'    => 'required|string|max:255',
    ]);

    $datos = $request->only([
        'nombre', 'fecha_nac', 'telefono', 'correo',
        'cp', 'colonia', 'calle', 'municipio', 'estado'
    ]);

    Mail::to('sarahiortizsilva@gmail.com')
        ->send(new SolicitudTramite($datos, $tramite->nombre));

    return redirect()->route('tramites.solicitud', $slug)
        ->with('enviado', true);
}

}