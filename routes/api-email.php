<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('api-email')->group(function() 
{
    
    Route::post('/', function(Request $request){
        return $request->input('name');
    });

});
