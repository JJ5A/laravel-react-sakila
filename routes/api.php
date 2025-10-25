<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\actorController;
use App\Http\Controllers\filmController;

// API Routes for Actor resource
Route::get('/actor',[ActorController::class,'index']);
Route::get('/actor/{id}',[ActorController::class,'show']);
Route::post('/actor',[ActorController::class,'store']);
Route::put('/actor/{id}',[ActorController::class,'update']);
Route::delete('/actor/{id}',[ActorController::class,'destroy']);

// API Routes for film resource
Route::get('/film',[FilmController::class,'index']);
Route::get('/film/{id}',[FilmController::class,'show']);
Route::post('/film',[FilmController::class,'store']);
Route::put('/film/{id}',[FilmController::class,'update']);
Route::delete('/film/{id}',[FilmController::class,'destroy']);
