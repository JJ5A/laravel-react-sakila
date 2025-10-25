<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\actorController;

Route::get('/actor',[ActorController::class,'index']);

Route::get('/actor/{id}',[ActorController::class,'show']);

Route::post('/actor',[ActorController::class,'store']);

Route::put('/actor/{id}',function(){
    return "actualizando actor";
});
Route::delete('/actor/{id}',function(){
    return "eliminando actor";
});