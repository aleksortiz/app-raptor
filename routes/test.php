<?php

use App\Models\aoscore\SupportTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('test')->group(function () 
{
    Route::get('/', function(){
        $date = new Carbon();
        $fecha = $date->isoWeekYear(2024)->isoWeek(17)->startOfWeek();
        $end = $date->isoWeekYear(2024)->isoWeek(17)->endOfWeek();
        return $end;
    });

});
