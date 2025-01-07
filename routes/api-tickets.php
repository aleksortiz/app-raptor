<?php

use App\Http\Resources\Printer\ValeMaterial\ValeMaterialResource;
use App\Models\ValeMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api-tickets')->group(function () {

    Route::get('/vale-material', function(Request $request){
        $id = $request->input('id');
        $vale = ValeMaterial::findOrFail($id);
        return new ValeMaterialResource($vale);
    });


});
