<?php

namespace App\Http\Controllers;

use App\Models\Documento;
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
} 