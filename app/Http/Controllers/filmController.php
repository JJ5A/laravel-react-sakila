<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    //listar todos los films
    public function index()
    {
        $films = Film::all();
        return response()->json($films, 200);
    }

    //mostrar un film
    public function show($id)
    {
        $film = Film::find($id);
        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }
        return response()->json($film, 200);
    }

    //crear un film
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'language_id' => 'required|integer',
            'original_language_id' => 'nullable|integer',
            'rental_duration' => 'required|integer',
            'rental_rate' => 'required|numeric',
            'length' => 'nullable|integer',
            'replacement_cost' => 'required|numeric',
            'rating' => 'nullable|string|max:10',
            'special_features' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $film = Film::create(array_merge(
            $request->all(),
            ['last_update' => now()]
        ));
        return response()->json($film, 201);
    }

    //actualizar un film
    public function update(Request $request, $id)
    {
        $film = Film::find($id);
        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'language_id' => 'sometimes|required|integer',
            'original_language_id' => 'nullable|integer',
            'rental_duration' => 'sometimes|required|integer',
            'rental_rate' => 'sometimes|required|numeric',
            'length' => 'nullable|integer',
            'replacement_cost' => 'sometimes|required|numeric',
            'rating' => 'nullable|string|max:10',
            'special_features' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $film->update(array_merge(
            $request->all(),
            ['last_update' => now()]
        ));
        return response()->json($film, 200);
    }

    //eliminar un film
    public function destroy($id)
    {
        try {
            $film = Film::find($id);
            if (!$film) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Film not found'
                ], 404);
            }

            // FORZAR BORRADO - Eliminar TODAS las dependencias sin verificar

            // 1. Eliminar todos los rentals (pendientes y completados) a través de inventory
            DB::table('rental')
                ->whereIn('inventory_id', function ($query) use ($id) {
                    $query->select('inventory_id')
                        ->from('inventory')
                        ->where('film_id', $id);
                })->delete();

            // 2. Eliminar inventory
            DB::table('inventory')->where('film_id', $id)->delete();

            // 3. Eliminar relaciones muchos a muchos
            DB::table('film_actor')->where('film_id', $id)->delete();
            DB::table('film_category')->where('film_id', $id)->delete();

            // 4. Finalmente eliminar el film
            $film->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Film and all dependencies force deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error force deleting film: ' . $e->getMessage()
            ], 500);
        }
    }
}
