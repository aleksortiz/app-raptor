<?php

use Illuminate\Support\Facades\Route;


Route::get('/upload-mobile-photos', function(){
    return view('livewire.foto.upload-mobile-photos.index');
});