<?php

namespace App\Http\Controllers;

use App\Models\Flotilla;
use App\Models\FlotillaUnidad;
use App\Models\ServicioFlotilla;
use Illuminate\Http\Request;

class ServicioFlotillaController extends Controller
{

    public function createFlotilla(Request $request){
        try{
            $request->validate([
                'cliente_id' => 'numeric|required|min:0',
                'nombre' => 'string|required|max:255',
                'notas' => 'string|nullable|max:255',
            ]);

            return Flotilla::create($request->all());

        }catch(\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }

    public function createFlotillaUnidad(Request $request){
        try{
            $request->validate([
                'flotilla_id' => 'numeric|required|min:0',
                'fabricante' => 'string|required|max:255',
                'modelo' => 'string|required|max:255',
                'year' => 'numeric|required|min:0',
                'serie' => 'string|nullable|max:255',
                'placas' => 'string|nullable|max:255',
                'kilometraje' => 'numeric|required|min:0',
            ]);

            return FlotillaUnidad::create($request->all());

        }catch(\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }

    public function createFlotillaServicio(Request $request){
        try{
            $request->validate([
                'flotilla_unidad_id' => 'numeric|required|min:0',
                'tipo_servicio' => 'string|required|max:255',
                'descripcion' => 'string|required|max:255',
                'fecha_servicio' => 'date|required',
                'costo' => 'numeric|required|min:0',
                'kilometraje' => 'numeric|required|min:0',
                'ubicacion' => 'string|required|max:255',
            ]);

            return ServicioFlotilla::create($request->all());

        }catch(\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }

    public function getFlotillasByCliente($cliente){
        return Flotilla::where('cliente_id', $cliente)->get();
    }

    public function getUnidadesByFlotilla($flotilla){
        return FlotillaUnidad::where('flotilla_id', $flotilla)->get();
    }

    public function getUnidadesByCliente($cliente){
        return FlotillaUnidad::whereHas('flotilla', function($query) use ($cliente){
            $query->where('cliente_id', $cliente);
        })->get();
    }

    public function getServiciosByUnidad($unidad){
        return FlotillaUnidad::find($unidad)->servicios;
    }


}
