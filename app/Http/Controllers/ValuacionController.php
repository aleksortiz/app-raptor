<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ValuacionController extends Controller
{
    /**
     * Download a document
     */
    public function downloadDocument($id)
    {
        $documento = Documento::findOrFail($id);
        
        if (Storage::disk('s3')->exists($documento->url)) {
            $contents = Storage::disk('s3')->get($documento->url);
            return response($contents)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $documento->name . '"');
        }
        
        return back()->with('error', 'El documento no existe');
    }
} 