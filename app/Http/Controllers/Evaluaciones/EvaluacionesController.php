<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Models\Evaluacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluacionesController extends Controller
{
    public function index(Request $request) {
        return datatables()->of(Evaluacion::all())
            ->addIndexColumn()
            ->whitelist([
                'usuario',
                'sucursal',
                'no_reporte',
                'entrada_id',
                'approved_by',
                'approved_at'
            ])
            // ->addColumn('action', fn($user) => view('usuarios.table-buttons', compact('user'))->render())
            // ->addColumn('labelactive', fn ($user) => view('usuarios.table-label', compact('user'))->render())
            // ->rawColumns(['action', 'labelactive'])
            ->make(true);
    }

    public function create() {

    }
}
