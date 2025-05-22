<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PersonalController extends Controller
{
    public function getDestajos(Request $request)
    {
        try {
            $token = $request->query('token');
            
            if (!$token) {
                return view('personal.destajos')->with('error', 'Token no proporcionado');
            }

            // Decode JWT token
            try {
                $decoded = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
            } catch (\Exception $e) {
                return view('personal.destajos')->with('error', 'Token inválido');
            }

            // Validate required fields in token
            if (!isset($decoded->personal_id) || !isset($decoded->week) || !isset($decoded->year)) {
                return view('personal.destajos')->with('error', 'Token mal formado');
            }

            // Validate week number
            if ($decoded->week < 1 || $decoded->week > 52) {
                return view('personal.destajos')->with('error', 'Número de semana inválido');
            }

            // Check token expiration
            if (isset($decoded->exp) && $decoded->exp < time()) {
                return view('personal.destajos')->with('error', 'Token expirado');
            }

            // Calculate date range
            $start = Carbon::now()->setISODate($decoded->year, $decoded->week)->startOfWeek();
            $end = Carbon::now()->setISODate($decoded->year, $decoded->week)->endOfWeek();

            // Get destajos data
            $destajos = OrdenTrabajo::select(
                'personal_id',
                DB::raw('COUNT(*) as total_ordenes'),
                DB::raw('SUM(monto) as monto_total'),
                DB::raw('SUM(CASE WHEN EXISTS (SELECT 1 FROM orden_trabajo_pagos WHERE orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id) THEN monto ELSE 0 END) as monto_pagado'),
                DB::raw('SUM(CASE WHEN NOT EXISTS (SELECT 1 FROM orden_trabajo_pagos WHERE orden_trabajo_pagos.orden_trabajo_id = ordenes_trabajo.id) THEN monto ELSE 0 END) as monto_pendiente')
            )
            ->with('personal')
            ->where('personal_id', $decoded->personal_id)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('personal_id')
            ->first();

            if (!$destajos) {
                return view('personal.destajos')->with('error', 'No se encontraron destajos para el período especificado');
            }

            // Get detailed orders
            $ordenes = OrdenTrabajo::with(['entrada', 'personal'])
                ->where('personal_id', $decoded->personal_id)
                ->whereBetween('created_at', [$start, $end])
                ->get()
                ->map(function ($orden) {
                    return [
                        'id' => $orden->id,
                        'folio_short' => $orden->entrada->folio_short,
                        'entrada_id' => $orden->entrada_id,
                        'vehiculo' => $orden->entrada->vehiculo,
                        'notas' => $orden->notas,
                        'monto' => $orden->monto,
                        'pagado' => $orden->pagado,
                        'pendiente' => $orden->pendiente,
                    ];
                });

            return view('personal.destajos', [
                'resumen' => $destajos,
                'ordenes' => $ordenes
            ]);

        } catch (\Exception $e) {
            return view('personal.destajos')->with('error', 'Error interno del servidor');
        }
    }

    public function generateToken(Request $request)
    {
        try {
            // Get required parameters without defaults
            $personal_id = $request->input('personal_id');
            $week = $request->input('week');
            $year = $request->input('year');

            // Validate all required parameters are present
            if (!$personal_id || !$week || !$year) {
                return response()->json(['error' => 'Todos los parámetros son requeridos (personal_id, week, year)'], 400);
            }

            // Validate week number
            if ($week < 1 || $week > 52) {
                return response()->json(['error' => 'Número de semana inválido'], 400);
            }

            // Get personal data
            $personal = Personal::find($personal_id);
            if (!$personal) {
                return response()->json(['error' => 'Personal no encontrado'], 404);
            }

            // Calculate the end of the specified week
            $expiration = Carbon::now()
                ->setISODate($year, $week)
                ->endOfWeek()
                ->endOfDay()
                ->timestamp;

            $payload = [
                'personal_id' => $personal_id,
                'week' => $week,
                'year' => $year,
                'exp' => $expiration
            ];

            $token = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

            return response()->json([
                'token' => $token,
                'personal' => $personal->nombre,
                'week' => $week,
                'date' => now()->toDateTimeString(),
                'url' => url('/destajos') . '?token=' . $token,
                'expires_at' => Carbon::createFromTimestamp($payload['exp'])->toDateTimeString(),
                'payload' => $payload
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el token'], 500);
        }
    }
} 