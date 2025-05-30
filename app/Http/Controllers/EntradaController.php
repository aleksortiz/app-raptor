<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntradaController extends Controller
{
    public function downloadDocument($id)
    {
        $documento = Documento::findOrFail($id);
        $contents = Storage::disk('s3')->get($documento->url);
        return response($contents)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $documento->name . '"');
    }

    public function publicview(Request $request)
    {
        $id = $request->id;
        $entrada = Entrada::with(['fotos', 'cliente', 'avance'])->findOrFail($id);
        return view('entrada.show', compact('entrada'));
    }
} 