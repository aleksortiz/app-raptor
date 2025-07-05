<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;

class AosScanController extends Controller
{
    /**
     * Register a document with the provided parameters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerDocument(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer',
            'doc_type' => 'required|string',
            'link' => 'required|string',
        ]);

        try {

            $name = $request->doc_type;
            if($name == 'ODA'){
                $name = 'Orden de Admisión';
            }
            if($name == 'INE'){
                $name = 'Identificación';
            }

            $documento = Documento::create([
                'name' => $name,
                'url' => $request->link,
                'tipo' => $request->doc_type,
                'model_id' => $request->id,
                'model_type' => $request->model,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Documento registrado correctamente',
                'data' => $documento
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
