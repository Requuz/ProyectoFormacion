<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipPilotController extends Controller
{
    public function index()
    {
        $pilots = Pilot::all()->sortBy('name');
        $starships = Starship::all()->sortBy('name');

        $starship_pilot = DB::table('starship_pilot')
            ->join('starships', 'starship_pilot.starship_id', '=', 'starships.id')
            ->join('pilots', 'starship_pilot.pilot_id', '=', 'pilots.id')
            ->select('starship_pilot.id', 'starships.name as starship_name', 'pilots.name as pilot_name', 'starships.cost_in_credits')
            ->get()
            ->groupBy('starship_name');

        return view('starshipPilot', ['starship_pilot' => $starship_pilot], compact('pilots', 'starships'));
    }

    public function destroyById($id)
{

    $pilot = Pilot::find($id);

    if (!$pilot) {
        return response()->json(['Mensaje:'=> 'Piloto no encontrado'], 404);
    }

    $pilot->starships()->detach();
    $pilot->delete();

    return response()->json(['Mensaje:'=> 'Piloto eliminado'], 200);

}
  public function linkPilot($pilot_id, $starship_id)
{
    // Buscar el piloto y la nave en la base de datos usando los valores de los parámetros
    $pilot = Pilot::find($pilot_id);
    $starship = Starship::find($starship_id);

    // Si los dos existen, se verifica si ya están vinculados
    if ($starship && $pilot) {
        // Si ya están vinculados, se muestra un mensaje de error
        if ($starship->pilots()->where('pilot_id', $pilot_id)->exists()) {
            return response()->json(['message' => 'El piloto y la nave ya están vinculados.'], 409);
        } else {
            // Si no están vinculados, se vinculan y se muestra un mensaje de éxito
            $starship->pilots()->attach($pilot);
            return response()->json(['success' => 'Piloto y nave vinculados correctamente']);
        }
    }

    // Si cualquiera de los dos no se encuentra, se muestra un mensaje de error
    return response()->json(['message' => 'Nave o piloto no encontrado.'], 404);
}



      public function unlinkPilot($pilot_id, $starship_id)
{
   //Buscar el piloto y la nave en la base de datos usando los valores de los parametros
    $pilot = Pilot::find($pilot_id);
    $starship = Starship::find($starship_id);

    //Si los dos existen, se desvinculan y se muestra un mensaje de éxito
    if ($starship && $pilot) {
        $starship->pilots()->detach($pilot);
        return response()->json(['success' => 'Piloto y nave desvinculados correctamente']);
    }

    //Si cualquiera de los dos no se encuentra, se muestra un mensaje de error
    return response()->json(['message' => 'Nave o piloto no encontrado.'], 404);
}
}
