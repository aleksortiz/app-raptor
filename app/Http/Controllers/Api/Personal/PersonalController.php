<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
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
            // Get token from Authorization header or query parameter
            $token = $request->bearerToken() ?? $request->query('token');
            
            if (!$token) {
                return response()->json([
                    'error' => 'Token no proporcionado',
                ], 401);
            }

            // Decode JWT token
            try {
                $decoded = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Token inválido'], 401);
            }

            // Validate required fields in token
            if (!isset($decoded->personal_id) || !isset($decoded->week) || !isset($decoded->year)) {
                return response()->json(['error' => 'Token mal formado'], 400);
            }

            // Validate week number
            if ($decoded->week < 1 || $decoded->week > 52) {
                return response()->json(['error' => 'Número de semana inválido'], 400);
            }

            // Check token expiration
            if (isset($decoded->exp) && $decoded->exp < time()) {
                return response()->json(['error' => 'Token expirado'], 401);
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
                return response()->json(['message' => 'No se encontraron destajos para el período especificado'], 404);
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

            return response()->json([
                'resumen' => $destajos,
                'ordenes' => $ordenes
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function generateToken(Request $request)
    {
        try {
            $personal_id = $request->input('personal_id', 1); // Default to 1 if not provided
            $week = $request->input('week', Carbon::now()->weekOfYear); // Default to current week
            $year = $request->input('year', Carbon::now()->year); // Default to current year

            // Validate week number
            if ($week < 1 || $week > 52) {
                return response()->json(['error' => 'Número de semana inválido'], 400);
            }

            $payload = [
                'personal_id' => $personal_id,
                'week' => $week,
                'year' => $year,
                'exp' => Carbon::now()->addDays(7)->timestamp // Token expires in 7 days
            ];

            $token = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

            return response()->json([
                'token' => $token,
                'expires_at' => Carbon::createFromTimestamp($payload['exp'])->toDateTimeString(),
                'payload' => $payload // Including payload in response for verification
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el token'], 500);
        }
    }
} 