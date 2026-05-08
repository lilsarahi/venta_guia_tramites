<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Illuminate\Support\Str;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

class PagoController extends Controller
{
    private function cargarTramite(string $slug): ?object
    {
        $archivo = resource_path("data/tramites/{$slug}.json");

        if (!file_exists($archivo)) {
            return null;
        }

        return json_decode(file_get_contents($archivo));
    }

    private function configurarMercadoPago(): void
    {
        $accessToken = config('services.mercadopago.access_token');

        if (!$accessToken) {
            throw new \Exception('Access Token no configurado.');
        }

        MercadoPagoConfig::setAccessToken($accessToken);
    }

    // ─── PAGO DE GUÍA ────────────────────────────────────────────────────────

    public function iniciarPago(Request $request, string $slug)
    {
        $tramite = $this->cargarTramite($slug);

        if (!$tramite) {
            abort(404);
        }

        $this->configurarMercadoPago();

        $token = Str::random(40);

        $pago = Pago::create([
            'slug'         => $slug,
            'token_acceso' => $token,
            'estado'       => 'pendiente',
            'monto'        => $tramite->precio,
            'tipo'         => 'guia',
        ]);

        $client = new PreferenceClient();

        try {

            $preference = $client->create([
                "items" => [
                    [
                        "title"       => $tramite->nombre,
                        "quantity"    => 1,
                        "unit_price"  => (float) $tramite->precio,
                        "currency_id" => "MXN"
                    ]
                ],

                "external_reference" => $token,

                "back_urls" => [
                    "success" => route('pago.exito', $slug),
                    "failure" => route('pago.fallido', $slug),
                    "pending" => route('pago.pendiente', $slug),
                ],

                "auto_return" => "approved",
            ]);

            $pago->update([
                'mp_preference_id' => $preference->id
            ]);

            return redirect($preference->init_point);

        } catch (MPApiException $e) {

            $response = $e->getApiResponse();

            if ($response) {
                dd($response->getContent());
            }

            dd($e->getMessage());
        }
    }

    public function exito(Request $request, string $slug)
    {
        $paymentId = $request->query('payment_id')
            ?? $request->query('collection_id');

        if (!$paymentId) {
            return redirect()->route('tramites.show', $slug)
                ->with('error', 'No se recibió ID de pago.');
        }

        $this->configurarMercadoPago();

        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get((int) $paymentId);

        if ($payment->status === 'approved') {

            $pago = Pago::where('token_acceso', $payment->external_reference)->first();

            if ($pago) {

                $pago->update([
                    'estado'        => 'completado',
                    'mp_payment_id' => $payment->id,
                    'pagado_en'     => now(),
                ]);

                session(["pago_confirmado_{$slug}" => true]);

                return redirect()->route('tramites.acceso', [
                    'slug'  => $slug,
                    'token' => $pago->token_acceso,
                ]);
            }
        }

        return redirect()->route('tramites.show', $slug)
            ->with('error', 'El pago no fue aprobado.');
    }

    public function fallido(string $slug)
    {
        return redirect()->route('tramites.show', $slug)
            ->with('error', 'El pago fue cancelado.');
    }

    public function pendiente(string $slug)
    {
        return redirect()->route('tramites.show', $slug)
            ->with('info', 'Pago pendiente.');
    }

    // ─── PAGO DE ASESORÍA ────────────────────────────────────────────────────

    public function iniciarPagoAsesor(Request $request, string $slug)
    {
        $tramite = $this->cargarTramite($slug);

        if (!$tramite) {
            abort(404);
        }

        $this->configurarMercadoPago();

        $token = Str::random(40);

        $pago = Pago::create([
            'slug'         => $slug,
            'token_acceso' => $token,
            'estado'       => 'pendiente',
            'monto'        => 500,
            'tipo'         => 'asesoria',
        ]);

        $client = new PreferenceClient();

        try {

            $preference = $client->create([
                "items" => [
                    [
                        "title"       => "Asesoría: " . $tramite->nombre,
                        "quantity"    => 1,
                        "unit_price"  => 500.00,
                        "currency_id" => "MXN",
                    ]
                ],

                "external_reference" => $token,

                "back_urls" => [
                    "success" => route('pago.asesor.exito', $slug),
                    "failure" => route('pago.asesor.fallido', $slug),
                    "pending" => route('pago.asesor.pendiente', $slug),
                ],

                "auto_return" => "approved",
            ]);

            $pago->update(['mp_preference_id' => $preference->id]);

            return redirect($preference->init_point);

        } catch (MPApiException $e) {

            $response = $e->getApiResponse();

            if ($response) {
                dd($response->getContent());
            }

            dd($e->getMessage());
        }
    }

    public function exitoAsesor(Request $request, string $slug)
    {
        $paymentId = $request->query('payment_id')
            ?? $request->query('collection_id');

        if (!$paymentId) {
            return redirect()->route('tramites.pago.asesor', $slug)
                ->with('error', 'No se recibió confirmación de pago.');
        }

        $this->configurarMercadoPago();

        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get((int) $paymentId);

        if ($payment->status === 'approved') {

            $pago = Pago::where('token_acceso', $payment->external_reference)
                ->where('tipo', 'asesoria')
                ->first();

            if ($pago) {
                $pago->update([
                    'estado'        => 'completado',
                    'mp_payment_id' => $payment->id,
                    'pagado_en'     => now(),
                ]);

                return redirect()->route('tramites.solicitud', [
                    'slug'  => $slug,
                    'token' => $pago->token_acceso,
                ])->with('success', '¡Pago confirmado! Completa tu solicitud.');
            }
        }

        return redirect()->route('tramites.pago.asesor', $slug)
            ->with('error', 'El pago no fue aprobado. Intenta de nuevo.');
    }

    public function fallidoAsesor(string $slug)
    {
        return redirect()->route('tramites.pago.asesor', $slug)
            ->with('error', 'El pago fue cancelado.');
    }

    public function pendienteAsesor(string $slug)
    {
        return redirect()->route('tramites.pago.asesor', $slug)
            ->with('info', 'Tu pago está pendiente de confirmación.');
    }

    // ─── WEBHOOK ─────────────────────────────────────────────────────────────

    public function webhook(Request $request)
    {
        $type = $request->query('type') ?? $request->input('type');
        $data = $request->input('data');

        if ($type !== 'payment' || empty($data['id'])) {
            return response()->json(['status' => 'ignored'], 200);
        }

        $this->configurarMercadoPago();

        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get((int) $data['id']);

        if ($payment->status === 'approved') {

            $pago = Pago::where('token_acceso', $payment->external_reference)->first();

            if ($pago) {
                $pago->update([
                    'estado'        => 'completado',
                    'mp_payment_id' => $payment->id,
                    'pagado_en'     => now(),
                ]);
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }
}