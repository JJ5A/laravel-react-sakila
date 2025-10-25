<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    //listar todos los actores
    public function index() {
        $actor = Actor::all();
        $data = [
            'status' => 'success',
            'code' => 200,
            'actor' => $actor
        ];
        return response()->json($data, 200);
    }

    //mostrar un actor
    public function show($id) {
        $actor = Actor::find($id);
        if (!$actor) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Actor not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'actor' => $actor
        ], 200);
    }

    //crear un actor

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $actor = Actor::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'last_update' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Actor created successfully',
            'actor' => $actor
        ], 201);
    }
    // eliminar un actor
    public function destroy($id) {
        $actor = Actor::find($id);
        if (!$actor) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Actor not found'
            ], 404);
        }
        $actor->delete();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Actor deleted successfully'
        ], 200);
    }
    // actualizar un actor
    public function update(Request $request, $id) {
        $actor = Actor::find($id);
        if (!$actor) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Actor not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $actor->first_name = $request->input('first_name');
        $actor->last_name = $request->input('last_name');
        $actor->last_update = now();
        $actor->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Actor updated successfully',
            'actor' => $actor
        ], 200);
    }
}
